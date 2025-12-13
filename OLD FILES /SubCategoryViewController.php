<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\MainCategory;

class SubCategoryViewController extends Controller
{



    // public function show($id)
    // {
    //     $subCategory = SubCategory::with([
    //         'contents' => function($query) {
    //             $query->where('is_active', true)->orderBy('order');
    //         },
    //         'mainCategory',
    //         'links' => function($query) {
    //             $query->orderBy('order');
    //         }
    //     ])->findOrFail($id);


    //          // Load all main categories with their sub-categories and links for navigation
    //          $mainCategories = MainCategory::where('is_active', true)
    //          ->with(['subCategories' => function($query) {
    //              $query->where('is_active', true)
    //                    ->with(['links' => function($q) {
    //                        $q->where('is_active', true)
    //                          ->orderBy('order');
    //                    }])
    //                    ->orderBy('order');
    //          }])
    //          ->orderBy('order')
    //          ->get();
        
    //     return view('link-view.sub-category', compact('subCategory', 'mainCategories'));
    // }



    
}