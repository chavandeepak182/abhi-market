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
    $industriesCount = DB::table('industries')->count();
    $servicesCount = DB::table('services')->count();
     $enquiriesCount = DB::table('enquiries')
        ->whereNull('deleted_at')
        ->where('assigned_to', $userId)
        ->count();

    return view('agent.dashboard', compact(
        'reportsCount',
        'industriesCount',
        'servicesCount',
        'enquiriesCount'
    ));
}
}
