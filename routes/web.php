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
            if(Auth::check()) {
                return redirect('home');
            }
        return redirect('login');
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::middleware(['auth'])->group(function () {
        // Registration Routes...
        Route::get('register', [
            'as' => 'register',
            'uses' => 'Auth\RegisterController@showRegistrationForm'
        ]);
        Route::post('register', [
            'as' => '',
            'uses' => 'Auth\RegisterController@register'
        ]);

        Route::resource('project', 'ProjectController');
        Route::get('property/{projectId}/list', 'ProjectController@getProperties');

        Route::resource('property', 'PropertyController');
        Route::get('credential/{propertyId}/list', 'PropertyController@getCredentials');

        Route::resource('credential', 'CredentialController');

    });
