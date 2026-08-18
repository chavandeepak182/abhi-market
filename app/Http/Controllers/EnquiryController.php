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
//  public function enquiryLead(Request $request)
// {
//     $roleId = session('role_id');
//     $userId = session('user_id');

//     $query = DB::table('enquiries')
//     ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
//     ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id') // ✅ ADD THIS
//     ->whereNull('enquiries.deleted_at')
//     ->orderBy('enquiries.created_at', 'desc')
//     ->select(
//         'enquiries.*',
//         'countries.name as country_name',
//         'users.name as agent_name'
//     );

//     // ✅ Agent restriction
//   if ($roleId == config('constants.roles.agent')) {

//     // ✅ Team Lead Agent
//     if (session('can_assign_leads') == 1) {

//         $query->where(function($q) use ($userId) {

//             $q->where('enquiries.assigned_to', $userId)
//               ->orWhere('enquiries.assigned_by', $userId);

//         });

//     } else {

//         // ✅ Normal agent
//         $query->where('enquiries.assigned_to', $userId);

//     }
// }

//     if ($request->type == 'today') {
//     $query->whereDate('enquiries.followup_date', \Carbon\Carbon::today());
// }

//     // =========================
// // ✅ FILTERS START
// // =========================

// // Status filter
// if ($request->filled('status')) {

//     if ($request->status == 'unassigned') {

//         // Show only unassigned leads
//         $query->whereNull('enquiries.assigned_to');

//     } else {

//         // Filter by lead status
//         $query->where('enquiries.status', $request->status);

//     }
// }

// // Agent filter
// if ($request->filled('agent')) {
//     $query->where('enquiries.assigned_to', $request->agent);
// }

// // Date filters
// if ($request->filled('from_date')) {
//     $query->whereDate('enquiries.created_at', '>=', $request->from_date);
// }

// if ($request->filled('to_date')) {
//     $query->whereDate('enquiries.created_at', '<=', $request->to_date);
// }

// // Email filter
// if ($request->filled('email')) {
//     $query->where('enquiries.email', 'like', '%' . $request->email . '%');
// }

// // =========================
// // ✅ FILTERS END
// // =========================

//     $enquiries = $query->paginate(50)->appends($request->all());
   

// $summaryQuery = clone $query;

// $totalLeads = $summaryQuery->count();

// $thisMonth = (clone $summaryQuery)
//     ->whereMonth('enquiries.created_at', Carbon::now()->month)
//     ->count();

// $todayLeads = (clone $summaryQuery)
//     ->whereDate('enquiries.created_at', Carbon::today())
//     ->count();

//     // Agents list (for admin filter dropdown)
//   $agents = [];

// // Admin OR agents with assign permission
// if (
//     $roleId != config('constants.roles.agent') ||
//     session('can_assign_leads') == 1
// ) {
//     $agents = DB::table('users')
//         ->where('role_id', config('constants.roles.agent'))
//         ->whereNull('deleted_at')
//         ->select('id', 'name')
//         ->get();
// }
// return view('admin.enquiry.index', compact(
//     'enquiries',
//     'agents',
//     'totalLeads',
//     'thisMonth',
//     'todayLeads'
// ));
// }
//  public function enquiryLead(Request $request)
// {
//     $roleId = session('role_id');
//     $userId = session('user_id');

//     $query = DB::table('enquiries')
//     ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
//     ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id') // ✅ ADD THIS
//     ->whereNull('enquiries.deleted_at')
//     ->orderBy('enquiries.created_at', 'desc')
//     ->select(
//         'enquiries.*',
//         'countries.name as country_name',
//         'users.name as agent_name'
//     );

//     // ✅ Agent restriction
//   if ($roleId == config('constants.roles.agent')) {

//     // ✅ Team Lead Agent
//     if (session('can_assign_leads') == 1) {

//         $query->where(function($q) use ($userId) {

//             $q->where('enquiries.assigned_to', $userId)
//               ->orWhere('enquiries.assigned_by', $userId);

//         });

//     } else {

//         // ✅ Normal agent
//         $query->where('enquiries.assigned_to', $userId);

//     }
// }

//     if ($request->type == 'today') {
//     $query->whereDate('enquiries.followup_date', \Carbon\Carbon::today());
// }

//     // =========================
// // ✅ FILTERS START
// // =========================

// // Status filter
// if ($request->filled('status')) {

