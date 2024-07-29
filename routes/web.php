<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*Backend Route*/
Route::get('/admin/login', [AdminController::class, 'login_form'])->name('admin.login');
Route::post('login-functionality',[AdminController::class,'login_functionality'])->name('login.functionality');

Route::group(['middleware'=>'admin'],function(){
    Route::get('admin/logout',[AdminController::class,'logout'])->name('admin.logout');
    Route::get('/',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::post('/admin/get_dashboard_data',[AdminController::class,'get_data'])->name('admin.dashboard_get_all_data');

    /** Customer Route **/
    Route::prefix('admin/customer')->group(function() {
        Route::controller(App\Http\Controllers\Backend\Customer\CustomerController::class)->group(function() {
            Route::get('/list', 'index')->name('admin.customer.index');
            Route::get('/all-data', 'get_all_data')->name('admin.customer.get_all_data');
            Route::get('/create', 'create')->name('admin.customer.create');
            Route::get('/edit/{id}', 'edit')->name('admin.customer.edit');
            Route::get('/view/{id}', 'view')->name('admin.customer.view');
            Route::post('/delete', 'delete')->name('admin.customer.delete');
            Route::post('/store', 'store')->name('admin.customer.store');
            Route::post('/update/{id}', 'update')->name('admin.customer.update');
        });
    });
   
});