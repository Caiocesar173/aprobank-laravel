<?php

namespace Caiocesar173\Aprobank\Classes;

use Caiocesar173\Aprobank\Models\BackLog;


use Illuminate\Support\Facades\Http;

class Aprobank
{
    private static $BaseUrl = 'https://aprobank.codfint.com.br/api';
    private static $ApiVersion = 'v1';

    private static function getHeaders()
    {
        return [
            'Accept' =>  'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.env('APROBANK_TOKEN')
        ];
    }

    public static function get($route, $payload = null)
    {   
        $url = self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route;
        $headers = self::getHeaders();

        $response = Http::withHeaders($headers)->get($url, $payload);
        self::saveBackLog($url, $headers, $payload, $response, 'get');

        return $response;
    }

    public static function post($route, $payload = null)
    {
        $url = self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route;
        $headers = self::getHeaders();

        $response = Http::withHeaders($headers)->post($url, $payload);
        self::saveBackLog($url, $headers, $payload, $response, 'post');

        return $response;
    }

    public static function put($route, $payload = null)
    {
        $url = self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route;
        $headers = self::getHeaders();

        $response = Http::withHeaders($headers)->put($url, $payload);
        self::saveBackLog($url, $headers, $payload, $response, 'put');

        return $response;
    }

    public static function delete($route, $payload = null)
    {
        $url = self::$BaseUrl.'/'.self::$ApiVersion.'/'.$route;
        $headers = self::getHeaders();

        $response = Http::withHeaders($headers)->delete($url, $payload);
        self::saveBackLog($url, $headers, $payload, $response, 'delete');

        return $response;
    }

    protected static function saveBackLog($url, $headers, $payload, $response, $type)
    {
        $data = [
            'url' => $url,
            'status' => $response->successful() ? 'successful' : 'failed',
            'code' => $response->getStatusCode(),
            'type' => $type,
            'token' => 'Bearer '.env('APROBANK_TOKEN'),
            'payload' => $payload,
            'headers' => $headers,
            'response' => $response->json(),
        ];

        BackLog::create($data);
    }
}