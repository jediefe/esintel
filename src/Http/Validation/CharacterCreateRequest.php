<?php

namespace Lawin\Seat\Esintel\Http\Validation;

use Illuminate\Foundation\Http\FormRequest;
use Seat\Eseye\Eseye;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Configuration;
use Lawin\Seat\Esintel\Models\Character;

class CharacterCreateRequest extends FormRequest {

    public function authorize() {
        return true;
    }


    public function rules() {
        return [
            "charname" => 'required',
            "charid" => 'required',
            "maincharid" => 'required_with:maincharname|different:charid',
            "eslevel" => 'required|min:0|max:10',
            "escategory" => 'sometimes',
            "estext" => 'sometimes'

        ];
    }


    protected function prepareForValidation() {

        // Check character id as such. This is obligatory.
        $charid = Character::findByName($this->charname);
        if($charid) {
            $this->merge([
                'charid' => $charid
            ]);
        }

        // Check optional Main character
        if ($this->maincharname) {
            $maincharid = Character::findByName($this->maincharname);
            if($maincharid) {
                $this->merge([
                    'maincharid' => $maincharid
                ]);
            }
        }
    }


    public function messages() {

        return [
            'charname.required' => 'Character Name must not be empty.',
            'charid.required'   => 'A character with this name does not exist.',
            'maincharid.required_with' => 'The main character does not exist.',
            'maincharid.different' => 'The main character must not be identical to the character you want to add.'
        ];
    }
}