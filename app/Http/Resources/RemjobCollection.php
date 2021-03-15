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
                "attribution" => "By using our Remjob's API you agree to attribute and mention Remjob IO as the source and also to link back to the job listing URL on https://remjob.io. Please be aware that the jobs list returned from our endpoint /api/v1/remjobs is delayed by 12 hours. We offer a paid option for instant API access for all remote jobs (US$ 3k/mo). Just send an email to info@remjob.io for details.",
            ],
            'data' => $this->collection,
            
        ];

    }
}
