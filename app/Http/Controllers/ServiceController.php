<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = DB::table('services')
            ->join('property_subcategory', 'services.property_subcategory_id', '=', 'property_subcategory.property_subcategory_id')
            ->join('property_category', 'property_subcategory.pid', '=', 'property_category.pid')
            ->select('services.*', 'property_subcategory.name as subcategory_name', 'property_category.category_name')
            ->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = DB::table('property_category')->get();
        return view('services.create', compact('categories'));
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = DB::table('property_subcategory')->where('pid', $categoryId)->get();
        return response()->json($subcategories);
    }
    
    public function getCategories(Request $request)
    {
        $limit = $request->input('limit', 5); // Default limit is 5
        $categories = DB::table('property_category')->limit($limit)->get();

        return response()->json($categories);
    }


    public function storeService(Request $request)
    {
        Log::info('storeService function called', ['request' => $request->all()]);

        $request->validate([
            'property_subcategory_id' => 'required|integer', 
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
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
            $destinationPath = public_path('uploads/services');
            
            if ($image->move($destinationPath, $imageName)) {
                $imagePath = 'uploads/services/' . $imageName;
                Log::info('Image successfully uploaded', ['path' => $imagePath]);
            } else {
                Log::error('Image upload failed');
            }
        } else {
            Log::warning('No image file detected in request');
        }

        $data = [
            'property_subcategory_id' => $request->property_subcategory_id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Log::info('Data to be inserted', ['data' => $data]);

        try {
            DB::table('services')->insert($data);
            Log::info('Service successfully inserted into database');
        } catch (\Exception $e) {
            Log::error('Error inserting service', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Service could not be added. Please check logs.');
        }

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }


    public function edit($id)
    {
        $service = DB::table('services')->where('id', $id)->first();

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        // Get all categories
        $categories = DB::table('property_category')->get();

        // Get subcategory details
        $subcategory = DB::table('property_subcategory')->where('property_subcategory_id', $service->property_subcategory_id)->first();

        // Get all subcategories under the selected category
        $subcategories = [];
        if ($subcategory) {
            $subcategories = DB::table('property_subcategory')
                ->where('pid', $subcategory->pid) // Get subcategories for same category
                ->get();
        }

        return view('services.edit', compact('service', 'categories', 'subcategories', 'subcategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_subcategory_id' => 'required|integer',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048', // Include image validation
        ]);

        $service = DB::table('services')->where('id', $id)->first();

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        $imagePath = $service->image; // Default to old image

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($service->image && File::exists(public_path($service->image))) {
                File::delete(public_path($service->image));
            }

            // Store new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/services');
            $image->move($destinationPath, $imageName);
            $imagePath = 'uploads/services/' . $imageName;
        }

        DB::table('services')->where('id', $id)->update([
            'property_subcategory_id' => $request->property_subcategory_id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'image' => $imagePath, // Save updated (or old) image
            'updated_at' => now(),
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

   public function delete($id)
    {
        $service = DB::table('services')->where('id', $id)->first();

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        DB::table('services')->where('id', $id)->delete();
        
        return redirect()->route('services.index')->with('success', 'Service has been deleted.');
    }

    public function show($slug)
    {
        $service = DB::table('services')->where('slug', $slug)->first();

        if (!$service) {
            abort(404); // or redirect to a default page
        }

        return view('frontend.service-details', compact('service'));
    }

    public function getServices(Request $request)
    {
        $limit = $request->get('limit', 5);

        $services = DB::table('services')
            ->select('id', 'service_name', 'slug')
            ->limit($limit)
            ->get();

        return response()->json($services);
    }

}
