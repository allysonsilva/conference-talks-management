<?php

namespace App\API\Conference\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @SuppressWarnings("UnusedFormalParameter")
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this['title'],
            'data' => $this['talks'],
        ];
    }
}
