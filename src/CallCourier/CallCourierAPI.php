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
                "SelOrigin" => (isset($booking['origin']) && $booking['origin'] != "") ? $booking['origin'] : throw new CallCourierException("Origin is missing for booking at index: ". $index),
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
            print_r($this->CallCourierClient->api_url . '/Booking/AfterSavePublic/' . $cn_number);
            exit;
            header($this->CallCourierClient->api_url . '/Booking/AfterSavePublic/' . $cn_number);
            return;
        } else if($type == 1){
            $endpoint = '/Booking/AfterSavePublic/' . $cn_number;
            $method = 'GET';
            $responseContent = $this->CallCourierClient->makeRequestFile($endpoint, array(), $savePath = "");
            $file_url = $savePath . uniqid(mt_rand(), true) . ".pdf";
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
}