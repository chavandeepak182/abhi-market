<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InsightsController;
use App\Http\Controllers\InsightsCategoryController;
use App\Http\Controllers\IndustriesCategoryController;
use App\Http\Controllers\IndustriesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PayPalController;

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/insights', [FrontendController::class, 'insights'])->name('insights');

Route::get('/industries', [FrontendController::class, 'industries'])->name('industries');

Route::get('/services', [FrontendController::class, 'services'])->name('services');

Route::get('/reports', [FrontendController::class, 'reports'])->name('reports');

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/contact', function () {
    return view('frontend.contact');
});
//Thank you page
Route::get('/thank-you', function () {
    return view('frontend.thank-you');
})->name('thank.you');

Route::post('/contact', [ContactController::class, 'handleContactForm'])->name('contact.submit');

Route::get('/details', function () {
    return view('frontend.details');
});

Route::get('/overview', function () {
    return view('frontend.overview');
});
Route::get('/purchase/{id}', [PurchaseController::class, 'showById'])->name('purchase.page');
Route::post('/paypal/payment', [PayPalController::class, 'handlePayment'])->name('paypal.payment');
Route::get('/paypal/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.cancel');

Route::get('/research', function () {
    return view('frontend.research');
});

Route::middleware('isAdmin')->group(function () {
    Route::post('admin/insertUser',[UsersController::class,'insertUser'])->name('insertUser');
        Route::get('editUser/{user_id}', [UsersController::class, 'editUser'])->name('editUser');
        Route::post('updateUser', [UsersController::class, 'updateUser'])->name('updateUser');
        Route::post('deleteUser', [UsersController::class, 'deleteUser'])->name('deleteUser');
        Route::get('updateProfile', [UsersController::class, 'updateProfile'])->name('updateProfile');
        Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('admin/allUsers', [UsersController::class, 'allUsers'])->name('allUsers');
        Route::post('update-user-status/{id}', [UsersController::class, 'updateStatus']);
    });

    // blog
    // frontend blog routes 
    Route::get('/blog/{id}', [FrontendController::class, 'showBlog'])->name('blog.show');

Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');


Route::get('admin/blog', [BlogController::class, 'index'])->name('blog.index');          // List blogs
   Route::get('admin/blog/create', [BlogController::class, 'create'])->name('blog.create'); // Add blog form
    Route::post('blog/store', [BlogController::class, 'storeService'])->name('blog.store'); // Save blog
    Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');  // Edit blog form
    Route::put('blog/update/{id}', [BlogController::class, 'update'])->name('blog.update'); // Update blog
    Route::post('blog/delete/{id}', [BlogController::class, 'deleteService'])->name('blog.delete'); // Delete blog


    // blog category
    Route::get('/blog-categories', [BlogCategoryController::class, 'index'])->name('blog.categories.index');
Route::post('/blog-categories/store', [BlogCategoryController::class, 'store'])->name('blog.categories.store');
Route::get('/blog-categories/edit/{pid}', [BlogCategoryController::class, 'edit'])->name('blog.categories.edit');
Route::post('/blog-categories/update/{pid}', [BlogCategoryController::class, 'update'])->name('blog.categories.update');

Route::middleware('isAdmin')->group(function () {
    Route::post('/blog-categories/delete/{pid}', [BlogCategoryController::class, 'destroy'])
        ->name('blog.categories.delete');
});



//admin user profile

Route::post('/register', [UsersController::class, 'registerUser'])->name('registerUser');
Route::get('login', [AdminController::class, 'loginView'])->name('login');
Route::post('userLogin', [FrontendController::class, 'userLogin'])->name('userLogin');
Route::get('logout', [FrontendController::class, 'logout'])->name('logout');
Route::get('userAuth/{user_id}/{auth_code}', [FrontendController::class, 'activate'])->name('activate');

//reset password
// Route::post('reset_password_link', [FrontendController::class, 'reset_password_link'])->name('reset_password_link');
// Route::get('reset_password/{auth_id}', [FrontendController::class, 'reset_password'])->name('reset_password');
// Route::post('update_password', [FrontendController::class, 'update_password'])->name('update_password');

