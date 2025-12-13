<?php

namespace App\Http\Controllers;
 
 
use App\Models\MediaCategory;
use App\Models\MediaFile;
use Illuminate\Http\Request;
 
 

class MediaCenterController extends Controller
{
    public function index(Request $request)
    {
        $categories = MediaCategory::active()->ordered()->get();
        
        // Get selected category or first active category
        $selectedCategoryId = $request->get('category');
        
        if ($selectedCategoryId) {
            $selectedCategory = MediaCategory::find($selectedCategoryId);
        } else {
            $selectedCategory = $categories->first();
        }
        
        // Get files for selected category
        $files = collect();
        if ($selectedCategory) {
            $files = MediaFile::where('mediacategory_id', $selectedCategory->id)
                ->active()
                ->recent()
                ->get();
        }

        // Get selected file if viewing
        $selectedFile = null;
        $fileId = $request->get('file');
        if ($fileId) {
            $selectedFile = MediaFile::find($fileId);
        }

        return view('mediacenter.show', compact('categories', 'selectedCategory', 'files', 'selectedFile'));
    }
}