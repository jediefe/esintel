<?php

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:esintel.create'],
        'prefix' => 'esintel',
    ], function () {
        Route::get('character/edit/{id}', [
            'as'   => 'edit',
            'uses' => 'CharacterController@editGet',
        ])->where(['id' => '[0-9]+']);
        Route::post('character/edit/{id}', [
            'as'   => 'edit',
            'uses' => 'CharacterController@editPost',
        ])->where(['id' => '[0-9]+']);
        Route::get('character/create', [
            'as'   => 'esintel.create',
            'uses' => 'CharacterController@createIndex',
        ]);
        Route::post('character/create', [
            'uses' => 'CharacterController@create',
        ]);
    }
);

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:esintel.view'],
        'prefix' => 'esintel',
    ], function () {
        Route::get('character/{id?}', [
            'as'   => 'esintel.view',
            'uses' => 'CharacterController@show',
        ])->where(['id' => '[0-9]+']);
        Route::post('character/{id?}', [
            'uses' => 'CharacterController@request',
        ])->where(['id' => '[0-9]+']);
    }
);