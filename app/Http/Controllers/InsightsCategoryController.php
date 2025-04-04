<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InsightsCategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('insights_category')->get();
        return view('insightscategories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('insights_category')->insert([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('insights.categories.index')->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = DB::table('insights_category')->where('pid', $id)->first();
        return view('insightscategories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:45',
        ]);

        DB::table('insights_category')->where('pid', $id)->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('insights.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('insights_category')->where('pid', $id)->delete();
        return redirect()->route('insights.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function subcategories()
    {
        $subcategories = DB::table('insights_subcategory')->join('insights_category', 'insights_subcategory.pid', '=', 'insights_category.pid')->select('insights_subcategory.*', 'insights_category.category_name')->get();
        $categories = DB::table('insights_category')->get();
        return view('insightssubcategories.index', compact('subcategories', 'categories'));
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('insights_subcategory')->insert([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('insights.subcategories.index')->with('success', 'Subcategory added successfully.');
    }

    public function editSubcategory($id)
    {
        $subcategory = DB::table('insights_subcategory')->where('insights_subcategory_id', $id)->first();
        $categories = DB::table('insights_category')->get();
        return view('insightssubcategories.edit', compact('subcategory', 'categories'));
    }

    public function updateSubcategory(Request $request, $id)
    {
        $request->validate([
            'pid' => 'required|integer',
            'name' => 'required|string|max:45',
        ]);

        DB::table('insights_subcategory')->where('insights_subcategory_id', $id)->update([
            'pid' => $request->pid,
            'name' => $request->name,
        ]);

        return redirect()->route('insights.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function deleteSubcategory($id)
    {
        DB::table('insights_subcategory')->where('insights_subcategory_id', $id)->delete();
        return redirect()->route('insights.subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }
}
