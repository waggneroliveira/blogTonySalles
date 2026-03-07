<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FootballService
{
    public function standings()
    {
        return Cache::remember('brazilian-serie-a', 3600, function () {

            $response = Http::get('https://www.thesportsdb.com/api/v1/json/123/lookuptable.php?l=4351&s=2026');

            return $response->json()['table'] ?? [];
        });
    }
}