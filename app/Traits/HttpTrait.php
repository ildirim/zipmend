<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait HttpTrait
{
    public Client $client;

    public function createClient(string $baseUrl): void
    {
        $this->client = new Client(['base_uri' => $baseUrl]);
    }

    public function httpGet($url, $urlData = [], $headers = [])
    {
        $url = $this->_setUrl($url, $urlData);
        $body = [
            'headers' => $headers,
            'connect_timeout' => 120,
            'timeout' => 120
        ];
        $response = $this->client->request('GET', $url, $body);
        return json_decode($response->getBody()->getContents());
    }

    public function httpPost($url, $data = [], $urlData = [], $headers = [])
    {
        $url = $this->_setUrl($url, $urlData);
        $body = [
            'json' => $data,
            'headers' => $headers,
            'connect_timeout' => 120,
            'timeout' => 120
        ];
        $response = $this->client->post($url, $body);
        return json_decode($response->getBody());
    }

    public function httpPut($url, $data = [], $urlData = [])
    {
        $url = $this->_setUrl($url, $urlData);
        $body = [
            'form_params' => $data,
            'connect_timeout' => 120,
            'timeout' => 120
        ];
        $response = $this->client->request('PUT', $url, $body);
        return json_decode($response->getBody()->getContents());
    }

    public function httpDelete($url, $urlData = [])
    {
        $url = $this->_setUrl($url, $urlData);
        $response = $this->client->request('DELETE', $url);
        return json_decode($response->getBody()->getContents());
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    private function _setUrl($url, $data = [])
    {
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $url = str_replace(":".$key, $value, $url);
            }
        }
        return $url;
    }
}
