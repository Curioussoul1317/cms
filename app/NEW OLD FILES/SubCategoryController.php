<?php
 
namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('mainCategory')
            ->withCount('links')
            ->orderBy('order')
            ->paginate(15);
        return view('sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        // $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();
        // return view('sub-categories.create', compact('mainCategories'));
        $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get(); 
        $selectedMainCategory = null;
        if (request('main_category')) {
            $selectedMainCategory = MainCategory::find(request('main_category'));
        }     
        $requesttype=request('type');    
        return view('sub-categories.create', compact('mainCategories', 'selectedMainCategory','requesttype'));
    } 

    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string',
            'svg' => 'nullable|file|mimes:svg|max:2048',  
            'heading' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'subtype'=>'nullable|string'
        ]);
    
       
        if ($request->hasFile('svg')) {
            $svgPath = $request->file('svg')->store('sub-categories/icons', 'public');
            $validated['svg'] = $svgPath;
        }
    
      SubCategory::create($validated);
     
    
        return redirect()->route('categories.hierarchy')
            ->with('success', 'Sub-category created successfully.');
    }


    public function edit(SubCategory $subCategory)
    {
        $mainCategories = MainCategory::where('is_active', true)->orderBy('name')->get();
        return view('sub-categories.edit', compact('subCategory', 'mainCategories'));
    }

 public function update(Request $request, SubCategory $subCategory)
{
    $validated = $request->validate([
        'main_category_id' => 'required|exists:main_categories,id',
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string',
        'svg' => 'nullable|file|mimes:svg|max:2048',  
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'order' => 'nullable|integer',
        'is_active' => 'boolean'
    ]);
 
    if ($request->hasFile('svg')) {
        $svgFile = $request->file('svg');
        $svgContent = file_get_contents($svgFile->getRealPath());
        $validated['svg'] = $svgContent;
    } else {
       
        unset($validated['svg']);
    }
 
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    $subCategory->update($validated);

    return redirect()->route('categories.hierarchy')
        ->with('success', 'Sub-category updated successfully.');
}


    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        // return redirect()->route('sub-categories.index')
        //     ->with('success', 'Sub-category deleted successfully.');
        return redirect()->route('categories.hierarchy')
        ->with('success', 'Sub-category deleted successfully.');
    }
}