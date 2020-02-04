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
        'mainchar',
        'info',
        'corp',
        'alliance',
        'related',
        'history'
    ];

    protected $hidden = [
        'corp',
        'alliance',
        'history',
        'related'
    ];


    public function __construct() {

    }


    public static function newFromId(int $id) {

        $character = new self();
        $character->character_id = $id;
        $character->name = Character::getNameById($id);
        $character->es = null;
        $character->intel_category = null;
        $character->intel_text = null;
        return $character;
    }


    public function findAlts() {
        $main = Character::where(
            'character_id', $this->main_character_id)->get();
        if($this->main_character_id){
            $alts = Character::where(
                'main_character_id', $this->main_character_id)->get();
            $main = $main->merge($alts);
        }
        $mainalts = Character::where(
            'main_character_id', $this->character_id)->get();
        $main = $main->merge($mainalts);
        // return $main->all();
        $filtered = $main->reject(function ($value) {
            return $value->character_id == $this->character_id;
        });
        return $filtered->all();
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
        if(isset($this->character_id))
        {
            return $this->getNameById($this->character_id);
        }
    }


    public function getInfoAttribute() {
        if(isset($this->character_id))
        {
            return $this->charinfo();
        }
    }



    public function getCorpAttribute() {
        if(isset($this->character_id))
        {
            return $this->corpinfo();
        }
    }


    public function getAllianceAttribute() {
        if(isset($this->character_id))
        {
            return $this->allianceinfo();
        }
    }


    public function getRelatedAttribute() {
        if(isset($this->character_id))
        {
            return $this->findAlts();
        }
    }


    public function getHistoryAttribute() {
        if (isset($this->character_id))
        {
            return $this->history();
        }
    }


    public function getMaincharAttribute() {
        if (isset($this->main_character_id)) {
            return Character::where('character_id', $this->main_character_id)->first();
        }
        else {
            return "";
        }
    }


    public function charinfo() {

        if ($cached_entry = cache('esintel.charinfo:' . $this->character_id))
        {
            return $cached_entry;
        }

        $esi = new Eseye();
        $reply = $esi->invoke(
                    'get',
                    '/characters/{character_id}',
                    ["character_id" => $this->character_id]
                 );
        cache(['esintel.charinfo:' . $this->character_id => $reply], 86400);
        return $reply;
    }


    public function corpinfo() {
        if ($cache_entry = cache('esintel.corpinfo:' . $this->info->corporation_id)) {
            return $cache_entry;
        }

        $esi = new Eseye();
        $reply = $esi->invoke(
            'get',
            '/corporations/{corporation_id}',
            ["corporation_id" => $this->info->corporation_id]
        );
        cache(["esintel.corpinfo:" . $this->info->corporation_id => $reply], 86400);
        return $reply;
    }

    public function allianceinfo() {
        if(isset($this->info->alliance_id)) {
            if ($cached_entry = cache('esintel.alliance:' . $this->info->alliance_id)) {
                return $cached_entry;
            }

            $esi = new Eseye();
            $reply = $esi->invoke(
                'get',
                '/alliances/{alliance_id}/',
                ["alliance_id" => $this->info->alliance_id]);
            cache(["esintel.alliance:" . $this->info->alliance_id => $reply], 86400);
            return $reply;
        } else {
            return null;
        }
    }


    public function history() {
        if ($cache_entry = cache('esintel.corphistory:' . $this->character_id)) {
            return $cache_entry;
        }

        $esi = new Eseye();
        $reply = collect($esi->invoke(
            'get',
            '/characters/{character_id}/corporationhistory/',
            ["character_id" => $this->character_id]));
        foreach ($reply as $h) {
            $corpname = Character::getCorpById($h->corporation_id);
            $h->corporation_name = $corpname;
        }
        cache(["esintel.corphistory:" . $this->character_id => $reply], 86400);
        return $reply;
    }




    public static function getNameById($id){
        if($id)
        {
            if ($cached_entry = cache('name_id:' . $id)) {
                return $cached_entry;
            }

            $esi = new Eseye();
            $reply = $esi->invoke(
                        'get',
                        '/characters/{character_id}',
                        ["character_id" => $id]
                     );
            return $reply->name;
        }
    }


    public static function getCorpById($id){

        if ($cached_entry = cache('corporation_id:' . $id)) {
            return $cached_entry;
        }

        $esi = new Eseye();
        $reply = $esi->invoke(
                    'get',
                    '/corporations/{corporation_id}',
                    ["corporation_id" => $id]
                 );
        return $reply->name;
    }


    public function getPortraitUrl(int $size=128){

        if (!in_array($size, [32, 64, 128, 256, 512, 1024])){
            $size=128;
        }

         return "https://images.evetech.net/characters/" . $this->character_id . "/portrait?size=" . $size;
    }


    public static function getUnknownPortraitUrl(int $id, int $size=128){

        if (!in_array($size, [32, 64, 128, 256, 512, 1024])){
            $size=128;
        }

         return "https://images.evetech.net/characters/" . $id . "/portrait?size=" . $size;
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



    public function intel_category_name()
    {
        if(isset($this->intel_category))
        {
            $category = Category::find($this->intel_category);
            if($category)
            {
                return $category->category_name;
            }
            else
            {
                return "";
            }

        }
        else
        {
            return "";
        }
    }

}