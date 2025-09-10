<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GalleryFolder;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryFolderController extends Controller
{
    // Show all folders
    public function index()
    {
        $folders = GalleryFolder::latest()->paginate(10);
        return view('admin.gallery-folder.index', compact('folders'));
    }

    // Show create form
    public function create()
    {
        return view('admin.gallery-folder.create');
    }

    // Store new folder
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_folders,name',
        ]);

        GalleryFolder::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.gallery-folder.index')
            ->with('success', 'Folder created successfully.');
    }

    // Show single folder (list images inside it)
    public function show(GalleryFolder $galleryFolder)
    {
        $galleries = Gallery::where('folder_id', $galleryFolder->id)
            ->latest()
            ->paginate(12);

        return view('admin.gallery.index', compact('galleryFolder', 'galleries'));
    }

    // Edit folder name
    public function edit(GalleryFolder $galleryFolder)
    {
        return view('admin.gallery-folder.edit', compact('galleryFolder'));
    }

    // Update folder
    public function update(Request $request, GalleryFolder $galleryFolder)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_folders,name,' . $galleryFolder->id,
        ]);

        $galleryFolder->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.gallery-folder.index')
            ->with('success', 'Folder updated successfully.');
    }

    // Delete folder (and delete images inside)
    public function destroy(GalleryFolder $galleryFolder)
    {
        foreach ($galleryFolder->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $galleryFolder->delete();

        return redirect()->route('admin.gallery-folder.index')
            ->with('success', 'Folder and its images deleted successfully.');
    }
}
