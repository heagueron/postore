<?php

namespace App\Http\Resources;

use App\Http\Resources\TagResource;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RemjobResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->position,
            'description'   => $this->description,
            'company'       => CompanyResource::make( $this->company ),
            'locations'     => $this->locations,
            'pub_date'      => $this->created_at->toDateTimeString(),
            'url'           => 'https://remjob.io/remote_job/' . $this->slug
        ];
    }
}
