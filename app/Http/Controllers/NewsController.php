<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Generate unique slug
        $slug = Str::slug($request->title, '-');
        $count = News::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Upload image if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        // Create the news record
        $news = News::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => 1,
        ]);

        Log::info('✅ News created successfully', ['id' => $news->id]);

        // Update sitemap safely
        try {
            $this->updateSitemap($news->slug);
        } catch (\Exception $e) {
            Log::error('❌ Sitemap update failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.news.index')->with('success', 'News added successfully.');

    } catch (\Exception $e) {
        Log::error('❌ News creation failed', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to add news. Check logs.');
    }
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
        'slug' => 'nullable|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    // ✅ Handle slug (manual or auto)
    if (!empty($data['slug'])) {
        // Ensure slug is unique (if user entered manually)
        $slug = Str::slug($data['slug'], '-');
        $count = News::where('slug', $slug)
            ->where('id', '!=', $news->id)
            ->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;
    } else {
        // Auto-generate from title if empty
        $slug = Str::slug($data['title'], '-');
        $count = News::where('slug', $slug)
            ->where('id', '!=', $news->id)
            ->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;
    }

    // ✅ Handle image update
    if ($request->hasFile('image')) {
        if ($news->image && \Storage::disk('public')->exists($news->image)) {
            \Storage::disk('public')->delete($news->image);
        }
        $data['image'] = $request->file('image')->store('news', 'public');
    }

    // ✅ Update record
    $news->update($data);

    return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
}

   public function show($slug)
{
    $news = News::where('slug', $slug)->first();

    if (!$news) {
        abort(404, 'News not found');
    }

    return view('admin.news.show', compact('news'));
}

    public function destroy($id) {
        News::destroy($id);
        return redirect()->route('admin.news.index')->with('success', 'News deleted.');
    }
    private function updateSitemap($slug)
{
    // Sitemap path at project root
    $sitemapPath = base_path('sitemap.xml');
    $newsUrl = url('/news/' . $slug);

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

    // Prevent duplicate entry
    foreach ($xml->url as $url) {
        if ((string)$url->loc === $newsUrl) {
            \Log::info('ℹ️ Sitemap: URL already exists', ['url' => $newsUrl]);
            return;
        }
    }

    // Add new <url> node
    $urlNode = $xml->addChild('url');
    $urlNode->addChild('loc', $newsUrl);
    $urlNode->addChild('lastmod', now()->toAtomString());
    $urlNode->addChild('changefreq', 'monthly');
    $urlNode->addChild('priority', '1.0');

    // ✅ Format XML neatly (multi-line, indented)
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($sitemapPath);

    \Log::info('✅ Sitemap updated successfully', ['url' => $newsUrl]);
}

}

