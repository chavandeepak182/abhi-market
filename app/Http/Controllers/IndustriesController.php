<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndustriesController extends Controller
{
    public function index()
    {
        $industries = DB::table('industries')
            ->join('industries_subcategory', 'industries.industries_subcategory_id', '=', 'industries_subcategory.industries_subcategory_id')
            ->join('industries_category', 'industries_subcategory.pid', '=', 'industries_category.pid')
            ->select('industries.*', 'industries_subcategory.name as subcategory_name', 'industries_category.category_name')
            ->get();

        return view('industries.index', compact('industries'));
    }
    public function create()
    {
        $categories = DB::table('industries_category')->get();
        return view('industries.create', compact('categories'));
    }

    // public function getSubcategories($categoryId)
    // {
    //     $subcategories = DB::table('industries_subcategory')->where('pid', $categoryId)->get();
    //     return response()->json($subcategories);
    // }

    public function storeService(Request $request)
{
    Log::info('storeService function called', ['request' => $request->all()]);

    $request->validate([
        'industries_subcategory_id' => 'required|integer', 
        'industries_name' => 'required|string|max:255',
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
        $destinationPath = public_path('uploads/industries');
        
        if ($image->move($destinationPath, $imageName)) {
            $imagePath = 'uploads/industries/' . $imageName;
            Log::info('Image successfully uploaded', ['path' => $imagePath]);
        } else {
            Log::error('Image upload failed');
        }
    } else {
        Log::warning('No image file detected in request');
    }

    $data = [
        'industries_subcategory_id' => $request->industries_subcategory_id,
        'industries_name' => $request->industries_name,
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
        DB::table('industries')->insert($data);
        Log::info('Industries successfully inserted into database');
    } catch (\Exception $e) {
        Log::error('Error inserting industries', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Industries could not be added. Please check logs.');
    }

    return redirect()->route('industries.index')->with('success', 'industries added successfully.');
}


public function edit($id)
{
    $industries = DB::table('industries')->where('id', $id)->first();

    if (!$industries) {
        return redirect()->route('industries.index')->with('error', 'industries not found.');
    }

    // Get all categories
    $categories = DB::table('industries_category')->get();

    // Get subcategory details
    $subcategory = DB::table('industries_subcategory')->where('industries_subcategory_id', $industries->industries_subcategory_id)->first();

    // Get all subcategories under the selected category
    $subcategories = [];
    if ($subcategory) {
        $subcategories = DB::table('industries_subcategory')
            ->where('pid', $subcategory->pid) // Get subcategories for same category
            ->get();
    }

    return view('industries.edit', compact('industries', 'categories', 'subcategories', 'subcategory'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'industries_subcategory_id' => 'required|integer',
        'industries_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'meta_title' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Include image validation
    ]);

    $industries = DB::table('industries')->where('id', $id)->first();

    if (!$industries) {
        return redirect()->route('industries.index')->with('error', 'industries not found.');
    }

    $imagePath = $industries->image; // Default to old image

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($industries->image && File::exists(public_path($industries->image))) {
            File::delete(public_path($industries->image));
        }

        // Store new image
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('uploads/industries');
        $image->move($destinationPath, $imageName);
        $imagePath = 'uploads/industries/' . $imageName;
    }

    DB::table('industries')->where('id', $id)->update([
        'industries_subcategory_id' => $request->industries_subcategory_id,
        'industries_name' => $request->industries_name,
        'description' => $request->description,
        'meta_title' => $request->meta_title,
        'meta_keywords' => $request->meta_keywords,
        'meta_description' => $request->meta_description,
        'image' => $imagePath, // Save updated (or old) image
        'updated_at' => now(),
    ]);

    return redirect()->route('industries.index')->with('success', 'industries updated successfully.');
}

public function deleteService($id)
{
    $industries = DB::table('industries')->where('id', $id)->first();

    if (!$industries) {
        return redirect()->route('industries.index')->with('error', 'industries not found.');
    }

    DB::table('industries')->where('id', $id)->delete();
    
    return redirect()->route('industries.index')->with('success', 'industries deleted.');
}

}
