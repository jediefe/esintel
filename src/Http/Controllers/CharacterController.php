<?php

namespace Lawin\Seat\Esintel\Http\Controllers;

use Lawin\Seat\Esintel\Models\Character;
use Lawin\Seat\Esintel\Http\Validation\CharacterCreateRequest;
use Lawin\Seat\Esintel\Http\Validation\CharacterSearchRequest;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;
use Exception;


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
                } elseif (isset($mainchar->main_character_id)){
                   /* Check if the mainchar does not have a mainchar id set itself */
                    return redirect()->back()->withError('Can not create entry: Found another main character set for the given main character.');
            } else {
                    // If there's a main character, update record with these information
                    $character->main_character_id = $data['maincharid'];
                    $character->es = $character->mainchar->es;
                    $character->intel_category = $character->mainchar->intel_category;
                    $character->intel_text = $character->mainchar->intel_text;
                    $character->save();
                    return redirect()->back()->with('success', 'Character has been created using main character information.');
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
            $mainchar = Character::where('character_id', $data['maincharid'])->get();
            if ($mainchar->isEmpty()) {
                return redirect()->route('esintel.create')->with('error', 'Error: The main character does not exist in the database. Please create the main character first.');
            } elseif (isset($mainchar->main_character_id)){
                /* Check if the mainchar does not have a mainchar id set itself */
                return redirect()->back()->withError('Can not update entry: Found another main character set for the given main character.');
            }
            else {
                $character->main_character_id = $data['maincharid'];
                $character->es = $character->mainchar->es;
                $character->intel_category = $character->mainchar->intel_category;
                $character->intel_text = $character->mainchar->intel_text;
                $character->update();
                return redirect()->back()->with('success', 'Character has been updated using main character information.');
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



    public function show(int $id = null){

    if ($id) {
        $character = Character::where('character_id', $id)->first();
        if ($character) {
            // dd($character->name);
            return view('esintel::view', [
                'characterInDB' => true,
                'character' => $character,
                'id' => $character->character_id]);
        } else {
            try {
                $character = Character::newFromId($id);
            } catch(\Exception $e) {
                return redirect()->route('esintel.view')->withError("Character ID does not exist!");
            }
            return view('esintel::view', [
                'characterInDB' => false,
                'character' => $character,
                'id' => $id,
                ]);
            }
        // Needs to be filled: Character not in DB
        } else {
            return view('esintel::view', [
                'id' => $id,
                'character' => null,
                'characterInDB' => false]);
        }
    }


    public function request(CharacterSearchRequest $request){
        $data = $request->validated();
        return redirect()->route('esintel.view', $data['charid'])->withInput();
        // $character = Character::where('character_id', $data['charid'])->first();
        // if ($character) {
        //     return view('esintel::view', [
        //         'characterInDB' => true,
        //         'character' => $character,
        //         'id' => $character->character_id]);
        // } else {
        //     return redirect()->route('esintel.view', [$data['charid']])->withInput()
        //     ])
        // }
    }
}