<?php

namespace Lawin\Seat\Esintel\Http\Controllers;

use Lawin\Seat\Esintel\Models\Character;
use Lawin\Seat\Esintel\Http\Validation\CharacterCreateRequest;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;


class CharacterController extends Controller {

    /*
    * Create or Update a user in the database
    *
    *
    *
    */

    public function createIndex() {
        return view('esintel::create');
    }

    public function create(CharacterCreateRequest $request) {

        $character = new Character;
        $data = $request->validated();

        $character->character_id = $data['charid'];

        if ($character->exists()) {
            redirect()->route('character/edit/' . $character->character_id);
        }

        if (array_key_exists('maincharid', $data)) {
            $character->main_character_id = $data['maincharid'];
        }
        $character->es = $data['eslevel'];
        if (array_key_exists('escategory', $data)){
            $character->intel_category = $data['escategory'];
        }
        if (array_key_exists('estext', $data)) {
            $character->intel_text = $data['estext'];
        }

        $character->save();

        return redirect()->back()->with('success', 'New character entry has been created successfully.')->withInput();
    }

}