//     if ($request->status == 'unassigned') {

//         // Show only unassigned leads
//         $query->whereNull('enquiries.assigned_to');

//     } else {

//         // Filter by lead status
//         $query->where('enquiries.status', $request->status);

//     }
// }

// // Agent filter
// if ($request->filled('agent')) {
//     $query->where('enquiries.assigned_to', $request->agent);
// }

// // Region filter
// if ($request->filled('region')) {
//     $query->where('enquiries.region_id', $request->region);
// }

// // Date filters

// // Date filters
// if ($request->filled('from_date')) {
//     $query->whereDate('enquiries.created_at', '>=', $request->from_date);
// }

// if ($request->filled('to_date')) {
//     $query->whereDate('enquiries.created_at', '<=', $request->to_date);
// }

// // Email filter
// if ($request->filled('email')) {
//     $query->where('enquiries.email', 'like', '%' . $request->email . '%');
// }

// // =========================
// // ✅ FILTERS END
// // =========================

//     $enquiries = $query->paginate(50)->appends($request->all());
   

// $summaryQuery = clone $query;

// $totalLeads = $summaryQuery->count();

// $thisMonth = (clone $summaryQuery)
//     ->whereMonth('enquiries.created_at', Carbon::now()->month)
//     ->count();

// $todayLeads = (clone $summaryQuery)
//     ->whereDate('enquiries.created_at', Carbon::today())
//     ->count();

//     // Agents list (for admin filter dropdown)
//   // Agents list (for admin filter dropdown)
// $agents = [];

// // Admin OR agents with assign permission
// if (
//     $roleId != config('constants.roles.agent') ||
//     session('can_assign_leads') == 1
// ) {
//     $agents = DB::table('users')
//         ->where('role_id', config('constants.roles.agent'))
//         ->whereNull('deleted_at')
//         ->select('id', 'name')
//         ->get();
// }

// // Region list
// $regions = DB::table('regions')
//     ->select('id', 'region_name')
//     ->orderBy('region_name')
//     ->get();

