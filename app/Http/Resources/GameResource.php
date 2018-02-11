<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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

        return array_merge($this->getAttributes(), $this->getRelations(), [
            'winner' => $this->winner(),
            'looser' => $this->looser()
        ]);
    }
}
