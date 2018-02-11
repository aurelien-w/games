<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->withoutWrapping();

        return array_merge($this->getAttributes(), [
            'games'     => $this->games(),
            'victories' => $this->victories(),
            'losses'    => $this->losses(),
            'draws'     => $this->draws()
        ]);
    }
}
