<?php

namespace TechAndaz\TCS;

class TCSAPI
{
    private $TCSClient;

    public function __construct(TCSClient $TCSClient)
    {
        $this->TCSClient = $TCSClient;
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

    /**
    * Add a Shipment.
    *
    * @param array $data
    *
    * @return array
    *   Decoded response data.
    */
    public function addShipment(array $data)
    {
        $service_id = (isset($data['service_id']) && in_array($data['service_id'], $this->andaz_array_column($this->TCSClient->services))) ? $data['service_id'] : "overnight";
        if($service_id == "overnight"){
            $service_id = "O";
        } else if($service_id == "second_day"){
            $service_id = "D";
        } else if($service_id == "same_day"){
            $service_id = "S";
        } else if($service_id == "self_collection"){
            $service_id = "MYO";
        }
        $fragile = (isset($data['fragile']) && in_array($data['fragile'], $this->andaz_array_column($this->TCSClient->fragile))) ? $data['fragile'] : 0;
        if($fragile == 0){
            $fragile = "No";
        } else if($fragile == 1){
            $fragile = "Yes";
        }
        $cost_center = (isset($data['cost_center']) && in_array($data['cost_center'], $this->andaz_array_column($this->TCSClient->cost_centers_codes))) ? $data['cost_center'] : throw new TCSException('Cost Center is required');
        foreach($this->TCSClient->cost_centers_codes as $centers){
            if($centers['label'] == $cost_center || $centers['value'] == $cost_center){
                $cost_center_city = $centers['label'];
                $cost_center_code = $centers['value'];
            }
        }
        $order_data = array(
            "userName" => $this->TCSClient->username,
            "password" => $this->TCSClient->password,
            "costCenterCode" => $cost_center_code,
            "originCityName" => $cost_center_city,
            "consigneeName" => isset($data['consignee_name']) ? $data['consignee_name'] : throw new TCSException('Consignee Name is required'),
            "consigneeAddress" => isset($data['consignee_address']) ? $data['consignee_address'] : throw new TCSException('Consignee Address is required'),
            "consigneeMobNo" => isset($data['consignee_phone']) ? $data['consignee_phone'] : throw new TCSException('Consignee Phone is required'),
            "consigneeEmail" => isset($data['consignee_email']) ? $data['consignee_email'] : throw new TCSException('Consignee Email is required'),
            "destinationCityName" => (isset($data['consignee_city']) && in_array(strtoupper($data['consignee_city']), $this->andaz_array_column($this->TCSClient->cities))) ? $data['consignee_city'] : throw new TCSException('Consignee City is missing/invalid'),
            "weight" => isset($data['weight']) ? $data['weight'] : throw new TCSException('Weight is required'),
            "pieces" => isset($data['pieces']) ? $data['pieces'] : throw new TCSException('Pieces is required'),
            "codAmount" => isset($data['amount']) ? $data['amount'] : throw new TCSException('Amount is required'),
            "customerReferenceNo" => isset($data['order_id']) ? $data['order_id'] : uniqid(),
            "services" => $service_id,
            "productDetails" => isset($data['order_details']) ? $data['order_details'] : "",
            "fragile" => $fragile,
            "remarks" => isset($data['remarks']) ? $data['remarks'] : "",
            "insuranceValue" => isset($data['insurance_value']) ? $data['insurance_value'] : 0,
        );
        $endpoint = 'v1/cod/create-order';
        $method = 'POST';
        $response = $this->TCSClient->makeRequest($endpoint, $method, $order_data);
        if(isset($response['returnStatus']['status'])){
            if($response['returnStatus']['status'] == "SUCCESS"){
                return array(
                    "status" => 1,
                    "cn_number" => trim(explode("Your generated CN is: ", $response['bookingReply']['result'])[1])
                );
            }
        }
        return array(
            "status" => 0,
            "response" => $response
        );
    }
    /**
    * Track a Shipment.
    *
    * @param array $data
    *
    * @return array
    *   Decoded response data.
    */
    public function trackShipment($tracking_number = "", $type = "url")
    {
        if(!isset($tracking_number) || $tracking_number == ""){
            throw new TCSException('Tracking Number is required');
        }
        if($type != "url" && $type != "data" && $type != "redirect"){
            $type = "url";
        }
        $url = $this->TCSClient->tracking_url . $tracking_number;
        if($type == "redirect"){
            header('Location: '.$url);
        } else if($type == "url"){
            return array(
                "status" => 1,
                "url" => $url
            );
        } else if($type == "data"){
            $params = array(
                "consignmentNo" => $tracking_number
            );
            $endpoint = 'track/v1/shipments/detail';
            $method = 'GET';
            $response = $this->TCSClient->makeRequest($endpoint, $method, array(), $params);
            if(isset($response['returnStatus']['status'])){
                if($response['returnStatus']['status'] == "SUCCESS"){
                    $tracking_response = array();
                    $track_response = $response['TrackDetailReply'];
                    foreach($track_response as $key => $delivery){
                        if($key != "TrackInfo"){
                            foreach($delivery as $movement){
                                array_push($tracking_response, $movement);
                            }
                        }
                    }
                    usort($tracking_response, function($a, $b) { return strtotime($b['dateTime']) - strtotime($a['dateTime']); });
                    return array(
                        "status" => 1,
                        "tracking" => $tracking_response
                    );
                }
            }
            return array(
                "status" => 0,
                "response" => $response
            );
        }
        return array(
            "status" => 0,
            "error" => "Unknown type provided"
        );
    }

    
    /**
    * Get List of Cities
    *
    * @return array
    *   Decoded response data.
    */
    public function getCityList()
    {
        return array(
            "status" => 1,
            "data" => $this->TCSClient->cities
        );
    }
    
    /**
    * Print Shipping Label
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function printShippingLabel($consignment_no, $type = "url")
    {
        $url = $this->TCSClient->label_url . $consignment_no;
        if($type == "url"){
            return array(
                "status" => 1,
                "label_url" => $url
            );
        } else if($type == "redirect"){
            header("Location: " . $url);
            die();
        } else {
            return array(
                "status" => 0,
                "error" => "Unknown Type"
            );
        }
    }

    public function validateIdNameData($data)
    {
        if (!is_array($data)) {
            throw new TCSException('Invalid data structure. Each data must be an associative array.');
        }
        foreach ($data as $item) {
            // Check if the item is an array
            if (!is_array($item)) {
                throw new TCSException('Invalid data structure. Each item must be an associative array.');
            }

            // Check if the item contains only 'id' and 'name' keys
            $keys = array_keys($item);
            $allowedKeys = ['label', 'value'];
            if (count($keys) != count($allowedKeys)) {
                throw new TCSException('Invalid data structure. Each item must contain both "value" and "label" keys.');
            }
            if (count($keys) != count(array_intersect($keys, $allowedKeys))) {
                throw new TCSException('Invalid data structure. Each item must contain only "value" and "label" keys.');
            }
        }

        // Validation passed
        return true;
    }
    /**
    * Get Form Fields.
    *
    * @param array $config
    *   Configuration settings for form display.
    * @return array
    *   Decoded response data.
    */
    
    public function getFormFields($config)
    {
        if(!isset($config['response']) || !in_array($config['response'], ["form", "json"])){
            throw new TCSException('Ivalid response type. Available: form, json');
        }
        if(isset($config['cities'])){
            $cities = $config['cities'];
            $this->validateIdNameData($cities);
        } else {
            $cities = $this->TCSClient->cities;
        }
        $cost_centers = $this->TCSClient->cost_centers_names;
        $services = $this->TCSClient->services;
        $fragile = $this->TCSClient->fragile;
        if(!isset($config['optional'])){
            $config['optional'] = false;
        }
        $form_fields = array(
            array(
                "name" => "cost_center",
                "field_type" => "required",
                "classes" => isset($config['cost_center-class']) ? $config['cost_center-class'] : "",
                "attr" => isset($config['cost_center-attr']) ? $config['cost_center-attr'] : "",
                "wrapper" => isset($config['cost_center-wrapper']) ? $config['cost_center-wrapper'] : "",
                "label" => isset($config['cost_center-label']) ? $config['cost_center-label'] : "Cost Center",
                "type" => "select",
                "default" => isset($config['cost_center']) && in_array($config['cost_center'], andaz_array_column($cost_centers)) ? $config['cost_center'] : $cost_centers[0]['value'],
                "options" => $cost_centers,
                "custom_options" => isset($config['cost_center-custom_options']) ? $config['cost_center-custom_options'] : array(),
            ),
            array(
                "name" => "consignee_name",
                "field_type" => "required",
                "classes" => isset($config['consignee_name-class']) ? $config['consignee_name-class'] : "",
                "attr" => isset($config['consignee_name-attr']) ? $config['consignee_name-attr'] : "",
                "wrapper" => isset($config['consignee_name-wrapper']) ? $config['consignee_name-wrapper'] : "",
                "label" => isset($config['consignee_name-label']) ? $config['consignee_name-label'] : "Consignee Name",
                "type" => "text",
                "default" => isset($config['consignee_name']) ? $config['consignee_name'] : "",
            ),
            array(
                "name" => "consignee_phone",
                "field_type" => "required",
                "classes" => isset($config['consignee_phone-class']) ? $config['consignee_phone-class'] : "",
                "attr" => isset($config['consignee_phone-attr']) ? $config['consignee_phone-attr'] : "",
                "wrapper" => isset($config['consignee_phone-wrapper']) ? $config['consignee_phone-wrapper'] : "",
                "label" => isset($config['consignee_phone-label']) ? $config['consignee_phone-label'] : "Consignee Phone",
                "type" => "phone",
                "default" => isset($config['consignee_phone']) ? $config['consignee_phone'] : "",
            ),
            array(
                "name" => "consignee_email",
                "field_type" => "required",
                "classes" => isset($config['consignee_email-class']) ? $config['consignee_email-class'] : "",
                "attr" => isset($config['consignee_email-attr']) ? $config['consignee_email-attr'] : "",
                "wrapper" => isset($config['consignee_email-wrapper']) ? $config['consignee_email-wrapper'] : "",
                "label" => isset($config['consignee_email-label']) ? $config['consignee_email-label'] : "Consignee Email",
                "type" => "email",
                "default" => isset($config['consignee_email']) ? $config['consignee_email'] : "",
            ),
            array(
                "name" => "consignee_address",
                "field_type" => "required",
                "classes" => isset($config['consignee_address-class']) ? $config['consignee_address-class'] : "",
                "attr" => isset($config['consignee_address-attr']) ? $config['consignee_address-attr'] : "",
                "wrapper" => isset($config['consignee_address-wrapper']) ? $config['consignee_address-wrapper'] : "",
                "label" => isset($config['consignee_address-label']) ? $config['consignee_address-label'] : "Consignee Address",
                "type" => "text",
                "default" => isset($config['consignee_address']) ? $config['consignee_address'] : "",
            ),
            array(
                "name" => "consignee_city",
                "field_type" => "required",
                "classes" => isset($config['consignee_city-class']) ? $config['consignee_city-class'] : "",
                "attr" => isset($config['consignee_city-attr']) ? $config['consignee_city-attr'] : "",
                "wrapper" => isset($config['consignee_city-wrapper']) ? $config['consignee_city-wrapper'] : "",
                "label" => isset($config['consignee_city-label']) ? $config['consignee_city-label'] : "Consignee City",
                "type" => "select",
                "default" => isset($config['consignee_city']) && in_array(strtoupper($config['consignee_city']), andaz_array_column($cities)) ? $config['consignee_city'] : "",
                "options" => $cities,
                "custom_options" => isset($config['consignee_city-custom_options']) ? $config['consignee_city-custom_options'] : array(),
            ),
            array(
                "name" => "weight",
                "field_type" => "required",
                "classes" => isset($config['weight-class']) ? $config['weight-class'] : "",
                "attr" => isset($config['weight-attr']) ? $config['weight-attr'] : "",
                "wrapper" => isset($config['weight-wrapper']) ? $config['weight-wrapper'] : "",
                "label" => isset($config['weight-label']) ? $config['weight-label'] : "Weight",
                "type" => "number",
                "default" => isset($config['weight']) ? $config['weight'] : "",
            ),
            array(
                "name" => "pieces",
                "field_type" => "required",
                "classes" => isset($config['pieces-class']) ? $config['pieces-class'] : "",
                "attr" => isset($config['pieces-attr']) ? $config['pieces-attr'] : "",
                "wrapper" => isset($config['pieces-wrapper']) ? $config['pieces-wrapper'] : "",
                "label" => isset($config['pieces-label']) ? $config['pieces-label'] : "Pieces",
                "type" => "number",
                "default" => isset($config['pieces']) ? $config['pieces'] : "",
            ),
            array(
                "name" => "amount",
                "field_type" => "required",
                "classes" => isset($config['amount-class']) ? $config['amount-class'] : "",
                "attr" => isset($config['amount-attr']) ? $config['amount-attr'] : "",
                "wrapper" => isset($config['amount-wrapper']) ? $config['amount-wrapper'] : "",
                "label" => isset($config['amount-label']) ? $config['amount-label'] : "Amount",
                "type" => "number",
                "default" => isset($config['amount']) ? $config['amount'] : 500,
            ),
            array(
                "name" => "order_id",
                "field_type" => "optional",
                "classes" => isset($config['order_id-class']) ? $config['order_id-class'] : "",
                "attr" => isset($config['order_id-attr']) ? $config['order_id-attr'] : "",
                "wrapper" => isset($config['order_id-wrapper']) ? $config['order_id-wrapper'] : "",
                "label" => isset($config['order_id-label']) ? $config['order_id-label'] : "Order ID",
                "type" => "text",
                "default" => isset($config['order_id']) ? $config['order_id'] : "",
            ),
            array(
                "name" => "service_id",
                "field_type" => "optional",
                "classes" => isset($config['service_id-class']) ? $config['service_id-class'] : "",
                "attr" => isset($config['service_id-attr']) ? $config['service_id-attr'] : "",
                "wrapper" => isset($config['service_id-wrapper']) ? $config['service_id-wrapper'] : "",
                "label" => isset($config['service_id-label']) ? $config['service_id-label'] : "Service",
                "type" => "select",
                "default" => isset($config['service_id']) && in_array($config['service_id'], andaz_array_column($services)) ? $config['service_id'] : $services[0]['value'],
                "options" => $services,
                "custom_options" => isset($config['service_id-custom_options']) ? $config['service_id-custom_options'] : array(),
            ),
            array(
                "name" => "order_details",
                "field_type" => "optional",
                "classes" => isset($config['order_details-class']) ? $config['order_details-class'] : "",
                "attr" => isset($config['order_details-attr']) ? $config['order_details-attr'] : "",
                "wrapper" => isset($config['order_details-wrapper']) ? $config['order_details-wrapper'] : "",
                "label" => isset($config['order_details-label']) ? $config['order_details-label'] : "Order Description",
                "type" => "text",
                "default" => isset($config['order_details']) ? $config['order_details'] : "",
            ),
            array(
                "name" => "fragile",
                "field_type" => "optional",
                "classes" => isset($config['fragile-class']) ? $config['fragile-class'] : "",
                "attr" => isset($config['fragile-attr']) ? $config['fragile-attr'] : "",
                "wrapper" => isset($config['fragile-wrapper']) ? $config['fragile-wrapper'] : "",
                "label" => isset($config['fragile-label']) ? $config['fragile-label'] : "Fragile",
                "type" => "select",
                "default" => isset($config['fragile']) && in_array($config['fragile'], andaz_array_column($fragile)) ? $config['fragile'] : $fragile[0]['value'],
                "options" => $fragile,
                "custom_options" => isset($config['fragile-custom_options']) ? $config['fragile-custom_options'] : array(),
            ),
            array(
                "name" => "remarks",
                "field_type" => "optional",
                "classes" => isset($config['remarks-class']) ? $config['remarks-class'] : "",
                "attr" => isset($config['remarks-attr']) ? $config['remarks-attr'] : "",
                "wrapper" => isset($config['remarks-wrapper']) ? $config['remarks-wrapper'] : "",
                "label" => isset($config['remarks-label']) ? $config['remarks-label'] : "Order Remarks",
                "type" => "text",
                "default" => isset($config['remarks']) ? $config['remarks'] : "",
            ),
            array(
                "name" => "insurance_value",
                "field_type" => "optional",
                "classes" => isset($config['insurance_value-class']) ? $config['insurance_value-class'] : "",
                "attr" => isset($config['insurance_value-attr']) ? $config['insurance_value-attr'] : "",
                "wrapper" => isset($config['insurance_value-wrapper']) ? $config['insurance_value-wrapper'] : "",
                "label" => isset($config['insurance_value-label']) ? $config['insurance_value-label'] : "Insurance Value",
                "type" => "number",
                "default" => isset($config['insurance_value']) ? $config['insurance_value'] : 0,
            ),
        );
        if(isset($config["sort_order"])){
            $sorted_fields = $config["sort_order"];
            $sortedArray = array();
            foreach ($sorted_fields as $key) {
                foreach ($form_fields as $item) {
                    if ($item['name'] === $key) {
                        $sortedArray[] = $item;
                        break;
                    }
                }
            }
            foreach ($form_fields as $item) {
                if (!in_array($item['name'], $sorted_fields)) {
                    $sortedArray[] = $item;
                }
            }
            $form_fields = $sortedArray;
        }
        if($config['response'] == "form"){
            return $this->getForm($form_fields, $config);
        } else {
            return $form_fields;
        }
    }
    public function getField($form_fields, $config, $field){
        $form_html = "";
        $label_class = isset($config['label_class']) ? $config['label_class'] : "";
        $input_class = isset($config['input_class']) ? $config['input_class'] : "";
        if($field['field_type'] == "optional"){
            if($config['optional'] == false && !in_array($field['name'], $config['optional_selective'])){
                return "";
            }
        }
        if(isset($config['wrappers'][$field['name']]['input_wrapper_start'])){
            $form_html .= $config['wrappers'][$field['name']]['input_wrapper_start'];
        }
        $form_html .= '<label class="' . $label_class . '" for="' . $field['name'] . '">' . $field['label'] . '</label>';
        $wrapper_data = "name='" . $field['name'] . "' " . " class='" . $input_class . " " . $field['classes'] . "' " . $field['attr'] . " " . $field['field_type'] . " placeholder='" . $field['label'] . "'";
        if($field['type'] == "select"){
            $wrapper = "select";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $options_html = '<option value = "">Select</option>';
            foreach($field['options'] as $option){
                $selected = "";
                if($field['default'] == $option['label'] || $field['default'] == $option['value']){
                    $selected = "selected";
                }
                $options_html .= '<option ' . $selected . ' value = "' . $option['value'] . '">' . $option['label'] . '</option>';
            }
            $form_html .= '<' . $wrapper . ' ' . $wrapper_data . '>' . $options_html . '</' . $wrapper . '>';
        } else if($field['type'] == "text"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "phone"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "email"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "email" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "number"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "number" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "date"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "date" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "textarea"){
            $wrapper = "textarea";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' ' . $wrapper_data . '>' . $field['default'] . '</' . $wrapper . '>';
        }
        if(isset($config['wrappers'][$field['name']]['input_wrapper_end'])){
            $form_html .= $config['wrappers'][$field['name']]['input_wrapper_end'];
        }
        return $form_html;
    }
    public function getForm($form_fields, $config){
        $form_html = "";
        if(!isset($config['optional_selective']) || !is_array($config['optional_selective'])){
            $config['optional_selective'] = array();
        }
        //row
        foreach($form_fields as $field){
            if($field['type'] == "row"){
                
                if(isset($config['wrappers'][$field['name']]['input_wrapper_start'])){
                    $form_html .= $config['wrappers'][$field['name']]['input_wrapper_start'];
                }
                foreach($field['row_fields'] as $row_field){
                    $form_html .= $this->getField($field['row_fields'], $config, $row_field);
                }
                if(isset($config['wrappers'][$field['name']]['input_wrapper_end'])){
                    $form_html .= $config['wrappers'][$field['name']]['input_wrapper_end'];
                }
            } else {
                $form_html .= $this->getField($form_fields, $config, $field);
            }
        }
        return $form_html;
    }
}
