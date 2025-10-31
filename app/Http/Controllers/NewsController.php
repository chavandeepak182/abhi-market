<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function index() {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create() {
        return view('admin.news.create');
    }

  public function store(Request $request)
{
    Log::info('NewsController@store - Request received', [
        'title' => $request->title,
        'has_image' => $request->hasFile('image')
    ]);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    // Default status
    $data['status'] = 1;

    // Handle image upload
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('news', 'public');
        Log::info('News image uploaded', ['path' => $data['image']]);
    }

    Log::info('Final data before insert', $data);

    try {
        $news = News::create($data);
        Log::info('News created successfully', ['id' => $news->id]);
    } catch (\Exception $e) {
        Log::error('News creation failed', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
    }

    return redirect()->route('admin.news.index')->with('success', 'News added successfully.');
}

    public function edit($id) {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
{
    $news = News::findOrFail($id);

    // Validate input
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    // Handle image update
    if ($request->hasFile('image')) {
        // Optional: delete old image if exists
        if ($news->image && \Storage::disk('public')->exists($news->image)) {
            \Storage::disk('public')->delete($news->image);
        }

        // Upload new image
        $data['image'] = $request->file('image')->store('news', 'public');
    }

    // Update record
    $news->update($data);

    return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
}

    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            abort(404, 'News not found');
        }

        // If returning to a view
        return view('admin.news.show', compact('news'));

}

    public function destroy($id) {
        News::destroy($id);
        return redirect()->route('admin.news.index')->with('success', 'News deleted.');
    }
}

