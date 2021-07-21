<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationService implements IAuthorizationService{

    private $client;
    
    function __construct(Http $client)
    {
        $this->client = $client;
    }

    public function Authorize()
    {
        return Http::withOptions(['verify' => false])->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    }
}