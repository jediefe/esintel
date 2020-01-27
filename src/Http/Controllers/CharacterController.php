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
                // Check if the main character exists in the system
                // and return to create main char
                $mainchar = Character::where('character_id', $data['maincharid'])->get();
                if ($mainchar->isEmpty()) {
                    return redirect()->route('esintel.create')->withError('Error: The main character does not exist in the database. Please create the main character first.');
                } elseif ($mainchar->main_character_id){
                   /* Check if the mainchar does not have a mainchar id set itself */
                    return redirect()->back()->withError('Can not create entry: Found another main character set for the given main character.');
            } else {
                    $character->main_character_id = $data['maincharid'];
                }
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
            // Check if the main character exists in the system
            // and return to create main char
            $mainchar = Character::where('character_id', $data['maincharid'])->first();
            if ($mainchar) {
                return redirect()->route('esintel.create')->with('error', 'Error: The main character does not exist in the database. Please create the main character first.');
            } elseif ($mainchar->main_character_id){
                /* Check if the mainchar does not have a mainchar id set itself */
                return redirect()->back()->withError('Can not update entry: Found another main character set for the given main character.');
            }
            else {
                $character->main_character_id = $data['maincharid'];
            }

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