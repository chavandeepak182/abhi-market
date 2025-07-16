<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\PasswordResets;
use App\Models\News;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
   public function index()
{
    $data['latestNews'] = News::where('status', 1)->latest()->take(3)->get();

    $data['allIndustries'] = DB::table('industries')
        ->select('id', 'image', 'industries_name', 'description', 'slug', 'meta_title', 'meta_keywords', 'meta_description', 'created_at', 'updated_at', 'industries_subcategory_id')
        ->take(4)
        ->get(); 

    $data['allServices'] = DB::table('services')
        ->select('id', 'property_subcategory_id', 'image', 'service_name', 'description', 'slug', 'meta_title', 'meta_keywords', 'meta_description', 'created_at', 'updated_at')
       
        ->take(6)
        ->get();

    return view('frontend.index-slider', $data);
}



    public function userLogin(Request $req)
    {
        // Validate the input
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $email = $req->input('email');
        $p = md5($req->input('password'));

        // Fetch user data including the password
        $users = DB::select('
            SELECT u.id, u.name, u.email_id, u.password, p.mobile_no, r.id as role_id, r.name as role_name, u.is_email_verify
            FROM users u
            JOIN profile p ON u.id = p.user_id
            JOIN roles r ON r.id = u.role_id
            WHERE u.email_id = ?
        ', [$email]);

        if (count($users) === 0) {
            // Username (email) not found
            return redirect()->back()->with('error', 'Incorrect username.');
        }

        $user = $users[0]; // Assuming there is only one matching user

        // Check password and email verification
        if ($user->password !== $p) {
            // Password does not match
            return redirect()->back()->with('error', 'Incorrect password.');
        }

        if (!$user->is_email_verify) {
            // Email not verified
            return redirect()->back()->with('error', 'Email not verified.');
        }

        // Set session variables
        Session::put('username', $user->name);
        Session::put('role_name', $user->role_name);
        Session::put('user_id', $user->id);
        Session::put('role_id', $user->role_id);
        Session::put('email', $user->email_id);

        // Redirect based on role_id
        switch ($user->role_id) {
            case 4:
                return redirect('admin/dashboard');
            case 1:
                return redirect('/');
            default:
                return redirect('/');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function PropDetailsView($property_id){
        $data['propertie_details'] = DB::select('select * from properties as p, price_range as pr, property_category as pc where 
        p.price_range_id = pr.range_id and pc.pid = p.property_type_id and p.properties_id =' . $property_id);
        $data['additional_images'] = DB::table('property_images')
        ->where('properties_id', $property_id)
        ->get();

        return view('frontend.property-details-test',compact('data'))
        ->with([
            'meta_title' => $propertyDetails[0]->meta_title ?? 'Default Property Title',
            'meta_description' => $propertyDetails[0]->meta_description ?? 'Default Property Description',
            'meta_keywords' => $propertyDetails[0]->meta_keywords ?? 'Default Keywords'
        ]);;
    }

    public function reports(){
        $data['allReports'] = DB::table('reports')
            ->select(
                'id',
                'image',
                'report_name',
                'description',
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'created_at',
                'updated_at'
            )
            ->paginate(700);

        return view('frontend.reports', $data);

        $data['allReports'] = DB::table('reports')
            ->select('id', 'report_name')
            ->get();

        return view('frontend.layouts.footer', $data);
    }

    public function services()
    {
        $data['allServices'] = DB::table('services')
            ->select(
                'id',
                'property_subcategory_id',
                'image',
                'service_name',
                'description',
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'created_at',
                'updated_at'
            )
            ->paginate(700);

        return view('frontend.services', $data);

        $data['allServices'] = DB::table('services')
            ->select('id', 'service_name')
            ->get();

        return view('frontend.layouts.footer', $data);
    }

    public function insights()
    {
        $data['allInsights'] = DB::table('insights')
            ->select(
                'id',
                'image',
                'insights_name',
                'description',
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'created_at',
                'updated_at',
                'insights_subcategory_id'
            )
            ->paginate(700);

        return view('frontend.insights', $data);
    }

    public function industries()
    {
        $data['allIndustries'] = DB::table('industries')
            ->select(
                'id',
                'image',
                'industries_name',  // Fixed column name
                'description',
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'created_at',
                'updated_at',
                'industries_subcategory_id' // Fixed column name
            )
            ->paginate(700);

        return view('frontend.industries', $data);
    }
public function search(Request $request)
{
    $query = $request->input('query');
    Log::info('Search method hit with query:', ['query' => $query]);

    $reports = DB::table('reports')
        ->where('report_title', 'like', '%' . $query . '%')
        ->orWhere('report_name', 'like', '%' . $query . '%')
        ->orderBy('publish_date', 'desc')
        ->paginate(10);

    Log::info('Reports fetched:', ['count' => $reports->total()]);

    return view('frontend.reports.list', compact('reports', 'query'));
}
}
