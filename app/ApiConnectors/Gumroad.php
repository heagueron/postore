<?php

namespace App\ApiConnectors;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Client\PendingRequest;

class Gumroad
{
    //protected PendingRequest $client;
    protected $client;

    // public function __construct(PendingRequest $client)
    // {
    //     $this->client = $client->baseUrl('https://api.gumroad.com/v2/')->withToken(config('services.gumroad.token'));
    // }

    public function __construct()
    {
        $this->client = Http::withToken(config('services.gumroad.token'));
    }

    public function getSale(string $id) : array
    {
        //return $this->client->get("/sales/{$id}")->throw()->json();
        return $this->client->get('https://api.gumroad.com/v2/sales/'.$id)->throw()->json();
    }

    public function verifyLicense( string $license, string $permalink ) : array
    {
        // return $this->client->post('/licenses/verify', [
        //     'product_permalink' => $permalink,
        //     'license_key' => $license,
        // ])->throw()->json();
        
        return $this->client->post('https://api.gumroad.com/v2/licenses/verify', [
            'product_permalink' => $permalink,
            'license_key' => $license,
        ])->throw()->json();
    }
}