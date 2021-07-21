<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService implements INotificationService {

    private $client;

    function __construct(Http $client)
     {
        $this->client = $client;
     }

     public function Notify() {
        return Http::withOptions(['verify' => false])->get('http://o4d9z.mocklab.io/notify');
     }
}