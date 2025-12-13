<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\CorpCategory;

class PageViewController extends Controller
{
    /**
     * Show a specific page with its contents
     */
    public function show($type, $id)
    {
         $mainCategories = $this->getMainCategoriesForNavigation();
    
        if ($type === 'page') {
            $item = Page::with([
                'contents' => function($query) {
                    $query->where('is_published', true) 
                          ->orderBy('order');
                },
                'mainCategory',
                'parent',
                'children' => function($query) {
                    $query->where('is_published', true) 
                          ->orderBy('order');
                }
            ])->findOrFail($id);
            
        } else {
            abort(404);
        } 
        return view('content-view.show', [
            'type' => $type,
            'item' => $item,
            'mainCategories' => $mainCategories
        ]);

        // $corpCategories = CorpCategory::with(['corpPages' => function($query) {
        //     $query->with('children') 
        //           ->orderBy('order');
        // }]) 
        // ->orderBy('order')
        // ->get();
        // $mainCategories = $this->getMainCategoriesForNavigation();
        // $allCategories = $mainCategories->merge($corpCategories);
        // return view('content-view.show', [
        //     'type' => 'page',
        //     'item' => $item,
        //     'mainCategories' => $mainCategories,
        //     'allCategories' => $allCategories,
        //     'corpCategories' => $corpCategories,

        // ]);
    }

    /**
     * Show default page (for testing or homepage)
     */
    public function index() 
    {
        // You can set a default page ID or redirect to a specific page
        $page = Page::with([
            'contents' => function($query) {
                $query->where('is_published', true) 
                      ->orderBy('order');
            },
            'mainCategory',
            'children' => function($query) {
                $query->where('is_published', true) 
                      ->orderBy('order');
            }
        ])->where('is_published', true) 
          ->whereNull('parent_id') // Get top-level pages only
          ->first();
    
        if (!$page) {
            abort(404, 'No active pages found');
        }
    
        // $corpCategories = CorpCategory::with(['corpPages' => function($query) {
        //     $query->with('children') 
        //           ->orderBy('order');
        // }]) 
        // ->orderBy('order')
        // ->get();
        $mainCategories = $this->getMainCategoriesForNavigation();
        $allCategories = $mainCategories->merge($corpCategories);
        return view('content-view.show', [
            'type' => 'page',
            'item' => $page,
            'mainCategories' => $mainCategories,
            // 'allCategories' => $allCategories,
            // 'corpCategories' => $corpCategories,

        ]);
    }

    /**
     * Get main categories with pages for navigation
     */
    private function getMainCategoriesForNavigation()
    {
        return MainCategory::where('is_published', true)
            ->with(['pages' => function($query) {
                $query->where('is_published', true) 
                      ->whereNull('parent_id') // Only top-level pages
                      ->with(['children' => function($q) {
                          $q->where('is_published', true) 
                            ->orderBy('order');
                      }])
                      ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }

 
}