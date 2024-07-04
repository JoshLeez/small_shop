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
    // 'middleware' => [
    //     'auth'
    // ],
    'controller' => App\Http\Controllers\ProductController::class,
    'prefix'=> 'admin/product',
    'as'=>'product.'
], function () {
    //Route:;get(url, class function) => name('name for route');
    Route::get('', 'index')->name('index');
    Route::get('dtable-product', 'dtable')->name('dtable');
    Route::post('create-product','store')->name('create');
    Route::get('edit-product/{id}','edit')->name('edit');
    Route::put('update-product/{id}','update')->name('update');
    Route::delete('delete-product/{id}','destroy')->name('destroy');
});
