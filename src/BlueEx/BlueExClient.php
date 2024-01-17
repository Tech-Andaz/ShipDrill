<?php

namespace TechAndaz\BlueEx;

class BlueExClient
{
    private $api_url;
    private $username;
    private $password; 
    public $label_url;

    /**
    * BlueExClient constructor.
    * @param string $url   API URL.
    * @param string $username   Username.
    * @param string $password   Password.
    */
    public function __construct($username, $password, $url = "")
    {
        //LIVE URL - https://bigazure.com/api/json_v3/
        if(!isset($url)){
            $this->api_url = 'https://bigazure.com/api/json_v3/';
        } else {
            $this->api_url = $url;
        }
        $this->username = $username;
        $this->password = $password;
        $this->label_url = "http://benefitx.blue-ex.com/customerportal/inc/cnprnb.php?";
    }
    /**
    * Make a request to the BlueEx API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws BlueExException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = $this->api_url . ltrim($endpoint, '/');
        $headers = ["Content-Type: application/json", "Accept: application/json"];
        $response = $this->sendRequest($url, $method, $headers, $data, $queryParams);
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
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            if(!empty($data)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new BlueExException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        $response = json_decode($response, true);
        return $response;
    }

}
