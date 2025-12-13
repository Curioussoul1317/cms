<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Models\CorpCategory;
use App\Models\CorprofilePage;
use App\Models\CorprofileObjective;
use App\Models\CorprofileStrategy;
use App\Models\CorprofileValue;
use App\Models\CorprofilePrinciple; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{

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
     
        
        $staticNav = [
            [
                'name' => 'About Us',
                'identifier' => 'about-us',
                'pages' => [
                    [
                        'name' => 'Corporate Profile',
                        'has_children' => true,
                        'icon' => 'ti ti-building',
                        'children' => [
                            ['name' => 'Our Company', 'route' => 'corprofile.OurCompany'],
                            ['name' => 'Board of Directors', 'route' => 'corprofile.BoardofDirectors'],
                            ['name' => 'Timeline', 'route' => 'corprofile.Timeline'],
                            ['name' => 'Our Partners', 'route' => 'corprofile.OurPartners'],
                        ]
                    ],
                    [
                        'name' => 'Get in Touch',
                        'has_children' => true,
                        'icon' => 'ti ti-mail',
                        'children' => [
                            ['name' => 'Locations', 'route' => 'corprofile.Locations'],
                        ]
                    ],
                    [
                        'name' => 'Resource Center',
                        'has_children' => true,
                        'icon' => 'ti ti-folder',
                        'children' => [
                            ['name' => 'Media', 'route' => 'corprofile.Media'],
                            ['name' => 'Downloads', 'route' => 'corprofile.Downloads'],
                            ['name' => 'Sustainability', 'route' => 'corprofile.Sustainability'],
                        ]
                    ],
                    [
                        'name' => 'Careers',
                        'has_children' => true,
                        'icon' => 'ti ti-briefcase',
                        'children' => [
                            ['name' => 'Open Vacancies', 'route' => 'corprofile.OpenVacancies'],
                        ]
                    ]
                ]
            ]
        ];

        return view('content-view.show', [
            'type' => $type,
            'item' => $item,
            'mainCategories' => $mainCategories,
            'staticNav'=>$staticNav
        ]);

    
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
        
        $mainCategories = $this->getMainCategoriesForNavigation(); 

     
        $staticNav = [
            [
                'name' => 'About Us',
                'identifier' => 'about-us',
                'pages' => [
                    [
                        'name' => 'Corporate Profile',
                        'has_children' => true,
                        'icon' => 'ti ti-building',
                        'children' => [
                            ['name' => 'Our Company', 'route' => 'corprofile.OurCompany'],
                            ['name' => 'Board of Directors', 'route' => 'corprofile.BoardofDirectors'],
                            ['name' => 'Timeline', 'route' => 'corprofile.Timeline'],
                            ['name' => 'Our Partners', 'route' => 'corprofile.OurPartners'],
                        ]
                    ],
                    [
                        'name' => 'Get in Touch',
                        'has_children' => true,
                        'icon' => 'ti ti-mail',
                        'children' => [
                            ['name' => 'Locations', 'route' => 'corprofile.Locations'],
                        ]
                    ],
                    [
                        'name' => 'Resource Center',
                        'has_children' => true,
                        'icon' => 'ti ti-folder',
                        'children' => [
                            ['name' => 'Media', 'route' => 'corprofile.Media'],
                            ['name' => 'Downloads', 'route' => 'corprofile.Downloads'],
                            ['name' => 'Sustainability', 'route' => 'corprofile.Sustainability'],
                        ]
                    ],
                    [
                        'name' => 'Careers',
                        'has_children' => true,
                        'icon' => 'ti ti-briefcase',
                        'children' => [
                            ['name' => 'Open Vacancies', 'route' => 'corprofile.OpenVacancies'],
                        ]
                    ]
                ]
            ]
        ];
        
        return view('content-view.show', [
            'type' => 'page',
            'item' => $page,
            'mainCategories' => $mainCategories, 
            'staticNav'=>$staticNav

        ]);
    }




    public function ourCompany()
    {
        $mainCategories = $this->getMainCategoriesForNavigation();
        $corprofile = CorprofilePage::with(['objectives', 'strategies', 'values', 'principles'])
            ->findOrFail(1);
        return view('content-view.corporateprofile', compact('corprofile','mainCategories'));

    }
 
   
    public function boardOfDirectors()
    { 
        
    }

    /**
     * Display Timeline page
     */
    public function timeline()
    {
        
    }

    /**
     * Display Our Partners page
     */
    public function ourPartners()
    {
       
    }

    /**
     * Display Locations page
     */
    public function locations()
    {
         
    }

    /**
     * Display Media page
     */
    public function media()
    {
        
    }

    /**
     * Display Downloads page
     */
    public function downloads()
    {
         
    }

    /**
     * Display Sustainability page
     */
    public function sustainability()
    {
         
    }

    /**
     * Display Open Vacancies page
     */
    public function openVacancies()
    {
         
    }
 
}