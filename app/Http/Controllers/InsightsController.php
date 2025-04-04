<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InsightsController extends Controller
{
    public function index()
    {
        $insights = DB::table('insights')
            ->join('insights_subcategory', 'insights.insights_subcategory_id', '=', 'insights_subcategory.insights_subcategory_id')
            ->join('insights_category', 'insights_subcategory.pid', '=', 'insights_category.pid')
            ->select('insights.*', 'insights_subcategory.name as subcategory_name', 'insights_category.category_name')
            ->get();

        return view('insights.index', compact('insights'));
    }
    public function create()
    {
        $categories = DB::table('insights_category')->get();
        return view('insights.create', compact('categories'));
    }

    public function getSubcategories($categoryId)
{
    $subcategories = DB::table('insights_subcategory')->where('pid', $categoryId)->get();
    return response()->json($subcategories);
}

    public function storeService(Request $request)
{
    Log::info('storeService function called', ['request' => $request->all()]);

    $request->validate([
        'insights_subcategory_id' => 'required|integer', 
        'insights_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        Log::info('Image file detected');
        
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('uploads/insights');
        
        if ($image->move($destinationPath, $imageName)) {
            $imagePath = 'uploads/insights/' . $imageName;
            Log::info('Image successfully uploaded', ['path' => $imagePath]);
        } else {
            Log::error('Image upload failed');
        }
    } else {
        Log::warning('No image file detected in request');
    }

    $data = [
        'insights_subcategory_id' => $request->insights_subcategory_id,
        'insights_name' => $request->insights_name,
        'description' => $request->description,
        'meta_title' => $request->meta_title,
        'meta_keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,
        'image' => $imagePath,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    Log::info('Data to be inserted', ['data' => $data]);

    try {
        DB::table('insights')->insert($data);
        Log::info('Insights successfully inserted into database');
    } catch (\Exception $e) {
        Log::error('Error inserting insights', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Insights could not be added. Please check logs.');
    }

    return redirect()->route('insights.index')->with('success', 'Insights added successfully.');
}


public function edit($id)
{
    $insights = DB::table('insights')->where('id', $id)->first();

    if (!$insights) {
        return redirect()->route('insights.index')->with('error', 'Insights not found.');
    }

    // Get all categories
    $categories = DB::table('insights_category')->get();

    // Get subcategory details
    $subcategory = DB::table('insights_subcategory')->where('insights_subcategory_id', $insights->insights_subcategory_id)->first();

    // Get all subcategories under the selected category
    $subcategories = [];
    if ($subcategory) {
        $subcategories = DB::table('insights_subcategory')
            ->where('pid', $subcategory->pid) // Get subcategories for same category
            ->get();
    }

    return view('insights.edit', compact('insights', 'categories', 'subcategories', 'subcategory'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'insights_subcategory_id' => 'required|integer',
        'insights_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Include image validation
    ]);

    $insights = DB::table('insights')->where('id', $id)->first();

    if (!$insights) {
        return redirect()->route('insights.index')->with('error', 'Insights not found.');
    }

    $imagePath = $insights->image; // Default to old image

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($insights->image && File::exists(public_path($insights->image))) {
            File::delete(public_path($insights->image));
        }

        // Store new image
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('uploads/insights');
        $image->move($destinationPath, $imageName);
        $imagePath = 'uploads/insights/' . $imageName;
    }

    DB::table('insights')->where('id', $id)->update([
        'insights_subcategory_id' => $request->insights_subcategory_id,
        'insights_name' => $request->insights_name,
        'description' => $request->description,
        'meta_title' => $request->meta_title,
        'meta_keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,
        'image' => $imagePath, // Save updated (or old) image
        'updated_at' => now(),
    ]);

    return redirect()->route('insights.index')->with('success', 'Insights updated successfully.');
}

public function deleteService($id)
{
    $insights = DB::table('insights')->where('id', $id)->first();

    if (!$insights) {
        return redirect()->route('insights.index')->with('error', 'Insights not found.');
    }

    DB::table('insights')->where('id', $id)->delete();
    
    return redirect()->route('insights.index')->with('success', 'Insights deleted.');
}

}
