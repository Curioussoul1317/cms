<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproveAndPublishController extends Controller
{
 
    protected $allowedModels = [
        'bod-director' => \App\Models\BodDirector::class, 
        'corprofile-page' => \App\Models\CorprofilePage::class,
        'download-category' => \App\Models\DownloadCategory::class,
        'download-file' => \App\Models\DownloadFile::class,
        'hero-section' => \App\Models\HeroSection::class,
        'main-category' => \App\Models\MainCategory::class,
        'media-category' => \App\Models\MediaCategory::class,
        'media-file' => \App\Models\MediaFile::class,
        'our-partner' => \App\Models\OurPartner::class,
        'our-timeline-item' => \App\Models\OurTimelineItem::class,
        'page-content' => \App\Models\PageContent::class,
        'page' => \App\Models\Page::class,
        'vacancy' => \App\Models\Vacancy::class,
        'vacancy-location' => \App\Models\VacancyLocation::class,
    ];

  
    protected function resolveModel($model, $id)
    {
        if (!array_key_exists($model, $this->allowedModels)) {
            abort(404, 'Model not found');
        }

        $modelClass = $this->allowedModels[$model];
        return $modelClass::findOrFail($id);
    }

 
    public function approve($model, $id)
    {
        $record = $this->resolveModel($model, $id);
 
        $record->update([
            'is_approved' => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Record approved successfully.');
    }

 
    public function unapprove($model, $id)
    {
        $record = $this->resolveModel($model, $id);

        $record->update([
            'is_approved' => false,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return back()->with('success', 'Record unapproved successfully.');
    }
 
    public function publish($model, $id)
    {
        $record = $this->resolveModel($model, $id);

        $record->update([
            'is_published' => true,
            'published_by' => Auth::id(),
            'published_at' => now(),
        ]);

        return back()->with('success', 'Record published successfully.');
    }

 
    public function unpublish($model, $id)
    {
        $record = $this->resolveModel($model, $id);

        $record->update([
            'is_published' => false,
            'published_by' => null,
            'published_at' => null,
        ]);

        return back()->with('success', 'Record unpublished successfully.');
    }
}