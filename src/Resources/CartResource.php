<?php

namespace IndieHD\Velkart\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' => $this->identifier,
            'content'    => \unserialize($this->content),
        ];
    }
}
