<?php

namespace App\Http\Resources;

use App\Http\Resources\RemjobResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RemjobCollection extends ResourceCollection
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
                "legal" => "By using Remjob's API you agree to mention Remjob as the source and also to link back to the job listing URL on https://remjob.io. The API feed at /api is delayed by 12 hours. We offer a paid option for instant API access for all remote jobs (US$ 2k/mo), send email to info@remjo.io",
            ],
            'data' => $this->collection,
            
        ];

    }
}