// return view('admin.enquiry.index', compact(
//     'enquiries',
//     'agents',
//     'regions',
//     'totalLeads',
//     'thisMonth',
//     'todayLeads'
// ));
// }
 public function enquiryLead(Request $request)
{
    $roleId = session('role_id');
    $userId = session('user_id');

        $query = DB::table('enquiries')
            ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
            ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id')
            ->whereNull('enquiries.deleted_at')
            ->orderBy('enquiries.created_at', 'desc')
            ->select(
                'enquiries.*',
                'countries.name as country_name',
                'users.name as agent_name'
            );

        // Agent restriction
        if ($roleId == config('constants.roles.agent')) {

            // Team Lead Agent
            if (session('can_assign_leads') == 1) {

                $query->where(function ($q) use ($userId) {

                    $q->where('enquiries.assigned_to', $userId)
                        ->orWhere('enquiries.assigned_by', $userId);

                });

            } else {

                // Normal agent
                $query->where('enquiries.assigned_to', $userId);

            }
        }

        if ($request->type == 'today') {
            $query->whereDate(
                'enquiries.followup_date',
                Carbon::today()
            );
        }

        // =========================
        // FILTERS START
        // =========================

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'enquiries.name',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'enquiries.email',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'enquiries.company_name',
                    'like',
                    '%' . $request->search . '%'
                );

            });
        }

        // Status filter
        if ($request->filled('status')) {

            if ($request->status == 'unassigned') {

                $query->whereNull('enquiries.assigned_to');

            } else {

                $query->where(
                    'enquiries.status',
                    $request->status
                );

            }
        }

        // Lead type filter
        if ($request->filled('lead_type')) {

            $query->where(
                'enquiries.lead_type',
                $request->lead_type
            );

        }

        // Agent filter
        if ($request->filled('agent')) {

            $query->where(
                'enquiries.assigned_to',
                $request->agent
            );

        }

        // Country filter
        if ($request->filled('country')) {

            $query->where(
                'countries.name',
                'like',
                '%' . $request->country . '%'
            );

        }

        // Timezone filter
        if ($request->filled('timezone')) {

            $query->where(
                'enquiries.timezone',
                'like',
                '%' . $request->timezone . '%'
            );

        }

        // Usage type filter
        if ($request->filled('usage_type')) {

            $query->where(
                'enquiries.usage_type',
                $request->usage_type
            );

        }

        // Date filters
        if ($request->filled('from_date')) {

            $query->whereDate(
                'enquiries.created_at',
                '>=',
                $request->from_date
            );

        }

        if ($request->filled('to_date')) {

            $query->whereDate(
                'enquiries.created_at',
                '<=',
                $request->to_date
            );

        }

        // Email filter
        if ($request->filled('email')) {

            $query->where(
                'enquiries.email',
                'like',
                '%' . $request->email . '%'
            );

        }

        // =========================
        // FILTERS END
        // =========================

        $perPage = (int) $request->input('per_page', 50);

        if (!in_array($perPage, [25, 50, 100, 200, 500], true)) {
            $perPage = 50;
        }

        $enquiries = $query
            ->paginate($perPage)
            ->appends($request->all());

        $summaryQuery = clone $query;

        $totalLeads = $summaryQuery->count();

        $thisMonth = (clone $summaryQuery)
            ->whereMonth(
                'enquiries.created_at',
                Carbon::now()->month
            )
            ->count();

        $todayLeads = (clone $summaryQuery)
            ->whereDate(
                'enquiries.created_at',
                Carbon::today()
            )
            ->count();

        $hotLeads = (clone $summaryQuery)
            ->where('enquiries.lead_type', 'hot')
            ->count();

        $warmLeads = (clone $summaryQuery)
            ->where('enquiries.lead_type', 'warm')
            ->count();

        $coldLeads = (clone $summaryQuery)
            ->where('enquiries.lead_type', 'cold')
            ->count();

        // Agents list
        $agents = [];

        if (
            $roleId != config('constants.roles.agent') ||
            session('can_assign_leads') == 1
        ) {

            $agents = DB::table('users')
                ->where(
                    'role_id',
                    config('constants.roles.agent')
                )
                ->whereNull('deleted_at')
                ->select('id', 'name')
                ->get();
        }

        return view(
            'admin.enquiry.index',
            compact(
                'enquiries',
                'agents',
                'totalLeads',
                'thisMonth',
                'todayLeads',
                'hotLeads',
                'warmLeads',
                'coldLeads'
            )
        );
    }

    public function todayFollowups(Request $request)
    {
        $userId = session('user_id');
        $roleId = session('role_id');

        $query = DB::table('enquiries')
            ->leftJoin(
                'users',
                'enquiries.assigned_to',
                '=',
                'users.id'
            )
            ->leftJoin(
                'countries',
                'enquiries.country_id',
                '=',
                'countries.id'
            )
            ->whereDate(
                'enquiries.followup_date',
                Carbon::today()
            )
            ->whereNull('enquiries.deleted_at')
            ->select(
                'enquiries.*',
                'users.name as agent_name',
                'countries.name as country_name',
                'countries.phone_code'
            );

        // Agent restriction
        if ($roleId == config('constants.roles.agent')) {

            $query->where(
                'enquiries.assigned_to',
                $userId
            );

        }

        $enquiries = $query->get();

        $todayCount = $enquiries->count();

        $selectedId = $request->id
            ?? ($enquiries->first()->id ?? null);

        $enquiry = null;
        $followups = collect();

        if ($selectedId) {

            $enquiry = DB::table('enquiries')
                ->leftJoin(
                    'countries',
                    'enquiries.country_id',
                    '=',
                    'countries.id'
                )
                ->select(
                    'enquiries.*',
                    'countries.name as country_name'
                )
                ->where(
                    'enquiries.id',
                    $selectedId
                )
                ->first();

            $followups = DB::table('enquiry_followups')
                ->where(
                    'enquiry_id',
                    $selectedId
                )
                ->whereNotNull('followup_date')
                ->whereNotNull('remark')
                ->where('remark', '!=', '')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view(
            'admin.followups.index',
            compact(
                'enquiries',
                'todayCount',
                'roleId'
            )
        );
    }

    public function followupDetail($id)
    {
        $userId = session('user_id');
        $roleId = session('role_id');

        $query = DB::table('enquiries')
            ->leftJoin(
                'countries',
                'enquiries.country_id',
                '=',
                'countries.id'
            )
            ->where(
                'enquiries.id',
                $id
            )
            ->select(
                'enquiries.*',
                'countries.name as country_name',
                'countries.phone_code'
            );

        // ✅ Agent restriction - UPDATED
        if ($roleId == config('constants.roles.agent')) {

            $query->where(
                'enquiries.assigned_to',
                $userId
            );

        }

        $enquiry = $query->first();

        $followups = DB::table('enquiry_followups')
            ->where(
                'enquiry_id',
                $id
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'admin.followups.detail',
            compact(
                'enquiry',
                'followups'
            )
        );
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

            // ✅ ADDED
            'lead_type' => 'nullable|in:hot,warm,cold',

            'converted_amount' => 'nullable|numeric',

            'job_title' => 'nullable|string|max:255'

        ]);

        // Convert followup dates
        $followupDates = [];

        if ($request->followup_date) {

            foreach (
                $request->followup_date as $key => $date
            ) {

                $followupDates[$key] = !empty($date)
                    ? Carbon::parse($date)->format('Y-m-d H:i:s')
                    : null;

            }

        }

        // Base query
        $query = DB::table('enquiries')
            ->where(
                'id',
                $request->id
            );

        // Agent restriction
        if ($roleId == config('constants.roles.agent')) {

            $query->where(
                'enquiries.assigned_to',
                $userId
            );

        }

        // Check exists
        if (!$query->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unauthorized or lead not found'
                );

        }

        // =========================================
        // FOLLOWUP INSERT / UPDATE
        // =========================================

        if ($request->followup_date) {

            foreach (
                $request->followup_date as $key => $date
            ) {

                // Skip empty row
                if (
                    empty($date) &&
                    empty($request->remark[$key] ?? null)
                ) {
                    continue;
                }

                // UPDATE EXISTING FOLLOWUP
                if (!empty($request->followup_id[$key])) {

                    DB::table('enquiry_followups')
                        ->where(
                            'id',
                            $request->followup_id[$key]
                        )
                        ->update([

                            'followup_date' =>
                                $followupDates[$key] ?? null,

                            'remark' =>
                                $request->remark[$key] ?? null,

                            'client_reply' =>
                                $request->client_reply[$key] ?? null,

                            'status' =>
                                $request->status,

                            'lead_type' =>
                                $request->lead_type,

                            'job_title' =>
                                $request->job_title,

                            'updated_at' => now()

                        ]);

                }

                // INSERT NEW FOLLOWUP
                else {

                    DB::table('enquiry_followups')
                        ->insert([

                            'enquiry_id' =>
                                $request->id,

                            'followup_date' =>
                                $followupDates[$key] ?? null,

                            'remark' =>
                                $request->remark[$key] ?? null,

                            'status' =>
                                $request->status,

                            'lead_type' =>
                                $request->lead_type,

                            'client_reply' =>
                                $request->client_reply[$key] ?? null,

                            'job_title' =>
                                $request->job_title,

                            'user_id' =>
                                session('user_id'),

                            'created_at' => now()

                        ]);

                }

            }

        }

        // Latest remark
        $remarks = $request->remark ?? [];

        // Update enquiry table
        $updateData = [

            'status' => $request->status,

            'followup_date' => !empty($followupDates)
                ? end($followupDates)
                : null,

            'remark' => !empty($remarks)
                ? end($remarks)
                : null,

            'job_title' => $request->job_title,

            'converted_amount' =>
                $request->status == 'converted'
                    ? $request->converted_amount
                    : null,

            'lead_type' =>
                $request->status == 'contacted'
                    ? $request->lead_type
                    : null,

            'updated_at' => now()

        ];

        // Only admin/team lead can assign
        if (
            $roleId != config('constants.roles.agent') ||
            session('can_assign_leads') == 1
        ) {

            $updateData['assigned_to'] =
                $request->assigned_to;

            $updateData['assigned_by'] =
                session('user_id');

        }

        // Update enquiry
        $query->update($updateData);

        return redirect()
            ->route('enquiries.enquiryLead')
            ->with(
                'success',
                'Lead updated successfully.'
            );
    }

    public function contactLead()
    {
        $contacts = DB::table('contact')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view(
            'contact.index',
            compact('contacts')
        );
    }

    public function showForm()
    {
        return view('frontend.enquiry-form');
    }
