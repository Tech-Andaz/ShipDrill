<?php

namespace TechAndaz\CallCourier;

class CallCourierAPI
{
    private $CallCourierClient;
    private $callback_url;

    public function __construct(CallCourierClient $CallCourierClient)
    {
        $this->CallCourierClient = $CallCourierClient;
    }

    /**
    * Get Return City List by Shipper
    *
    * @return array
    *   Decoded response data.
    */
    public function getReturnCityListByShipper()
    {
        
        $endpoint = "API/CallCourier/GetReturnCitiesByShipper?LoginId=" . $this->CallCourierClient->login_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Get Origin City List by Shipper
    *
    * @return array
    *   Decoded response data.
    */
    public function getOriginCityListByShipper()
    {
        $endpoint = "API/CallCourier/GetOriginListByShipper?LoginId=" . $this->CallCourierClient->login_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Get Service Types
    *
    * @return array
    *   Decoded response data.
    */
    public function getServiceTypes()
    {
        $endpoint = "API/CallCourier/GetServiceType/" . $this->CallCourierClient->account_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Check if Service is COD
    *
    * @return array
    *   Decoded response data.
    */
    public function checkIfServiceIsCOD($service_id)
    {
        $endpoint = "API/CallCourier/GetServiceTypeDetails?id=" . $service_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Get City List by Service
    *
    * @return array
    *   Decoded response data.
    */
    public function getCityListByService($service_id)
    {
        $endpoint = "API/CallCourier/GetCityListByService?serviceID=" . $service_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Get Areas by City
    *
    * @return array
    *   Decoded response data.
    */
    public function getAreasByCity($city_id)
    {
        $endpoint = "API/CallCourier/GetAreasByCity?CityID=" . $city_id;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    
    /**
    * Create Booking
    *
    * @return array
    *   Decoded response data.
    */
    public function createBookings($data)
    {
        if(!isset($data['bookings']) || !is_array($data['bookings']) || count($data['bookings']) == 0){
            throw new CallCourierException("Must provide atleast 1 booking.");
        }
        $booking_list = array();
        foreach($data['bookings'] as $index => $booking){
            array_push($booking_list, array(
                "index" => $index,
                "ConsigneeName" => (isset($booking['name']) && $booking['name'] != "") ? $booking['name'] : throw new CallCourierException("Name is missing for booking at index: ". $index),
                "ConsigneeRefNo" => (isset($booking['reference_number']) && $booking['reference_number'] != "") ? $booking['reference_number'] : throw new CallCourierException("Reference Number is missing for booking at index: ". $index),
                "ConsigneeCellNo" => (isset($booking['cell']) && $booking['cell'] != "") ? $booking['cell'] : throw new CallCourierException("Cell is missing for booking at index: ". $index),
                "Address" => (isset($booking['address']) && $booking['address'] != "") ? $booking['address'] : throw new CallCourierException("Address is missing for booking at index: ". $index),
                "DestCityId" => (isset($booking['city_id']) && $booking['city_id'] != "") ? $booking['city_id'] : throw new CallCourierException("City ID is missing for booking at index: ". $index),
                "ServiceTypeId" => (isset($booking['service_type']) && $booking['service_type'] != "") ? $booking['service_type'] : throw new CallCourierException("Service Type is missing for booking at index: ". $index),
                "Pcs" => (isset($booking['pieces']) && $booking['pieces'] != "") ? $booking['pieces'] : throw new CallCourierException("Pieces is missing for booking at index: ". $index),
                "Weight" => (isset($booking['weight']) && $booking['weight'] != "") ? $booking['weight'] : throw new CallCourierException("Weight is missing for booking at index: ". $index),
                "Description" => (isset($booking['description']) && $booking['description'] != "") ? $booking['description'] : throw new CallCourierException("Description is missing for booking at index: ". $index),
                "SelOrigin" => (isset($booking['origin']) && $booking['origin'] != "") ? $booking['origin'] : "Domestic",
                "CodAmount" => (isset($booking['amount']) && $booking['amount'] != "") ? $booking['amount'] : throw new CallCourierException("Amount is missing for booking at index: ". $index),
                "MyBoxId" => (isset($booking['box_id']) && $booking['box_id'] != "") ? $booking['box_id'] : throw new CallCourierException("Box ID is missing for booking at index: ". $index),
                "SpecialHandling" => (isset($booking['special_handling']) && $booking['special_handling'] != "") ? $booking['special_handling'] : "",
                "Holiday" => (isset($booking['holiday']) && $booking['holiday'] != "") ? $booking['holiday'] : "",
                "remarks" => (isset($booking['remarks']) && $booking['remarks'] != "") ? $booking['remarks'] : "",
            ));
        }
        $bookings_data = array(
            "loginId" => $this->CallCourierClient->login_id,
            "ShipperName" => (isset($data['shipper_name']) && $data['shipper_name'] != "") ? $data['shipper_name'] : throw new CallCourierException("Shipper Name is missing"),
            "ShipperCellNo" => (isset($data['shipper_cell']) && $data['shipper_cell'] != "") ? $data['shipper_cell'] : throw new CallCourierException("Shipper Phone Number is missing"),
            "ShipperArea" => (isset($data['shipper_area']) && $data['shipper_area'] != "") ? $data['shipper_area'] : throw new CallCourierException("Shipper Area ID is missing"),
            "ShipperCity" => (isset($data['shipper_city']) && $data['shipper_city'] != "") ? $data['shipper_city'] : throw new CallCourierException("Shipper City ID is missing"),
            "ShipperLandLineNo" => (isset($data['shipper_landline']) && $data['shipper_landline'] != "") ? $data['shipper_landline'] : throw new CallCourierException("Shipper Landline is missing"),
            "ShipperAddress" => (isset($data['shipper_address']) && $data['shipper_address'] != "") ? $data['shipper_address'] : "",
            "ShipperReturnAddress" => (isset($data['shipper_return_address']) && $data['shipper_return_address'] != "") ? $data['shipper_return_address'] : "",
            "ShipperEmail" => (isset($data['shipper_email']) && $data['shipper_email'] != "") ? $data['shipper_email'] : "",
            "bookingList" => $booking_list
        );
        $endpoint = "API/CallCourier/BulkBookings";
        $method = 'POST';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, $bookings_data);
        return $payload;
    }
    /**
    * View/Print a Receiving Sheet.
    *
    * @param int $receivingSheetId
    *   The number generated upon the creation of the receiving sheet.
    * @param int $type
    *   Type of print, whether pdf or jpeg.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShippingLabel($cn_number, $type)
    {
        $this->validateViewReceivingSheetData($cn_number, $type);
        if($type == 0){
            header('Location: ' . $this->CallCourierClient->api_url . '/Booking/AfterSavePublic/' . $cn_number);
            return;
        } else if($type == 1){
            $endpoint = '/Booking/AfterSavePublic/' . $cn_number;
            $method = 'GET';
            $responseContent = $this->CallCourierClient->makeRequestFile($endpoint, array(), $savePath = "");
            $file_url = $savePath . uniqid(mt_rand(), true) . ".pdf";
        } else if($type == 2){
            return array(
                "status" => 1,
                "url" => $this->CallCourierClient->api_url . '/Booking/AfterSavePublic/' . $cn_number
            );
            return($this->CallCourierClient->api_url . '/Booking/AfterSavePublic/' . $cn_number);
        } else {
            throw new CallCourierException('Unknown Type');
        }
        if(file_put_contents($file_url, $responseContent)){
            return array(
                "status" => 1,
                "filename" => $file_url
            );
        } else {
            throw new CallCourierException('Unable to save file: ' . error_get_last());
        }
    }

    /**
     * Validate data for viewing/printing a Receiving Sheet.
     *
     * @param int $receivingSheetId
     *   The number generated upon the creation of the receiving sheet.
     * @param int $type
     *   Type of print, whether pdf or jpeg.
     *
     * @throws CallCourierException
     *   If the data does not meet the required conditions.
     */
    private function validateViewReceivingSheetData($receivingSheetId, $type)
    {
        if (!is_numeric($receivingSheetId) || !is_numeric($type)) {
            throw new CallCourierException('Invalid data for viewing/printing a receiving sheet.');
        }
    }

    
    /**
    * Get Tracking History
    *
    * @return array
    *   Decoded response data.
    */
    public function getTrackingHistory($cn_numebr)
    {
        $endpoint = "API/CallCourier/GetTackingHistory?cn=" . $cn_numebr;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }

    /**
    * Get Tracking By Reference Number
    *
    * @return array
    *   Decoded response data.
    */
    public function getTrackingByReferenceNumber($order_reference)
    {
        $endpoint = "API/CallCourier/TrackingByRefNo?accountId=" . $this->CallCourierClient->account_id . "&refNo=" . $order_reference;
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
    }
    
    /**
    * Get Tracking Status List
    *
    * @return array
    *   Decoded response data.
    */
    public function getTrackingStatusList()
    {
        $endpoint = "API/CallCourier/GetTrackingStatusList";
        $method = 'GET';
        $payload = $this->CallCourierClient->makeRequest($endpoint, $method, array());
        return $payload;
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
            $cities_temp = $this->getOriginCityListByShipper();
            foreach ($cities_temp as $item) {
                array_push($cities,array(
                    "value" => $item['id'],
                    "label" => $item['CityName'],
                ));
            }
        }
        if(isset($config['service_types'])){
            $service_types = $config['service_types'];
            $this->validateIdNameData($service_types);
        } else {
            $service_types = array();
            $service_types_temp = $this->getServiceTypes();
            foreach ($service_types_temp as $item) {
                array_push($service_types,array(
                    "value" => $item['ServiceTypeID'],
                    "label" => $item['ServiceType1'],
                ));
            }
        }

        $special_handling =  array(
            array(
                "label" => "Not Required",
                "value" => false
            ),
            array(
                "label" => "Required",
                "value" => true
            ),
        );
        $holiday =  array(
            array(
                "label" => "Yes",
                "value" => false
            ),
            array(
                "label" => "No",
                "value" => true
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
                "name" => "shipper_cell",
                "field_type" => "required",
                "classes" => isset($config['shipper_cell-class']) ? $config['shipper_cell-class'] : "",
                "attr" => isset($config['shipper_cell-attr']) ? $config['shipper_cell-attr'] : "",
                "wrapper" => isset($config['shipper_cell-wrapper']) ? $config['shipper_cell-wrapper'] : "",
                "label" => isset($config['shipper_cell-label']) ? $config['shipper_cell-label'] : "Shipper Phone Number",
                "type" => "phone",
                "default" => isset($config['shipper_cell']) ? $config['shipper_cell'] : "",
            ),
            array(
                "name" => "shipper_city",
                "field_type" => "required",
                "classes" => isset($config['shipper_city-class']) ? $config['shipper_city-class'] : "",
                "attr" => isset($config['shipper_city-attr']) ? $config['shipper_city-attr'] : "",
                "wrapper" => isset($config['shipper_city-wrapper']) ? $config['shipper_city-wrapper'] : "",
                "label" => isset($config['shipper_city-label']) ? $config['shipper_city-label'] : "Shipper City",
                "type" => "select",
                "default" => isset($config['shipper_city']) && in_array($config['shipper_city'], array_column($cities, "label")) ? $config['shipper_city'] : "LAHORE",
                "options" => $cities,
                "custom_options" => isset($config['shipper_city-custom_options']) ? $config['shipper_city-custom_options'] : array(),
            ),
            array(
                "name" => "shipper_area",
                "field_type" => "required",
                "classes" => isset($config['shipper_area-class']) ? $config['shipper_area-class'] : "",
                "attr" => isset($config['shipper_area-attr']) ? $config['shipper_area-attr'] : "",
                "wrapper" => isset($config['shipper_area-wrapper']) ? $config['shipper_area-wrapper'] : "",
                "label" => isset($config['shipper_area-label']) ? $config['shipper_area-label'] : "Shipper Area",
                "type" => "select",
                "default" => isset($config['shipper_area']) ? $config['shipper_area'] : "",
                "options" => array(),
                "custom_options" => isset($config['shipper_area-custom_options']) ? $config['shipper_area-custom_options'] : array(),
            ),
            array(
                "name" => "shipper_landline",
                "field_type" => "required",
                "classes" => isset($config['shipper_landline-class']) ? $config['shipper_landline-class'] : "",
                "attr" => isset($config['shipper_landline-attr']) ? $config['shipper_landline-attr'] : "",
                "wrapper" => isset($config['shipper_landline-wrapper']) ? $config['shipper_landline-wrapper'] : "",
                "label" => isset($config['shipper_landline-label']) ? $config['shipper_landline-label'] : "Shipper Landline Number",
                "type" => "phone",
                "default" => isset($config['shipper_landline']) ? $config['shipper_landline'] : "",
            ),
            array(
                "name" => "shipper_address",
                "field_type" => "optional",
                "classes" => isset($config['shipper_address-class']) ? $config['shipper_address-class'] : "",
                "attr" => isset($config['shipper_address-attr']) ? $config['shipper_address-attr'] : "",
                "wrapper" => isset($config['shipper_address-wrapper']) ? $config['shipper_address-wrapper'] : "",
                "label" => isset($config['shipper_address-label']) ? $config['shipper_address-label'] : "Shipper Address",
                "type" => "text",
                "default" => isset($config['shipper_address']) ? $config['shipper_address'] : "",
            ),
            array(
                "name" => "shipper_return_address",
                "field_type" => "optional",
                "classes" => isset($config['shipper_return_address-class']) ? $config['shipper_return_address-class'] : "",
                "attr" => isset($config['shipper_return_address-attr']) ? $config['shipper_return_address-attr'] : "",
                "wrapper" => isset($config['shipper_return_address-wrapper']) ? $config['shipper_return_address-wrapper'] : "",
                "label" => isset($config['shipper_return_address-label']) ? $config['shipper_return_address-label'] : "Shipper Return Address",
                "type" => "text",
                "default" => isset($config['shipper_return_address']) ? $config['shipper_return_address'] : "",
            ),
            array(
                "name" => "shipper_email",
                "field_type" => "optional",
                "classes" => isset($config['shipper_email-class']) ? $config['shipper_email-class'] : "",
                "attr" => isset($config['shipper_email-attr']) ? $config['shipper_email-attr'] : "",
                "wrapper" => isset($config['shipper_email-wrapper']) ? $config['shipper_email-wrapper'] : "",
                "label" => isset($config['shipper_email-label']) ? $config['shipper_email-label'] : "Shipper Email",
                "type" => "email",
                "default" => isset($config['shipper_email']) ? $config['shipper_email'] : "",
            ),
            array(
                "name" => "bookings_row",
                "field_type" => "required",
                "classes" => isset($config['bookings_row-class']) ? $config['bookings_row-class'] : "",
                "attr" => isset($config['bookings_row-attr']) ? $config['bookings_row-attr'] : "",
                "wrapper" => isset($config['bookings_row-wrapper']) ? $config['bookings_row-wrapper'] : "",
                "label" => isset($config['bookings_row-label']) ? $config['bookings_row-label'] : "Parcels",
                "type" => "row",
                "default" => isset($config['bookings_row']) ? $config['bookings_row'] : "",
                "row_fields" => array(
                    array(
                        "name" => "bookings[name]",
                        "field_type" => "required",
                        "classes" => isset($config['product_code-class']) ? $config['product_code-class'] : "",
                        "attr" => isset($config['product_code-attr']) ? $config['product_code-attr'] : "",
                        "wrapper" => isset($config['product_code-wrapper']) ? $config['product_code-wrapper'] : "",
                        "label" => isset($config['product_code-label']) ? $config['product_code-label'] : "Consignee Name",
                        "type" => "text",
                        "default" => isset($config['product_code']) ? $config['product_code'] : "",
                    ),
                    array(
                        "name" => "bookings[reference_number]",
                        "field_type" => "required",
                        "classes" => isset($config['reference_number-class']) ? $config['reference_number-class'] : "",
                        "attr" => isset($config['reference_number-attr']) ? $config['reference_number-attr'] : "",
                        "wrapper" => isset($config['reference_number-wrapper']) ? $config['reference_number-wrapper'] : "",
                        "label" => isset($config['reference_number-label']) ? $config['reference_number-label'] : "Reference Number",
                        "type" => "text",
                        "default" => isset($config['reference_number']) ? $config['reference_number'] : "",
                    ),
                    array(
                        "name" => "bookings[cell]",
                        "field_type" => "required",
                        "classes" => isset($config['cell-class']) ? $config['cell-class'] : "",
                        "attr" => isset($config['cell-attr']) ? $config['cell-attr'] : "",
                        "wrapper" => isset($config['cell-wrapper']) ? $config['cell-wrapper'] : "",
                        "label" => isset($config['cell-label']) ? $config['cell-label'] : "Customer Phone",
                        "type" => "phone",
                        "default" => isset($config['cell']) ? $config['cell'] : "",
                    ),
                    array(
                        "name" => "bookings[address]",
                        "field_type" => "required",
                        "classes" => isset($config['address-class']) ? $config['address-class'] : "",
                        "attr" => isset($config['address-attr']) ? $config['address-attr'] : "",
                        "wrapper" => isset($config['address-wrapper']) ? $config['address-wrapper'] : "",
                        "label" => isset($config['address-label']) ? $config['address-label'] : "Consignee Address",
                        "type" => "text",
                        "default" => isset($config['address']) ? $config['address'] : "",
                    ),
                    array(
                        "name" => "bookings[city]",
                        "field_type" => "required",
                        "classes" => isset($config['city-class']) ? $config['city-class'] : "",
                        "attr" => isset($config['city-attr']) ? $config['city-attr'] : "",
                        "wrapper" => isset($config['city-wrapper']) ? $config['city-wrapper'] : "",
                        "label" => isset($config['city-label']) ? $config['city-label'] : "Consignee City",
                        "type" => "select",
                        "default" => isset($config['city']) && in_array($config['city'], array_column($cities, "label")) ? $config['city'] : "LAHORE",
                        "options" => $cities,
                        "custom_options" => isset($config['city-custom_options']) ? $config['city-custom_options'] : array(),
                    ),
                    array(
                        "name" => "bookings[service_type]",
                        "field_type" => "required",
                        "classes" => isset($config['service_type-class']) ? $config['service_type-class'] : "",
                        "attr" => isset($config['service_type-attr']) ? $config['service_type-attr'] : "",
                        "wrapper" => isset($config['service_type-wrapper']) ? $config['service_type-wrapper'] : "",
                        "label" => isset($config['service_type-label']) ? $config['service_type-label'] : "Service Type",
                        "type" => "select",
                        "default" => isset($config['service_type']) && in_array($config['service_type'], array_column($service_types, "label")) ? $config['service_type'] : $service_types[0]['label'],
                        "options" => $service_types,
                        "custom_options" => isset($config['service_type-custom_options']) ? $config['service_type-custom_options'] : array(),
                    ),
                    array(
                        "name" => "bookings[pieces]",
                        "field_type" => "required",
                        "classes" => isset($config['pieces-class']) ? $config['pieces-class'] : "",
                        "attr" => isset($config['pieces-attr']) ? $config['pieces-attr'] : "",
                        "wrapper" => isset($config['pieces-wrapper']) ? $config['pieces-wrapper'] : "",
                        "label" => isset($config['pieces-label']) ? $config['pieces-label'] : "Pieces",
                        "type" => "number",
                        "default" => isset($config['pieces']) ? $config['pieces'] : "",
                    ),
                    array(
                        "name" => "bookings[weight]",
                        "field_type" => "required",
                        "classes" => isset($config['weight-class']) ? $config['weight-class'] : "",
                        "attr" => isset($config['weight-attr']) ? $config['weight-attr'] : "",
                        "wrapper" => isset($config['weight-wrapper']) ? $config['weight-wrapper'] : "",
                        "label" => isset($config['weight-label']) ? $config['weight-label'] : "Weight",
                        "type" => "number",
                        "default" => isset($config['weight']) ? $config['weight'] : "",
                    ),
                    array(
                        "name" => "bookings[description]",
                        "field_type" => "required",
                        "classes" => isset($config['description-class']) ? $config['description-class'] : "",
                        "attr" => isset($config['description-attr']) ? $config['description-attr'] : "",
                        "wrapper" => isset($config['description-wrapper']) ? $config['description-wrapper'] : "",
                        "label" => isset($config['description-label']) ? $config['description-label'] : "Description",
                        "type" => "text",
                        "default" => isset($config['description']) ? $config['description'] : "",
                    ),
                    array(
                        "name" => "bookings[origin]",
                        "field_type" => "optional",
                        "classes" => isset($config['origin-class']) ? $config['origin-class'] : "",
                        "attr" => isset($config['origin-attr']) ? $config['origin-attr'] : "",
                        "wrapper" => isset($config['origin-wrapper']) ? $config['origin-wrapper'] : "",
                        "label" => isset($config['origin-label']) ? $config['origin-label'] : "Origin",
                        "type" => "text",
                        "default" => isset($config['origin']) ? $config['origin'] : "",
                    ),
                    array(
                        "name" => "bookings[amount]",
                        "field_type" => "required",
                        "classes" => isset($config['amount-class']) ? $config['amount-class'] : "",
                        "attr" => isset($config['amount-attr']) ? $config['amount-attr'] : "",
                        "wrapper" => isset($config['amount-wrapper']) ? $config['amount-wrapper'] : "",
                        "label" => isset($config['amount-label']) ? $config['amount-label'] : "Amount",
                        "type" => "number",
                        "default" => isset($config['amount']) ? $config['amount'] : "",
                    ),
                    array(
                        "name" => "bookings[box_id]",
                        "field_type" => "required",
                        "classes" => isset($config['box_id-class']) ? $config['box_id-class'] : "",
                        "attr" => isset($config['box_id-attr']) ? $config['box_id-attr'] : "",
                        "wrapper" => isset($config['box_id-wrapper']) ? $config['box_id-wrapper'] : "",
                        "label" => isset($config['box_id-label']) ? $config['box_id-label'] : "Box ID",
                        "type" => "text",
                        "default" => isset($config['box_id']) ? $config['box_id'] : "",
                    ),
                    array(
                        "name" => "bookings[special_handling]",
                        "field_type" => "optional",
                        "classes" => isset($config['special_handling-class']) ? $config['special_handling-class'] : "",
                        "attr" => isset($config['special_handling-attr']) ? $config['special_handling-attr'] : "",
                        "wrapper" => isset($config['special_handling-wrapper']) ? $config['special_handling-wrapper'] : "",
                        "label" => isset($config['special_handling-label']) ? $config['special_handling-label'] : "Special Handling",
                        "type" => "select",
                        "default" => isset($config['special_handling']) && in_array($config['special_handling'], array_column($special_handling, "label")) ? $config['special_handling'] : "Not Required",
                        "options" => $special_handling,
                        "custom_options" => isset($config['special_handling-custom_options']) ? $config['special_handling-custom_options'] : array(),
                    ),
                    array(
                        "name" => "bookings[holiday]",
                        "field_type" => "optional",
                        "classes" => isset($config['holiday-class']) ? $config['holiday-class'] : "",
                        "attr" => isset($config['holiday-attr']) ? $config['holiday-attr'] : "",
                        "wrapper" => isset($config['holiday-wrapper']) ? $config['holiday-wrapper'] : "",
                        "label" => isset($config['holiday-label']) ? $config['holiday-label'] : "Holiday",
                        "type" => "select",
                        "default" => isset($config['holiday']) && in_array($config['holiday'], array_column($holiday, "label")) ? $config['holiday'] : "No",
                        "options" => $holiday,
                        "custom_options" => isset($config['holiday-custom_options']) ? $config['holiday-custom_options'] : array(),
                    ),
                    array(
                        "name" => "bookings[remarks]",
                        "field_type" => "optional",
                        "classes" => isset($config['remarks-class']) ? $config['remarks-class'] : "",
                        "attr" => isset($config['remarks-attr']) ? $config['remarks-attr'] : "",
                        "wrapper" => isset($config['remarks-wrapper']) ? $config['remarks-wrapper'] : "",
                        "label" => isset($config['remarks-label']) ? $config['remarks-label'] : "Remarks",
                        "type" => "text",
                        "default" => isset($config['remarks']) ? $config['remarks'] : "",
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
                if($field['default'] == $option['label']){
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
