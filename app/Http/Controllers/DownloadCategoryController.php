<?php
 

namespace App\Http\Controllers;

use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadCategoryController extends Controller
{
    public function index()
    {
        $categories = DownloadCategory::withCount('downloadFiles')->ordered()->get();
        return view('downloads.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('downloads.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:mysql_cms.downloadcategories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active'); 
        $validated['created_by'] = auth()->id();
        DownloadCategory::create($validated);

        return redirect()->route('downloadcategories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(DownloadCategory $downloadcategory)
    {
        return view('downloads.categories.edit', compact('downloadcategory'));
    }

    public function update(Request $request, DownloadCategory $downloadcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:mysql_cms.downloadcategories,name,' . $downloadcategory->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['updated_by'] = Auth::id();

        $downloadcategory->update($validated);

        return redirect()->route('downloadcategories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(DownloadCategory $downloadcategory)
    {
        $downloadcategory->delete();

        return redirect()->route('downloadcategories.index')
            ->with('success', 'Category deleted successfully.');
    }
}