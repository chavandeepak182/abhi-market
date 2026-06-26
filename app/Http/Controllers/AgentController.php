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

class AgentController extends Controller
{
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
}
