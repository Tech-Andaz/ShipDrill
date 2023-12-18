<?php

namespace TechAndaz\Trax;

class TraxClient
{
    private $apiKey;
    private $apiUrl;

    /**
    * TraxClient constructor.
    * @param string $apiKey   Trax API key for authentication.
    * @param string|null $apiUrl Trax API URL. If not provided, the default URL will be used.
    */
    public function __construct($apiKey, $apiUrl = null)
    {
        //TEST URL - https://app.sonic.pk
        //LIVE URL - https://sonic.pk
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl ?: 'https://sonic.pk';
    }

    /**
    * Make a request to the Trax API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws TraxException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = $this->apiUrl . '/' . ltrim($endpoint, '/');
        $headers = ['Authorization: ' . $this->apiKey, "Content-Type: application/json"];
        $response = $this->sendRequest($url, $method, $headers, $data, $queryParams);
        $responseData = json_decode($response, true);
        return $responseData;
    }
    public function makeRequestFile($endpoint, $queryParams = []){
        $url = $this->apiUrl . '/' . ltrim($endpoint, '/');
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->apiKey
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private function sendRequest($url, $method, $headers, $data, $queryParams = [])
    {
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new TraxException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

}
