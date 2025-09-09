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

			return view('admin.dashboard', compact('reportsCount', 'industriesCount', 'servicesCount', 'enquiriesCount'));
		} else {
			return redirect('/');
		}
	}
}
