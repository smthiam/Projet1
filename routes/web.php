<?php

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
/*Route::get('contact', 'ContactsController@index');
Route::post('contact', 'ContactsController@store');


Route::get('profil', 'ProfilController@index');

Route::get('age', function(){
    return 'Age Page';
});

Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
    
    Route::middleware('admin')->group(function () {

        Route::resource ('category', 'CategoryController', [
            'except' => 'show'
        ]);

        Route::resource ('user', 'UserController', [
            'only' => ['index', 'edit', 'update', 'destroy']
        ]);

        Route::name ('orphans.')->prefix('orphans')->group(function () {
            Route::name ('index')->get ('/', 'AdminController@orphans');
            Route::name ('destroy')->delete ('/', 'AdminController@destroy');
        });

        Route::name ('maintenance.')->prefix('maintenance')->group(function () {
            Route::name ('index')->get ('/', 'AdminController@edit');
            Route::name ('update')->put ('/', 'AdminController@update');
        });
        

    });
    Route::middleware ('auth', 'verified')->group (function () {

        Route::resource ('album', 'AlbumController', [
            'except' => 'show'
        ]);
        Route::resource ('image', 'ImageController', [
            'only' => ['create', 'store', 'destroy', 'update']
        ]);

        Route::resource ('profile', 'ProfileController', [
            'only' => ['edit', 'update', 'destroy', 'show'],
            'parameters' => ['profile' => 'user']
        ]);
        
    });
    Route::name('category')->get('category/{slug}', 'ImageController@category');
    Route::name ('user')->get ('user/{user}', 'ImageController@user');

    Route::name ('image.')->middleware ('ajax')->group (function () {


        Route::prefix('image')->group(function () {

            Route::name ('description')->put ('{image}/description', 'ImageController@descriptionUpdate');
            Route::name ('adult')->put ('{image}/adult', 'ImageController@adultUpdate');
            Route::name ('albums.update')->put ('{image}/albums', 'ImageController@albumsUpdate');
            Route::name('albums')->get('{image}/albums', 'ImageController@albums');
            
        });
    });
    Route::name ('album')->get ('album/{slug}', 'ImageController@album');
    