<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Services\BrevoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Exports\LeadExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessEnquiryAI;


class EnquiryController extends Controller
{
 public function enquiryLead(Request $request)
{
    $roleId = session('role_id');
    $userId = session('user_id');

    $query = DB::table('enquiries')
    ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
    ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id') // ✅ ADD THIS
    ->whereNull('enquiries.deleted_at')
    ->orderBy('enquiries.created_at', 'desc')
    ->select(
        'enquiries.*',
        'countries.name as country_name',
        'users.name as agent_name'
    );

    // ✅ Agent restriction
   if ($roleId == config('constants.roles.agent')) {

    // ✅ Team Lead Agent
    if (session('can_assign_leads') == 1) {

        $query->where(function($q) use ($userId) {

            $q->where('enquiries.assigned_to', $userId)
              ->orWhere('enquiries.assigned_by', $userId);

        });

    } else {

        // ✅ Normal agent
        $query->where('enquiries.assigned_to', $userId);

    }
}

    if ($request->type == 'today') {
    $query->whereDate('enquiries.followup_date', \Carbon\Carbon::today());
}

    // =========================
// ✅ FILTERS START
// =========================

// Status filter
if ($request->filled('status')) {

    if ($request->status == 'unassigned') {

        // Show only unassigned leads
        $query->whereNull('enquiries.assigned_to');

    } else {

        // Filter by lead status
        $query->where('enquiries.status', $request->status);

    }
}

// Agent filter
if ($request->filled('agent')) {
    $query->where('enquiries.assigned_to', $request->agent);
}

// Date filters
if ($request->filled('from_date')) {
    $query->whereDate('enquiries.created_at', '>=', $request->from_date);
}

if ($request->filled('to_date')) {
    $query->whereDate('enquiries.created_at', '<=', $request->to_date);
}

// Email filter
if ($request->filled('email')) {
    $query->where('enquiries.email', 'like', '%' . $request->email . '%');
}

// =========================
// ✅ FILTERS END
// =========================

    $enquiries = $query->paginate(50)->appends($request->all());
   

$summaryQuery = clone $query;

$totalLeads = $summaryQuery->count();

$thisMonth = (clone $summaryQuery)
    ->whereMonth('enquiries.created_at', Carbon::now()->month)
    ->count();

$todayLeads = (clone $summaryQuery)
    ->whereDate('enquiries.created_at', Carbon::today())
    ->count();

    // Agents list (for admin filter dropdown)
   $agents = [];

// Admin OR agents with assign permission
if (
    $roleId != config('constants.roles.agent') ||
    session('can_assign_leads') == 1
) {
    $agents = DB::table('users')
        ->where('role_id', config('constants.roles.agent'))
        ->whereNull('deleted_at')
        ->select('id', 'name')
        ->get();
}
return view('admin.enquiry.index', compact(
    'enquiries',
    'agents',
    'totalLeads',
    'thisMonth',
    'todayLeads'
));
}
public function todayFollowups(Request $request)
{
    $userId = session('user_id');
    $roleId = session('role_id');

    // ================= LIST =================
  $query = DB::table('enquiries')
    ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id')
    ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id') // ✅ MUST
    ->whereDate('enquiries.followup_date', \Carbon\Carbon::today())
    ->whereNull('enquiries.deleted_at')
    ->select(
        'enquiries.*',
        'users.name as agent_name',
        'countries.name as country_name',   // ✅ MUST
        'countries.phone_code'              // (optional)
    );

    // Agent restriction
    if ($roleId == config('constants.roles.agent')) {
        $query->where('enquiries.assigned_to', $userId);
    }

    $enquiries = $query->get();
    $todayCount = $enquiries->count();

    // ================= SELECTED LEAD =================
    $selectedId = $request->id ?? ($enquiries->first()->id ?? null);

    $enquiry = null;
    $followups = collect();

    if ($selectedId) {

        // Lead detail
        $enquiry = DB::table('enquiries')
            ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
            ->select('enquiries.*', 'countries.name as country_name')
            ->where('enquiries.id', $selectedId)
            ->first();

        // Follow-up history (NO EMPTY DATA)
        $followups = DB::table('enquiry_followups')
            ->where('enquiry_id', $selectedId)
            ->whereNotNull('followup_date')
            ->whereNotNull('remark')
            ->where('remark', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('admin.followups.index', compact('enquiries', 'todayCount', 'roleId'));
}
// public function followupDetail($id)
// {
//     $userId = session('user_id');
//     $roleId = session('role_id');

//     $query = DB::table('enquiries')->where('id', $id);

//     // ✅ Agent restriction
//     if ($roleId == config('constants.roles.agent')) {
//         $query->where('assigned_to', $userId);
//     }

//     $enquiry = $query->first();

//     // followup history
//     $followups = DB::table('enquiry_followups')
//         ->where('enquiry_id', $id)
//         ->orderBy('created_at', 'desc')
//         ->get();

//     return view('admin.followups.detail', compact('enquiry', 'followups'));
// }
// public function update(Request $request)
// {
//     $roleId = session('role_id');
//     $userId = session('user_id');

//     $request->validate([
//         'id' => 'required|exists:enquiries,id',
//         'assigned_to' => 'nullable|exists:users,id',
//         'status' => 'required|in:new,contacted,not_interested,converted',
//         'followup_date' => 'nullable|date_format:Y-m-d\TH:i', // ✅ strict format
//         'remark' => 'nullable|string',
//         'converted_amount' => 'nullable|numeric'
//     ]);

//     // ✅ Safe datetime conversion
//     $followupDate = null;

//     if ($request->followup_date) {
//         $followupDate = Carbon::createFromFormat('Y-m-d\TH:i', $request->followup_date)
//             ->format('Y-m-d H:i:s');
//     }

//     // ✅ Base query
//     $query = DB::table('enquiries')->where('id', $request->id);

//     // ✅ Agent restriction
//     if ($roleId == config('constants.roles.agent')) {
//         $query->where('assigned_to', $userId);
//     }

//     // ✅ Update data
//     $updateData = [
//         'status' => $request->status,
//         'followup_date' => $followupDate, // ✅ fixed
//         'remark' => $request->remark,
//         'converted_amount' => $request->status == 'converted' 
//             ? $request->converted_amount 
//             : null,
//         'updated_at' => now()
//     ];
//     DB::table('enquiry_followups')->insert([
//     'enquiry_id' => $request->id,
//     'followup_date' => $followupDate,
//     'remark' => $request->remark,
//     'created_at' => now()
// ]);

//     // ✅ Only admin can assign
//     if ($roleId != config('constants.roles.agent')) {
//         $updateData['assigned_to'] = $request->assigned_to;
//     }

//     $exists = (clone $query)->exists(); // check if record exists first

//     if (!$exists) {
//         return response()->json([
//             'error' => 'Unauthorized or lead not found'
//         ], 403);
//     }

//     $query->update($updateData); // run update anyway
//     // ✅ Save follow-up history
// if ($followupDate || $request->remark) {
//     DB::table('enquiry_followups')->insert([
//         'enquiry_id' => $request->id,
//         'followup_date' => $followupDate,
//         'remark' => $request->remark,
//         'created_at' => now()
//     ]);
// }

//     return redirect()->route('followups', ['id' => $request->id])
//     ->with('success', 'Follow-up updated successfully');
// }

public function followupDetail($id)
{
    $userId = session('user_id');
    $roleId = session('role_id');

    $query = DB::table('enquiries')
        ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
        ->where('enquiries.id', $id)
        ->select(
            'enquiries.*',
            'countries.name as country_name',
            'countries.phone_code'
        );

    // Agent restriction
    if ($roleId == config('constants.roles.agent')) {
        $query->where('assigned_to', $userId);
    }

    $enquiry = $query->first();

    $followups = DB::table('enquiry_followups')
        ->where('enquiry_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.followups.detail', compact('enquiry', 'followups'));
}



public function update(Request $request)
{


$roleId = session('role_id');
$userId = session('user_id');

// ✅ Validation
$request->validate([

    'id' => 'required|exists:enquiries,id',

    'assigned_to' => 'nullable|exists:users,id',

    'status' => 'required|in:new,contacted,not_interested,converted',

    'followup_date' => 'nullable|array',

    'followup_date.*' => 'nullable|date',

    'remark' => 'nullable|array',

    'remark.*' => 'nullable|string',
    'client_reply' => 'nullable|array',
'client_reply.*' => 'nullable|string',

    'converted_amount' => 'nullable|numeric',

    'job_title' => 'nullable|string|max:255'

]);


// ✅ Convert followup dates
$followupDates = [];

if ($request->followup_date) {

    foreach ($request->followup_date as $key => $date) {

        $followupDates[$key] = !empty($date)
            ? Carbon::parse($date)->format('Y-m-d H:i:s')
            : null;

    }

}


// ✅ Base query
$query = DB::table('enquiries')

    ->where('id', $request->id);

// ✅ Agent restriction
if ($roleId == config('constants.roles.agent')) {

    $query->where('assigned_to', $userId);

}

// ✅ Check exists
if (!$query->exists()) {

    return redirect()->back()

        ->with('error', 'Unauthorized or lead not found');

}

// =========================================
// FOLLOWUP INSERT / UPDATE
// =========================================

if ($request->followup_date) {

    foreach ($request->followup_date as $key => $date) {

        // Skip empty row
        if (
            empty($date) &&
            empty($request->remark[$key])
        ) {
            continue;
        }

        // =========================
        // UPDATE EXISTING FOLLOWUP
        // =========================

        if (!empty($request->followup_id[$key])) {

            DB::table('enquiry_followups')

                ->where('id', $request->followup_id[$key])

                ->update([

                    'followup_date' => $followupDates[$key] ?? null,

                    'remark' => $request->remark[$key] ?? null,
                    'client_reply' => $request->client_reply[$key] ?? null,

                    'status' => $request->status,

                    'lead_type' => $request->lead_type,

                    'job_title' => $request->job_title,

                    'updated_at' => now()

                ]);

        }

        // =========================
        // INSERT NEW FOLLOWUP
        // =========================

        else {

            DB::table('enquiry_followups')->insert([

                'enquiry_id' => $request->id,

                'followup_date' => $followupDates[$key] ?? null,

                'remark' => $request->remark[$key] ?? null,

                'status' => $request->status,

                'lead_type' => $request->lead_type,
                'client_reply' => $request->client_reply[$key] ?? null,

                'job_title' => $request->job_title,

                'user_id' => session('user_id'),

                'created_at' => now()

            ]);

        }

    }

}

// ✅ Latest remark
$remarks = $request->remark ?? [];

// ✅ Update enquiry table
$updateData = [

    'status' => $request->status,

    'followup_date' => !empty($followupDates)
        ? end($followupDates)
        : null,

    'remark' => !empty($remarks)
        ? end($remarks)
        : null,

    'job_title' => $request->job_title,

    'converted_amount' => $request->status == 'converted'
        ? $request->converted_amount
        : null,

    'lead_type' => $request->status == 'contacted'
        ? $request->lead_type
        : null,

    'updated_at' => now()

];

// ✅ Only admin can assign
if (
    $roleId != config('constants.roles.agent') ||
    session('can_assign_leads') == 1
) {

    $updateData['assigned_to'] = $request->assigned_to;

    $updateData['assigned_by'] = session('user_id');

}

// ✅ Update enquiry
$query->update($updateData);

// ✅ Redirect
return redirect()
    ->route('enquiries.enquiryLead')
    ->with('success', 'Lead updated successfully.');
}
public function contactLead()
{
    $contacts = DB::table('contact')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // pagination added

    return view('contact.index', compact('contacts'));
}
    public function showForm()
    {
        return view('frontend.enquiry-form');
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'contact'      => 'required|string|max:15',
        'amount'       => 'nullable|numeric',
        'address'      => 'nullable|string',
        'message'      => 'nullable|string',
        'enquiry_type' => 'nullable|string',
        'page_url'     => 'nullable|url',
        'page_name'    => 'nullable|string',
        'job_title'    => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'country_id'   => 'nullable|exists:countries,id',
        'g-recaptcha-response' => 'required',
        'usage_type'   => 'required|in:personal,office',
    ]);
// Verify Google reCAPTCHA v3
$response = Http::asForm()->post(
    'https://www.google.com/recaptcha/api/siteverify',
    [
        'secret'   => env('NOCAPTCHA_SECRET'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]
);


$result = $response->json();
\Log::info('Google Response', $result);

// Log everything
Log::info('===== RECAPTCHA DEBUG =====');
Log::info('Token:', [
    'token' => $request->input('g-recaptcha-response')
]);

Log::info('Google Response:', $result);

if (!isset($result['success']) || $result['success'] !== true) {

    Log::error('Recaptcha Failed', [
        'response' => $result
    ]);

    return back()
        ->withInput()
        ->withErrors([
            'captcha' => 'Captcha verification failed.'
        ]);
}

Log::info('Recaptcha Passed');

    try {

        // Get selected country
        $country = null;

        if (!empty($validated['country_id'])) {

            $country = DB::table('countries')
                ->where('id', $validated['country_id'])
                ->first();
        }

        // =========================
        // ✅ Region Logic
        // =========================

        $regionId = $country->region_id ?? null;

        // =========================
        // ✅ Auto Lead Assignment
        // =========================

        // APAC → Amol
        if ($regionId == 1) {

            $assignedTo = 88;

        } else {

            // Other Regions → Tarun
            $assignedTo = 29;
        }

        // Save enquiry
        $enquiryId = DB::table('enquiries')->insertGetId([

            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'contact'         => $validated['contact'],
            'amount'          => $validated['amount'] ?? null,
            'address'         => $validated['address'] ?? null,
            'message'         => $validated['message'] ?? null,
            'enquiry_type'    => $validated['enquiry_type'] ?? null,
            'page_url'        => $validated['page_url'] ?? null,
            'page_name'       => $validated['page_name'] ?? null,
            'job_title'       => $validated['job_title'] ?? null,
            'company_name'    => $validated['company_name'] ?? null,
            'country_id'      => $validated['country_id'] ?? null,
            'phone_code'      => $country->phone_code ?? null,
            'visitor_country' => null,
            'usage_type'      => $validated['usage_type'],

            // ✅ Added Region Logic
            'region_id'       => $regionId,
            'assigned_to'     => $assignedTo,

            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        \Log::info('Enquiry saved successfully.', [
            'enquiry_id' => $enquiryId
        ]);

        // Dispatch AI job
        ProcessEnquiryAI::dispatch($enquiryId);

    } catch (\Exception $e) {

        \Log::error('Enquiry store failed: ' . $e->getMessage());

        return back()->withErrors([
            'msg' => 'Something went wrong, please try again.'
        ]);
    }

    $slug = $request->slug;

    return redirect()->route('thank.you', $slug);
}



// excel


public function exportLead($id)
{
    return Excel::download(
        new LeadExport($id),
        'lead-'.$id.'.xlsx'
    );
}
public function showLead($id)
{
    // Lead Details
    $enquiry = DB::table('enquiries')
        ->leftJoin(
            'countries',
            'enquiries.country_id',
            '=',
            'countries.id'
        )
        ->leftJoin(
            'users',
            'enquiries.assigned_to',
            '=',
            'users.id'
        )
        ->select(
            'enquiries.*',
            'countries.name as country_name',
            'users.name as agent_name'
        )
        ->where('enquiries.id', $id)
        ->first();

    // Agents List
   // Agents List
$agents = collect();

if (
    session('role_id') != config('constants.roles.agent') ||
    session('can_assign_leads') == 1
) {
    $agents = DB::table('users')
        ->where('role_id', config('constants.roles.agent'))
        ->whereNull('deleted_at')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();
}

    // Followup History
    $followups = DB::table('enquiry_followups')
        ->where('enquiry_id', $id)
        ->orderBy('created_at', 'asc')
        ->get();

    // Latest Followup
    $latestFollowup = DB::table('enquiry_followups')
        ->where('enquiry_id', $id)
        ->latest('id')
        ->first();

    $emails = DB::table('ai_email_logs')
    ->leftJoin(
        'users',
        'ai_email_logs.agent_id',
        '=',
        'users.id'
    )
    ->select(
        'ai_email_logs.*',
        'users.name as agent_name'
    )
    ->where('ai_email_logs.enquiry_id', $id)
    ->orderBy('ai_email_logs.id', 'asc')
    ->get();
    

    return view(
        'admin.enquiry.show',
        compact(
            'enquiry',
            'agents',
            'followups',
            'latestFollowup',
            'emails'
        )
    );
}


public function assignAgent(Request $request)
{
    $request->validate([
        'enquiry_id' => 'required|exists:enquiries,id',
        'agent_id'   => 'required|exists:users,id',
    ]);

    DB::table('enquiries')
        ->where('id', $request->enquiry_id)
        ->update([
            'assigned_to' => $request->agent_id,
            'assigned_by' => session('user_id'),
            'updated_at'  => now(),
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Agent assigned successfully.'
    ]);
}
public function view($id)
{
    $enquiry = DB::table('enquiries')
        ->where('id', $id)
        ->first();

    $emails = DB::table('ai_email_logs')
        ->where('enquiry_id', $id)
        ->orderBy('email_date', 'asc')
        ->get();

    return view(
        'admin.enquiry.view',
        compact(
            'enquiry',
            'emails'
        )
    );
}


// upload sample report



public function sendSampleReport(Request $request)
{
    $lead = DB::table('enquiries')
        ->where('id', $request->enquiry_id)
        ->first();

    Mail::raw(
        $request->message .
        "\n\nSample Report:\n" .
        $request->sample_report_link,

        function ($mail) use ($lead) {

            $mail->to($lead->email)
                 ->subject('Sample Report');
        }
    );

    DB::table('sample_report_logs')->insert([

        'enquiry_id' => $lead->id,

        'report_link' => $request->sample_report_link,

        'message' => $request->message,

        'created_at' => now(),

        'updated_at' => now()

    ]);

    return back()
        ->with(
            'success',
            'Sample Report Sent Successfully'
        );
}
public function destroy($id)
{
    DB::table('enquiries')
       ->where('id', $id) 
        ->update([
            'deleted_at' => now()
        ]);

    return redirect()->back()->with('status', 'Enquiry deleted successfully!');
}

public function contactdestroy($id)
{
    DB::table('contact')
        ->where('id', $id)
        ->delete(); // ✅ Permanently remove record

    return redirect()->back()->with('status', 'Contact deleted successfully!');
}
 public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'contact'  => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'message'  => 'nullable|string',
            'page_url' => 'nullable|string',
            'page_name'=> 'nullable|string',
        ]);

        DB::table('contact')->insert([
            'name'       => $validated['name'],
            'contact'    => $validated['contact'],
            'email'      => $validated['email'],
            'message'    => $validated['message'] ?? null,
            'page_url'   => $validated['page_url'] ?? null,
            'page_name'  => $validated['page_name'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('contact.thank-you');
    }

}