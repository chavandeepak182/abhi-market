<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
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


Route::get('/', function () {
    return view('frontend.index-slider');
});

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

Route::post('/contact', [ContactController::class, 'handleContactForm'])->name('contact.submit');

Route::get('/details', function () {
    return view('frontend.details');
});

Route::get('/overview', function () {
    return view('frontend.overview');
});

Route::middleware('isAdmin')->group(function () {
    Route::post('admin/insertUser',[UsersController::class,'insertUser'])->name('insertUser');
        Route::get('editUser/{user_id}', [UsersController::class, 'editUser'])->name('editUser');
        Route::post('updateUser', [UsersController::class, 'updateUser'])->name('updateUser');
        Route::post('deleteUser', [UsersController::class, 'deleteUser'])->name('deleteUser');
        Route::get('updateProfile', [UsersController::class, 'updateProfile'])->name('updateProfile');
        Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('admin/allUsers', [UsersController::class, 'allUsers'])->name('allUsers');
        Route::post('update-user-status/{id}', [UserController::class, 'updateStatus']);
        Route::post('admin/assignAgent', [LoanApplicationController::class, 'assignAgent'])->name('assignAgent');
    });

//admin user profile

Route::get('admin/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.profile.edit');
Route::post('admin/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
Route::get('admin/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
//customer register
Route::post('/register', [UsersController::class, 'registerUser'])->name('registerUser');

Route::middleware('isAgent')->group(function () {
    Route::get('agent/agentDashboard', [AgentController::class, 'agentDashboard'])->name('agentDashboard');
    Route::get('agent/allAgents', [AgentController::class, 'allAgents'])->name('allAgents');
    Route::post('agent/insertAgent',[AgentController::class,'insertAgent'])->name('insertAgent');
    Route::get('/editAgent/{user_id}', [AgentController::class, 'editAgent'])->name('editAgent');
    Route::post('/updateAgent', [AgentController::class, 'updateAgent'])->name('updateAgent');
    Route::post('/deleteAgent', [AgentController::class, 'deleteAgent'])->name('deleteAgent');
    Route::get('agent/assigned-loans', [LoanApplicationController::class, 'assignedLoans'])->name('agent.assignedLoans');
    Route::get('loan/details/{id}', [LoanApplicationController::class, 'loanShow'])->name('loan.details');
    Route::post('agent/accept-loan', [LoanApplicationController::class, 'acceptLoan'])->name('agent.acceptLoan');
    Route::post('agent/reject-loan', [LoanApplicationController::class, 'rejectLoan'])->name('agent.rejectLoan');
    Route::get('agent/referral_earnings', [ReferralController::class, 'referral_earnings'])->name('referral_earnings');
    Route::get('agent/walletbalance', [ReferralController::class, 'walletbalance'])->name('walletbalance');

});
Route::middleware('isAdmin')->group(function () {
    Route::get('admin/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('admin/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
});

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

//banner
Route::middleware('isPartner')->group(function () {
    Route::get('/admin/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
});
//channel partner
Route::middleware('isPartner')->group(function () {
    Route::get('partner/partnerDashboard', [PartnerController::class, 'partnerDashboard'])->name('partnerDashboard');
    Route::get('partner/allPartners', [PartnerController::class, 'allPartners'])->name('allPartners');
    Route::post('partner/insertPartner',[PartnerController::class,'insertPartner'])->name('insertPartner');
    Route::get('/editPartner/{user_id}', [PartnerController::class, 'editPartner'])->name('editPartner');
    Route::post('/updatePartner', [PartnerController::class, 'updatePartner'])->name('updatePartner');
    Route::post('/deletePartner', [PartnerController::class, 'deletePartner'])->name('deletePartner');

    //property
    Route::get('partner/pendingProperties', [PropertyController::class, 'pendingProperties'])->name('pendingProperties');
    Route::get('partner/addProperty', [PropertyController::class, 'addProperty'])->name('addProperty');
    Route::post('partner/insertProperty',[PropertyController::class,'insertProperty'])->name('insertProperty');
    Route::get('partner/allProperties', [PropertyController::class, 'allProperties'])->name('allProperties');
    Route::get('/viewDetails/{property_id}', [PropertyController::class, 'viewDetails'])->name('viewDetails');
    Route::get('/editProperty/{property_id}', [PropertyController::class, 'editProperty'])->name('editProperty');
    Route::post('/updatePropertie', [PropertyController::class, 'updatePropertie'])->name('updatePropertie');
    Route::post('/deletePropertie', [PropertyController::class, 'deletePropertie'])->name('deletePropertie');
    Route::post('/activate', [PropertyController::class, 'activate'])->name('activate');
    //profile
    Route::get('/partner/profile', [ProfileController::class, 'showPartnerProfile'])->name('partner.profile');
    Route::post('/partner/profile/update', [ProfileController::class, 'updatePartnerProfile'])->name('partner.updateProfile');
    Route::post('/tinymce/upload', [PropertyController::class, 'uploadTinyMCEImage'])->name('tinymce.upload');
});
Route::post('/toggle-featured', [PropertyController::class, 'toggleFeatured'])->name('toggleFeatured');    
/// Show the locality selection form for a specific property (GET)
Route::get('/admin/localities', [PropertyController::class, 'getLocalities'])->name('admin.localities');
Route::post('/admin/localities', [PropertyController::class, 'storeLocalities'])->name('admin.localities.store');
Route::get('property-details/{property_id}', [FrontendController::class, 'PropDetailsView'])->name('property.details');

//serivce category & subcategory
Route::get('/categories', [PropertyCategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/store', [PropertyCategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [PropertyCategoryController::class, 'edit'])->name('categories.edit');
Route::post('/categories/update/{id}', [PropertyCategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/delete/{id}', [PropertyCategoryController::class, 'destroy'])->name('categories.delete');

Route::get('/subcategories', [PropertyCategoryController::class, 'subcategories'])->name('subcategories.index');
Route::post('/subcategories/store', [PropertyCategoryController::class, 'storeSubcategory'])->name('subcategories.store');
Route::get('/subcategories/edit/{id}', [PropertyCategoryController::class, 'editSubcategory'])->name('subcategories.edit');
Route::post('/subcategories/update/{id}', [PropertyCategoryController::class, 'updateSubcategory'])->name('subcategories.update');
Route::get('/subcategories/delete/{id}', [PropertyCategoryController::class, 'deleteSubcategory'])->name('subcategories.delete');

//Reports
Route::get('admin/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports/store', [ReportController::class, 'storeReport'])->name('reports.store');
Route::get('/reports/edit/{id}', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/update/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::get('/reports/delete/{id}', [ReportController::class, 'deleteReport'])->name('reports.delete');
Route::get('/reports/{slug}', [ReportController::class, 'show'])->name('reports.details');
Route::get('/get-reports', [ReportController::class, 'getReports']);


//services
Route::get('admin/services', [ServiceController::class, 'index'])->name('services.index');
Route::post('/services/store', [ServiceController::class, 'storeService'])->name('services.store');
Route::get('/services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/update/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::get('/services/delete/{id}', [ServiceController::class, 'deleteService'])->name('services.delete');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::get('/get-subcategories/{categoryId}', [ServiceController::class, 'getSubcategories']);
// Route::get('/service-details/{id}', [ServiceController::class, 'show'])->name('service.details');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.details');

Route::get('/get-categories', [ServiceController::class, 'getCategories']);
Route::get('/get-services', [ServiceController::class, 'getServices']);

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
Route::get('/industries/delete/{id}', [IndustriesController::class, 'deleteService'])->name('industries.delete');
Route::get('/industries/create', [IndustriesController::class, 'create'])->name('industries.create');
Route::get('/industries/{slug}', [IndustriesController::class, 'show'])->name('industries.details');
Route::get('/get-subcategories-industries/{categoryId}', [IndustriesCategoryController::class, 'getSubcategories']);
Route::get('/get-industries', [IndustriesController::class, 'getIndustries']);

//industries category & subcategory
Route::get('/industries-categories', [IndustriesCategoryController::class, 'index'])->name('industries.categories.index');
Route::post('/industries-categories/store', [IndustriesCategoryController::class, 'store'])->name('industries.categories.store');
Route::get('/industries-categories/edit/{id}', [IndustriesCategoryController::class, 'edit'])->name('industries.categories.edit');
Route::post('/industries-categories/update/{id}', [IndustriesCategoryController::class, 'update'])->name('industries.categories.update');
Route::get('/industries-categories/delete/{id}', [IndustriesCategoryController::class, 'destroy'])->name('industries.categories.delete');

Route::get('/industries-subcategories', [IndustriesCategoryController::class, 'subcategories'])->name('industries.subcategories.index');
Route::post('/industries-subcategories/store', [IndustriesCategoryController::class, 'storeSubcategory'])->name('industries.subcategories.store');
Route::get('/industries-subcategories/edit/{id}', [IndustriesCategoryController::class, 'editSubcategory'])->name('industries.subcategories.edit');
Route::post('/industries-subcategories/update/{id}', [IndustriesCategoryController::class, 'updateSubcategory'])->name('industries.subcategories.update');
Route::get('/industriessubcategories/delete/{id}', [IndustriesCategoryController::class, 'deleteSubcategory'])->name('industries.subcategories.delete');