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

 

Route::resource('pages', PageController::class);
Route::get('pages/{page}/children', [PageController::class, 'children'])->name('pages.children');
Route::get('main-categories/{mainCategory}/pages', [PageController::class, 'byMainCategory'])->name('pages.by-category');

Route::get('/home', [PageViewController::class, 'index'])->name('home');
Route::get('/page/{slug}', [PageViewController::class, 'showBySlug'])->name('page.slug');
Route::get('/content/{type}/{id}', [PageViewController::class, 'show'])->name('content.show'); 
 

// Corporate Profile Routes
Route::prefix('corporate')->name('corprofile.')->group(function () {
  // Corporate Profile
  Route::get('/our-company', [PageViewController::class, 'ourCompany'])->name('OurCompany');
  Route::get('/board-of-directors', [PageViewController::class, 'boardOfDirectors'])->name('BoardofDirectors');
  Route::get('/timeline', [PageViewController::class, 'timeline'])->name('Timeline');
  Route::get('/our-partners', [PageViewController::class, 'ourPartners'])->name('OurPartners');
  
  // Get in Touch
  Route::get('/locations', [PageViewController::class, 'locations'])->name('Locations');
  
  // Resource Center
  Route::get('/media', [PageViewController::class, 'media'])->name('Media');
  Route::get('/mediadownload', [PageViewController::class, 'mediadownload'])->name('Mediadownload');
  
  Route::get('/downloads', [PageViewController::class, 'downloads'])->name('Downloads');
  Route::get('/sustainability', [PageViewController::class, 'sustainability'])->name('Sustainability');
  
  // Careers
  Route::get('/open-vacancies', [PageViewController::class, 'openVacancies'])->name('OpenVacancies');
});



Route::prefix('ourtimeline')->name('ourtimeline.')->group(function () {
  Route::get('/', [OurTimelineController::class, 'index'])->name('index');
  Route::get('/show', [OurTimelineController::class, 'show'])->name('show');
  Route::get('/create', [OurTimelineController::class, 'create'])->name('create');
  Route::post('/', [OurTimelineController::class, 'store'])->name('store');
  Route::get('/{ourtimeline}/edit', [OurTimelineController::class, 'edit'])->name('edit');
  Route::put('/{ourtimeline}', [OurTimelineController::class, 'update'])->name('update');
  Route::delete('/{ourtimeline}', [OurTimelineController::class, 'destroy'])->name('destroy');
});


Route::prefix('ourpartners')->name('ourpartners.')->group(function () {
  Route::get('/', [OurPartnerController::class, 'index'])->name('index');
  Route::get('/show', [OurPartnerController::class, 'show'])->name('show');
  Route::get('/create', [OurPartnerController::class, 'create'])->name('create');
  Route::post('/', [OurPartnerController::class, 'store'])->name('store');
  Route::get('/{ourpartner}/edit', [OurPartnerController::class, 'edit'])->name('edit');
  Route::put('/{ourpartner}', [OurPartnerController::class, 'update'])->name('update');
  Route::delete('/{ourpartner}', [OurPartnerController::class, 'destroy'])->name('destroy');
});








Route::get('/mediacenter', [MediaCenterController::class, 'index'])->name('mediacenter.index');

// Admin Routes - Media Categories
Route::prefix('admin/mediacategories')->name('mediacategories.')->group(function () {
    Route::get('/', [MediaCategoryController::class, 'index'])->name('index');
    Route::get('/create', [MediaCategoryController::class, 'create'])->name('create');
    Route::post('/', [MediaCategoryController::class, 'store'])->name('store');
    Route::get('/{mediacategory}/edit', [MediaCategoryController::class, 'edit'])->name('edit');
    Route::put('/{mediacategory}', [MediaCategoryController::class, 'update'])->name('update');
    Route::delete('/{mediacategory}', [MediaCategoryController::class, 'destroy'])->name('destroy');
});

// Admin Routes - Media Files
Route::prefix('admin/mediafiles')->name('mediafiles.')->group(function () {
    Route::get('/', [MediaFileController::class, 'index'])->name('index');
    Route::get('/create', [MediaFileController::class, 'create'])->name('create');
    Route::post('/', [MediaFileController::class, 'store'])->name('store');
    Route::get('/{mediafile}/edit', [MediaFileController::class, 'edit'])->name('edit');
    Route::put('/{mediafile}', [MediaFileController::class, 'update'])->name('update');
    Route::delete('/{mediafile}', [MediaFileController::class, 'destroy'])->name('destroy');
    Route::get('/{mediafile}/download', [MediaFileController::class, 'download'])->name('download');
});




Route::get('/downloads', [DownloadsSectionController::class, 'index'])->name('downloads.index');

// Admin Routes - Download Categories
Route::prefix('admin/downloadcategories')->name('downloadcategories.')->group(function () {
    Route::get('/', [DownloadCategoryController::class, 'index'])->name('index');
    Route::get('/create', [DownloadCategoryController::class, 'create'])->name('create');
    Route::post('/', [DownloadCategoryController::class, 'store'])->name('store');
    Route::get('/{downloadcategory}/edit', [DownloadCategoryController::class, 'edit'])->name('edit');
    Route::put('/{downloadcategory}', [DownloadCategoryController::class, 'update'])->name('update');
    Route::delete('/{downloadcategory}', [DownloadCategoryController::class, 'destroy'])->name('destroy');
});

