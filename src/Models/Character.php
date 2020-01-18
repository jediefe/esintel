<?php

namespace Lawin\Seat\Esintel\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model {

    /*
        define the table name for the model name
    */
    protected $table = 'lawin_esintel_chars';

    /*
        define the column names that are fillable
    */
    protected $fillable = [
        "character_id",
        "main_character_id",
        "es",
        "intel_category",
        "intel_text"
    ];

    public function alts() {
        $main = Character::where(
            'character_id', $this->main_character_id)->get();
        $alts = Character::where(
            'main_character_id', $this->main_character_id)->get();
        return $main->merge($alts);
    }

    public function chars() {
        return $this->all();
    }


}