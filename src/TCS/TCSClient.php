<?php

namespace TechAndaz\TCS;

class TCSClient
{
    private $environment;
    private $client_id;
    public $username;
    public $password;
    public $cities;
    public $services;
    public $fragile;
    public $cost_centers;
    public $cost_centers_codes;
    public $cost_centers_names;
    public $tracking_url;
    private $api_url;

    /**
    * TCSClient constructor.
    * @param string $apiKey   TCS API key for authentication.
    * @param string|null $api_url TCS API URL. If not provided, the default URL will be used.
    */
    public function __construct($config)
    {
        //TEST URL - https://api.tcscourier.com/production/v1/ - No Sandbox Environment, only sandbox credentials
        //LIVE URL - https://api.tcscourier.com/production/v1/
        $this->environment = (isset($config['environment']) && in_array($config['environment'], ['sandbox','production'])) ? $config['environment'] : "production";
        $this->api_url = ($this->environment == 'production') ? "https://api.tcscourier.com/production" : "https://api.tcscourier.com/production";
        if($this->environment == "sandbox"){
            $this->username = isset($config['username']) ? $config['username'] : "testenvio";
            $this->password = isset($config['password']) ? $config['password'] : "abc123+";
            $this->client_id = isset($config['client_id']) ? $config['client_id'] : "33b3ef31-8474-45d8-aa0f-afed317ef8b8";
            $this->cost_centers = array(
                array(
                    "city" => "KARACHI", //Sender City
                    "code" => "Test", // Cost Center Code
                    "name" => "Karachi Cost Center", //Sender City
                )
            );
        } else {
            $this->username = isset($config['username']) ? $config['username'] : throw new TCSException('Username is required');
            $this->password = isset($config['password']) ? $config['password'] : throw new TCSException('Password are required');
            $this->client_id = isset($config['client_id']) ? $config['client_id'] : throw new TCSException('Client ID are required');
            $this->cost_centers = isset($config['cost_centers']) ? $config['cost_centers'] : throw new TCSException('Cost Centers are required');
        }
        $this->tracking_url = isset($config['tracking_url']) ? $config['tracking_url'] : "https://www.tcsexpress.com/track/";
        $this->cities = $this->getCitiesList();
        $this->services = array(
            array(
                "label" => "Overnight",
                "value" => "overnight"
            ),
            array(
                "label" => "Second Day",
                "value" => "second_day"
            ),
            array(
                "label" => "Same Day",
                "value" => "same_day"
            ),
            array(
                "label" => "Self Collection",
                "value" => "self_collection"
            ),
        );
        $this->fragile = array(
            array(
                "label" => "Yes",
                "value" => "1"
            ),
            array(
                "label" => "No",
                "value" => "0"
            ),
        );
        $this->cost_centers_codes = array();
        $this->cost_centers_names = array();
        foreach($this->cost_centers as $center){
            array_push($this->cost_centers_codes, array(
                "label" => $center['city'],
                "value" => $center['code'],
            ));
            array_push($this->cost_centers_names, array(
                "label" => $center['name'],
                "value" => $center['code'],
            ));
        }
        $this->validateIdNameData($this->cost_centers);
        foreach($this->cost_centers as $centers){
            if(!in_array(strtoupper($centers['city']), $this->andaz_array_column($this->cities))){
                throw new TCSException('Cost Center City is not a valid City: ' . json_encode($centers));
            }
        }
    }
    function getAllUniqueKeys($array) {
        $keys = [];
        foreach ($array as $key => $value) {
            $keys[] = $key;
    
            if (is_array($value)) {
                $keys = array_merge($keys, $this->getAllUniqueKeys($value));
            }
        }
        return array_unique($keys);
    }
    function andaz_array_column($array, $key = ""){
        //Key is there just for backward compatibility
        $uniqueKeys = $this->getAllUniqueKeys($array);
        $result = array_merge(...array_map(function ($item) use ($uniqueKeys) {
            return array_values(array_intersect_key($item, array_flip($uniqueKeys)));
        }, $array));
        return $result;
    }
    public function validateIdNameData($data)
    {
        if (!is_array($data)) {
            throw new TCSException('Invalid Cost Centers data structure. Each data must be an associative array.');
        }
        foreach ($data as $item) {
            // Check if the item is an array
            if (!is_array($item)) {
                throw new TCSException('Invalid Cost Centers data structure. Each item must be an associative array.');
            }

            // Check if the item contains only 'id' and 'name' keys
            $keys = array_keys($item);
            $allowedKeys = ['city', 'code', 'name'];
            if (count($keys) != count($allowedKeys)) {
                throw new TCSException('Invalid Cost Centers data structure. Each item must contain "city", "code" and "name" keys.');
            }
            if (count($keys) != count(array_intersect($keys, $allowedKeys))) {
                throw new TCSException('Invalid Cost Centers data structure. Each item must contain only "city", "code" and "name" keys.');
            }
        }

        // Validation passed
        return true;
    }    
    function getCitiesList(){
        $csvFile = __DIR__ . '/cities.csv';
        $file = fopen($csvFile, 'r');
        $index = 0;
        $cities = array();
        if ($file !== false) {
            while (($data = fgetcsv($file)) !== false) {
                if($index != 0){
                    array_push($cities, array(
                        "label" => $data[2],
                        "value" => $data[2],
                    ));
                }
                $index++;
            }
            fclose($file);
        } else {
            throw new TCSException('Error getting cities');
        }
        usort($cities, function($a, $b) {
            return strcmp($a['label'], $b['label']);
        });
        return $cities;
    }
    /**
    * Make a request to the TCS API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws TCSException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = $this->api_url . '/' . ltrim($endpoint, '/');
        $headers = ['X-IBM-Client-Id: ' . $this->client_id, "Content-Type: application/json"];
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new TCSException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

}
