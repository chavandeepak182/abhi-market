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
        ->whereNull('deleted_at')
        ->where('assigned_to', $userId)
        ->where('status', 'new')
        ->latest()
        ->paginate(10);

    return view('agent.new-leads', compact('leads'));
}

public function todayLeads()
{
    $leads = DB::table('enquiries')

        // Deleted leads exclude
        ->whereNull('deleted_at')

        // Only today's leads
        ->whereDate('created_at', today())

        // Latest first
        ->orderBy('created_at', 'desc')

        ->paginate(10);

    return view('agent.today-leads', compact('leads'));
}
}
