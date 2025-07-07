<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index()
    {
        $reports = DB::table('reports')
            ->select('reports.*')
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $categories = DB::table('industries_category')->get();
        return view('reports.create', compact('categories'));
    }

    public function storeReport(Request $request)
    {
        Log::info('storeReport function called', ['request' => $request->all()]);

        $request->validate([ 
            'report_name' => 'required|string|max:255',
             'report_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schema_markup' => 'nullable|string',
            'faq_que' => 'nullable|array',
            'faq_que.*' => 'nullable|string|max:1000',
            'faq_ans' => 'nullable|array',
            'faq_ans.*' => 'nullable|string|max:1000',
            'toc' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'industry_category_id' => 'required|integer|exists:industries_category,pid',
            'publish_date' => 'required|date',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            Log::info('Image file detected');
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/reports');
            
            if ($image->move($destinationPath, $imageName)) {
                $imagePath = 'uploads/reports/' . $imageName;
                Log::info('Image successfully uploaded', ['path' => $imagePath]);
            } else {
                Log::error('Image upload failed');
            }
        } else {
            Log::warning('No image file detected in request');
        }

        $data = [
            'report_name' => $request->report_name,
            'report_title' => $request->report_title,
            'industry_category_id' => $request->industry_category_id,
            'publish_date' => $request->publish_date,
            'description' => $request->description,
            'schema_markup' => $request->schema_markup,
            'toc' => $request->toc,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'faq_que' => is_array($request->faq_que) ? implode('||', $request->faq_que) : '',
            'faq_ans' => is_array($request->faq_ans) ? implode('||', $request->faq_ans) : '',
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Log::info('Data to be inserted', ['data' => $data]);

        try {
            DB::table('reports')->insert($data);
            Log::info('Report has been successfully created');
        } catch (\Exception $e) {
            Log::error('Error inserting service', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Service could not be added. Please check logs.');
        }

        return redirect()->route('reports.index')->with('success', 'Report added successfully.');
    }


    public function edit($id)
    {
        $report = DB::table('reports')->where('id', $id)->first();

        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found.');
        }

        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'report_name' => 'required|string|max:255',
        'report_title' => 'required|string|max:255',
        'schema_markup' => 'nullable|string',
        'description' => 'nullable|string',
        'toc' => 'nullable|string',
        'slug' => 'nullable|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'faq_que' => 'nullable|array',
        'faq_que.*' => 'nullable|string|max:1000',
        'faq_ans' => 'nullable|array',
        'faq_ans.*' => 'nullable|string|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'publish_date' => 'required|date',
    ]);

    $report = DB::table('reports')->where('id', $id)->first();

    if (!$report) {
        return redirect()->route('reports.index')->with('error', 'Report not found.');
    }

    $imagePath = $report->image;

    if ($request->hasFile('image')) {
        if ($report->image && File::exists(public_path($report->image))) {
            File::delete(public_path($report->image));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('uploads/reports');
        $image->move($destinationPath, $imageName);
        $imagePath = 'uploads/reports/' . $imageName;
    }

    // Handle optional FAQ fields
    $faqQue = is_array($request->faq_que) ? implode('||', $request->faq_que) : null;
    $faqAns = is_array($request->faq_ans) ? implode('||', $request->faq_ans) : null;

    // If toc is required in DB but nullable in form, fallback default:
    $tocContent = $request->filled('toc') ? $request->toc : 'N/A';

    DB::table('reports')->where('id', $id)->update([
        'report_name' => $request->report_name,
        'report_title' => $request->report_title,
        'description' => $request->description,
        'publish_date' => $request->publish_date,
        'schema_markup' => $request->schema_markup,
        'toc' => $tocContent,
        'slug' => $request->slug,
        'meta_title' => $request->meta_title,
        'meta_keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,
        'faq_que' => $faqQue,
        'faq_ans' => $faqAns,
        'image' => $imagePath,
        'updated_at' => now(),
    ]);

    return redirect()->route('reports.index')->with('success', 'Report has been updated successfully.');
}

    public function deleteReport($id)
    {
        $report = DB::table('reports')->where('id', $id)->first();

        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found.');
        }

        DB::table('reports')->where('id', $id)->delete();
        
        return redirect()->route('reports.index')->with('success', 'Report has been deleted.');
    }

    public function show($slug)
    {
        $report = DB::table('reports')->where('slug', $slug)->first();

        if (!$report) {
            abort(404); // or redirect to a default page
        }

        return view('frontend.report-details', compact('report'));
    }

    public function getReports(Request $request){
        $limit = $request->get('limit', 5);

        $reports = DB::table('reports')
            ->select('id', 'report_name', 'slug') // include slug
            ->limit($limit)
            ->get();

        return response()->json($reports);
    }
}
