<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EnquiryController;

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

        //activity list
        Route::get('admin/activities', [AdminController::class, 'activities'])->name('activities');  
    
        
        //referral
        Route::get('admin/referral_earnings', [ReferralController::class, 'referral_earnings'])->name('referral_earnings');
        Route::get('/admin/refer-tool', [ReferralController::class, 'listUsers'])->name('admin.refer.tool');


        //bank 
        Route::get('admin/allbanks', [BankController::class, 'allbanks'])->name('allbanks');
        Route::post('bank/insertBank',[BankController::class,'insertBank'])->name('insertBank');
        Route::get('/editBank/{bank_id}', [BankController::class, 'editBank'])->name('editBank');
        Route::post('/updateBank', [BankController::class, 'updateBank'])->name('updateBank');
        Route::post('/deleteBank', [BankController::class, 'deleteBank'])->name('deleteBank');  
        //Bank loan
        Route::get('admin/loanbanks', [BankController::class, 'loanbanks'])->name('loanbanks');
        Route::post('bank/insertLoanBank',[BankController::class,'insertLoanBank'])->name('insertLoanBank');
        Route::get('/editLoanBank/{bank_id}', [BankController::class, 'editLoanBank'])->name('editLoanBank');
        Route::post('/updateLoanBank', [BankController::class, 'updateLoanBank'])->name('updateLoanBank');
        Route::post('/deleteLoanBank', [BankController::class, 'deleteLoanBank'])->name('deleteLoanBank');  

        //calculator
        Route::get('admin/sanctioncalculator', [AdminController::class, 'getSanctionCalculator'])->name('sanctioncalculator');
        Route::post('admin/add_sanction_calculator', [AdminController::class, 'postAddSanctionCalculator']);
        Route::get('admin/sanctioncalculatorhistory', [AdminController::class, 'getSanctionCalculatorHistory']);
        Route::get('admin/sanctioncalculatorhistoryAll', [AdminController::class, 'getAllSanctionCalculatorHistory']);
        Route::post('admin/add_sanction_calculator', [AdminController::class, 'postAddSanctionCalculator']);
        Route::get('admin/sanctioncalculator/{id}', [AdminController::class, 'getEditSanctionCalculator']);
        Route::post('admin/sanctioncalculator/{id}', [AdminController::class, 'postEditSanctionCalculator']);
        
        //MLM
        Route::get('admin/mlm', [MlmController::class, 'mlmView'])->name('mlmView');  
        Route::post('addMember', [MlmController::class, 'addMember'])->name('addMember');

        //commission
        Route::get('admin/allCommission', [CommissionController::class, 'allCommission'])->name('allCommission');
        Route::post('commission/insertCommission',[CommissionController::class,'insertCommission'])->name('insertCommission');
        Route::get('/editCommission/{com_id}', [CommissionController::class, 'editCommission'])->name('editCommission');
        Route::post('/updateCommission',[CommissionController::class,'updateCommission'])->name('updateCommission');
        Route::post('/deleteCommission',[CommissionController::class,'deleteCommission'])->name('deleteCommission');

        //eligibilityCriteria
        Route::get('/eligibilityCriteria',[EligibilityCriteriaController::class,'eligibilityCriteria'])->name('eligibilityCriteria');
        Route::get('/eligiblityDetails/{loan_id}', [EligibilityCriteriaController::class, 'eligiblityDetails'])->name('eligiblityDetails');
        Route::post('/calculate-eligibilityself', [EligibilityCriteriaController::class, 'calculateEligibility'])->name('calculate.eligibility');
        Route::post('/calculate-eligibilitysalaried', [EligibilityCriteriaController::class, 'calculateEligibilitysalaried'])->name('calculate.eligibility.salaried');

        //standalone
        Route::post('/calculate-eligibility-standalone', [EligibilityCriteriaController::class, 'calculateStandaloneEligibility'])->name('calculateEligibilitystandalone');
        Route::get('/standalone-self', [EligibilityCriteriaController::class, 'showStandaloneForm'])
        ->name('standalone.self');
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