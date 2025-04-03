<?php

namespace App\ExternalService;

use App\ExternalService\Events\DataGet;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function getData()
    {
        $response = Http::withoutVerifying()->get($this->url);

        if ($response->successful()) {
            event(new DataGet($response->json()));
            return $response->json();
        }

        return ['error' => 'Error al obtener la informacion de la api externa.'];
    }
}