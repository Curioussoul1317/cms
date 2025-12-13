<?php
 

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class LinkViewController extends Controller
{
    // public function show($id)
    // {
    //     // Load the current link with its contents
    //     $link = Link::with([
    //         'subCategory.mainCategory',
    //         'contents' => function($query) {
    //             $query->where('is_active', true)
    //                   ->orderBy('order');
    //         }
    //     ])->findOrFail($id);

    //     // Load all main categories with their sub-categories and links for navigation
    //     $mainCategories = MainCategory::where('is_active', true)
    //         ->with(['subCategories' => function($query) {
    //             $query->where('is_active', true)
    //                   ->with(['links' => function($q) {
    //                       $q->where('is_active', true)
    //                         ->orderBy('order');
    //                   }])
    //                   ->orderBy('order');
    //         }])
    //         ->orderBy('order')
    //         ->get();

    //     return view('link-view.show', compact('link', 'mainCategories'));
    // }
}