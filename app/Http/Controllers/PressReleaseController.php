<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PressReleaseController extends Controller
{
    public function create()
    {
        $categories = DB::table('industries_category')->get();
        return view('press_releases.create', compact('categories'));
    }

    // Store Press Release
    public function store(Request $request)
    {
        Log::info('storePressRelease function called', [
            'title' => $request->title,
            'industry_category_id' => $request->industry_category_id,
            'has_image' => $request->hasFile('image'),
            'publish_date' => $request->publish_date,
        ]);

        // Validation
        try {
            $request->validate([
                'title' => 'required|string',
                'short_description' => 'nullable|string',
                'content' => 'nullable|string',
                'schema_markup' => 'nullable|string',
                'slug' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'industry_category_id' => 'required|integer|exists:industries_category,pid',
                'publish_date' => 'required|date',
                'author_name' => 'nullable|string|max:255',
            ]);

            Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            Log::info('Image file detected');

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/press-releases');

            if ($image->move($destinationPath, $imageName)) {
                $imagePath = 'uploads/press-releases/' . $imageName;
                Log::info('Image uploaded', ['path' => $imagePath]);
            } else {
                Log::error('Image upload failed');
            }
        } else {
            Log::info('No image uploaded');
        }

        // Prepare data for insert
        $data = [
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'schema_markup' => $request->schema_markup,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'image' => $imagePath,
            'industry_category_id' => $request->industry_category_id,
            'publish_date' => $request->publish_date,
            'author_name' => $request->author_name,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Log::info('Prepared data for DB insert', collect($data)->except(['content'])->toArray());

        // Insert into DB
        try {
            DB::table('press_releases')->insert($data);
            Log::info('Press release inserted successfully');
        } catch (\Exception $e) {
            Log::error('Insert error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save press release. Check logs for error.');
        }

        return redirect()->route('press-releases.index')->with('success', 'Press release added successfully.');
    }

    // List All Press Releases
    public function index()
    {
        $pressReleases = DB::table('press_releases')
            ->leftJoin('industries_category', 'press_releases.industry_category_id', '=', 'industries_category.pid')
            ->select('press_releases.*', 'industries_category.category_name as category_name')
            ->orderBy('press_releases.publish_date', 'desc') // Latest first
            ->paginate(25); // 25 per page

        return view('press_releases.index', compact('pressReleases'));
    }

    // Edit Form
    public function edit($id)
    {
        $pressRelease = DB::table('press_releases')->find($id);
        $categories = DB::table('industries_category')->get();

        if (!$pressRelease) {
            return redirect()->route('press-releases.index')->with('error', 'Press release not found.');
        }

        return view('press_releases.edit', compact('pressRelease', 'categories'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'publish_date' => 'required|date',
        ]);

        $data = $request->only([
            'title', 'short_description', 'content', 'publish_date',
            'meta_title', 'meta_keywords', 'meta_description', 'schema_markup',
            'industry_category_id', 'author_name'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/press-releases');
            $image->move($destinationPath, $imageName);
            $data['image'] = 'uploads/press-releases/' . $imageName;
        }

        $data['updated_at'] = now();

        DB::table('press_releases')->where('id', $id)->update($data);

        return redirect()->route('press-releases.index')->with('success', 'Press release updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        DB::table('press_releases')->where('id', $id)->delete();
        return redirect()->route('press-releases.index')->with('success', 'Press release deleted successfully.');
    }
   public function show($slug)
{
    // main press release
    $pressRelease = DB::table('press_releases')
        ->leftJoin('industries_category', 'press_releases.industry_category_id', '=', 'industries_category.pid')
        ->select('press_releases.*', 'industries_category.category_name as category_name')
        ->where('press_releases.slug', $slug)
        ->first();

    if (!$pressRelease) {
        abort(404);
    }

    // optional industry info (if you still need it)
    $industry = DB::table('industries')
        ->where('industries_subcategory_id', $pressRelease->industry_category_id)
        ->first();

    // latest press releases (for sidebar) — exclude current if desired
    $latestPressReleases = DB::table('press_releases')
        ->where('id', '!=', $pressRelease->id)
        ->orderBy('publish_date', 'desc')
        ->limit(5)
        ->get();

    // related press releases from same category (exclude current)
    $relatedPressReleases = DB::table('press_releases')
        ->where('industry_category_id', $pressRelease->industry_category_id)
        ->where('id', '!=', $pressRelease->id)
        ->orderBy('publish_date', 'desc')
        ->limit(3)
        ->get();

    return view('frontend.press-release-details', compact(
        'pressRelease',
        'industry',
        'latestPressReleases',
        'relatedPressReleases'
    ));
}
public function pressReleases(Request $request)
{
    $query = DB::table('press_releases')
        ->select(
            'press_releases.id',
            'press_releases.image',
            'press_releases.title',
            'press_releases.short_description',
            'press_releases.content',
            'press_releases.slug',
            'press_releases.meta_title',
            'press_releases.meta_keywords',
            'press_releases.meta_description',
            'press_releases.created_at',
            'press_releases.updated_at',
            'press_releases.schema_markup',
            'press_releases.publish_date',
            'press_releases.author_name',
            'press_releases.industry_category_id',
            'industries_category.category_name'
        )
        ->leftJoin('industries_category', 'press_releases.industry_category_id', '=', 'industries_category.pid');

    // 🔍 Search functionality
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('press_releases.title', 'LIKE', '%' . $request->search . '%')
              ->orWhere('press_releases.short_description', 'LIKE', '%' . $request->search . '%')
              ->orWhere('industries_category.category_name', 'LIKE', '%' . $request->search . '%');
        });
    }

    // 🏷️ Category filter
    if ($request->filled('category')) {
        $query->where('press_releases.industry_category_id', $request->category);
    }

    // 📄 Paginate and preserve filters
    $data['pressReleases'] = $query->orderBy('press_releases.publish_date', 'desc')
        ->paginate(12)
        ->appends($request->all());

    // 📂 Fetch categories
    $data['categories'] = DB::table('industries_category')
        ->select('pid', 'category_name')
        ->get();

    return view('frontend.press-releases', $data);
}



}
