<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function getReports()
    {
        $reports = DB::table('reports')->orderBy('created_at', 'desc')->paginate(1); // LIFO
        return view('frontend.reports.list', compact('reports'));
    }
  public function index()
{
    $reports = DB::table('reports')
        ->join('industries_category', 'reports.industry_category_id', '=', 'industries_category.pid')
        ->select('reports.*', 'industries_category.category_name as category_name')
        ->orderBy('reports.publish_date', 'desc') // Latest first
        ->paginate(25); // 25 per page

    return view('reports.index', compact('reports'));
}

    public function create()
    {
        $categories = DB::table('industries_category')->get();
        return view('reports.create', compact('categories'));
    }

public function storeReport(Request $request)
{
    // Log essential request details only
    Log::info('storeReport function called', [
        'report_title' => $request->report_title,
        'industry_category_id' => $request->industry_category_id,
        'has_image' => $request->hasFile('image'),
        'publish_date' => $request->publish_date,
    ]);

    // Validation with error logging
    try {
        $request->validate([
            'report_name' => 'required|string',
            'report_title' => 'required|string',
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

        Log::info('Validation passed');
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed', ['errors' => $e->errors()]);
        return redirect()->back()->withErrors($e->errors())->withInput();
    }

    $imagePath = null;

    // Image upload
    if ($request->hasFile('image')) {
        Log::info('Image file detected');

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('uploads/reports');

        if ($image->move($destinationPath, $imageName)) {
            $imagePath = 'uploads/reports/' . $imageName;
            Log::info('Image uploaded', ['path' => $imagePath]);
        } else {
            Log::error('Image upload failed');
        }
    } else {
        Log::info('No image uploaded');
    }

    // Prepare data for insert
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

    // Log trimmed data for clarity
    $logData = $data;
    unset($logData['description'], $logData['toc'], $logData['faq_que'], $logData['faq_ans']);
    Log::info('Prepared data for DB insert', $logData);

    // Insert into DB with error handling
    try {
        DB::table('reports')->insert($data);
        Log::info('Report inserted successfully');
    } catch (\Exception $e) {
        Log::error('Insert error', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to save report. Check logs for error.');
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
        'report_name' => 'required|string',
        'report_title' => 'required|string',
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
    $report = DB::table('reports')
        ->join('industries_category', 'reports.industry_category_id', '=', 'industries_category.pid')
        ->select('reports.*', 'industries_category.category_name as category_name') // this includes publish_date too
        ->where('reports.slug', $slug)
        ->first();

    if (!$report) {
        abort(404);
    }
    $industry = DB::table('industries')
            ->where('industries_subcategory_id', $report->industry_category_id)
            ->first();
    return view('frontend.report-details', compact('report', 'industry'));
}

   public function getReportsByIndustry($industryId)
{
    if ($industryId === 'all') {
        // Get all reports
        $reports = DB::table('reports')
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // Get filtered reports
        $reports = DB::table('reports')
            ->where('industry_category_id', $industryId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    $html = '';
    foreach ($reports as $report) {
        $html .= view('frontend.reports.reports-card', compact('report'))->render();
    }

    return response($html);
}

public function showSampleForm($slug)
{
    $report = DB::table('reports')->where('slug', $slug)->first();

    if (!$report) {
        abort(404, 'Report not found');
    }

    return view('frontend.reports.sample-form', compact('report', 'slug'));
}
}
