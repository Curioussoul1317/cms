<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['creator', 'images'])
                     ->ordered();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            match ($request->status) {
                'published' => $query->published(),
                'approved' => $query->approved()->where('is_published', false),
                'draft' => $query->where('is_approved', false),
                'active' => $query->active(),
                'inactive' => $query->where('is_active', false),
                default => null,
            };
        }

        $news = $query->paginate(15)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:mysql_cms.news,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255',
        ]);

        DB::connection('mysql_cms')->beginTransaction();

        try {
            // Handle slug
            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')
                    ->store('news/featured', 'public');
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $news = News::create($validated);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('news/gallery', 'public');
                    
                    NewsImage::create([
                        'news_id' => $news->id,
                        'image_path' => $path,
                        'caption' => $request->input("captions.{$index}"),
                        'alt_text' => $request->input("alt_texts.{$index}"),
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::connection('mysql_cms')->commit();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'News created successfully.');

        } catch (\Exception $e) {
            DB::connection('mysql_cms')->rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create news: ' . $e->getMessage());
        }
    }

    public function show(News $news)
    {
        $news->load(['images', 'creator', 'updater', 'approver', 'publisher']);
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $news->load('images');
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:mysql_cms.news,slug,' . $news->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255',
            'existing_images' => 'nullable|array',
            'existing_captions' => 'nullable|array',
            'existing_alt_texts' => 'nullable|array',
            'image_order' => 'nullable|array',
        ]);

        DB::connection('mysql_cms')->beginTransaction();

        try {
            // Handle slug
            $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                // Delete old image
                if ($news->featured_image) {
                    Storage::disk('public')->delete($news->featured_image);
                }
                $validated['featured_image'] = $request->file('featured_image')
                    ->store('news/featured', 'public');
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $news->update($validated);

            // Handle existing images (update captions, alt_texts, delete removed)
            $existingImageIds = $request->input('existing_images', []);
            
            // Delete images that were removed
            $imagesToDelete = $news->images()->whereNotIn('id', $existingImageIds)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Update existing images
            foreach ($existingImageIds as $index => $imageId) {
                $newsImage = NewsImage::find($imageId);
                if ($newsImage && $newsImage->news_id === $news->id) {
                    $newsImage->update([
                        'caption' => $request->input("existing_captions.{$imageId}"),
                        'alt_text' => $request->input("existing_alt_texts.{$imageId}"),
                        'sort_order' => $request->input("image_order.{$imageId}", $index),
                    ]);
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                $startOrder = $news->images()->max('sort_order') + 1;
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('news/gallery', 'public');
                    
                    NewsImage::create([
                        'news_id' => $news->id,
                        'image_path' => $path,
                        'caption' => $request->input("captions.{$index}"),
                        'alt_text' => $request->input("alt_texts.{$index}"),
                        'sort_order' => $startOrder + $index,
                    ]);
                }
            }

            DB::connection('mysql_cms')->commit();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'News updated successfully.');

        } catch (\Exception $e) {
            DB::connection('mysql_cms')->rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update news: ' . $e->getMessage());
        }
    }

    public function destroy(News $news)
    {
        DB::connection('mysql_cms')->beginTransaction();

        try {
            // Delete featured image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }

            // Delete gallery images
            foreach ($news->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $news->delete();

            DB::connection('mysql_cms')->commit();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'News deleted successfully.');

        } catch (\Exception $e) {
            DB::connection('mysql_cms')->rollBack();
            return back()->with('error', 'Failed to delete news: ' . $e->getMessage());
        }
    }

    // Workflow Actions
    public function approve(News $news)
    {
        $news->approve();
        return back()->with('success', 'News approved successfully.');
    }

    public function unapprove(News $news)
    {
        $news->unapprove();
        return back()->with('success', 'News unapproved successfully.');
    }

    public function publish(News $news)
    {
        if ($news->publish()) {
            return back()->with('success', 'News published successfully.');
        }
        return back()->with('error', 'News must be approved before publishing.');
    }

    public function unpublish(News $news)
    {
        $news->unpublish();
        return back()->with('success', 'News unpublished successfully.');
    }

    public function toggleActive(News $news)
    {
        $news->update(['is_active' => !$news->is_active]);
        $status = $news->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "News {$status} successfully.");
    }

    // Delete single image (AJAX)
    public function deleteImage(NewsImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }

    // Update image order (AJAX)
    public function updateImageOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:mysql_cms.news_images,id',
            'orders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->orders as $item) {
            NewsImage::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
    }
}