//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'name'         => 'required|string|max:255',
//         'email'        => 'required|email|max:255',
//         'contact'      => 'required|string|max:15',
//         'amount'       => 'nullable|numeric',
//         'address'      => 'nullable|string',
//         'message'      => 'nullable|string',
//         'enquiry_type' => 'nullable|string',
//         'page_url'     => 'nullable|url',
//         'page_name'    => 'nullable|string',
//         'job_title'    => 'nullable|string|max:255',
//         'company_name' => 'nullable|string|max:255',
//         'country_id'   => 'nullable|exists:countries,id',
//         'usage_type'   => 'required|in:personal,office',
//     ]);

//     try {

//         // Get selected country
//         $country = null;

//         if (!empty($validated['country_id'])) {

//             $country = DB::table('countries')
//                 ->where('id', $validated['country_id'])
//                 ->first();
//         }

//         // =========================
//         // ✅ Region Logic
//         // =========================

//         $regionId = $country->region_id ?? null;

//         // =========================
//         // ✅ Auto Lead Assignment
//         // =========================

//         // APAC → Amol
//         if ($regionId == 1) {

//             $assignedTo = 30;

//         } else {

//             // Other Regions → Tarun
//             $assignedTo = 29;
//         }

//         // Save enquiry
//         $enquiryId = DB::table('enquiries')->insertGetId([

