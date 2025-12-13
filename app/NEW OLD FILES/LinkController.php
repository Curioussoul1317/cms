<?php
 
 
namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::with('subCategory.mainCategory')
            ->withCount('contents')
            ->orderBy('order')
            ->paginate(15);
   
        return view('links.index', compact('links'));
    }

    public function create()
    {
        // $subCategories = SubCategory::with('mainCategory')
        //     ->where('is_active', true)
        //     ->get()
        //     ->groupBy('main_category_id');
        // return view('links.create', compact('subCategories'));
        $subCategories = SubCategory::with('mainCategory')
        ->where('is_active', true)
        ->get()
        ->groupBy('main_category_id');
    
    // Get the pre-selected sub category if provided
    $selectedSubCategory = null;
    if (request('sub_category')) {
        $selectedSubCategory = SubCategory::with('mainCategory')->find(request('sub_category'));
    }
    
    return view('links.create', compact('subCategories', 'selectedSubCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        Link::create($validated);

        // return redirect()->route('links.index')
        //     ->with('success', 'Link created successfully.');
            return redirect()->route('categories.hierarchy')
            ->with('success', 'Link created successfully.');
    }

    public function show(Link $link)
    {
        $link->load('subCategory.mainCategory', 'contents');
       
        return view('links.show', compact('link'));
    }

    public function edit(Link $link)
    {
        $subCategories = SubCategory::with('mainCategory')
            ->where('is_active', true)
            ->get()
            ->groupBy('main_category_id');
        return view('links.edit', compact('link', 'subCategories'));
    }

    public function update(Request $request, Link $link)
    {
        $validated = $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $link->update($validated);

        // return redirect()->route('links.index')
        //     ->with('success', 'Link updated successfully.');
        return redirect()->route('categories.hierarchy')
        ->with('success', 'Link updated successfully.');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        // return redirect()->route('links.index')
        //     ->with('success', 'Link deleted successfully.');
        return redirect()->route('categories.hierarchy')
        ->with('success', 'Link deleted successfully.');
    }
}