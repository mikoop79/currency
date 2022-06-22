<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('Y-m-d'),
            'currency' => $this->currency,
            'data' => json_decode($this->data, true, 512, JSON_THROW_ON_ERROR)
        ];
    }
}
