<?php

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:esintel.create'],
        'prefix' => 'esintel',
    ], function () {
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
        'middleware' => ['web', 'auth', 'bouncer:esintel.edit'],
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

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:superuser'],
        'prefix' => 'esintel',
    ], function () {
        Route::get('categories/status/',[
            'as' => 'esintel.categories.status',
            'uses' => 'CategoryController@toggleCategory',
        ]);
        Route::get('categories/', [
            'as' => 'esintel.categories',
            'uses' => 'CategoryController@index'
        ]);
        Route::post('categories/',[
            'as' => 'esintel.categories',
            'uses' => 'CategoryController@createCategory',
        ]);
    }
);

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:esintel.view_table'],
        'prefix' => 'esintel',
    ], function()
    {
        Route::get('list/', [
            'as' => 'esintel.list',
            'name' => 'esintel.list',
            'uses' => 'CharacterController@userTable',
        ]);
    }
);