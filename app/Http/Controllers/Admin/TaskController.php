<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Meeting;
use App\Services\TaskPriorityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin-side Today's Tasks + Meetings Scheduled pages - same layout and
 * priority logic as the agent versions (see AgentController@todayTasks /
 * meetingsToday and App\Services\TaskPriorityService), but across every
 * agent at once, with an Agent column and an agent filter.
 */
class TaskController extends Controller
{
    public function today(Request $request)
    {
        $agentFilter = $request->get('agent_id');

        $leadsQuery = Enquiry::whereDate('created_at', today());
        $followupsQuery = Enquiry::whereDate('followup_date', today());

        if ($agentFilter) {
            $leadsQuery->where('assigned_to', $agentFilter);
            $followupsQuery->where('assigned_to', $agentFilter);
        }

        $todayLeads = $leadsQuery->with('user')->get();
        $followups = $followupsQuery->with('user')->get();

        foreach ($todayLeads as $lead) {
            TaskPriorityService::applyLeadMeta($lead);
        }

        foreach ($followups as $lead) {
            TaskPriorityService::applyLeadMeta($lead);
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

        $meetingsQuery = Meeting::with(['enquiry', 'user'])
            ->whereDate('scheduled_at', today());

        if ($agentFilter) {
            $meetingsQuery->where('user_id', $agentFilter);
        }

        $meetings = $meetingsQuery->get();

        foreach ($meetings as $meeting) {
            TaskPriorityService::applyMeetingMeta($meeting);
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

        $agents = DB::table('users')
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.tasks.today', compact(
            'todayLeads', 'followups', 'meetings', 'completedTasks', 'pendingTasks', 'agents', 'agentFilter'
        ));
    }

    public function toggleTask($id)
    {
        $lead = Enquiry::findOrFail($id);

        $lead->update(['today_task_completed' => ! $lead->today_task_completed]);

        return response()->json(['success' => true, 'completed' => $lead->today_task_completed]);
    }

    public function meetingsToday(Request $request)
    {
        $agentFilter = $request->get('agent_id');

        $meetingsQuery = Meeting::with(['enquiry', 'user'])
            ->where('status', 'scheduled')
            ->whereDate('scheduled_at', today());

        if ($agentFilter) {
            $meetingsQuery->where('user_id', $agentFilter);
        }

        $meetings = $meetingsQuery->get();

        foreach ($meetings as $meeting) {
            TaskPriorityService::applyMeetingMeta($meeting);
        }

        $meetings = $meetings->sortBy(function ($meeting) {
            return [$meeting->priority_rank, $meeting->priority_minutes];
        })->values();

        $agents = DB::table('users')
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.tasks.meetings-today', compact('meetings', 'agents', 'agentFilter'));
    }

    public function toggleMeetingConducted($id)
    {
        $meeting = Meeting::findOrFail($id);

        $meeting->update(['conducted' => ! $meeting->conducted]);

        return response()->json(['success' => true, 'conducted' => $meeting->conducted]);
    }
}
