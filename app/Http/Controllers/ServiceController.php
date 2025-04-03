<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = DB::table('service_categories')->get();
        $subcategories = DB::table('service_subcategories')->join('service_categories', 'service_subcategories.category_id', '=', 'service_categories.id')->select('service_subcategories.*', 'service_categories.category_name')->get();
        $services = DB::table('services')->join('service_subcategories', 'services.subcategory_id', '=', 'service_subcategories.id')->select('services.*', 'service_subcategories.subcategory_name')->get();

        return view('services.index', compact('categories', 'subcategories', 'services'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        DB::table('service_categories')->insert(['category_name' => $request->category_name]);
        return redirect()->route('services.index')->with('success', 'Category added successfully.');
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'subcategory_name' => 'required|string|max:255',
        ]);

        DB::table('service_subcategories')->insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
        ]);

        return redirect()->route('services.index')->with('success', 'Subcategory added successfully.');
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|integer',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        DB::table('services')->insert([
            'subcategory_id' => $request->subcategory_id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    public function deleteCategory($id)
    {
        DB::table('service_categories')->where('id', $id)->delete();
        return redirect()->route('services.index')->with('success', 'Category deleted.');
    }

    public function deleteSubcategory($id)
    {
        DB::table('service_subcategories')->where('id', $id)->delete();
        return redirect()->route('services.index')->with('success', 'Subcategory deleted.');
    }

  

    public function edit($id)
    {
        $service = DB::table('services')->where('id', $id)->first();
        $subcategories = DB::table('service_subcategories')->get();
        
        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        return view('services.edit', compact('service', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subcategory_id' => 'required|integer',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        DB::table('services')->where('id', $id)->update([
            'subcategory_id' => $request->subcategory_id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function deleteService($id)
    {
        DB::table('services')->where('id', $id)->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted.');
    }
}
