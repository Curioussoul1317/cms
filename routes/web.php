<?php      
  
use App\Http\Controllers\MainCategoryController; 
use App\Http\Controllers\CategoryViewController; 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\PageController; 
use App\Http\Controllers\CorprofileController;
use App\Http\Controllers\BodDirectorController; 
use App\Http\Controllers\OurTimelineController;
use App\Http\Controllers\OurPartnerController;
use App\Http\Controllers\ApproveAndPublishController;

use App\Http\Controllers\MediaCategoryController;
use App\Http\Controllers\MediaFileController;
use App\Http\Controllers\MediaCenterController;

use App\Http\Controllers\DownloadCategoryController;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\DownloadsSectionController;

use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VacancyLocationController;

use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\FrontendController;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\SyncController;

Route::get('/check-auth', function() {
    return response()->json([
        'authenticated' => Auth::check()
    ]);
});

Route::get('/login', function() {
    return redirect('https://dev-1.wamco.mv/home');
})->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('https://dev-1.wamco.mv/home');
})->name('logout');

 
Route::resource('pages', PageController::class)->only(['index', 'show']);
Route::get('pages/{page}/children', [PageController::class, 'children'])->name('pages.children');
Route::get('main-categories/{mainCategory}/pages', [PageController::class, 'byMainCategory'])->name('pages.by-category');

Route::get('/home', [PageViewController::class, 'index'])->name('home');
Route::get('/page/{slug}', [PageViewController::class, 'showBySlug'])->name('page.slug');
Route::get('/content/{type}/{id}', [PageViewController::class, 'show'])->name('content.show'); 

// Corporate Profile Public Routes
Route::prefix('corporate')->name('corprofile.')->group(function () {
    Route::get('/our-company', [PageViewController::class, 'ourCompany'])->name('OurCompany');
    Route::get('/board-of-directors', [PageViewController::class, 'boardOfDirectors'])->name('BoardofDirectors');
    Route::get('/timeline', [PageViewController::class, 'timeline'])->name('Timeline');
    Route::get('/our-partners', [PageViewController::class, 'ourPartners'])->name('OurPartners');
    Route::get('/locations', [PageViewController::class, 'locations'])->name('Locations');
    Route::get('/media', [PageViewController::class, 'media'])->name('Media');
    Route::get('/mediadownload', [PageViewController::class, 'mediadownload'])->name('Mediadownload');
    Route::get('/downloads', [PageViewController::class, 'downloads'])->name('Downloads');
    Route::get('/sustainability', [PageViewController::class, 'sustainability'])->name('Sustainability');
    Route::get('/open-vacancies', [PageViewController::class, 'openVacancies'])->name('OpenVacancies');
    Route::get('/news/{identifier?}', [PageViewController::class, 'news'])->name('news');
});

// Public Media & Downloads
Route::get('/mediacenter', [MediaCenterController::class, 'index'])->name('mediacenter.index');
Route::get('/downloads', [DownloadsSectionController::class, 'index'])->name('downloads.index'); 

// Public Locations & Places
Route::get('/locations', [FrontendController::class, 'locationsMap'])->name('locations.map');
Route::get('/locations/{location:slug}/{place:slug}', [FrontendController::class, 'showPlace'])->name('locations.place.show');

// Public API Routes
Route::prefix('api')->group(function () {
    Route::get('/places/all', [FrontendController::class, 'getAllPlaces'])->name('api.places.all');
    Route::get('/places/location/slug/{slug}', [FrontendController::class, 'getPlacesBySlug']);
    Route::get('/places/location/{id}', [FrontendController::class, 'getPlacesByLocation'])->where('id', '[0-9]+');
});

 

