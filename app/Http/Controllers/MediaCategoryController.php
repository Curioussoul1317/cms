<?php

namespace App\Http\Controllers;
 

use App\Models\MediaCategory;
use Illuminate\Http\Request;

class MediaCategoryController extends Controller
{
    public function index()
    {
        $categories = MediaCategory::withCount('mediaFiles')->ordered()->get();
        return view('mediacenter.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('mediacenter.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:mysql_cms.mediacategories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['created_by'] = auth()->id();
        MediaCategory::create($validated);

        return redirect()->route('mediacategories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(MediaCategory $mediacategory)
    {
        return view('mediacenter.categories.edit', compact('mediacategory'));
    }

    public function update(Request $request, MediaCategory $mediacategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:mysql_cms.mediacategories,name,' . $mediacategory->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = auth()->id();
        $mediacategory->update($validated);

        return redirect()->route('mediacategories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(MediaCategory $mediacategory)
    {
        $mediacategory->delete();

        return redirect()->route('mediacategories.index')
            ->with('success', 'Category deleted successfully.');
    }
}