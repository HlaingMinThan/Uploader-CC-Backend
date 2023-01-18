<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'plan' => PlanResource::make($this->plan),
            'subscribed' => $this->subscribed('default'),
            'ends_at' => $this->subscription('default')->ends_at->format('D, d M Y'),
            'created_at'  => $this->created_at
        ];
    }
}
