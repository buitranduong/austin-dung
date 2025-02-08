<?php

namespace App\Utils;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ReCaptcha
{
    public static function verify($token, $ip, $action)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'secret' => config('services.google.recaptcha.secret_key'),
                    'response' => $token,
                    'remoteip' => $ip
                ]
            ]);
            $body = json_decode($response->getBody(), true);
            if (!isset($body['success']) || $body['success'] !== true) {
                return false;
            }
            if ($action && (!isset($body['action']) || $action != $body['action'])) {
                return false;
            }
            return $body['score'] ?? false;
        }catch (GuzzleException $e){
            Log::error($e->getMessage());
            return false;
        }
    }
}