//             'name'            => $validated['name'],
//             'email'           => $validated['email'],
//             'contact'         => $validated['contact'],
//             'amount'          => $validated['amount'] ?? null,
//             'address'         => $validated['address'] ?? null,
//             'message'         => $validated['message'] ?? null,
//             'enquiry_type'    => $validated['enquiry_type'] ?? null,
//             'page_url'        => $validated['page_url'] ?? null,
//             'page_name'       => $validated['page_name'] ?? null,
//             'job_title'       => $validated['job_title'] ?? null,
//             'company_name'    => $validated['company_name'] ?? null,
//             'country_id'      => $validated['country_id'] ?? null,
//             'phone_code'      => $country->phone_code ?? null,
//             'visitor_country' => null,
//             'usage_type'      => $validated['usage_type'],

//             // ✅ Added Region Logic
//             'region_id'       => $regionId,
//             'assigned_to'     => $assignedTo,

//             'created_at'      => now(),
//             'updated_at'      => now(),
//         ]);

//         \Log::info('Enquiry saved successfully.', [
//             'enquiry_id' => $enquiryId
//         ]);

//         // Dispatch AI job
//         ProcessEnquiryAI::dispatch($enquiryId);

//     } catch (\Exception $e) {

//         \Log::error('Enquiry store failed: ' . $e->getMessage());

//         return back()->withErrors([
//             'msg' => 'Something went wrong, please try again.'
//         ]);
//     }

//     $slug = $request->slug;

