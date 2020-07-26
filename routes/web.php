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

Route::resource('category', 'CategoryController');

Route::get('/restaurant/{id}/favorite', 'RestaurantController@favorite')->name('restaurant.favorite');
Route::post('/restaurant/{id}/comment/add', 'RestaurantController@addComment')->name('restaurant.add_comment');
Route::delete('/restaurant/{id}/comment/delete/{c_id}', 'RestaurantController@deleteComment')->name('restaurant.delete_comment');
Route::resource('restaurant', 'RestaurantController');
