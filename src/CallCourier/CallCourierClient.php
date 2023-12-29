<?php

namespace TechAndaz\CallCourier;
class CallCourierClient
{
    public $environment;
    public $api_url;
    public $login_id;
    public $account_id;

    /**
    * CallCourierClient constructor.
    * @param array $config.
    */
    public function __construct($config)
    {
        //Call courier doesnt have a sandbox so in sandbox mode test credentials will be applied automatically unless specified otherwise.
        //LIVE = https://cod.callcourier.com.pk/api/
        $this->environment = (isset($config['environment']) && in_array($config['environment'], ['sandbox','production'])) ? $config['environment'] : "production";
        if($this->environment == "sandbox" && (!isset($config['login_id']) || $config['login_id'] == "")){
            $this->login_id = $config['login_id'];
        } else if($this->environment == "sandbox"){
            $this->login_id = "test-0001";
        } else {
            $this->login_id = (isset($config['login_id']) && $config['login_id'] != "") ? $config['login_id'] : throw new CallCourierException("Login ID is missing");
        }
        if($this->environment == "sandbox" && (!isset($config['password']) || $config['password'] == "")){
            $this->password = $config['password'];
        } else if($this->environment == "sandbox"){
            $this->password = "test0001new";
        } else {
            $this->password = (isset($config['password']) && $config['password'] != "") ? $config['password'] : throw new CallCourierException("Password is missing");
        }
        
        if($this->environment == "sandbox" && (!isset($config['account_id']) || $config['account_id'] == "")){
            $this->account_id = $config['account_id'];
        } else if($this->environment == "sandbox"){
            $this->account_id = "242";
        } else {
            $this->account_id = (isset($config['account_id']) && $config['account_id'] != "") ? $config['account_id'] : throw new CallCourierException("Account ID is missing");
        }
        $this->api_url = "https://cod.callcourier.com.pk/";
    }

    /**
    * Make a request to the CallCourier API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws CallCourierException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = rtrim($this->api_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = ["Content-Type: application/json"];
        $response = $this->sendRequest($url, $method, $headers, $data, $queryParams);
        $responseData = json_decode($response, true);
        return $responseData;
    }

    private function sendRequest($url, $method, $headers, $data, $queryParams = [])
    {
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            if($method == "POST"){
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new CallCourierException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }
}
