<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    // Show all blogs in admin
    // public function index()
    // {
    //     $blogs = DB::table('blog')
    // ->orderBy('id', 'desc') // latest first
    // ->get();

    //     return view('blog.index', compact('blogs'));
    // }


    public function index()
    {
        $blog = DB::table('blog')
            //->join('industries_subcategory', 'industries.industries_subcategory_id', '=', 'industries_subcategory.industries_subcategory_id')
            //->join('industries_category', 'industries_subcategory.pid', '=', 'industries_category.pid')
            ->select('blog.*') // सबकॅटेगरी/कॅटेगरी रिलेशन काढलं
            ->get();

        return view('blog.index', compact('blog'));
    }


    // Show create form
    public function create()
    {
        $categories = DB::table('blog_category')->get();
        return view('blog.create', compact('categories'));
    }

    // Store new blog
  


    
    public function storeService(Request $request)
    {
        Log::info('storeService function called', ['request' => $request->all()]);

        $request->validate([
            'blog_name' => 'required|string|max:255',
            'category_id'  => 'required|integer|',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'publish_date' => 'nullable|string',
            'status' => 'nullable|string',
            'author_name' => 'nullable|string',
            'tag' => 'nullable|string',
            'schema_markup' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
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
            'blog_name' => $request->blog_name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'publish_date' => $request->publish_date,
            'status' => $request->status,
            'schema_markup' => $request->schema_markup,
            'tag' => $request->tag,
            'author_name' => $request->author_name,
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Log::info('Data to be inserted', ['data' => $data]);

        try {
    DB::table('blog')->insert($data);
    Log::info('Blog successfully inserted into database');

    // ✅ Update sitemap after new blog is added
    $this->updateSitemapForBlog($request->slug);

} catch (\Exception $e) {
    Log::error('Error inserting blog', ['error' => $e->getMessage()]);
    return redirect()->back()->with('error', 'Blog could not be added. Please check logs.');
}


        return redirect()->route('blog.index')->with('success', 'Blog added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $blog = DB::table('blog')->where('id', $id)->first();

        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }

        $categories = DB::table('blog_category')->get();
        return view('blog.edit', compact('blog', 'categories'));
    }

    // Update blog
    public function update(Request $request, $id)
    {
        $request->validate([
            'blog_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'status' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'tag' => 'nullable|string',
            'schema_markup' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $blog = DB::table('blog')->where('id', $id)->first();

        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }

        $imagePath = $blog->image;

        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/blog');
            $image->move($destinationPath, $imageName);
            $imagePath = 'uploads/blog/' . $imageName;
        }

        DB::table('blog')->where('id', $id)->update([
            'blog_name' => $request->blog_name,
            'description' => $request->description,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'publish_date' => $request->publish_date,
            'status' => $request->status ?? 'inactive',
            'schema_markup' => $request->schema_markup,
            'tag' => $request->tag,
            'author_name' => $request->author_name,
            'image' => $imagePath,
            'updated_at' => now(),
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }

    // Delete blog
    public function deleteService($id)
    {
        $blog = DB::table('blog')->where('id', $id)->first();

        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }

        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }

        DB::table('blog')->where('id', $id)->delete();

        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
    }
    private function updateSitemapForBlog($slug)
{
    // Sitemap file path in root directory (same as .env)
    $sitemapPath = base_path('sitemap.xml');
    $blogUrl = url('/blogs/' . $slug);

    // Ensure sitemap.xml exists and is valid
    if (!file_exists($sitemapPath)) {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' .
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
    } else {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($sitemapPath);
        if ($xml === false) {
            // Recreate fresh if corrupted
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' .
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        }
    }

    // Prevent duplicate entries
    foreach ($xml->url as $url) {
        if ((string)$url->loc === $blogUrl) {
            \Log::info('ℹ️ Sitemap: Blog URL already exists', ['url' => $blogUrl]);
            return;
        }
    }

    // Add new <url> node for the blog
    $urlNode = $xml->addChild('url');
    $urlNode->addChild('loc', $blogUrl);
    $urlNode->addChild('lastmod', now()->toAtomString());
    $urlNode->addChild('changefreq', 'monthly');
    $urlNode->addChild('priority', '1.0');

    // ✅ Format XML nicely with line breaks and indentation
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($sitemapPath);

    \Log::info('✅ Sitemap updated successfully for new blog', ['url' => $blogUrl]);
}
}


