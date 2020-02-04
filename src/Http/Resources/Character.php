<?php

namespace Lawin\Seat\Esintel\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;



class Character extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'character_id' => $this->character_id,
            'name' => $this->name,
            'corporation' => $this->corpinfo()->name,
            'alliance' => $this->allianceinfo()->name,
            'es' => $this->es,
            'intel_category' => $this->intel_category_name(),
        ];
    }
}