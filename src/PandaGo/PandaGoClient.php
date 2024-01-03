<?php

namespace TechAndaz\PandaGo;

class PandaGoClient
{
    private $credentials;
    private $access_token;
    private $token_url;
    private $api_url;
    public $webhook_secret;

    /**
    * PandaGoClient constructor.
    * @param array $config   Configuration Object for authentication.
    */
    public function __construct($config)
    {
        //TEST URL - https://sts-st.deliveryhero.io/
        //LIVE URL - https://sts.deliveryhero.io/
        if(!isset($config['token_url'])){
            $this->token_url = 'https://sts-st.deliveryhero.io/';
        } else {
            $this->token_url = $config['token_url'];
        }
        if(!isset($config['api_url'])){
            $this->api_url = 'https://pandago-api-sandbox.deliveryhero.io/sg/api/v1/';
        } else {
            $this->api_url = $config['api_url'];
        }
        $this->credentials = isset($config['credentials']) ? $config['credentials'] : throw new PandaGoException('Credentials are required');;
        $this->webhook_secret = isset($config['webhook_secret']) ? $config['webhook_secret'] : "";
        $this->oAuthRequest();
    }
    /**
    * Make an oAuth request to the PandaGo API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws PandaGoException    If the request or response encounters an error.
    */
    public function oAuthRequest()
    {
        $headers = ["Content-Type: application/x-www-form-urlencoded"];
        $url = $this->token_url . "oauth2/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->credentials));
        $responseData = json_decode(curl_exec($ch),true);
        if (curl_errno($ch)) {
            throw new PandaGoException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(isset($responseData['access_token'])){
            $this->access_token = $responseData['access_token'];
            return array(
                "status" => 1,
                "access_token" => $responseData['access_token']
            );
        } else {
            return array(
                "status" => 0,
                "access_token" => $responseData
            );
        }
        return $response;
    }
    /**
    * Make a request to the PandaGo API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws PandaGoException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = $this->api_url . ltrim($endpoint, '/');
        $headers = ['Authorization: Bearer ' . $this->access_token, "Content-Type: application/json", "Accept: application/json"];
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
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            if(!empty($data)){
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new PandaGoException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        $response = json_decode($response, true);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpcode == 200 || $httpcode == 201){
            return array(
                "status" => 1,
                "response" => $response
            );
        } else {
            return array(
                "status" => 0,
                "response" => $response['message']
            );
        }
    }

}
