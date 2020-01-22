<?php

Route::group(
    [
        'namespace' => 'Lawin\Seat\Esintel\Http\Controllers',
        'middleware' => ['web', 'auth', 'bouncer:esintel.create'],
        'prefix' => 'esintel',
    ], function () {
        Route::get('character/create', [
            'as' => 'esintel.character.create',
            'uses' => 'CharacterController@createIndex',
        ]);
        Route::post('character/create', [
            'as' => 'esintel.character.create',
            'uses' => 'CharacterController@create',
        ]);
        Route::get('character/{id}', [
            'uses' => 'CharacterController@show',
        ]);
    }
);