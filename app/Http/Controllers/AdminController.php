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

class AdminController extends Controller
{
    public function loginView(){
        return view('admin.sign-in');
    }

    public function dashboard()
{
    if (!empty(Session::get('role_id'))) {

        $reportsCount = DB::table('reports')->count();
        $industriesCount = DB::table('industries')->count();
        $servicesCount = DB::table('services')->count();

        $enquiriesCount = DB::table('enquiries')
            ->whereNull('deleted_at')
            ->count();

        // ✅ Month-wise converted revenue
        $monthlyRevenue = DB::table('enquiries')
            ->selectRaw('MONTH(updated_at) as month, SUM(converted_amount) as total')
            ->where('status', 'converted')
            ->whereNotNull('converted_amount')
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->orderBy('month')
            ->pluck('total', 'month');

        // ✅ Fill all months
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $monthlyRevenue[$i] ?? 0;
        }

        // ✅ Optional stats
        $totalRevenue = DB::table('enquiries')
            ->where('status', 'converted')
            ->sum('converted_amount');

        $currentMonthRevenue = DB::table('enquiries')
            ->where('status', 'converted')
            ->whereMonth('updated_at', now()->month)
            ->sum('converted_amount');
		$statusCounts = DB::table('enquiries')
			->select('status', DB::raw('count(*) as total'))
			->groupBy('status')
			->pluck('total', 'status');

        return view('admin.dashboard', compact(
            'reportsCount',
            'industriesCount',
            'servicesCount',
            'enquiriesCount',
            'months',
            'totalRevenue',
            'currentMonthRevenue',
			'statusCounts'
        ));
    } else {
        return redirect('/');
    }
}
}
