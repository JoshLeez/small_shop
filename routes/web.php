<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Product
Route::group([
    'middleware' => [
        'auth',
        'can:product-list'
    ],
    'controller' => App\Http\Controllers\ProductController::class,
    'prefix'=> 'admin/product',
    'as'=>'product.'
], function () {
    //Route::get(url, class function) -> name('name for route');
    Route::get('', 'index')->name('index');
    Route::get('dtable-product', 'dtable')->name('dtable');
    Route::group([
        'middleware' =>[
            'can:product-create',
        ],
    ], function (){
        Route::post('create-product','store')->name('create');
        Route::get('edit-product/{id}','edit')->name('edit');
        Route::put('update-product/{id}','update')->name('update');
        Route::delete('delete-product/{id}','destroy')->name('destroy');
    });
});


Route::group([
    'middleware'=> [
        'auth',
        'can:product-create' // admin can access
    ],
    'prefix' => 'admin/',
], function(){
    Route::resource('user', \App\Http\Controllers\UserController::class, ['names'=> ['show' => 'user.show']])->middleware("can:role-create");
    Route::get('user', [\App\Http\Controllers\UserController::class, 'index']); // admin can access
    Route::get('user-dtable',[ \App\Http\Controllers\UserController::class, 'dtable'])->name('user.dtable')->middleware('can:role-list');
});