//     return redirect()->route('thank.you', $slug);
// }
public function store(Request $request)
{
    
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        // 'email'        => 'required|email|max:255',
        'email' => 'required|email:rfc,dns|max:255',
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

Log::info('Google Response', $result);

        Log::info(
            '===== RECAPTCHA DEBUG ====='
        );

        Log::info(
            'Token:',
            [
                'token' =>
                    $request->input(
                        'g-recaptcha-response'
                    )
            ]
        );

        Log::info(
            'Google Response:',
            $result
        );

        if (
            !isset($result['success']) ||
            $result['success'] !== true
        ) {

            Log::error(
                'Recaptcha Failed',
                [
                    'response' => $result
                ]
            );

            return back()
                ->withInput()
                ->withErrors([
                    'captcha' =>
                        'Captcha verification failed.'
                ]);

        }

Log::info('reCAPTCHA Passed', [
    'score' => $result['score'],
    'action' => $result['action'],
]);
// =========================
// EMAIL TYPE DETECTION
// =========================

$email = strtolower(trim($validated['email']));

$personalEmailDomains = [
    'gmail.com',
    'googlemail.com',
    'yahoo.com',
    'yahoo.in',
    'hotmail.com',
    'outlook.com',
    'live.com',
    'icloud.com',
    'me.com',
    'mac.com',
    'aol.com',
    'protonmail.com',
    'proton.me',
    'mail.com',
    'zoho.com',
];

$emailDomain = '';

if (str_contains($email, '@')) {
    $emailDomain = strtolower(
        trim(substr(strrchr($email, '@'), 1))
    );
}

$emailType = in_array($emailDomain, $personalEmailDomains, true)
    ? 'personal'
    : 'business';
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
// ✅ Region IDs
// =========================

// APAC
$apacRegions = [1];

// North America + Latin America
$americaRegions = [2, 3];

// Europe
$europeRegions = [4];

// Middle East
$middleEastRegions = [5];


// =========================
// ✅ Auto Lead Assignment
// =========================

if (in_array($regionId, $americaRegions)) {

    // 🇺🇸 North America + 🌎 Latin America
    $assignedTo = 81;

} elseif (in_array($regionId, $apacRegions) || in_array($regionId, $middleEastRegions)) {

    // 🌏 APAC + 🌍 Middle East
    $assignedTo = 28;

} elseif (in_array($regionId, $europeRegions)) {

    // 🇪🇺 Europe
    $assignedTo = 30;

} else {

    // Other / Unknown regions
    $assignedTo = 28;
}  
// Prevent duplicate submission within 2 minutes
$alreadySubmitted = DB::table('enquiries')
    ->where('email', $validated['email'])
    ->where('page_name', $validated['page_name'])
    ->where('created_at', '>=', now()->subMinutes(2))
    ->exists();

if ($alreadySubmitted) {
    return redirect()->route('thank.you', $request->slug);
}

        // Save enquiry
       $enquiryId = DB::table('enquiries')->insertGetId([

                    'name' =>
                        $validated['name'],

                    'email' =>
                        $validated['email'],

                    'contact' =>
                        $validated['contact'],

                    'amount' =>
                        $validated['amount'] ?? null,

                    'address' =>
                        $validated['address'] ?? null,

                    'message' =>
                        $validated['message'] ?? null,

                    'enquiry_type' =>
                        $validated['enquiry_type'] ?? null,

                    'page_url' =>
                        $validated['page_url'] ?? null,

                    'page_name' =>
                        $validated['page_name'] ?? null,

                    'job_title' =>
                        $validated['job_title'] ?? null,

                    'company_name' =>
                        $validated['company_name'] ?? null,

                    'country_id' =>
                        $validated['country_id'] ?? null,

                    'phone_code' =>
                        $country->phone_code ?? null,

                    'visitor_country' =>
                        null,

                    'usage_type' =>
                        $validated['usage_type'],

                    'region_id' =>
                        $regionId,

                    'timezone' =>
                        $timezone,

                    'timezone_region' =>
                        $timezoneRegion,

                    'assigned_to' =>
                        $assignedTo,

                    'created_at' =>
                        now(),

                    'updated_at' =>
                        now(),

                ]);

            Log::info(
                'Enquiry saved successfully.',
                [
                    'enquiry_id' =>
                        $enquiryId
                ]
            );

        // Dispatch AI job
        // ProcessEnquiryAI::dispatch($enquiryId);

        } catch (\Exception $e) {

            Log::error(
                'Enquiry store failed: ' .
                $e->getMessage()
            );

            return back()
                ->withErrors([
                    'msg' =>
                        'Something went wrong, please try again.'
                ]);

        }

        $slug = $request->slug;

    return redirect()->route('thank.you', $slug);
}


    // Excel
    public function exportLead($id)
    {
        return Excel::download(
            new LeadExport($id),
            'lead-' . $id . '.xlsx'
        );
    }

    public function showLead($id)
    {
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
            ->where(
                'enquiries.id',
                $id
            )
            ->first();

        $agents = collect();

        if (
            session('role_id') !=
                config('constants.roles.agent') ||
            session('can_assign_leads') == 1
        ) {

            $agents = DB::table('users')
                ->where(
                    'role_id',
                    config('constants.roles.agent')
                )
                ->whereNull('deleted_at')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

        }

        $followups = DB::table('enquiry_followups')
            ->where(
                'enquiry_id',
                $id
            )
            ->orderBy('created_at', 'asc')
            ->get();

        $latestFollowup =
            DB::table('enquiry_followups')
                ->where(
                    'enquiry_id',
                    $id
                )
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
            ->where(
                'ai_email_logs.enquiry_id',
                $id
            )
            ->orderBy(
                'ai_email_logs.id',
                'asc'
            )
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
            'enquiry_id' =>
                'required|exists:enquiries,id',

            'agent_id' =>
                'required|exists:users,id',
        ]);

        DB::table('enquiries')
            ->where(
                'id',
                $request->enquiry_id
            )
            ->update([

                'assigned_to' =>
                    $request->agent_id,

                'assigned_by' =>
                    session('user_id'),

                'updated_at' =>
                    now(),

            ]);

        return response()->json([
            'success' => true,
            'message' =>
                'Agent assigned successfully.'
        ]);
    }

    public function view($id)
    {
        $enquiry = DB::table('enquiries')
            ->where(
                'id',
                $id
            )
            ->first();

        $emails = DB::table('ai_email_logs')
            ->where(
                'enquiry_id',
                $id
            )
            ->orderBy(
                'email_date',
                'asc'
            )
            ->get();

        return view(
            'admin.enquiry.view',
            compact(
                'enquiry',
                'emails'
            )
        );
    }

    public function sendSampleReport(Request $request)
    {
        $lead = DB::table('enquiries')
            ->where(
                'id',
                $request->enquiry_id
            )
            ->first();

        Mail::raw(
            $request->message .
            "\n\nSample Report:\n" .
            $request->sample_report_link,

            function ($mail) use ($lead) {

                $mail->to($lead->email)
                    ->subject(
                        'Sample Report'
                    );

            }
        );

        DB::table('sample_report_logs')
            ->insert([

                'enquiry_id' =>
                    $lead->id,

                'report_link' =>
                    $request->sample_report_link,

                'message' =>
                    $request->message,

                'created_at' =>
                    now(),

                'updated_at' =>
                    now()

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
            ->where(
                'id',
                $id
            )
            ->update([
                'deleted_at' => now()
            ]);

        return redirect()
            ->back()
            ->with(
                'status',
                'Enquiry deleted successfully!'
            );
    }

    public function contactdestroy($id)
    {
        DB::table('contact')
            ->where(
                'id',
                $id
            )
            ->delete();

        return redirect()
            ->back()
            ->with(
                'status',
                'Contact deleted successfully!'
            );
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'contact' =>
                'required|string|max:20',

            'email' =>
                'required|email|max:255',

            'message' =>
                'nullable|string',

            'page_url' =>
                'nullable|string',

            'page_name' =>
                'nullable|string',

        ]);

        DB::table('contact')
            ->insert([

                'name' =>
                    $validated['name'],

                'contact' =>
                    $validated['contact'],

                'email' =>
                    $validated['email'],

                'message' =>
                    $validated['message'] ?? null,

                'page_url' =>
                    $validated['page_url'] ?? null,

                'page_name' =>
                    $validated['page_name'] ?? null,

                'created_at' =>
                    now(),

                'updated_at' =>
                    now(),

            ]);

        return redirect()
            ->route(
                'contact.thank-you'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Shared lead-detail actions
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([
            'status' =>
                'required|string|max:50',
        ]);

        $enquiry->update([
            'status' =>
                $request->status
        ]);

        \App\Models\EnquiryActivity::create([

            'enquiry_id' =>
                $enquiry->id,

            'user_id' =>
                session('user_id'),

            'activity_type' =>
                'status',

            'description' =>
                'Status changed to ' .
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $request->status
                    )
                ) .
                '.',

        ]);

        return back()
            ->with(
                'success',
                'Status updated successfully.'
            );
    }

    public function storeNote(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([
            'note' =>
                'required|string',
        ]);

        \App\Models\EnquiryActivity::create([

            'enquiry_id' =>
                $enquiry->id,

            'user_id' =>
                session('user_id'),

            'activity_type' =>
                'note',

            'description' =>
                $request->note,

        ]);

        return back()
            ->with(
                'success',
                'Note added successfully.'
            );
    }

    public function sendEmailShared(
        Request $request,
        $id
    ) {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([

            'subject' =>
                'required|string|max:255',

            'body' =>
                'required|string',

        ]);

        $deliveryStatus = 'sent';
        $deliveryError = null;

        try {

            Mail::send(
                [],
                [],
                function ($message)
                    use ($request, $enquiry) {

                    $message
                        ->to($enquiry->email)
                        ->subject(
                            $request->subject
                        )
                        ->html(
                            $request->body
                        );

                }
            );

        } catch (\Throwable $e) {

            $deliveryStatus = 'failed';

            $deliveryError =
                $e->getMessage();

        }

        DB::table('ai_email_logs')
            ->insert([

                'enquiry_id' =>
                    $enquiry->id,

                'agent_id' =>
                    session('user_id'),

                'source' =>
                    'manual',

                'message_type' =>
                    'sent',

                'delivery_status' =>
                    $deliveryStatus,

                'delivery_error' =>
                    $deliveryError,

                'email_subject' =>
                    $request->subject,

                'email_body' =>
                    $request->body,

                'subject' =>
                    $request->subject,

                'body' =>
                    $request->body,

                'from_email' =>
                    config(
                        'mail.from.address'
                    ),

                'to_email' =>
                    $enquiry->email,

                'status' =>
                    $deliveryStatus === 'sent'
                        ? 'sent'
                        : 'failed',

                'created_at' =>
                    now(),

                'updated_at' =>
                    now(),

            ]);

        \App\Models\EnquiryActivity::create([

            'enquiry_id' =>
                $enquiry->id,

            'user_id' =>
                session('user_id'),

            'activity_type' =>
                'email',

            'description' =>
                $deliveryStatus === 'sent'
                    ? 'Email sent: ' .
                        $request->subject
                    : 'Email failed to send: ' .
                        $request->subject,

        ]);

        if (
            $deliveryStatus === 'failed'
        ) {

            return back()
                ->with(
                    'error',
                    'Email could not be sent: ' .
                    $deliveryError
                );

        }

        return back()
            ->with(
                'success',
                'Email sent successfully.'
            );
    }

    public function storeMeeting(
        Request $request,
        $id
    ) {
        $enquiry =
            Enquiry::findOrFail($id);

        $request->validate([

            'title' =>
                'nullable|string|max:255',

            'scheduled_at' =>
                'required|date',

            'duration_minutes' =>
                'nullable|integer|min:5|max:480',

            'notes' =>
                'nullable|string',

        ]);

        $meeting =
            \App\Models\Meeting::create([

                'enquiry_id' =>
                    $enquiry->id,

                'user_id' =>
                    session('user_id'),

                'title' =>
                    $request->title
                        ?: 'Meeting with ' .
                            $enquiry->name,

                'scheduled_at' =>
                    $request->scheduled_at,

                'duration_minutes' =>
                    $request->duration_minutes
                        ?: 30,

                'notes' =>
                    $request->notes,

                'status' =>
                    'scheduled',

            ]);

        \App\Models\EnquiryActivity::create([

            'enquiry_id' =>
                $enquiry->id,

            'user_id' =>
                session('user_id'),

            'activity_type' =>
                'meeting',

            'description' =>
                'Meeting scheduled for ' .
                $meeting
                    ->scheduled_at
                    ->format(
                        'd M Y, h:i A'
                    ) .
                '.',

        ]);

        return back()
            ->with(
                'success',
                'Meeting scheduled successfully.'
            );
    }

   public function upcomingMeetings()
{
    $userId = session('user_id');

    $now = now();

    $meetings = DB::table('lead_meetings')
        ->join('enquiries', 'lead_meetings.enquiry_id', '=', 'enquiries.id')
        ->where('lead_meetings.user_id', $userId)
        ->where('lead_meetings.conducted', 0)
        ->whereBetween(
            'lead_meetings.meeting_at',
            [$now, $now->copy()->addHours(24)]
        )
        ->orderBy('lead_meetings.meeting_at')
        ->select(
            'lead_meetings.id',
            'lead_meetings.meeting_at',
            'lead_meetings.agenda',
            'enquiries.id as enquiry_id',
            'enquiries.name',
            'enquiries.email'
        )
        ->get()
        ->map(function ($meeting) use ($now) {

            $meetingTime = Carbon::parse($meeting->meeting_at);

            $minutesUntil = $now->diffInMinutes($meetingTime, false);

            if ($minutesUntil <= 5) {
                $reminder = 'starting_soon';
            } elseif ($minutesUntil <= 15) {
                $reminder = '15_minutes';
            } elseif ($minutesUntil <= 30) {
                $reminder = '30_minutes';
            } else {
                $reminder = 'upcoming';
            }

            return [
                'id'            => $meeting->id,
                'enquiry_id'    => $meeting->enquiry_id,
                'name'          => $meeting->name,
                'email'         => $meeting->email,
                'agenda'        => $meeting->agenda,
                'meeting_at'    => $meeting->meeting_at,
                'minutes_until' => $minutesUntil,
                'reminder'      => $reminder,
            ];
        });

    return response()->json($meetings);
}
}