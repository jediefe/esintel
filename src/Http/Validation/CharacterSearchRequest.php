<?php

namespace Lawin\Seat\Esintel\Http\Validation;

use Illuminate\Foundation\Http\FormRequest;
use Lawin\Seat\Esintel\Models\Character;

class CharacterSearchRequest extends FormRequest {

    public function authorize() {
        return true;
    }


    public function rules() {
        return [
            'charname' => 'required',
            'charid'   => 'required',
        ];
    }


    public function prepareForValidation() {
        // Check if character id exists
        if ($this->charname) {
            $charid = Character::findByName($this->charname);
            if ($charid){
                $this->merge([
                    'charid' => $charid
                ]);
            }
        }
    }


    public function messages() {
        return [
            'charname.required' => 'Character name is empty.',
            'charid.required'   => 'A character with this name does not exist.'
        ];
    }
}