<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\Users;
use App\Models\Activity;
use DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class AgentController extends Controller
{
    /**
     * The 8 canonical broad timezone regions used for auto-assignment
     * (App\Services\TimezoneRegionMapper). Not a DB-backed list - the
     * agent_regions table just stores these names against a user_id, so
     * we keep the master list here instead of a separate `regions` table.
     */
    private const REGIONS = [
        'North America',
        'South America',
        'Europe',
        'Africa',
        'Middle East',
        'South Asia',
        'East Asia',
        'Australia & Oceania',
    ];

    private function regionOptions()
    {
        return collect(self::REGIONS)->map(fn ($name) => (object) [
            'id' => $name,
            'name' => $name,
        ]);
    }

    /**
     * /admin/agents - list all agents with lead counts, regions covered,
     * team-lead flag, and active/inactive status.
     */
    public function index()
    {
        $agents = DB::table('users')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.role_id', config('constants.roles.agent'))
            ->whereNull('users.deleted_at')
            ->select('users.*', 'profile.mobile_no')
            ->orderBy('users.name')
            ->get();

        $leadCounts = DB::table('enquiries')
            ->whereNull('deleted_at')
            ->whereNotNull('assigned_to')
            ->select('assigned_to', DB::raw('count(*) as total'))
            ->groupBy('assigned_to')
            ->pluck('total', 'assigned_to');

        $regionNames = DB::table('agent_regions')
            ->select('user_id', 'region_name')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($rows) => $rows->pluck('region_name')->implode(', '));

        return view('admin.agents.index', compact('agents', 'leadCounts', 'regionNames'));
    }

    public function create()
    {
        $regions = $this->regionOptions();

        return view('admin.agents.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email_id'  => 'required|email|unique:users,email_id',
            'mobile_no' => 'nullable|string|max:20',
            'password'  => 'required|string|min:6',
            'app_password' => 'required|string|min:6',
            'regions'   => 'nullable|array',
            'regions.*' => 'in:' . implode(',', self::REGIONS),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $userId = DB::table('users')->insertGetId([
                'name'             => $request->name,
                'email_id'         => $request->email_id,
                'password'         => md5($request->password),
                // Gmail displays App Passwords with spaces between each
                // 4-char group ("abcd efgh ijkl mnop") purely for
                // readability - the real credential has no spaces. Strip
                // all whitespace so a straight copy-paste from Gmail still
                // works, then encrypt at rest (it has to be readable back
                // in plain text later to authenticate outgoing SMTP as
                // this agent, so it's encrypted, not hashed).
                'mail_password'    => Crypt::encryptString(
                    preg_replace('/\s+/', '', $request->app_password)
                ),
                'role_id'          => config('constants.roles.agent'),
                'can_assign_leads' => $request->boolean('can_assign_leads') ? 1 : 0,
                'active'           => 1,
                'is_email_verify'  => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // Only fills the columns actually used elsewhere in the code
            // (mirrors UsersController::insertUser's approach). If your
            // `profile` table has other NOT NULL columns, this insert will
            // fail below with a clear message instead of silently breaking
            // anything - the whole thing rolls back.
            DB::table('profile')->insert([
                'user_id'    => $userId,
                'mobile_no'  => $request->mobile_no,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $regions = collect($request->input('regions', []))->filter();

            if ($regions->isNotEmpty()) {
                $rows = $regions->map(fn ($region) => [
                    'user_id'     => $userId,
                    'region_name' => $region,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ])->all();

                DB::table('agent_regions')->insert($rows);
            }

            DB::commit();

            return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Agent creation failed', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Could not create agent: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agent = DB::table('users')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->where('users.role_id', config('constants.roles.agent'))
            ->whereNull('users.deleted_at')
            ->select('users.*', 'profile.mobile_no')
            ->first();

        abort_if(! $agent, 404);

        $regions = $this->regionOptions();

        $assignedRegionIds = DB::table('agent_regions')
            ->where('user_id', $id)
            ->pluck('region_name')
            ->all();

        return view('admin.agents.edit', compact('agent', 'regions', 'assignedRegionIds'));
    }

    public function update(Request $request, $id)
    {
        $agent = DB::table('users')
            ->where('id', $id)
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->first();

        abort_if(! $agent, 404);

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email_id'  => 'required|email|unique:users,email_id,' . $id,
            'mobile_no' => 'nullable|string|max:20',
            'password'  => 'nullable|string|min:6',
            'regions'   => 'nullable|array',
            'regions.*' => 'in:' . implode(',', self::REGIONS),
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $userUpdate = [
                'name'             => $request->name,
                'email_id'         => $request->email_id,
                'can_assign_leads' => $request->boolean('can_assign_leads') ? 1 : 0,
                'active'           => $request->boolean('active') ? 1 : 0,
                'updated_at'       => now(),
            ];

            // Matches the existing login (FrontendController::userLogin),
            // which compares md5($password) - not Hash::make(). Only
            // applied if a new password was actually provided.
            if ($request->filled('password')) {
                $userUpdate['password'] = md5($request->password);
            }

            DB::table('users')->where('id', $id)->update($userUpdate);

            DB::table('profile')->updateOrInsert(
                ['user_id' => $id],
                ['mobile_no' => $request->mobile_no, 'updated_at' => now()]
            );

            DB::table('agent_regions')->where('user_id', $id)->delete();

            $regions = collect($request->input('regions', []))->filter();

            if ($regions->isNotEmpty()) {
                $rows = $regions->map(fn ($region) => [
                    'user_id'     => $id,
                    'region_name' => $region,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ])->all();

                DB::table('agent_regions')->insert($rows);
            }

            DB::commit();

            return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Agent update failed', ['error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Could not update agent: ' . $e->getMessage());
        }
    }

    /**
     * Quick Activate / Deactivate toggle from the agents list, without
     * going through the full edit form.
     */
   public function toggleStatus($id)
{
    $agent = DB::table('users')
        ->where('id', $id)
        ->where('role_id', config('constants.roles.agent'))
        ->whereNull('deleted_at')
        ->first();

    if (!$agent) {
        return redirect()
            ->route('agents.index')
            ->with('error', 'Agent not found.');
    }

    $newStatus = ((int) ($agent->active ?? 1) === 1) ? 0 : 1;

    DB::table('users')
        ->where('id', $id)
        ->update([
            'active' => $newStatus,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('agents.index')
        ->with(
            'success',
            $newStatus
                ? $agent->name . ' has been activated.'
                : $agent->name . ' has been deactivated.'
        );
}

    /**
     * Admin sets a brand-new password directly, no old password required.
     */
    public function resetPassword(Request $request, $id)
    {
        $agent = DB::table('users')
            ->where('id', $id)
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->first();

        abort_if(! $agent, 404);

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::table('users')->where('id', $id)->update([
            'password'   => md5($request->password),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Password reset successfully for ' . $agent->name . '.');
    }

    /**
     * Soft-delete an agent. Their historical leads stay assigned to them -
     * nothing gets orphaned or reassigned automatically.
     */
    public function destroy($id)
    {
        $agent = DB::table('users')
            ->where('id', $id)
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->first();

        abort_if(! $agent, 404);

        DB::table('users')->where('id', $id)->update([
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent removed. Their existing leads stay assigned to them.');
    }

    /**
     * /admin/agents/{id} - agent detail: profile summary + every lead
     * currently assigned to them, with status/date filters (same filters
     * as the main enquiries screen).
     */
    public function show(Request $request, $id)
    {
        $agent = DB::table('users')
            ->leftJoin('profile', 'profile.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->where('users.role_id', config('constants.roles.agent'))
            ->whereNull('users.deleted_at')
            ->select('users.*', 'profile.mobile_no')
            ->first();

        abort_if(! $agent, 404);

        $regionNames = DB::table('agent_regions')
            ->where('user_id', $id)
            ->pluck('region_name');

        $leadsQuery = DB::table('enquiries')
            ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
            ->whereNull('enquiries.deleted_at')
            ->where('enquiries.assigned_to', $id)
            ->select('enquiries.*', 'countries.name as country_name');

        if ($request->filled('status')) {
            $leadsQuery->where('enquiries.status', $request->status);
        }

        if ($request->filled('from_date')) {
            $leadsQuery->whereDate('enquiries.created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $leadsQuery->whereDate('enquiries.created_at', '<=', $request->to_date);
        }

        $leads = $leadsQuery->latest('enquiries.created_at')->paginate(10)->withQueryString();

        $totalLeads = DB::table('enquiries')
            ->whereNull('deleted_at')
            ->where('assigned_to', $id)
            ->count();

        $convertedLeads = DB::table('enquiries')
            ->whereNull('deleted_at')
            ->where('assigned_to', $id)
            ->where('status', 'converted')
            ->count();

        return view('admin.agents.show', compact('agent', 'leads', 'regionNames', 'totalLeads', 'convertedLeads'));
    }

    /**
     * /admin/agent-regions - grid to tick which region(s) each agent
     * covers. Drives EnquiryController's auto-assignment of new leads.
     */
    public function regionsIndex()
    {
        $agents = DB::table('users')
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $regions = $this->regionOptions();

        $assigned = DB::table('agent_regions')
            ->select('user_id', 'region_name')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($rows) => $rows->pluck('region_name')->all());

        return view('admin.agents.regions', compact('agents', 'regions', 'assigned'));
    }

    public function regionsUpdate(Request $request)
    {
        $regionsInput = $request->input('regions', []); // [agent_id => [region_name, ...]]

        DB::beginTransaction();

        try {
            DB::table('agent_regions')->truncate();

            $rows = [];

            foreach ($regionsInput as $agentId => $regionNames) {
                foreach ($regionNames as $regionName) {
                    if (! in_array($regionName, self::REGIONS, true)) {
                        continue;
                    }

                    $rows[] = [
                        'user_id'     => (int) $agentId,
                        'region_name' => $regionName,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
            }

            if (! empty($rows)) {
                DB::table('agent_regions')->insert($rows);
            }

            DB::commit();

            return back()->with('success', 'Region assignments saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Region assignment update failed', ['error' => $e->getMessage()]);

            return back()->with('error', 'Could not save region assignments: ' . $e->getMessage());
        }
    }

    public function dashboard()
{
    Log::info('Agent Dashboard Hit', [
        'session' => session()->all()
    ]);
$userId = session('user_id');
    $reportsCount = DB::table('reports')->count();
    $newLeadsCount = DB::table('enquiries')
    ->whereNull('deleted_at')
    ->where('assigned_to', $userId)
    ->where('status', 'new')
    ->count();

$todaysLeadsCount = DB::table('enquiries')
    ->whereNull('deleted_at')
    ->where('assigned_to', $userId)
    ->whereDate('created_at', Carbon::today())
    ->count();
     $enquiriesCount = DB::table('enquiries')
        ->whereNull('deleted_at')
        ->where('assigned_to', $userId)
        ->count();

    return view('agent.dashboard', compact(
        'reportsCount',
        'newLeadsCount',
        'todaysLeadsCount',
        'enquiriesCount'
    ));
}
public function newLeads()
{
    $userId = session('user_id');

    $leads = DB::table('enquiries')
        ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
        ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id')
        ->whereNull('enquiries.deleted_at')
        ->where('enquiries.assigned_to', $userId)
        ->where('enquiries.status', 'new')
        ->select(
            'enquiries.*',
            'countries.name as country_name',
            'users.name as agent_name'
        )
        ->latest('enquiries.created_at')
        ->paginate(10);

    $agents = [];

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

    return view('agent.new-leads', compact('leads', 'agents'));
}
public function todayLeads()
{
    $leads = DB::table('enquiries')
        ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
        ->leftJoin('users', 'enquiries.assigned_to', '=', 'users.id')
        ->whereNull('enquiries.deleted_at')
        ->whereDate('enquiries.created_at', today())
        ->select(
            'enquiries.*',
            'countries.name as country_name',
            'users.name as agent_name'
        )
        ->orderBy('enquiries.created_at', 'desc')
        ->paginate(10);

    $agents = [];

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

    return view('agent.today-leads', compact('leads', 'agents'));
}

/*
|--------------------------------------------------------------------------
| Agent lead detail page (CRM-style, mirrors admin/leads/show.blade.php)
|--------------------------------------------------------------------------
*/

public function leadDetails($id)
{
    $lead = \App\Models\Enquiry::findOrFail($id);

    if ($lead->has_unread_reply) {
        $lead->update(['has_unread_reply' => false]);
    }

    $activities = $lead->activities()->with('user')->get();
    $mails = $lead->emails()->orderBy('created_at')->get();
    $meetings = $lead->meetings()->orderBy('scheduled_at', 'desc')->get();
    $followups = DB::table('enquiry_followups')
        ->where('enquiry_id', $lead->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('agent.lead-details', compact('lead', 'activities', 'mails', 'meetings', 'followups'));
}

/*
|--------------------------------------------------------------------------
| My Enquiries list (agent.leads)
|--------------------------------------------------------------------------
*/

public function myLeads(Request $request)
{
    $agentId = session('user_id');

    $query = \App\Models\Enquiry::where('assigned_to', $agentId);

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('lead_type')) {
        $query->where('lead_type', $request->lead_type);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('company_name', 'like', "%{$search}%");
        });
    }

    $leads = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

    $baseQuery = \App\Models\Enquiry::where('assigned_to', $agentId);
    $totalLeads = (clone $baseQuery)->count();
    $hotLeads = (clone $baseQuery)->where('lead_type', 'hot')->count();
    $warmLeads = (clone $baseQuery)->where('lead_type', 'warm')->count();
    $coldLeads = (clone $baseQuery)->where('lead_type', 'cold')->count();

    return view('agent.my-leads', compact('leads', 'totalLeads', 'hotLeads', 'warmLeads', 'coldLeads'));
}

/*
|--------------------------------------------------------------------------
| Calendar - followups assigned to this agent
|--------------------------------------------------------------------------
*/

public function calendar()
{
    $followups = \App\Models\Enquiry::where('assigned_to', session('user_id'))
        ->whereNotNull('followup_date')
        ->orderBy('followup_date')
        ->get();

    return view('agent.calendar', compact('followups'));
}

/*
|--------------------------------------------------------------------------
| Today's Tasks dashboard (agent.tasks)
|--------------------------------------------------------------------------
*/

public function todayTasks()
{
    $agentId = session('user_id');

    $todayLeads = \App\Models\Enquiry::where('assigned_to', $agentId)
        ->whereDate('created_at', today())
        ->get();

    $followups = \App\Models\Enquiry::where('assigned_to', $agentId)
        ->whereDate('followup_date', today())
        ->get();

    foreach ($todayLeads as $lead) {
        \App\Services\TaskPriorityService::applyLeadMeta($lead);
    }

    foreach ($followups as $lead) {
        \App\Services\TaskPriorityService::applyLeadMeta($lead);
    }

    $todayLeads = $todayLeads->sortBy(function ($lead) {
        return [
            $lead->today_task_completed ? 1 : 0,
            $lead->priority_rank,
            $lead->priority_minutes,
            -$lead->created_at->timestamp,
        ];
    })->values();

    $followups = $followups->sortBy(function ($lead) {
        return [
            $lead->today_task_completed ? 1 : 0,
            $lead->priority_rank,
            $lead->priority_minutes,
            $lead->followup_count,
        ];
    })->values();

    $meetings = \App\Models\Meeting::with('enquiry')
        ->where('user_id', $agentId)
        ->whereDate('scheduled_at', today())
        ->get();

    foreach ($meetings as $meeting) {
        \App\Services\TaskPriorityService::applyMeetingMeta($meeting);
    }

    $meetings = $meetings->sortBy(function ($meeting) {
        return [
            $meeting->conducted ? 1 : 0,
            $meeting->priority_rank,
            $meeting->priority_minutes,
        ];
    })->values();

    $completedTasks = $todayLeads->where('today_task_completed', true)->count()
        + $followups->where('today_task_completed', true)->count();

    $pendingTasks = $todayLeads->where('today_task_completed', false)->count()
        + $followups->where('today_task_completed', false)->count();

    return view(
        'agent.today-tasks',
        compact('todayLeads', 'followups', 'meetings', 'completedTasks', 'pendingTasks')
    );
}

public function toggleTask($id)
{
    $lead = \App\Models\Enquiry::where('assigned_to', session('user_id'))->findOrFail($id);

    $lead->update(['today_task_completed' => ! $lead->today_task_completed]);

    return response()->json(['success' => true, 'completed' => $lead->today_task_completed]);
}

public function meetingsToday()
{
    $meetings = \App\Models\Meeting::with('enquiry')
        ->where('user_id', session('user_id'))
        ->where('status', 'scheduled')
        ->whereDate('scheduled_at', today())
        ->get();

    foreach ($meetings as $meeting) {
        \App\Services\TaskPriorityService::applyMeetingMeta($meeting);
    }

    $meetings = $meetings->sortBy(function ($meeting) {
        return [$meeting->priority_rank, $meeting->priority_minutes];
    })->values();

    return view('agent.meetings-today', compact('meetings'));
}

public function toggleMeetingConducted($id)
{
    $meeting = \App\Models\Meeting::where('user_id', session('user_id'))->findOrFail($id);

    $meeting->update(['conducted' => ! $meeting->conducted]);

    return response()->json(['success' => true, 'conducted' => $meeting->conducted]);
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
