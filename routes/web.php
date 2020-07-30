<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('admin.index');
//Route::get('/admin/category', 'AdminController@category')->name('admin.category');



Route::get('/restaurant/{id}/favorite', 'RestaurantController@favorite')->name('restaurant.favorite');

Route::get('/restaurant/{id}/order', 'RestaurantController@order')->name('restaurant.order');
Route::post('/restaurant/{id}/order', 'RestaurantController@addOrder')->name('restaurant.add_order');

Route::resource('category', 'CategoryController');

Route::resource('restaurant', 'RestaurantController');
Route::resource('restaurant.comment', 'CommentController')->only(['store', 'destroy']);
Route::resource('restaurant.group', 'GroupController')->only(['index', 'store']);
Route::resource('restaurant.table', 'TableController')->only(['index', 'store']);
Route::resource('restaurant.product', 'ProductController');
Route::resource('restaurant.workhour', 'WorkhourController')->only(['index', 'store']);