Route::middleware(['auth', 'role:cms-editor|cms-approver|cms-publisher'])->group(function () {
    
    // Pages Management
    Route::resource('pages', PageController::class)->except(['index', 'show']);
    
    // Main Categories
    Route::resource('main-categories', MainCategoryController::class);
    
    // Corporate Profile
    Route::resource('corprofile', CorprofileController::class);
    Route::patch('corprofile/{corprofile}/basic-info', [CorprofileController::class, 'updateBasicInfo'])->name('corprofile.update.basic');
    Route::patch('corprofile/{corprofile}/vision', [CorprofileController::class, 'updateVision'])->name('corprofile.update.vision');
    Route::patch('corprofile/{corprofile}/mission', [CorprofileController::class, 'updateMission'])->name('corprofile.update.mission');
    Route::patch('corprofile/{corprofile}/objectives', [CorprofileController::class, 'updateObjectives'])->name('corprofile.update.objectives');
    Route::patch('corprofile/{corprofile}/strategies', [CorprofileController::class, 'updateStrategies'])->name('corprofile.update.strategies');
    Route::patch('corprofile/{corprofile}/values', [CorprofileController::class, 'updateValues'])->name('corprofile.update.values');
    Route::patch('corprofile/{corprofile}/principles', [CorprofileController::class, 'updatePrinciples'])->name('corprofile.update.principles');
    
    // Board of Directors
    Route::resource('bod', BodDirectorController::class);
    
    // Timeline
    Route::prefix('ourtimeline')->name('ourtimeline.')->group(function () {
        Route::get('/', [OurTimelineController::class, 'index'])->name('index');
        Route::get('/show', [OurTimelineController::class, 'show'])->name('show');
        Route::get('/create', [OurTimelineController::class, 'create'])->name('create');
        Route::post('/', [OurTimelineController::class, 'store'])->name('store');
        Route::get('/{ourtimeline}/edit', [OurTimelineController::class, 'edit'])->name('edit');
        Route::put('/{ourtimeline}', [OurTimelineController::class, 'update'])->name('update');
        Route::delete('/{ourtimeline}', [OurTimelineController::class, 'destroy'])->name('destroy');
    });
    
    // Partners
    Route::prefix('ourpartners')->name('ourpartners.')->group(function () {
        Route::get('/', [OurPartnerController::class, 'index'])->name('index');
        Route::get('/show', [OurPartnerController::class, 'show'])->name('show');
        Route::get('/create', [OurPartnerController::class, 'create'])->name('create');
        Route::post('/', [OurPartnerController::class, 'store'])->name('store');
        Route::get('/{ourpartner}/edit', [OurPartnerController::class, 'edit'])->name('edit');
        Route::put('/{ourpartner}', [OurPartnerController::class, 'update'])->name('update');
        Route::delete('/{ourpartner}', [OurPartnerController::class, 'destroy'])->name('destroy');
    });
    
    // Media Categories
    Route::prefix('mediacategories')->name('mediacategories.')->group(function () {
        Route::get('/', [MediaCategoryController::class, 'index'])->name('index');
        Route::get('/create', [MediaCategoryController::class, 'create'])->name('create');
        Route::post('/', [MediaCategoryController::class, 'store'])->name('store');
        Route::get('/{mediacategory}/edit', [MediaCategoryController::class, 'edit'])->name('edit');
        Route::put('/{mediacategory}', [MediaCategoryController::class, 'update'])->name('update');
        Route::delete('/{mediacategory}', [MediaCategoryController::class, 'destroy'])->name('destroy');
    });
    
    // Media Files
    Route::prefix('mediafiles')->name('mediafiles.')->group(function () {
        Route::get('/', [MediaFileController::class, 'index'])->name('index');
        Route::get('/create', [MediaFileController::class, 'create'])->name('create');
        Route::post('/', [MediaFileController::class, 'store'])->name('store');
        Route::get('/{mediafile}/edit', [MediaFileController::class, 'edit'])->name('edit');
        Route::put('/{mediafile}', [MediaFileController::class, 'update'])->name('update');
        Route::delete('/{mediafile}', [MediaFileController::class, 'destroy'])->name('destroy');
        Route::get('/{mediafile}/download', [MediaFileController::class, 'download'])->name('download');
    });
    
    // Download Categories
    Route::prefix('downloadcategories')->name('downloadcategories.')->group(function () {
        Route::get('/', [DownloadCategoryController::class, 'index'])->name('index');
        Route::get('/create', [DownloadCategoryController::class, 'create'])->name('create');
        Route::post('/', [DownloadCategoryController::class, 'store'])->name('store');
        Route::get('/{downloadcategory}/edit', [DownloadCategoryController::class, 'edit'])->name('edit');
        Route::put('/{downloadcategory}', [DownloadCategoryController::class, 'update'])->name('update');
        Route::delete('/{downloadcategory}', [DownloadCategoryController::class, 'destroy'])->name('destroy');
    });
    
    // Download Files
    Route::prefix('downloadfiles')->name('downloadfiles.')->group(function () {
        Route::get('/', [DownloadFileController::class, 'index'])->name('index');
        Route::get('/create', [DownloadFileController::class, 'create'])->name('create');
        Route::post('/', [DownloadFileController::class, 'store'])->name('store');
        Route::get('/{downloadfile}/edit', [DownloadFileController::class, 'edit'])->name('edit');
        Route::put('/{downloadfile}', [DownloadFileController::class, 'update'])->name('update');
        Route::delete('/{downloadfile}', [DownloadFileController::class, 'destroy'])->name('destroy');
        Route::get('/{downloadfile}/download-english', [DownloadFileController::class, 'downloadEnglish'])->name('download-english');
        Route::get('/{downloadfile}/download-dhivehi', [DownloadFileController::class, 'downloadDhivehi'])->name('download-dhivehi');
    });
    
    // Vacancy Locations
    Route::prefix('vacancylocations')->name('vacancylocations.')->group(function () {
        Route::get('/', [VacancyLocationController::class, 'index'])->name('index');
        Route::get('/create', [VacancyLocationController::class, 'create'])->name('create');
        Route::post('/', [VacancyLocationController::class, 'store'])->name('store');
        Route::get('/{vacancylocation}/edit', [VacancyLocationController::class, 'edit'])->name('edit');
        Route::put('/{vacancylocation}', [VacancyLocationController::class, 'update'])->name('update');
        Route::delete('/{vacancylocation}', [VacancyLocationController::class, 'destroy'])->name('destroy');
    });
    
    // Vacancies
    Route::prefix('vacancies')->name('vacancies.')->group(function () {
        Route::get('/', [VacancyController::class, 'index'])->name('index');
        Route::get('/create', [VacancyController::class, 'create'])->name('create');
        Route::post('/', [VacancyController::class, 'store'])->name('store');
        Route::get('/{vacancy}/edit', [VacancyController::class, 'edit'])->name('edit');
        Route::put('/{vacancy}', [VacancyController::class, 'update'])->name('update');
        Route::delete('/{vacancy}', [VacancyController::class, 'destroy'])->name('destroy');
    });
    
    // Locations & Places
    Route::resource('locations', LocationController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('hero-sections', HeroSectionController::class);
    
    // News CRUD
    Route::resource('news', NewsController::class);
    Route::delete('news/images/{image}', [NewsController::class, 'deleteImage'])->name('news.images.delete');
    Route::post('news/images/order', [NewsController::class, 'updateImageOrder'])->name('news.images.order');
    
    // Page Contents
    Route::get('/', [CategoryViewController::class, 'index'])->name('categories.hierarchy');
    
    Route::prefix('{type}/{id}')->where(['type' => 'page'])->group(function () {
        Route::get('/contents', [PageContentController::class, 'index'])->name('page-contents.index');
        Route::get('/contents/create', [PageContentController::class, 'create'])->name('page-contents.create');
        Route::post('/contents', [PageContentController::class, 'store'])->name('page-contents.store');
        Route::get('/contents/{pageContent}/edit', [PageContentController::class, 'edit'])->name('page-contents.edit');
        Route::put('/contents/{pageContent}', [PageContentController::class, 'update'])->name('page-contents.update');
        Route::delete('/contents/{pageContent}', [PageContentController::class, 'destroy'])->name('page-contents.destroy');
        Route::post('/contents/update-order', [PageContentController::class, 'updateOrder'])->name('page-contents.update-order');
    });
});
 

Route::middleware(['auth', 'role:cms-approver|cms-publisher'])->group(function () {
    
    // Generic Approve/Unapprove
    Route::patch('{model}/{id}/approve', [ApproveAndPublishController::class, 'approve'])->name('approve');
    Route::patch('{model}/{id}/unapprove', [ApproveAndPublishController::class, 'unapprove'])->name('unapprove');
    
    // News Approve/Unapprove
    Route::patch('news/{news}/approve', [NewsController::class, 'approve'])->name('news.approve');
    Route::patch('news/{news}/unapprove', [NewsController::class, 'unapprove'])->name('news.unapprove');
});

 
Route::middleware(['auth', 'role:cms-publisher'])->group(function () {
    
    // Generic Publish/Unpublish
    Route::patch('{model}/{id}/publish', [ApproveAndPublishController::class, 'publish'])->name('publish');
    Route::patch('{model}/{id}/unpublish', [ApproveAndPublishController::class, 'unpublish'])->name('unpublish');
    
    // News Publish/Unpublish
    Route::patch('news/{news}/publish', [NewsController::class, 'publish'])->name('news.publish');
    Route::patch('news/{news}/unpublish', [NewsController::class, 'unpublish'])->name('news.unpublish');
    Route::patch('news/{news}/toggle-active', [NewsController::class, 'toggleActive'])->name('news.toggle-active');
    
    // Sync Routes 
    Route::prefix('sync')->name('sync.')->group(function () {
        Route::get('/', [SyncController::class, 'index'])->name('index');
        Route::get('/health', [SyncController::class, 'checkHealth'])->name('health');
        Route::post('/all', [SyncController::class, 'syncAll'])->name('all');
        Route::post('/table', [SyncController::class, 'syncTable'])->name('table');
        Route::post('/modified', [SyncController::class, 'syncModified'])->name('modified');
        Route::get('/logs', [SyncController::class, 'logs'])->name('logs');
        Route::get('/logs/{log}', [SyncController::class, 'logDetails'])->name('log-details');
        Route::delete('/logs/clear', [SyncController::class, 'clearLogs'])->name('clear-logs');
    });
});


Route::prefix('api/sync')->group(function () {
    Route::post('/file', [\App\Http\Controllers\Api\SyncController::class, 'receiveFile']);
    Route::post('/files-batch', [\App\Http\Controllers\Api\SyncController::class, 'receiveFilesBatch']);
    Route::delete('/file', [\App\Http\Controllers\Api\SyncController::class, 'deleteFile']);
});

 // Sync Dashboard
 Route::get('/sync', [SyncController::class, 'index'])->name('sync.index');

 // Health Check (AJAX)
 Route::get('/sync/health', [SyncController::class, 'checkHealth'])->name('sync.health');

 // Database Sync
 Route::post('/sync/all', [SyncController::class, 'syncAll'])->name('sync.all');
 Route::post('/sync/table', [SyncController::class, 'syncTable'])->name('sync.table');
 Route::post('/sync/modified', [SyncController::class, 'syncModified'])->name('sync.modified');

 // File Sync
 Route::post('/sync/files', [SyncController::class, 'syncFiles'])->name('sync.files');
 Route::post('/sync/files/modified', [SyncController::class, 'syncModifiedFiles'])->name('sync.files.modified');

 // Sync Everything (Database + Files)
 Route::post('/sync/everything', [SyncController::class, 'syncEverything'])->name('sync.everything');

 // Sync Logs
 Route::get('/sync/logs', [SyncController::class, 'logs'])->name('sync.logs');
 Route::get('/sync/logs/{log}', [SyncController::class, 'logDetails'])->name('sync.log-details');
 Route::delete('/sync/logs/clear', [SyncController::class, 'clearLogs'])->name('sync.clear-logs');