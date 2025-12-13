<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('mainCategory', 'parent')
            ->withCount('children')
            ->orderBy('order')
            ->paginate(15);
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        $mainCategories = MainCategory::orderBy('name')->get();
        $parentPages = Page::where('has_children', true) 
            ->orderBy('name')
            ->get();
        
        $selectedMainCategory = null;
        $selectedParentPage = null;
        
        if (request('main_category')) {
            $selectedMainCategory = MainCategory::find(request('main_category'));
        }
        
        if (request('parent_id')) {
            $selectedParentPage = Page::find(request('parent_id'));
        }
        
        $requesttype = request('type');
        
        return view('pages.create', compact(
            'mainCategories', 
            'parentPages',
            'selectedMainCategory', 
            'selectedParentPage',
            'requesttype'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_category_id' => 'required|exists:mysql_cms.main_categories,id', 
            'parent_id' => 'nullable|exists:mysql_cms.pages,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string',
            'svg' => 'nullable|file|mimes:svg|max:2048',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'has_children' => 'boolean',
            'subtype' => 'nullable|string', 
        ]);
    
        if ($request->hasFile('svg')) {
            $svgPath = $request->file('svg')->store('pages/icons', 'public');
            $validated['svg'] = $svgPath;
        }  
        
        $validated['has_children'] = $request->has('has_children') ? 1 : 0; 
        $validated['created_by'] = auth()->id();
    
        Page::create($validated);
    
        return redirect()->route('categories.hierarchy')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $mainCategories = MainCategory::orderBy('name')->get();
        
        // Get potential parent pages (exclude current page and its descendants to prevent circular references)
        $parentPages = Page::where('has_children', true) 
            ->where('id', '!=', $page->id)
            ->orderBy('name')
            ->get();
        
        return view('pages.edit', compact('page', 'mainCategories', 'parentPages'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'main_category_id' => 'required|exists:mysql_cms.main_categories,id', 
            'parent_id' => 'nullable|exists:mysql_cms.pages,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string',
            'svg' => 'nullable|file|mimes:svg|max:2048',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'has_children' => 'boolean',
            'subtype' => 'nullable|string', 
        ]);
    
        if ($request->hasFile('svg')) {
            $svgPath = $request->file('svg')->store('pages/icons', 'public');
            $validated['svg'] = $svgPath;
        }  
        
        $validated['has_children'] = $request->has('has_children') ? 1 : 0; 
        $validated['updated_by'] = auth()->id();
    
        $page->update($validated);
    
        return redirect()->route('categories.hierarchy')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        // Check if page has children
        if ($page->children()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete a page that has child pages. Delete child pages first.']);
        }

        $page->delete();

        return redirect()->route('categories.hierarchy')
            ->with('success', 'Page deleted successfully.');
    }

    // Additional helper methods

    // Get all children of a specific page
    public function children(Page $page)
    {
        $children = $page->children()
            ->with('mainCategory')
            ->orderBy('order')
            ->get();
        
        return view('pages.children', compact('page', 'children'));
    }

    // Get all top-level pages for a main category
    public function byMainCategory(MainCategory $mainCategory)
    {
        $pages = $mainCategory->pages()
            ->whereNull('parent_id')
            ->withCount('children')
            ->orderBy('order')
            ->get();
        
        return view('pages.by-category', compact('mainCategory', 'pages'));
    }

     // Approve page
     public function approve($id)
     {
         $page = Page::findOrFail($id);
         $page->is_approved = true;
         $page->approved_by = auth()->id();
         $page->approved_at = now();
         $page->save();
 
         return redirect()->back()->with('success', 'Page approved successfully!');
     }
 
     // Unapprove page
     public function unapprove($id)
     {
         $page = Page::findOrFail($id);
         $page->is_approved = false;
         $page->is_published = false; // unpublish when unapproving
         $page->approved_by = null;
         $page->approved_at = null;
         $page->save();
 
         return redirect()->back()->with('success', 'Page unapproved successfully!');
     }
 
     // Publish page
     public function publish($id)
     {
         $page = Page::findOrFail($id);
         
         if (!$page->is_approved) {
             return redirect()->back()->with('error', 'Page must be approved before publishing!');
         }
 
         $page->is_published = true;
         $page->published_by = auth()->id();
         $page->published_at = now();
         $page->save();
 
         return redirect()->back()->with('success', 'Page published successfully!');
     }
 
     // Unpublish page
     public function unpublish($id)
     {
         $page = Page::findOrFail($id);
         $page->is_published = false;
         $page->published_by = null;
         $page->published_at = null;
         $page->save();
 
         return redirect()->back()->with('success', 'Page unpublished successfully!');
     }
}