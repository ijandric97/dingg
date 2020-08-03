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

// Auth
Auth::routes();

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'HomeController@search')->name('home.search');



Route::get('/admin', 'AdminController@index')->name('admin.index');
//Route::get('/admin/category', 'AdminController@category')->name('admin.category');

// Category
Route::resource('category', 'CategoryController');

// Restaurant
Route::get('/restaurant/{id}/favorite', 'RestaurantController@favorite')->name('restaurant.favorite');
Route::resource('restaurant', 'RestaurantController');
Route::resource('restaurant.comment', 'CommentController')->only(['store', 'destroy']);
Route::resource('restaurant.group', 'GroupController')->only(['index', 'store']);
Route::resource('restaurant.table', 'TableController')->only(['index', 'store']);
Route::resource('restaurant.product', 'ProductController');
Route::resource('restaurant.workhour', 'WorkhourController')->only(['index', 'store']);

// User
Route::resource('user', 'UserController')->except(['create', 'store']);

// Order
// TODO: https://stackoverflow.com/questions/46128476/same-laravel-resource-controller-for-multiple-routes
// TODO: make OrderController inherited by RestaurantOrderController and UserOrderController :) ty
Route::resource('restaurant.order', 'OrderController')->shallow();
Route::resource('user.order', 'OrderController')->shallow();
