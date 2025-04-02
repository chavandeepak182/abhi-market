<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\BannerController;

Route::get('/', function () {
    return view('frontend.index-slider');
});

Route::get('/insights', function () {
    return view('frontend.insights');
});

Route::get('/industries', function () {
    return view('frontend.industries');
});

Route::get('/services', function () {
    return view('frontend.services');
});

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/contact', function () {
    return view('frontend.contact');
});

Route::get('/service-details', function () {
    return view('frontend.service-details');
});

Route::get('/details', function () {
    return view('frontend.details');
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
Route::get('/admin/banners', [BannerController::class, 'index'])->name('banners.index');
Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');