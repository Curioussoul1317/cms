<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\MainCategory; 

class ContentViewController extends Controller
{

    public function index()
    {
        $subCategory = SubCategory::with([
            'contents' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            },
            'mainCategory',
            'links' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }
        ])->find(13);  
    
        if (!$subCategory) {
            abort(404, 'SubCategory not found');
        }
    
        $mainCategories = $this->getMainCategoriesForNavigation();
    
        return view('content-view.show', [
            'type' => 'subcategory',
            'item' => $subCategory,
            'mainCategories' => $mainCategories 
        ]);
    }

    // Controller
    public function show($type, $id)
    {
        $mainCategories = $this->getMainCategoriesForNavigation();
    
        if ($type === 'subcategory') {
            $item = SubCategory::with([
                'contents' => function($query) {
                    $query->where('is_active', true)->orderBy('order');
                },
                'mainCategory',
                'links' => function($query) {
                    $query->where('is_active', true)->orderBy('order');
                }
            ])->findOrFail($id);
            
        } elseif ($type === 'link') {
            $item = Link::with([
                'subCategory.mainCategory',
                'contents' => function($query) {
                    $query->where('is_active', true)->orderBy('order');
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
    }

    /**
     * Show subcategory with its contents and links
     */
    // public function showSubCategory($id)
    // {
  
    //     $subCategory = SubCategory::with([
    //         'contents' => function($query) {
    //             $query->where('is_active', true)->orderBy('order');
    //         },
    //         'mainCategory',
    //         'links' => function($query) {
    //             $query->where('is_active', true)->orderBy('order');
    //         }
    //     ])->findOrFail($id);

    //     $mainCategories = $this->getMainCategoriesForNavigation();

    //     return view('content-view.show', [
    //         'type' => 'subcategory',
    //         'item' => $subCategory,
    //         'mainCategories' => $mainCategories 
    //     ]);
    // } 

    // /**
    //  * Show link with its contents
    //  */
    // public function showLink($id)
    // { 
       
   
    //     $link = Link::with([
    //         'subCategory.mainCategory',
    //         'contents' => function($query) {
    //             $query->where('is_active', true)->orderBy('order');
    //         }
    //     ])->findOrFail($id);

    //     $mainCategories = $this->getMainCategoriesForNavigation();
 
        
    //     return view('content-view.show', [
    //         'type' => 'link',
    //         'item' => $link,
    //         'mainCategories' => $mainCategories
    //     ]);
    // }

    /**
     * Get main categories with sub-categories and links for navigation
     */
    private function getMainCategoriesForNavigation()
    {
        return MainCategory::where('is_active', true)
            ->with(['subCategories' => function($query) {
                $query->where('is_active', true)
                    ->with(['links' => function($q) {
                        $q->where('is_active', true)->orderBy('order');
                    }])
                    ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();
    }
}