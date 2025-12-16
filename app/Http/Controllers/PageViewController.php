<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HeroSectionController;

use App\Models\Page;
use App\Models\CorprofilePage;
use Illuminate\Http\Request;
use App\Models\BodDirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\OurTimelineItem;
use App\Models\OurPartner; 
use App\Models\MediaCategory;
use App\Models\MediaFile;  
use App\Models\DownloadCategory;
use App\Models\Vacancy;
use App\Models\VacancyLocation;
use App\Models\Location;
use App\Models\Place;

class PageViewController extends Controller
{
     
    public function show($type, $id)
    {
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
        ]);
    }

  
    public function index() 
    {
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
          ->whereNull('parent_id')
          ->first();
    
        if (!$page) {
            abort(404, 'No active pages found');
        }
        
        return view('content-view.show', [
            'type' => 'page',
            'item' => $page,
        ]);
    }

    public function ourCompany()
    {
        $heroData = HeroSectionController::getHeroData('corprofile.OurCompany', 'our-company');
        $corprofile = CorprofilePage::with(['objectives', 'strategies', 'values', 'principles'])
            ->findOrFail(1); 

        $directors = BodDirector::active()->ordered()->get(); 

        $timelineItems = OurTimelineItem::orderBy('year', 'desc')
        ->orderBy('date', 'desc')
        ->orderBy('order', 'asc')
        ->get();     
         $groupedByYear = $timelineItems->groupBy('year');

         $partners = OurPartner::active()->ordered()->get();  
 
        return view('content-view.corporateprofile', compact('corprofile','directors','groupedByYear','partners','heroData'));
    }


       /**
     * Display Media page
     */
    public function media(Request $request)
    {
        $heroData = HeroSectionController::getHeroData('corprofile.Media');
        $categories = MediaCategory::active()->ordered()->get();
         
        $selectedCategoryId = $request->get('category');
        
        if ($selectedCategoryId) {
            $selectedCategory = MediaCategory::find($selectedCategoryId);
        } else {
            $selectedCategory = $categories->first();
        }
         
        $files = collect();
        if ($selectedCategory) {
            $files = MediaFile::where('mediacategory_id', $selectedCategory->id)
                ->active()
                ->recent()
                ->get();
        }
 
        $selectedFile = null;
        $fileId = $request->get('file');
        if ($fileId) {
            $selectedFile = MediaFile::find($fileId);
        }

        return view('content-view.media', compact('categories', 'selectedCategory', 'files', 'selectedFile','heroData'));
    }

    public function mediadownload(MediaFile $mediafile)
    {
        if ($mediafile->file_path && Storage::disk('public')->exists($mediafile->file_path)) {
            return Storage::disk('public')->download($mediafile->file_path, $mediafile->file_name);
        }

        return back()->with('error', 'File not found.');
    }


        /**
     * Display Downloads page
     */
    public function downloads()
    {
        $heroData = HeroSectionController::getHeroData('corprofile.Downloads');
        $categories = DownloadCategory::active()
        ->ordered()
        ->with(['activeDownloadFiles' => function($query) {
            $query->orderBy('date', 'desc');
        }])
        ->get();

    return view('content-view.downloads', compact('categories','heroData'));
    }


        /**
     * Display Open Vacancies page
     */
    public function openVacancies(Request $request)
    {
        $search = $request->get('search');
        
        $vacancies = Vacancy::with('location')
        ->search($search)
        ->recent()
        ->paginate(3)
        ->withQueryString();

        return view('content-view.vacancy', compact('vacancies', 'search'));
    }
    

      /**
     * Display Locations page
     */
    public function locations()
    {
        $locations = Location::active()
        ->ordered()
        ->withCount('places')
        ->get();

    return view('content-view.locations-map', compact('locations'));
    }
}