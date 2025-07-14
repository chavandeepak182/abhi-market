<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IndustriesCategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('industries_category')->get();
        return view('industriescategories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('industries_category')->insert([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('industries.categories.index')->with('success', 'Category added successfully.');
    }
    public function getSubcategories($categoryId)
{
    try {
        $subcategories = DB::table('industries_subcategory')
                            ->where('pid', $categoryId)
                            ->select('industries_subcategory_id', 'name') // Ensure correct columns
                            ->get();

        return response()->json($subcategories);
    } catch (\Exception $e) {
        \Log::error('Error fetching subcategories', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Something went wrong!'], 500);
    }
}
    public function edit($id)
    {
        $category = DB::table('industries_category')->where('pid', $id)->first();
        return view('industriescategories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('industries_category')->where('pid', $id)->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('industries.categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroy($id)
    {
        DB::table('industries_category')->where('pid', $id)->delete();
        return redirect()->route('industries.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function subcategories()
    {
        $subcategories = DB::table('industries_subcategory')->join('industries_category', 'industries_subcategory.pid', '=', 'industries_category.pid')->select('industries_subcategory.*', 'industries_category.category_name')->get();
        $categories = DB::table('industries_category')->get();
        return view('industriessubcategories.index', compact('subcategories', 'categories'));
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('industries_subcategory')->insert([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('industries.subcategories.index')->with('success', 'Subcategory added successfully.');
    }

    public function editSubcategory($id)
    {
        $subcategory = DB::table('industries_subcategory')->where('industries_subcategory_id', $id)->first();
        $categories = DB::table('industries_category')->get();
        return view('industriessubcategories.edit', compact('subcategory', 'categories'));
    }

    public function updateSubcategory(Request $request, $id)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('industries_subcategory')->where('industries_subcategory_id', $id)->update([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('industries.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function deleteSubcategory($id)
    {
        DB::table('industries_subcategory')->where('industries_subcategory_id', $id)->delete();
        return redirect()->route('industries.subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }
}
