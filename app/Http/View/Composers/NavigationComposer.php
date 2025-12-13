<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\MainCategory;

class NavigationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $mainCategories = MainCategory::where('is_published', true)
            ->with(['pages' => function($query) {
                $query->where('is_published', true) 
                      ->whereNull('parent_id')
                      ->with(['children' => function($q) {
                          $q->where('is_published', true) 
                            ->orderBy('order');
                      }])
                      ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

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
                        ['name' => 'Our Company', 'route' => 'corprofile.OurCompany', 'section' => 'our-company'],
                        ['name' => 'Board of Directors', 'route' => 'corprofile.OurCompany', 'section' => 'board-of-directors'],
                        ['name' => 'Timeline', 'route' => 'corprofile.OurCompany', 'section' => 'timeline'],
                        ['name' => 'Our Partners', 'route' => 'corprofile.OurCompany', 'section' => 'our-partners'],
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

        $view->with('mainCategories', $mainCategories)
             ->with('staticNav', $staticNav);
    }
}