Route::get('/reset', function () {
    return view('frontend.reset-password');
});

Route::get('/signup', function () {
    return view('admin.sign-up');
});

//enquiry
Route::get('admin/enquiries', [EnquiryController::class, 'enquiryLead'])->name('enquiries.enquiryLead');

//enquiry form
Route::get('enquiry', [EnquiryController::class, 'showForm'])->name('enquiry.form');
Route::post('enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');

Route::get('/request-sample/{slug}', [ReportController::class, 'showSampleForm'])->name('request.sample');

//banner
Route::middleware('isPartner')->group(function () {
    Route::get('/admin/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
});
//channel partner

//serivce category & subcategory
Route::get('/categories', [PropertyCategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/store', [PropertyCategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [PropertyCategoryController::class, 'edit'])->name('categories.edit');
Route::post('/categories/update/{id}', [PropertyCategoryController::class, 'update'])->name('categories.update');
Route::middleware('isAdmin')->group(function () {
    Route::post('/categories/delete/{id}', [PropertyCategoryController::class, 'destroy'])->name('categories.delete');
});
Route::get('/subcategories', [PropertyCategoryController::class, 'subcategories'])->name('subcategories.index');
Route::post('/subcategories/store', [PropertyCategoryController::class, 'storeSubcategory'])->name('subcategories.store');
Route::get('/subcategories/edit/{id}', [PropertyCategoryController::class, 'editSubcategory'])->name('subcategories.edit');
Route::post('/subcategories/update/{id}', [PropertyCategoryController::class, 'updateSubcategory'])->name('subcategories.update');
Route::middleware('isAdmin')->group(function () {
    Route::post('/subcategories/delete/{id}', [PropertyCategoryController::class, 'deleteSubcategory'])->name('subcategories.delete');
});
Route::get('/reports/search', [FrontendController::class, 'search'])->name('reports.search');

Route::middleware('isAdmin')->group(function () {
//Reports
Route::get('admin/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports/store', [ReportController::class, 'storeReport'])->name('reports.store');
Route::get('/reports/edit/{id}', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/update/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::post('/reports/delete/{id}', [ReportController::class, 'deleteReport'])->name('reports.delete');
});

//frontend reports
Route::get('/reports/{slug}', [ReportController::class, 'show'])->name('reports.details');
Route::get('/get-reports', [ReportController::class, 'getReports'])->name('reports.list');
Route::get('/get-reports-by-industry/{id}', [ReportController::class, 'getReportsByIndustry']);
//frontend industries
Route::get('/industries/{slug}', [IndustriesController::class, 'show'])->name('industries.details');
Route::get('/get-subcategories-industries/{categoryId}', [IndustriesCategoryController::class, 'getSubcategories']);
Route::get('/get-industries', [IndustriesController::class, 'getIndustries']);
//frontend capabilities
Route::get('/get-subcategories/{categoryId}', [ServiceController::class, 'getSubcategories']);
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.details');
Route::get('/get-categories', [ServiceController::class, 'getCategories']);
Route::get('/get-services', [ServiceController::class, 'getServices']);

Route::middleware('isAdmin')->group(function () {
//services
Route::get('admin/services', [ServiceController::class, 'index'])->name('services.index');
Route::post('/services/store', [ServiceController::class, 'storeService'])->name('services.store');
Route::get('/services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/update/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');

    Route::post('/services/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
});

Route::middleware('isAdmin')->group(function () {
//insights
Route::get('admin/insights', [InsightsController::class, 'index'])->name('insights.index');
Route::post('/insights/store', [InsightsController::class, 'storeService'])->name('insights.store');
Route::get('/insights/edit/{id}', [InsightsController::class, 'edit'])->name('insights.edit');
Route::put('/insights/update/{id}', [InsightsController::class, 'update'])->name('insights.update');
Route::get('/insights/delete/{id}', [InsightsController::class, 'deleteService'])->name('insights.delete');
Route::get('/insights/create', [InsightsController::class, 'create'])->name('insights.create');
Route::get('/get-subcategories-insights/{categoryId}', [InsightsController::class, 'getSubcategories']);
Route::get('/insights/{slug}', [InsightsController::class, 'show'])->name('insights.details');
Route::get('/get-insights', [InsightsController::class, 'getInsights']);

//serivce category & subcategory
Route::get('/insights-categories', [InsightsCategoryController::class, 'index'])->name('insights.categories.index');
Route::post('/insights-categories/store', [InsightsCategoryController::class, 'store'])->name('insights.categories.store');
Route::get('/insights-categories/edit/{id}', [InsightsCategoryController::class, 'edit'])->name('insights.categories.edit');
Route::post('/insights-categories/update/{id}', [InsightsCategoryController::class, 'update'])->name('insights.categories.update');
Route::get('/insights-categories/delete/{id}', [InsightsCategoryController::class, 'destroy'])->name('insights.categories.delete');

Route::get('/insights-subcategories', [InsightsCategoryController::class, 'subcategories'])->name('insights.subcategories.index');
Route::post('/insights-subcategories/store', [InsightsCategoryController::class, 'storeSubcategory'])->name('insights.subcategories.store');
Route::get('/insights-subcategories/edit/{id}', [InsightsCategoryController::class, 'editSubcategory'])->name('insights.subcategories.edit');
Route::post('/insights-subcategories/update/{id}', [InsightsCategoryController::class, 'updateSubcategory'])->name('insights.subcategories.update');
Route::get('/insightssubcategories/delete/{id}', [InsightsCategoryController::class, 'deleteSubcategory'])->name('insights.subcategories.delete');

//industries
Route::get('admin/industries', [IndustriesController::class, 'index'])->name('industries.index');
Route::post('/industries/store', [IndustriesController::class, 'storeService'])->name('industries.store');
Route::get('/industries/edit/{id}', [IndustriesController::class, 'edit'])->name('industries.edit');
Route::put('/industries/update/{id}', [IndustriesController::class, 'update'])->name('industries.update');
Route::get('/industries/create', [IndustriesController::class, 'create'])->name('industries.create');
Route::post('/industries/delete/{id}', [IndustriesController::class, 'deleteService'])->name('industries.delete');


//industries category & subcategory
Route::get('/industries-categories', [IndustriesCategoryController::class, 'index'])->name('industries.categories.index');
Route::post('/industries-categories/store', [IndustriesCategoryController::class, 'store'])->name('industries.categories.store');
Route::get('/industries-categories/edit/{id}', [IndustriesCategoryController::class, 'edit'])->name('industries.categories.edit');
Route::post('/industries-categories/update/{id}', [IndustriesCategoryController::class, 'update'])->name('industries.categories.update');
Route::middleware('isAdmin')->group(function () {
    Route::post('/industries-categories/delete/{id}', [IndustriesCategoryController::class, 'destroy'])
        ->name('industries.categories.delete');
});
Route::get('/industries-subcategories', [IndustriesCategoryController::class, 'subcategories'])->name('industries.subcategories.index');
Route::post('/industries-subcategories/store', [IndustriesCategoryController::class, 'storeSubcategory'])->name('industries.subcategories.store');
Route::get('/industries-subcategories/edit/{id}', [IndustriesCategoryController::class, 'editSubcategory'])->name('industries.subcategories.edit');
Route::post('/industries-subcategories/update/{id}', [IndustriesCategoryController::class, 'updateSubcategory'])->name('industries.subcategories.update');
    Route::post('/industriessubcategories/delete/{id}', [IndustriesCategoryController::class, 'deleteSubcategory'])
        ->name('industries.subcategories.delete');
});
//news
Route::middleware('isAdmin')->group(function () {
    Route::prefix('admin/news')->name('admin.news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/create', [NewsController::class, 'create'])->name('create');
        Route::post('/store', [NewsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [NewsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [NewsController::class, 'destroy'])->name('destroy');
    });
});
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
