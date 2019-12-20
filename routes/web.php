<?php

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
