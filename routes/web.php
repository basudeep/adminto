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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::post('/category-add', 'CategoryController@addCategory');
Route::get('/categories-list', 'CategoryController@allCategory');
Route::get('/category-delete/{id}', 'CategoryController@deleteCategory');
Route::post('/category-update', 'CategoryController@updateCategory');
Route::post('/upload-post-image', 'PostController@uploadImage');
Route::post('/delete-image', 'PostController@deleteImage');
Route::post('/add-post', 'PostController@addPost');
Route::get('/post-delete/{id}', 'PostController@deletePost');
Route::post('/update-post', 'PostController@updatePost');


Route::get('/allpost', 'PostController@all_post');

Route::any('/{slag}', 'HomeController@index');
