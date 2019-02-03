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
    
    Route::get('/', function () {
        return view('welcome');
    });
    
    Auth::routes();
    
    Route::get('/home', 'HomeController@index')->name('home');
    /**
     *  CRUD Customer phones
     */
    Route::group(['prefix' => 'phones'], function () {
        Route::get('', 'API\PhoneController@getAll')->middleware('auth');
        Route::post('', 'API\PhoneController@createPhone')->middleware('auth');
        Route::put('/{id}', 'API\PhoneController@updatePhone')->middleware('auth');
    
    
    });
    /**
     * CRUD Products
     */
    Route::group(['prefix' => 'products'], function () {
        Route::get('', 'API\ProductController@getAll')->middleware('auth');
        Route::post('', 'API\ProductController@createProduct')->middleware('auth');
        
    });
    
    /**
     * CRUD Subscription
     */
    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('', 'API\SubscriptionController@getAll')->middleware('auth');
        Route::post('/subscribe', 'API\SubscriptionController@subscribe')->middleware('auth');
        Route::post('/unsubscribe', 'API\SubscriptionController@unsubscribe')->middleware('auth');
        
    });
