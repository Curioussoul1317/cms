<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroSections = HeroSection::orderBy('route_name')
            ->orderBy('section')
            ->paginate(15);

        return view('admin.hero-sections.index', compact('heroSections'));
    }

    public function create()
    {
        $availableRoutes = $this->getAvailableRoutes();
        return view('admin.hero-sections.create', compact('availableRoutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = DB::connection('mysql_cms')
                        ->table('hero_sections')
                        ->where('route_name', $value)
                        ->where('section', $request->section)
                        ->exists();
                    
                    if ($exists) {
                        $fail('A hero section already exists for this route and section combination.');
                    }
                }
            ],
            'section' => 'nullable|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'background_color' => 'required|string|max:20',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hero-sections', 'public');
        }
        $validated['created_by'] = auth()->id();
        HeroSection::create($validated); 

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section created successfully!');
    }

    public function show(HeroSection $heroSection)
    {
        return view('admin.hero-sections.show', compact('heroSection'));
    }

    public function edit(HeroSection $heroSection)
    {
        $availableRoutes = $this->getAvailableRoutes();
        return view('admin.hero-sections.edit', compact('heroSection', 'availableRoutes'));
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'route_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request, $heroSection) {
                    $exists = DB::connection('mysql_cms')
                        ->table('hero_sections')
                        ->where('route_name', $value)
                        ->where('section', $request->section)
                        ->where('id', '!=', $heroSection->id)
                        ->exists();
                    
                    if ($exists) {
                        $fail('A hero section already exists for this route and section combination.');
                    }
                }
            ],
            'section' => 'nullable|string',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'background_color' => 'required|string|max:20',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($heroSection->image && Storage::disk('public')->exists($heroSection->image)) {
                Storage::disk('public')->delete($heroSection->image);
            }
            $validated['image'] = $request->file('image')->store('hero-sections', 'public');
        }
        $validated['updated_by'] = auth()->id();
        $heroSection->update($validated);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section updated successfully!');
    }

    public function destroy(HeroSection $heroSection)
    {
        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section deleted successfully!');
    }

    private function getAvailableRoutes(): array
    {
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

        $routes = [];
        foreach ($staticNav as $navGroup) {
            foreach ($navGroup['pages'] as $page) {
                if (isset($page['children'])) {
                    foreach ($page['children'] as $child) {
                        $identifier = isset($child['section']) 
                            ? "{$child['route']}:{$child['section']}" 
                            : $child['route'];
                        
                        $routes[$identifier] = $child['name'] . 
                            (isset($child['section']) ? " ({$child['section']})" : '');
                    }
                }
            }
        }

        return $routes;
    }

    public static function getHeroData(string $routeName, ?string $section = null): ?array
    {
        $hero = HeroSection::where('route_name', $routeName)
            ->where('section', $section)
            ->where('is_active', true)
            ->first();

        if (!$hero) {
            return null;
        }

        return [
            'title' => $hero->title,
            'subtitle' => $hero->subtitle,
            'button_text' => $hero->button_text,
            'button_link' => $hero->button_link,
            'image' => $hero->image,
            'background_color' => $hero->background_color,
        ];
    }
}