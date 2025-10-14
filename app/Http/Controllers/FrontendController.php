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
use App\Models\Enquiry;
use Illuminate\Support\Facades\Response;
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


// blog section

public function blog(Request $request)
    {
        $query = DB::table('blog')
            ->select(
                'blog.id',
                'blog.image',
                'blog.blog_name',
                'blog.description',
                'blog.slug',
                'blog.meta_title',
                'blog.meta_keywords',
                'blog.meta_description',
                'blog.created_at',
                'blog.updated_at',
                'blog.schema_markup',
                'blog.publish_date',
                'blog.tag',
                'blog.status',
                'blog.author_name',
                'blog.category_id',
                'blog_category.category_name'
            )
            ->leftJoin('blog_category', 'blog.category_id', '=', 'blog_category.pid')
            ->where('blog.status', 'active');

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('blog.blog_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('blog.description', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('blog_category.category_name', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('blog.category_id', $request->category);
        }

        $data['allIndustries'] = $query->paginate(12)->appends($request->all());

        // Fetch categories
        $data['categories'] = DB::table('blog_category')
            ->select('pid', 'category_name')
            ->get();

        return view('frontend.blog', $data);
    }

    // Blog details by slug
public function showBlog($slug)
{
    // 🔹 1. All your old slug → new slug mappings here:
    $redirectSlugs = [
        'fast-fashion-circular-fashion'      => 'fast-fashion-vs-circular-fashion-sustainable-retail',
        'global-healthcare'     => 'cell-and-gene-therapy-in-2025-transforming-global-healthcare',
        'eu-green-deal'                 => 'eu-green-deal-global-trade-policies',
        'sustainable-packaging-industry' => 'sustainable-packaging-industry-regulation-global-fmcg',
        'Sustainable-Packaging-Industry' => 'sustainable-packaging-industry-regulation-global-fmcg',
        // add as many as you need...
    ];

    // 🔹 2. If current slug is old → redirect permanently
    if (isset($redirectSlugs[$slug])) {
        return redirect()
            ->route('blog.show', ['slug' => $redirectSlugs[$slug]])
            ->setStatusCode(301); // permanent redirect
    }

    // 🔹 3. Main blog query
    $blog = DB::table('blog')
        ->join('blog_category', 'blog.category_id', '=', 'blog_category.pid')
        ->select('blog.*', 'blog_category.category_name as category_name')
        ->where('blog.slug', $slug)
        ->first();

    if (!$blog) {
        abort(404);
    }

    // 🔹 4. Related blogs
    $relatedBlogs = DB::table('blog')
        ->select('id', 'blog_name', 'slug', 'image', 'description', 'created_at', 'category_id')
        ->where('slug', '!=', $slug)
        ->where('category_id', $blog->category_id)
        ->latest()
        ->take(3)
        ->get()
        ->map(fn($item) => tap($item, fn($i) => $i->slug = (string)$i->slug));

    // 🔹 5. Latest blogs
    $latestBlogs = DB::table('blog')
        ->select('id', 'blog_name', 'slug', 'image', 'description', 'created_at', 'category_id')
        ->where('slug', '!=', $slug)
        ->latest()
        ->take(3)
        ->get()
        ->map(fn($item) => tap($item, fn($i) => $i->slug = (string)$i->slug));

    return view('frontend.blog-details', compact('blog', 'relatedBlogs', 'latestBlogs'));
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

    public function services(Request $request)
{
    // If ?page exists and is not 1, show custom 404
    if ($request->has('page') && $request->query('page') != 1) {
        return response()->view('404', [], 404);
    }

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
        ->get(); // fetch all items

    return view('frontend.services', $data);
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

    public function industries(Request $request)
{
    if ($request->has('page') && $request->query('page') != 1) {
        return response()->view('404', [], 404); // Your custom blade
    }

    $data['allIndustries'] = DB::table('industries')
        ->select(
            'id',
            'image',
            'industries_name',
            'description',
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'created_at',
            'updated_at',
            'industries_subcategory_id'
        )
        ->get();

    return view('frontend.industries', $data);
}
public function search(Request $request)
{
    $query = $request->input('query');
    Log::info('Search method hit with query:', ['query' => $query]);

    $reports = DB::table('reports')
        ->where('report_name', 'like', '%' . $query . '%') // Only searching by report_name
        ->orderBy('publish_date', 'desc')
        ->paginate(10);

    Log::info('Reports fetched:', ['count' => $reports->total()]);

    return view('frontend.reports.list', compact('reports', 'query'));
}
public function searchByTitle(Request $request)
{
    $query = $request->input('query');

    // Optional: validate
    $request->validate([
        'query' => 'required|string|min:2',
    ]);

    // Search reports by title with category join
    $reports = DB::table('reports')
        ->leftJoin('categories', 'reports.industry_category_id', '=', 'categories.id')
        ->select('reports.*', 'categories.name as category_name')
        ->where('reports.report_title', 'like', '%' . $query . '%')
        ->orderBy('reports.publish_date', 'desc')
        ->paginate(10);

    return view('reports.index', compact('reports', 'query'));
}

//export enquiery

public function export($type)
{
    $enquiries = Enquiry::all();

    if ($type === 'csv') {
        $filename = 'enquiries_' . date('Y_m_d_H_i_s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['ID', 'Name', 'Email', 'Country', 'Contact', 'Page', 'Date'];
        $callback = function() use ($enquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($enquiries as $enquiry) {
                fputcsv($file, [
                    $enquiry->enquiry_id,
                    $enquiry->name,
                    $enquiry->email,
                    $enquiry->country_name,
                    $enquiry->contact,
                    $enquiry->page_name,
                    $enquiry->created_at->format('d M, Y H:i'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    } 
    elseif ($type === 'json') {
        $filename = 'enquiries_' . date('Y_m_d_H_i_s') . '.json';
        $data = $enquiries->map(function ($e) {
            return [
                'id' => $e->enquiry_id,
                'name' => $e->name,
                'email' => $e->email,
                'country' => $e->country_name,
                'contact' => $e->contact,
                'page' => $e->page_name,
                'date' => $e->created_at->format('d M, Y H:i'),
            ];
        });

        return response()->streamDownload(function() use ($data) {
            echo $data->toJson(JSON_PRETTY_PRINT);
        }, $filename);
    }

    return redirect()->back()->with('status', 'Invalid export type selected.');
}
}
