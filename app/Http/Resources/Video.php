<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Video extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        "owner_id" => $this->owner_id,
        "name" => $this->name,
        "title" => $this->title,
        "description" => $this->description,
        "type" => $this->type,
        "size" => $this->size,
        "created_at" => $this->created_at,
        "updated_at" => $this->updated_at
      ];
    }
}
