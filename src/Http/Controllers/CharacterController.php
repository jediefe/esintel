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
            return redirect()->route('edit', $character->character_id);
        } else {
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


    public function editGet(int $id) {
        $character = Character::where('character_id', $id)->first();
        return view('esintel::create', ["character"=>$character]);
    }


    public function editPost(CharacterCreateRequest $request, int $id){

        $character = Character::where('character_id', $id)->first();
        if (!$character){
            return redirect()->route('esintel.create');
        }
        $data = $request->validated();

        if (!($character->character_id == $data['charid'])) {
            return redirect()->back()
                             ->withErrors(['msg', 'Character ID mismatch!']);
            }

        if (array_key_exists('maincharid', $data)) {
            $character->main_character_id = $data['maincharid'];
        } else {
            $character->main_character_id = null;
        }

        $character->es = $data['eslevel'];

        if (array_key_exists('escategory', $data)){
            $character->intel_category = $data['escategory'];
        }

        if (array_key_exists('estext', $data)) {
            $character->intel_text = $data['estext'];
        } else {
            $character->intel_text = null;
        }

        $character->update();

        return redirect()->back();
    }
}