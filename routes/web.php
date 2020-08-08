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

// Request
Route::resource('request', 'RequestController')->only('index', 'edit', 'update')
    ->parameters(['request' => 'apprequest']);

// User
Route::get('/user/{user}/restaurants', 'UserController@restaurants')->name('user.restaurants');
Route::put('/user/{user}/role', 'UserController@role')->name('user.role');
Route::resource('user', 'UserController')->except(['create', 'store']);
Route::resource('user.request', 'RequestUserController')->except(['show', 'edit', 'update']);

// Order
Route::resource('restaurant.order', 'OrderRestaurantController')->except(['show', 'delete']);
Route::resource('user.order', 'OrderUserController')->only(['index', 'edit', 'update']);
