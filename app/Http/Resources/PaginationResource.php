<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
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
            'currentPage' => $this->currentPage(),
            'totalItems' => $this->total(),
            'itemsPerPage' => (int) $this->perPage(),
            'totalPages' => $this->lastPage()
            #'count' => $this->count(),
        ];
    }
}
