<?php

Route::group(
    [
        'middleware' => ['bouncer:esintel.create'],
    ], function () {
        Route::get('character/create', [
            'as' => 'esintel.character.create',
            'uses' => 'CharacterController@create',
        ]);
        Route:post('character/add', [
            'as' => 'esintel.character.add',
            'uses' => 'CharacterController@store',
        ]);
    }
)