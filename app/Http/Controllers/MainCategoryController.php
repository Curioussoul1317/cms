<?php

namespace App\Http\Controllers;
 

use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {
        $categories = MainCategory::withCount('subCategories')->orderBy('order')->paginate(15);
        return view('main-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('main-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:mysql_cms.main_categories,slug',
            'order' => 'nullable|integer',
        ]); 
    
        $validated['created_by'] = auth()->id();
    
        MainCategory::create($validated); 
        
        return redirect()->route('categories.hierarchy')
            ->with('success', 'Main category created successfully.');
    }


    public function edit(MainCategory $mainCategory)
    {
         
        return view('main-categories.edit', compact('mainCategory'));
      
    }

    public function update(Request $request, MainCategory $mainCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:mysql_cms.main_categories,slug,' . $mainCategory->id,
            'order' => 'nullable|integer',
        ]); 
    
        $validated['updated_by'] = auth()->id();
    
        $mainCategory->update($validated); 
        
        return redirect()->route('categories.hierarchy')
            ->with('success', 'Main category updated successfully.');
    }
  

    public function destroy(MainCategory $mainCategory)
    {
        $mainCategory->delete();
 
        return redirect()->route('categories.hierarchy')
        ->with('success', 'Main category deleted successfully.');
    }
}