<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class GoogleScriptService
{
    private string $apiUrl;
    public function __construct()
    {
        $this->apiUrl = config('services.google.script_url');
    }

    /**
     */
    public function pushData(array $data): bool
    {
        try{
            $response = Http::asForm()->post($this->apiUrl, $data);
            if($response->successful()){
                return true;
            }
            return false;
        }catch (ConnectionException $e){
            return false;
        }
    }
}
