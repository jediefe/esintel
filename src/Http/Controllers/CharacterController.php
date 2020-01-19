<?php

namespace Lawin\Seat\Esintel\Http\Controllers;

use Lawin\Seat\Esintel\Models\Character;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;

class CharacterController extends Controller {

    /*
    * Create or Update a user in the database
    *
    *
    *
    */

    public function createOrUpdate() {

        // First Try: Set static data

        $character = Character::updateOrCreate(
            ['character_id'=>95319007],
            ['es' => 0, 'intel_category' => null]);

        $character->save();
    }
}
