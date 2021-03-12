<?php

namespace App\Http\Resources;

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
            'category'      => $this->category->name,
            'company'       => $this->company->name,
            'locations'     => $this->locations,
            'tags'          => $this->tags()->take(5)->pluck('name'),
            'pub_date'      => $this->created_at,
            'url'           => 'https://remjob.io/remote_job/' . $this->slug
        ];
    }
}