// Admin Routes - Download Files
Route::prefix('admin/downloadfiles')->name('downloadfiles.')->group(function () {
    Route::get('/', [DownloadFileController::class, 'index'])->name('index');
    Route::get('/create', [DownloadFileController::class, 'create'])->name('create');
    Route::post('/', [DownloadFileController::class, 'store'])->name('store');
    Route::get('/{downloadfile}/edit', [DownloadFileController::class, 'edit'])->name('edit');
    Route::put('/{downloadfile}', [DownloadFileController::class, 'update'])->name('update');
    Route::delete('/{downloadfile}', [DownloadFileController::class, 'destroy'])->name('destroy');
    Route::get('/{downloadfile}/download-english', [DownloadFileController::class, 'downloadEnglish'])->name('download-english');
    Route::get('/{downloadfile}/download-dhivehi', [DownloadFileController::class, 'downloadDhivehi'])->name('download-dhivehi');
});


Route::get('/vacancies', [VacancyController::class, 'show'])->name('vacancies.show');

// Admin Routes - Vacancy Locations
Route::prefix('admin/vacancylocations')->name('vacancylocations.')->group(function () {
    Route::get('/', [VacancyLocationController::class, 'index'])->name('index');
    Route::get('/create', [VacancyLocationController::class, 'create'])->name('create');
    Route::post('/', [VacancyLocationController::class, 'store'])->name('store');
    Route::get('/{vacancylocation}/edit', [VacancyLocationController::class, 'edit'])->name('edit');
    Route::put('/{vacancylocation}', [VacancyLocationController::class, 'update'])->name('update');
    Route::delete('/{vacancylocation}', [VacancyLocationController::class, 'destroy'])->name('destroy');
});

// Admin Routes - Vacancies
Route::prefix('admin/vacancies')->name('vacancies.')->group(function () {
    Route::get('/', [VacancyController::class, 'index'])->name('index');
    Route::get('/create', [VacancyController::class, 'create'])->name('create');
    Route::post('/', [VacancyController::class, 'store'])->name('store');
    Route::get('/{vacancy}/edit', [VacancyController::class, 'edit'])->name('edit');
    Route::put('/{vacancy}', [VacancyController::class, 'update'])->name('update');
    Route::delete('/{vacancy}', [VacancyController::class, 'destroy'])->name('destroy');
});



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
  Route::resource('locations', LocationController::class);
    
  // Place CRUD
  Route::resource('places', PlaceController::class);
  Route::resource('hero-sections', HeroSectionController::class);
});


// Frontend Routes
// Route::get('/', [FrontendController::class, 'locationsMap'])->name('home');
Route::get('/locations', [FrontendController::class, 'locationsMap'])->name('locations.map');
Route::get('/locations/{location:slug}/{place:slug}', [FrontendController::class, 'showPlace'])->name('locations.place.show');

// AJAX Routes for Frontend
Route::prefix('api')->group(function () {
    Route::get('/places/all', [FrontendController::class, 'getAllPlaces'])->name('api.places.all');
    Route::get('/places/location/slug/{slug}', [FrontendController::class, 'getPlacesBySlug']);
    Route::get('/places/location/{id}', [FrontendController::class, 'getPlacesByLocation'])->where('id', '[0-9]+');
});


Route::middleware(['auth'])->group(function () { 






  Route::patch('{model}/{id}/approve', [ApproveAndPublishController::class, 'approve'])->name('approve');
  Route::patch('{model}/{id}/unapprove', [ApproveAndPublishController::class, 'unapprove'])->name('unapprove');
  Route::patch('{model}/{id}/publish', [ApproveAndPublishController::class, 'publish'])->name('publish');
  Route::patch('{model}/{id}/unpublish', [ApproveAndPublishController::class, 'unpublish'])->name('unpublish');


 Route::resource('corprofile', CorprofileController::class);
// Corprofile Routes
 

// Section updates
Route::patch('corprofile/{corprofile}/basic-info', [CorprofileController::class, 'updateBasicInfo'])->name('corprofile.update.basic');
Route::patch('corprofile/{corprofile}/vision', [CorprofileController::class, 'updateVision'])->name('corprofile.update.vision');
Route::patch('corprofile/{corprofile}/mission', [CorprofileController::class, 'updateMission'])->name('corprofile.update.mission');
Route::patch('corprofile/{corprofile}/objectives', [CorprofileController::class, 'updateObjectives'])->name('corprofile.update.objectives');
Route::patch('corprofile/{corprofile}/strategies', [CorprofileController::class, 'updateStrategies'])->name('corprofile.update.strategies');
Route::patch('corprofile/{corprofile}/values', [CorprofileController::class, 'updateValues'])->name('corprofile.update.values');
Route::patch('corprofile/{corprofile}/principles', [CorprofileController::class, 'updatePrinciples'])->name('corprofile.update.principles');

Route::resource('bod', BodDirectorController::class);

  Route::get('/', [CategoryViewController::class, 'index'])
  ->name('categories.hierarchy');
  
 
Route::resource('main-categories', MainCategoryController::class);
  
  

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


  




//   <form action="{{ route('pageContent.approveModel', ['type' => $type, 'id' => $model->id]) }}" 
// method="POST" 
// style="display: inline;"> 
// @csrf
// <button type="submit" 
//       class="btn btn-success d-none d-sm-inline-block"
//       data-bs-toggle="tooltip"
//       title="Approve Page">
//   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checks">
//       <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
//       <path d="M7 12l5 5l10 -10" />
//       <path d="M2 12l5 5m5 -5l5 -5" />
//   </svg>
//   Approve
// </button>
// </form>

// <form action="{{ route('pageContent.unapproveModel', ['type' => $type, 'id' => $model->id]) }}" 
// method="POST" 
// style="display: inline;">
// @csrf
// <button type="submit" 
//       class="btn btn-danger d-none d-sm-inline-block"
//       data-bs-toggle="tooltip"
//       title="Unapprove Page">
//   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
//       <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
//       <path d="M18 6l-12 12" />
//       <path d="M6 6l12 12" />
//   </svg>
//   Unapprove
// </button>
// </form> 