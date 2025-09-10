<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Show all images (optional: without filtering)
    public function index()
    {
        $galleries = Gallery::latest()->paginate(20);
        return view('admin.gallery.index', compact('galleries'));
    }

    // Show create form with folder selection
    public function create()
    {
        $folders = GalleryFolder::all();
        return view('admin.gallery.create', compact('folders'));
    }

    // Store image
   public function store(Request $request)
{
    // Validate request
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        'folder_id' => 'nullable|exists:gallery_folders,id',
    ]);

    $path = null;
    $altText = null;

    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // Save to storage/app/public/gallery
        $path = $file->store('gallery', 'public');

        // Auto-generate alt text from filename
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $altText = ucwords(str_replace(['-', '_'], ' ', $filename));
    }

    // Create gallery record
    Gallery::create([
        'image' => $path,            // stored path like gallery/filename.jpg
        'folder_id' => $request->folder_id,
        'alt' => $altText,           // store auto-generated alt text
    ]);

    // Redirect to gallery page with success message
    return redirect()->route('admin.gallery.index')
                     ->with('success', 'Image uploaded successfully.');
}

    // Edit form (if needed)
    public function edit(Gallery $gallery)
    {
        $folders = GalleryFolder::all();
        return view('admin.gallery.edit', compact('gallery', 'folders'));
    }

    // Update image or folder
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'folder_id' => 'nullable|exists:gallery_folders,id',
        ]);

        $data = [
            'folder_id' => $request->folder_id,
        ];

        if ($request->hasFile('image')) {
            // delete old image
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully.');
    }

    // Delete image
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return back()->with('success', 'Image deleted.');
    }
}
