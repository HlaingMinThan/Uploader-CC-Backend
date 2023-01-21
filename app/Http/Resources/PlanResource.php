<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'storage' => $this->storage,
            'free' => !$this->buyable,
        ];
        if ($request->user()) {
            $data['can_swap'] = $request->user()->canSwap($this);
        }
        return $data;
    }
}
