<?php

namespace App\Http\Resources;

use App\Http\Resources\RemjobResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RemjobCollectionPro extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = RemjobResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'terms' => [
                "salute"    => "Thanks for using Remjob IO Api Pro",
                "attribution" => "By using our Remjob's API you agree to attribute and mention Remjob IO as the source and also to link back to the job listing URL on https://remjob.io.",
            ],
            'data' => $this->collection,
            
        ];

    }
}
