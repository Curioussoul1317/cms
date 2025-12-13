<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;

class CategoryViewController extends Controller
{
    // public function index()
    // {
    //     // Eager load all relationships
    //     $mainCategories = MainCategory::with(['subCategories.links'])
    //         ->orderBy('name')
    //         ->get();
        
    //     return view('dashboard', compact('mainCategories'));
    // }

    public function index()
{
    // Eager load main categories with their top-level pages and child pages
    // $mainCategories = MainCategory::with([
    //     'pages' => function($query) {
    //         $query->whereNull('parent_id') // Only top-level pages
    //               ->orderBy('order')
    //               ->with(['children' => function($q) {
    //                   $q->orderBy('order');
    //               }]);
    //     }
    // ])
    // ->orderBy('name')
    // ->get();
    
    $mainCategories = MainCategory::with([
        'pages.children',
        'pages.parent'
    ])
    ->orderBy('name')
    ->get();
    
    return view('dashboard', compact('mainCategories'));
}
}