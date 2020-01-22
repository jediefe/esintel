<?php

namespace Lawin\Seat\Esintel\Models;

use Illuminate\Database\Eloquent\Model;
use \Seat\Eseye\Eseye;

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


    public function findAlts() {
        $main = Character::where(
            'character_id', $this->main_character_id)->get();
        $alts = Character::where(
            'main_character_id', $this->main_character_id)->get();
        return $main->merge($alts);
    }

    public function chars() {
        return $this->all();
    }


    public static function findByName(string $charname) {
        $esi = new Eseye();
        $reply = $esi
            ->setBody(array($charname))
            ->invoke('post', '/universe/ids');

        if(! isset($reply->characters)) {
            return false;
        } else {
            return $reply->characters[0]->id;
        }
    }

    public function exists() {
        return $this->where(
            'character_id', '=', $this->character_id)->exists();
    }


}