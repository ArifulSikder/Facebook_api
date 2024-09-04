<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\PostPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleAndPermission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return "Optimization commands cleared!";
});
Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [OverviewController::class, 'index'])->name('dashboard');
    
    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('members/data', [MemberController::class, 'getData'])->name('members.data');
    
    Route::get('/get-members', [MemberController::class, 'getMembers'])->name('get-members');
    Route::get('/add-member', [MemberController::class, 'addMember'])->name('add-member');
    Route::post('/store-member', [MemberController::class, 'storeMember'])->name('store-member');
    Route::get('/edit-member/{id}', [MemberController::class, 'editMember'])->name('edit-member');
    Route::put('/update-member/{id}', [MemberController::class, 'updateMember'])->name('update-member');
    Route::put('/update-member/{id}', [MemberController::class, 'updateMember'])->name('update-member');
    Route::get('/members/payment-log/{id}', [MemberController::class, 'membersPaymentLog']);
    Route::get('/delete-member/{id}', [MemberController::class, 'deleteMember']);
    
    
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
    Route::get('/accounts/data', [AccountController::class, 'accountData']);
    Route::get('/delete-account/{id}', [AccountController::class, 'deleteAccount']);
    Route::get('/post-offering', [AccountController::class, 'indexPostOffering'])->name('post-offering');
    Route::get('/add-new-post-offering', [AccountController::class, 'addNewPostOffering'])->name('add-new-post-offering');
    Route::get('/edit-earning/{id}', [AccountController::class, 'editEmaring']);
    Route::get('earnings/data', [AccountController::class, 'getDataEarning']);
    Route::get('/add-offering-ajax', [AccountController::class, 'addOfferingAjax']);
    Route::post('/store-post-offering', [AccountController::class, 'storePostOffering'])->name('store-post-offering');
    Route::put('/update-post-offering/{id}', [AccountController::class, 'updatePostOffering'])->name('update-post-offering');
    Route::get('/delete-earning/{id}', [AccountController::class, 'deletePostOffering']);



    Route::get('/add-account', [AccountController::class, 'addAccount'])->name('add-account');
    Route::post('/store-account', [AccountController::class, 'storeAccount'])->name('store-account');
    Route::put('/update-account/{id}', [AccountController::class, 'updateAccount'])->name('update-account');
    Route::get('/edit-account/{id}', [AccountController::class, 'editAccount']);
    Route::post('/store-payment-withdrawal', [AccountController::class, 'storePaymentWithdrawal'])->name('store-payment-withdrawal');
    Route::get('/payments/data', [AccountController::class, 'getDataPayment']);
    Route::get('/edit-payment/{id}', [AccountController::class, 'editPayment']);
    Route::get('/payment-withdrawal', [AccountController::class, 'indexPayment'])->name('payment-withdrawal');
    Route::get('/add-payment-withdrawal', [AccountController::class, 'paymentWithdrawal'])->name('add-payment-withdrawal');
    Route::put('/update-payment-withdrawal/{id}', [AccountController::class, 'updatePaymentWithdrawal'])->name('update-payment-withdrawal');
    Route::get('/delete-payment/{id}', [AccountController::class, 'deletePayment']);
    Route::get('/amount-check-from-account', [AccountController::class, 'amountCheckFromAccount'])->name('amount-check-from-account');

    Route::get('/transfer-funds', [PostPaymentController::class, 'index'])->name('transfer-funds');
    Route::get('/post-payments/data', [PostPaymentController::class, 'postPaymentData'])->name('post-payments/data');
    Route::get('/transfer_funds', [PostPaymentController::class, 'addNewPostPayment']);
    Route::get('/edit-transfer-funds/{id}', [PostPaymentController::class, 'editPostPayment']);
    Route::get('/delete-post-payment/{id}', [PostPaymentController::class, 'deletePostPayment']);
    Route::post('/store-post-payment', [PostPaymentController::class, 'storePostPayment'])->name('store-post-payment');
    Route::put('/update-post-payment/{id}', [PostPaymentController::class, 'updatePostPayment'])->name('update-post-payment');


    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    
Route::controller(RoleAndPermission::class)->group(function(){
    //role
    Route::get('/user-role', 'roleIndex')->name('user-role');
    Route::post('/create-role', 'storeRole')->name('create_role');
    Route::post('/update-role', 'updateRole')->name('updateRole');

    //permission and role
    Route::get('permission', 'indexPermission')->name('permission');
    Route::post('create-permission', 'storePermission')->name('create-permission');
    Route::post('update-permission', 'updatePermission')->name('update-permission');
    Route::post('sort-permission-data', 'sortPermissionData')->name('sort-permission-data');
    Route::get('give-user-role', 'giveUserRole')->name('give-user-role');
    Route::get('/give-user-permission', 'giveUserPermission')->name('give-user-permission');
    Route::post('/store-user-permission', 'storeUserPermission')->name('store-user-permission');
    Route::post('update-given-user-role', 'updateGivenUserRole')->name('update-given-user-role');
    Route::post('check-user-permission', 'userGivePermissionCheck');
    Route::post('user-excess-in-card', 'userExcessInCard');


});

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
