<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PropertyCategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('property_category')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('property_category')->insert([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = DB::table('property_category')->where('pid', $id)->first();
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('property_category')->where('pid', $id)->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('property_category')->where('pid', $id)->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function subcategories()
    {
        $subcategories = DB::table('property_subcategory')->join('property_category', 'property_subcategory.pid', '=', 'property_category.pid')->select('property_subcategory.*', 'property_category.category_name')->get();
        $categories = DB::table('property_category')->get();
        return view('subcategories.index', compact('subcategories', 'categories'));
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('property_subcategory')->insert([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory added successfully.');
    }

    public function editSubcategory($id)
    {
        $subcategory = DB::table('property_subcategory')->where('property_subcategory_id', $id)->first();
        $categories = DB::table('property_category')->get();
        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function updateSubcategory(Request $request, $id)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('property_subcategory')->where('property_subcategory_id', $id)->update([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }
public function deleteSubcategory($id)
{
    DB::table('property_subcategory')->where('property_subcategory_id', $id)->delete();
    return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
}
}
