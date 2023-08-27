<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'city'=>$this->city,
            'cuisine_type'=>$this->cuisine_type,
            'rating'=>$this->rating,
            'owner'=>new UserResource($this->user),
            'images'=>ImageResource::collection($this->images),
    ];
    }
}
