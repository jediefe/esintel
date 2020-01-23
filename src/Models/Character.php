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


    protected $appends = [
        'name',
        'maincharname',
        'info',
        'corp',
        'alliance'
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



    public function getNameAttribute() {
        return $this->getNameById($this->character_id);
    }


    public function getInfoAttribute() {
        return $this->charinfo();
    }



    public function getCorpAttribute() {
        return $this->corpinfo();
    }


    public function getAllianceAttribute() {
        return $this->allianceinfo();
    }


    public function getMaincharnameAttribute() {
        if (isset($this->main_character_id)) {
            return $this->getNameById($this->main_character_id);
        }
        else {
            return "";
        }
    }


    public function charinfo() {
        $esi = new Eseye();
        $reply = $esi->invoke(
                    'get',
                    '/characters/{character_id}',
                    ["character_id" => $this->character_id]
                 );
        return $reply;
    }


    public function corpinfo() {
        $esi = new Eseye();
        $reply = $esi->invoke(
            'get',
            '/corporations/{corporation_id}',
            ["corporation_id" => $this->info->corporation_id]
        );
        return $reply;
    }

    public function allianceinfo() {
        if(isset($this->info->alliance_id)) {
            $esi = new Eseye();
            return $esi->invoke(
                'get',
                '/alliances/{alliance_id}/',
                ["alliance_id" => $this->info->alliance_id]);
        } else {
            return null;
        }
    }


    private static function getNameById($id){
        $esi = new Eseye();
        $reply = $esi->invoke(
                    'get',
                    '/characters/{character_id}',
                    ["character_id" => $id]
                 );
        return $reply->name;
    }


    public function getPortraitUrl(int $size=128){

        if (!in_array($size, [32, 64, 128, 256, 512, 1024])){
            $size=128;
        }

         return "https://images.evetech.net/characters/" . $this->character_id . "/portrait?size=" . $size;
    }


    public function getCorpLogoUrl(int $size=128) {
        if (!in_array($size, [32, 64, 128, 256, 512, 1024])) {
            $size = 128;
        }

        return "https://images.evetech.net/corporations/" .
            $this->info->corporation_id . "/logo?size=" . $size;
    }


    public function getAllianceLogoUrl(int $size=128) {
        if (!in_array($size, [32, 64, 128, 256, 512, 1024])) {
            $size = 128;
        }

        return "https://images.evetech.net/alliances/" .
            $this->info->alliance_id . "/logo?size=" . $size;
    }

}