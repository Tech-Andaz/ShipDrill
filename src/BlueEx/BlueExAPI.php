<?php

namespace TechAndaz\BlueEx;

class BlueExAPI
{
    private $BlueExClient;

    public function __construct(BlueExClient $BlueExClient)
    {
        $this->BlueExClient = $BlueExClient;
    }

    /**
    * Get All Pickup Locations
    *
    * @return array
    *   Decoded response data.
    */
    public function getAllPickupLocations()
    {
        $endpoint = 'locations/get_pickup.php';
        $method = 'POST';
        $data = [
            "location_id" => "all"
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get a Pickup Location
    *
    * @param string $location_id
    *   The location ID of the requested location.
    *
    * @return array
    *   Decoded response data.
    */
    public function getPickupLocation($location_id)
    {
        $endpoint = 'locations/get_pickup.php';
        $method = 'POST';
        $data = [
            "location_id" => $location_id
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get Shipment Status
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShipmentStatus($consignment_no)
    {
        $endpoint = 'status/get_status.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get Shipment Settlement
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShipmentSettlement($consignment_no)
    {
        $endpoint = 'settlement/get_settlement.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get Shipment Info
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShipmentInfo($consignment_no)
    {
        $endpoint = 'shipment/get_shipment.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }
    
    /**
    * Get Shipment Tracking
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShipmentTracking($consignment_no)
    {
        $endpoint = 'tracking/get_tracking.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get Cities
    *
    * @param string $country_code
    *   The country code.
    *
    * @return array
    *   Decoded response data.
    */
    public function getCities($country_code)
    {
        $endpoint = 'cities/get_cities.php';
        $method = 'POST';
        $data = [
            "country_code" => $country_code
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }
    
    /**
    * Get Service Types
    *
    * @return array
    *   Decoded response data.
    */
    public function getServiceType()
    {
        $endpoint = 'services/get_services.php';
        $method = 'POST';
        return $this->BlueExClient->makeRequest($endpoint, $method, array());
    }

    /**
    * Create Shipment
    *
    * @return array
    *   Decoded response data.
    */
    public function createShipment($data)
    {
        $endpoint = 'shipment/create_shipment.php';
        $method = 'POST';
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }
    
    /**
    * Cancel Shipment
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function cancelShipment($consignment_no)
    {
        $endpoint = 'cancel/void.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Reverse Pickup
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function reversePickup($consignment_no)
    {
        $endpoint = 'reversepickup/reversepickup.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Create Loadsheet
    *
    * @param string $consignment_no
    *   The Consignment Number of the requested shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function createLoadsheet($consignment_no)
    {
        $endpoint = 'loadsheet/create_loadsheet.php';
        $method = 'POST';
        $data = [
            "consignment_no" => $consignment_no
        ];
        return $this->BlueExClient->makeRequest($endpoint, $method, $data);
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
        $url = $this->BlueExClient->label_url . $consignment_no;
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
            throw new TraxException('Invalid data structure. Each data must be an associative array.');
        }
        foreach ($data as $item) {
            // Check if the item is an array
            if (!is_array($item)) {
                throw new TraxException('Invalid data structure. Each item must be an associative array.');
            }

            // Check if the item contains only 'id' and 'name' keys
            $keys = array_keys($item);
            $allowedKeys = ['label', 'value'];
            if (count($keys) != count($allowedKeys)) {
                throw new TraxException('Invalid data structure. Each item must contain both "value" and "label" keys.');
            }
            if (count($keys) != count(array_intersect($keys, $allowedKeys))) {
                throw new TraxException('Invalid data structure. Each item must contain only "value" and "label" keys.');
            }
        }

        // Validation passed
        return true;
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
        $uniqueKeys = $this->getAllUniqueKeys($array);
        $result = array_merge(...array_map(function ($item) use ($uniqueKeys) {
            return array_values(array_intersect_key($item, array_flip($uniqueKeys)));
        }, $array));
        return $result;
    }

    /**
    * Get Form Fields
    *
    * @return array
    *   Decoded response data.
    */
    public function getFormFields($config)
    {
        if(!isset($config['response']) || !in_array($config['response'], ["form", "json"])){
            throw new BlueExException('Ivalid response type. Available: form, json');
        }
        if(!isset($config['optional'])){
            $config['optional'] = false;
        }
        if(isset($config['cities'])){
            $cities = $config['cities'];
            $this->validateIdNameData($cities);
        } else {
            $cities = array();
            $cities_temp = json_decode(file_get_contents(__DIR__ . '/' . 'cities.json'),true);
            foreach ($cities_temp as $item) {
                array_push($cities,array(
                    "value" => $item['CITY_CODE'],
                    "label" => $item['CITY_NAME'],
                ));
            }
        }
        $countries = json_decode(file_get_contents(__DIR__ . '/' . 'countries.json'),true);
        $service_types = array();
        $service_types_temp = $this->getServiceType()['response']['detail'];
        foreach ($service_types_temp as $item) {
            array_push($service_types,array(
                "value" => $item['service_code'],
                "label" => $item['service_name'],
            ));
        }
        $payment_type =  array(
            array(
                "label" => "Cash on Delivery",
                "value" => "COD"
            ),
            array(
                "label" => "Paid",
                "value" => "CC"
            ),
        );
        $fragile =  array(
            array(
                "label" => "No",
                "value" => "N"
            ),
            array(
                "label" => "Yes",
                "value" => "Y"
            ),
        );
        $parcel_type =  array(
            array(
                "label" => "Parcel",
                "value" => "P"
            ),
            array(
                "label" => "Document",
                "value" => "D"
            ),
        );
        $insurance_require =  array(
            array(
                "label" => "No",
                "value" => "N"
            ),
            array(
                "label" => "Yes",
                "value" => "Y"
            ),
        );
        $cn_generate =  array(
            array(
                "label" => "Yes",
                "value" => "Y"
            ),
            array(
                "label" => "No",
                "value" => "N"
            ),
        );
        $multi_pickup =  array(
            array(
                "label" => "No",
                "value" => "N"
            ),
            array(
                "label" => "Yes",
                "value" => "Y"
            ),
        );
        $form_fields = array(
            array(
                "name" => "shipper_name",
                "field_type" => "required",
                "classes" => isset($config['shipper_name-class']) ? $config['shipper_name-class'] : "",
                "attr" => isset($config['shipper_name-attr']) ? $config['shipper_name-attr'] : "",
                "wrapper" => isset($config['shipper_name-wrapper']) ? $config['shipper_name-wrapper'] : "",
                "label" => isset($config['shipper_name-label']) ? $config['shipper_name-label'] : "Shipper Name",
                "type" => "text",
                "default" => isset($config['shipper_name']) ? $config['shipper_name'] : "",
            ),
            array(
                "name" => "shipper_email",
                "field_type" => "required",
                "classes" => isset($config['shipper_email-class']) ? $config['shipper_email-class'] : "",
                "attr" => isset($config['shipper_email-attr']) ? $config['shipper_email-attr'] : "",
                "wrapper" => isset($config['shipper_email-wrapper']) ? $config['shipper_email-wrapper'] : "",
                "label" => isset($config['shipper_email-label']) ? $config['shipper_email-label'] : "Shipper Email",
                "type" => "email",
                "default" => isset($config['shipper_email']) ? $config['shipper_email'] : "",
            ),
            array(
                "name" => "shipper_contact",
                "field_type" => "required",
                "classes" => isset($config['shipper_contact-class']) ? $config['shipper_contact-class'] : "",
                "attr" => isset($config['shipper_contact-attr']) ? $config['shipper_contact-attr'] : "",
                "wrapper" => isset($config['shipper_contact-wrapper']) ? $config['shipper_contact-wrapper'] : "",
                "label" => isset($config['shipper_contact-label']) ? $config['shipper_contact-label'] : "Shipper Phone Number",
                "type" => "phone",
                "default" => isset($config['shipper_contact']) ? $config['shipper_contact'] : "",
            ),
            array(
                "name" => "shipper_address",
                "field_type" => "required",
                "classes" => isset($config['shipper_address-class']) ? $config['shipper_address-class'] : "",
                "attr" => isset($config['shipper_address-attr']) ? $config['shipper_address-attr'] : "",
                "wrapper" => isset($config['shipper_address-wrapper']) ? $config['shipper_address-wrapper'] : "",
                "label" => isset($config['shipper_address-label']) ? $config['shipper_address-label'] : "Shipper Address",
                "type" => "text",
                "default" => isset($config['shipper_address']) ? $config['shipper_address'] : "",
            ),
            array(
                "name" => "shipper_city",
                "field_type" => "required",
                "classes" => isset($config['shipper_city-class']) ? $config['shipper_city-class'] : "",
                "attr" => isset($config['shipper_city-attr']) ? $config['shipper_city-attr'] : "",
                "wrapper" => isset($config['shipper_city-wrapper']) ? $config['shipper_city-wrapper'] : "",
                "label" => isset($config['shipper_city-label']) ? $config['shipper_city-label'] : "Shipper City",
                "type" => "select",
                "default" => isset($config['shipper_city']) && in_array($config['shipper_city'], $this->andaz_array_column($cities, "label")) ? $config['shipper_city'] : "LHE",
                "options" => $cities,
                "custom_options" => isset($config['shipper_city-custom_options']) ? $config['shipper_city-custom_options'] : array(),
            ),
            array(
                "name" => "customer_name",
                "field_type" => "required",
                "classes" => isset($config['customer_name-class']) ? $config['customer_name-class'] : "",
                "attr" => isset($config['customer_name-attr']) ? $config['customer_name-attr'] : "",
                "wrapper" => isset($config['customer_name-wrapper']) ? $config['customer_name-wrapper'] : "",
                "label" => isset($config['customer_name-label']) ? $config['customer_name-label'] : "Customer Name",
                "type" => "text",
                "default" => isset($config['customer_name']) ? $config['customer_name'] : "",
            ),
            array(
                "name" => "customer_email",
                "field_type" => "required",
                "classes" => isset($config['customer_email-class']) ? $config['customer_email-class'] : "",
                "attr" => isset($config['customer_email-attr']) ? $config['customer_email-attr'] : "",
                "wrapper" => isset($config['customer_email-wrapper']) ? $config['customer_email-wrapper'] : "",
                "label" => isset($config['customer_email-label']) ? $config['customer_email-label'] : "Customer Email",
                "type" => "email",
                "default" => isset($config['customer_email']) ? $config['customer_email'] : "",
            ),
            array(
                "name" => "customer_contact",
                "field_type" => "required",
                "classes" => isset($config['customer_contact-class']) ? $config['customer_contact-class'] : "",
                "attr" => isset($config['customer_contact-attr']) ? $config['customer_contact-attr'] : "",
                "wrapper" => isset($config['customer_contact-wrapper']) ? $config['customer_contact-wrapper'] : "",
                "label" => isset($config['customer_contact-label']) ? $config['customer_contact-label'] : "Customer Phone Number",
                "type" => "phone",
                "default" => isset($config['customer_contact']) ? $config['customer_contact'] : "",
            ),
            array(
                "name" => "customer_address",
                "field_type" => "required",
                "classes" => isset($config['customer_address-class']) ? $config['customer_address-class'] : "",
                "attr" => isset($config['customer_address-attr']) ? $config['customer_address-attr'] : "",
                "wrapper" => isset($config['customer_address-wrapper']) ? $config['customer_address-wrapper'] : "",
                "label" => isset($config['customer_address-label']) ? $config['customer_address-label'] : "Customer Address",
                "type" => "text",
                "default" => isset($config['customer_address']) ? $config['customer_address'] : "",
            ),
            array(
                "name" => "customer_city",
                "field_type" => "required",
                "classes" => isset($config['customer_city-class']) ? $config['customer_city-class'] : "",
                "attr" => isset($config['customer_city-attr']) ? $config['customer_city-attr'] : "",
                "wrapper" => isset($config['customer_city-wrapper']) ? $config['customer_city-wrapper'] : "",
                "label" => isset($config['customer_city-label']) ? $config['customer_city-label'] : "Customer City",
                "type" => "select",
                "default" => isset($config['customer_city']) && in_array($config['customer_city'], $this->andaz_array_column($cities, "label")) ? $config['customer_city'] : "Lahore",
                "options" => $cities,
                "custom_options" => isset($config['customer_city-custom_options']) ? $config['customer_city-custom_options'] : array(),
            ),
            array(
                "name" => "customer_country",
                "field_type" => "required",
                "classes" => isset($config['customer_country-class']) ? $config['customer_country-class'] : "",
                "attr" => isset($config['customer_country-attr']) ? $config['customer_country-attr'] : "",
                "wrapper" => isset($config['customer_country-wrapper']) ? $config['customer_country-wrapper'] : "",
                "label" => isset($config['customer_country-label']) ? $config['customer_country-label'] : "Customer Country",
                "type" => "select",
                "default" => isset($config['customer_country']) && in_array($config['customer_country'], $this->andaz_array_column($countries, "label")) ? $config['customer_country'] : "Pakistan",
                "options" => $countries,
                "custom_options" => isset($config['customer_country-custom_options']) ? $config['customer_country-custom_options'] : array(),
            ),
            array(
                "name" => "shipping_charges",
                "field_type" => "optional",
                "classes" => isset($config['shipping_charges-class']) ? $config['shipping_charges-class'] : "",
                "attr" => isset($config['shipping_charges-attr']) ? $config['shipping_charges-attr'] : "",
                "wrapper" => isset($config['shipping_charges-wrapper']) ? $config['shipping_charges-wrapper'] : "",
                "label" => isset($config['shipping_charges-label']) ? $config['shipping_charges-label'] : "Shipping Charges",
                "type" => "number",
                "default" => isset($config['shipping_charges']) ? $config['shipping_charges'] : 150,
            ),
            array(
                "name" => "customer_comment",
                "field_type" => "optional",
                "classes" => isset($config['customer_comment-class']) ? $config['customer_comment-class'] : "",
                "attr" => isset($config['customer_comment-attr']) ? $config['customer_comment-attr'] : "",
                "wrapper" => isset($config['customer_comment-wrapper']) ? $config['customer_comment-wrapper'] : "",
                "label" => isset($config['customer_comment-label']) ? $config['customer_comment-label'] : "Customer Comments",
                "type" => "text",
                "default" => isset($config['customer_comment']) ? $config['customer_comment'] : "",
            ),
            array(
                "name" => "payment_type",
                "field_type" => "required",
                "classes" => isset($config['payment_type-class']) ? $config['payment_type-class'] : "",
                "attr" => isset($config['payment_type-attr']) ? $config['payment_type-attr'] : "",
                "wrapper" => isset($config['payment_type-wrapper']) ? $config['payment_type-wrapper'] : "",
                "label" => isset($config['payment_type-label']) ? $config['payment_type-label'] : "Customer Country",
                "type" => "select",
                "default" => isset($config['payment_type']) && in_array($config['payment_type'], $this->andaz_array_column($payment_type, "label")) ? $config['payment_type'] : "Cash on Delivery",
                "options" => $payment_type,
                "custom_options" => isset($config['payment_type-custom_options']) ? $config['payment_type-custom_options'] : array(),
            ),
            array(
                "name" => "service_code",
                "field_type" => "required",
                "classes" => isset($config['service_code-class']) ? $config['service_code-class'] : "",
                "attr" => isset($config['service_code-attr']) ? $config['service_code-attr'] : "",
                "wrapper" => isset($config['service_code-wrapper']) ? $config['service_code-wrapper'] : "",
                "label" => isset($config['service_code-label']) ? $config['service_code-label'] : "Service Type",
                "type" => "select",
                "default" => isset($config['service_code']) && in_array($config['service_code'], $this->andaz_array_column($service_types, "label")) ? $config['service_code'] : $service_types[0]['label'],
                "options" => $service_types,
                "custom_options" => isset($config['service_code-custom_options']) ? $config['service_code-custom_options'] : array(),
            ),
            array(
                "name" => "total_order_amount",
                "field_type" => "required",
                "classes" => isset($config['total_order_amount-class']) ? $config['total_order_amount-class'] : "",
                "attr" => isset($config['total_order_amount-attr']) ? $config['total_order_amount-attr'] : "",
                "wrapper" => isset($config['total_order_amount-wrapper']) ? $config['total_order_amount-wrapper'] : "",
                "label" => isset($config['total_order_amount-label']) ? $config['total_order_amount-label'] : "Total Order Amount",
                "type" => "number",
                "default" => isset($config['total_order_amount']) ? $config['total_order_amount'] : "",
            ),
            array(
                "name" => "total_order_weight",
                "field_type" => "required",
                "classes" => isset($config['total_order_weight-class']) ? $config['total_order_weight-class'] : "",
                "attr" => isset($config['total_order_weight-attr']) ? $config['total_order_weight-attr'] : "",
                "wrapper" => isset($config['total_order_weight-wrapper']) ? $config['total_order_weight-wrapper'] : "",
                "label" => isset($config['total_order_weight-label']) ? $config['total_order_weight-label'] : "Total Order Weight",
                "type" => "number",
                "default" => isset($config['total_order_weight']) ? $config['total_order_weight'] : "",
            ),
            array(
                "name" => "order_refernce_code",
                "field_type" => "required",
                "classes" => isset($config['order_refernce_code-class']) ? $config['order_refernce_code-class'] : "",
                "attr" => isset($config['order_refernce_code-attr']) ? $config['order_refernce_code-attr'] : "",
                "wrapper" => isset($config['order_refernce_code-wrapper']) ? $config['order_refernce_code-wrapper'] : "",
                "label" => isset($config['order_refernce_code-label']) ? $config['order_refernce_code-label'] : "Order ID",
                "type" => "text",
                "default" => isset($config['order_refernce_code']) ? $config['order_refernce_code'] : "",
            ),
            array(
                "name" => "fragile",
                "field_type" => "required",
                "classes" => isset($config['fragile-class']) ? $config['fragile-class'] : "",
                "attr" => isset($config['fragile-attr']) ? $config['fragile-attr'] : "",
                "wrapper" => isset($config['fragile-wrapper']) ? $config['fragile-wrapper'] : "",
                "label" => isset($config['fragile-label']) ? $config['fragile-label'] : "Service Type",
                "type" => "select",
                "default" => isset($config['fragile']) && in_array($config['fragile'], $this->andaz_array_column($fragile, "label")) ? $config['fragile'] : $fragile[0]['label'],
                "options" => $fragile,
                "custom_options" => isset($config['fragile-custom_options']) ? $config['fragile-custom_options'] : array(),
            ),
            array(
                "name" => "parcel_type",
                "field_type" => "required",
                "classes" => isset($config['parcel_type-class']) ? $config['parcel_type-class'] : "",
                "attr" => isset($config['parcel_type-attr']) ? $config['parcel_type-attr'] : "",
                "wrapper" => isset($config['parcel_type-wrapper']) ? $config['parcel_type-wrapper'] : "",
                "label" => isset($config['parcel_type-label']) ? $config['parcel_type-label'] : "Parcel Type",
                "type" => "select",
                "default" => isset($config['parcel_type']) && in_array($config['parcel_type'], $this->andaz_array_column($parcel_type, "label")) ? $config['parcel_type'] : $parcel_type[0]['label'],
                "options" => $parcel_type,
                "custom_options" => isset($config['parcel_type-custom_options']) ? $config['parcel_type-custom_options'] : array(),
            ),
            array(
                "name" => "insurance_require",
                "field_type" => "required",
                "classes" => isset($config['insurance_require-class']) ? $config['insurance_require-class'] : "",
                "attr" => isset($config['insurance_require-attr']) ? $config['insurance_require-attr'] : "",
                "wrapper" => isset($config['insurance_require-wrapper']) ? $config['insurance_require-wrapper'] : "",
                "label" => isset($config['insurance_require-label']) ? $config['insurance_require-label'] : "Insurance",
                "type" => "select",
                "default" => isset($config['insurance_require']) && in_array($config['insurance_require'], $this->andaz_array_column($insurance_require, "label")) ? $config['insurance_require'] : $insurance_require[0]['label'],
                "options" => $insurance_require,
                "custom_options" => isset($config['insurance_require-custom_options']) ? $config['insurance_require-custom_options'] : array(),
            ),
            array(
                "name" => "insurance_value",
                "field_type" => "optional",
                "classes" => isset($config['insurance_value-class']) ? $config['insurance_value-class'] : "",
                "attr" => isset($config['insurance_value-attr']) ? $config['insurance_value-attr'] : "",
                "wrapper" => isset($config['insurance_value-wrapper']) ? $config['insurance_value-wrapper'] : "",
                "label" => isset($config['insurance_value-label']) ? $config['insurance_value-label'] : "Insurance Weight",
                "type" => "number",
                "default" => isset($config['insurance_value']) ? $config['insurance_value'] : "",
            ),
            array(
                "name" => "cn_generate",
                "field_type" => "required",
                "classes" => isset($config['cn_generate-class']) ? $config['cn_generate-class'] : "",
                "attr" => isset($config['cn_generate-attr']) ? $config['cn_generate-attr'] : "",
                "wrapper" => isset($config['cn_generate-wrapper']) ? $config['cn_generate-wrapper'] : "",
                "label" => isset($config['cn_generate-label']) ? $config['cn_generate-label'] : "Generate CN",
                "type" => "select",
                "default" => isset($config['cn_generate']) && in_array($config['cn_generate'], $this->andaz_array_column($cn_generate, "label")) ? $config['cn_generate'] : $cn_generate[0]['label'],
                "options" => $cn_generate,
                "custom_options" => isset($config['cn_generate-custom_options']) ? $config['cn_generate-custom_options'] : array(),
            ),
            array(
                "name" => "multi_pickup",
                "field_type" => "optional",
                "classes" => isset($config['multi_pickup-class']) ? $config['multi_pickup-class'] : "",
                "attr" => isset($config['multi_pickup-attr']) ? $config['multi_pickup-attr'] : "",
                "wrapper" => isset($config['multi_pickup-wrapper']) ? $config['multi_pickup-wrapper'] : "",
                "label" => isset($config['multi_pickup-label']) ? $config['multi_pickup-label'] : "Multi Pickup",
                "type" => "select",
                "default" => isset($config['multi_pickup']) && in_array($config['multi_pickup'], $this->andaz_array_column($multi_pickup, "label")) ? $config['multi_pickup'] : $multi_pickup[0]['label'],
                "options" => $multi_pickup,
                "custom_options" => isset($config['multi_pickup-custom_options']) ? $config['multi_pickup-custom_options'] : array(),
            ),
            
            array(
                "name" => "products_detail_row",
                "field_type" => "required",
                "classes" => isset($config['products_detail_row-class']) ? $config['products_detail_row-class'] : "",
                "attr" => isset($config['products_detail_row-attr']) ? $config['products_detail_row-attr'] : "",
                "wrapper" => isset($config['products_detail_row-wrapper']) ? $config['products_detail_row-wrapper'] : "",
                "label" => isset($config['products_detail_row-label']) ? $config['products_detail_row-label'] : "Items",
                "type" => "row",
                "default" => isset($config['products_detail_row']) ? $config['products_detail_row'] : "",
                "row_fields" => array(
                    array(
                        "name" => "products_detail[0][product_code]",
                        "field_type" => "required",
                        "classes" => isset($config['product_code-class']) ? $config['product_code-class'] : "",
                        "attr" => isset($config['product_code-attr']) ? $config['product_code-attr'] : "",
                        "wrapper" => isset($config['product_code-wrapper']) ? $config['product_code-wrapper'] : "",
                        "label" => isset($config['product_code-label']) ? $config['product_code-label'] : "Product Code",
                        "type" => "text",
                        "default" => isset($config['product_code']) ? $config['product_code'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][product_name]",
                        "field_type" => "required",
                        "classes" => isset($config['product_name-class']) ? $config['product_name-class'] : "",
                        "attr" => isset($config['product_name-attr']) ? $config['product_name-attr'] : "",
                        "wrapper" => isset($config['product_name-wrapper']) ? $config['product_name-wrapper'] : "",
                        "label" => isset($config['product_name-label']) ? $config['product_name-label'] : "Product Name",
                        "type" => "text",
                        "default" => isset($config['product_name']) ? $config['product_name'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][product_price]",
                        "field_type" => "required",
                        "classes" => isset($config['product_price-class']) ? $config['product_price-class'] : "",
                        "attr" => isset($config['product_price-attr']) ? $config['product_price-attr'] : "",
                        "wrapper" => isset($config['product_price-wrapper']) ? $config['product_price-wrapper'] : "",
                        "label" => isset($config['product_price-label']) ? $config['product_price-label'] : "Product Price",
                        "type" => "number",
                        "default" => isset($config['product_price']) ? $config['product_price'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][product_quantity]",
                        "field_type" => "required",
                        "classes" => isset($config['product_quantity-class']) ? $config['product_quantity-class'] : "",
                        "attr" => isset($config['product_quantity-attr']) ? $config['product_quantity-attr'] : "",
                        "wrapper" => isset($config['product_quantity-wrapper']) ? $config['product_quantity-wrapper'] : "",
                        "label" => isset($config['product_quantity-label']) ? $config['product_quantity-label'] : "Product Quantity",
                        "type" => "number",
                        "default" => isset($config['product_quantity']) ? $config['product_quantity'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][product_weight]",
                        "field_type" => "required",
                        "classes" => isset($config['product_weight-class']) ? $config['product_weight-class'] : "",
                        "attr" => isset($config['product_weight-attr']) ? $config['product_weight-attr'] : "",
                        "wrapper" => isset($config['product_weight-wrapper']) ? $config['product_weight-wrapper'] : "",
                        "label" => isset($config['product_weight-label']) ? $config['product_weight-label'] : "Product Weight",
                        "type" => "number",
                        "default" => isset($config['product_weight']) ? $config['product_weight'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][product_variations]",
                        "field_type" => "optional",
                        "classes" => isset($config['product_variations-class']) ? $config['product_variations-class'] : "",
                        "attr" => isset($config['product_variations-attr']) ? $config['product_variations-attr'] : "",
                        "wrapper" => isset($config['product_variations-wrapper']) ? $config['product_variations-wrapper'] : "",
                        "label" => isset($config['product_variations-label']) ? $config['product_variations-label'] : "Product Variations",
                        "type" => "text",
                        "default" => isset($config['product_variations']) ? $config['product_variations'] : "",
                    ),
                    array(
                        "name" => "products_detail[0][sku_code]",
                        "field_type" => "optional",
                        "classes" => isset($config['sku_code-class']) ? $config['sku_code-class'] : "",
                        "attr" => isset($config['sku_code-attr']) ? $config['sku_code-attr'] : "",
                        "wrapper" => isset($config['sku_code-wrapper']) ? $config['sku_code-wrapper'] : "",
                        "label" => isset($config['sku_code-label']) ? $config['sku_code-label'] : "Product SKU",
                        "type" => "text",
                        "default" => isset($config['sku_code']) ? $config['sku_code'] : "",
                    ),
                )
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
            $options_html = "";
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
