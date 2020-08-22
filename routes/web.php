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
    return view('layouts.frontend');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');


/*===================================================
                 CATEGORY ROUTES
=====================================================*/
Route::post('/category-add', 'CategoryController@addCategory');
Route::get('/categories-list', 'CategoryController@allCategory');
Route::get('/category-delete/{id}', 'CategoryController@deleteCategory');
Route::post('/category-update', 'CategoryController@updateCategory');

/*===================================================
                 POST ROUTES
=====================================================*/
Route::post('/upload-post-image', 'PostController@uploadImage');
Route::post('/delete-image', 'PostController@deleteImage');
Route::post('/add-post', 'PostController@addPost');
Route::get('/post-delete/{id}', 'PostController@deletePost');
Route::post('/update-post', 'PostController@updatePost');

/*===================================================
                 CONTACT ROUTES
=====================================================*/

Route::get('/allcontact', 'ContactController@allContact');
Route::get('/mycontacts', 'ContactController@userContact');
Route::post('/upload-contact-image', 'ContactController@uploadContactImage');
Route::post('/delete-contact-image', 'ContactController@deleteContactImage');
Route::get('/contact-delete/{id}', 'ContactController@deleteContact');


/*===================================================
                 SMS ROUTES
=====================================================*/
Route::post('/send-message', 'SmsController@sendMessage');

/*===================================================
                 FRONT-END
=====================================================*/


Route::get('api/blogpost', 'BlogController@blogPost');
Route::get('api/single-blog/{id}', 'BlogController@singlePost');
Route::get('api/categories', 'BlogController@allCategories');
Route::get('api/latest-post', 'BlogController@latestPost');
Route::get('api/categorywise-post/{id}', 'BlogController@categoryWisePost');
Route::get('api/search', 'BlogController@searchPost');

Route::get('/allpost', 'PostController@all_post');

Route::any('/{slag}', 'HomeController@index');
