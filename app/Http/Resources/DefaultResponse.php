<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultResponse extends JsonResource
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
            'status' => isset($this['status']) ? $this['status'] : false,
            'message' => isset($this['message']) ? $this['message'] : "",
            'data' => isset($this['data']) ? $this['data'] : null,
        ];
    }
}
