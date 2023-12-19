<?php

namespace TechAndaz\Trax;

class TraxAPI
{
    private $traxClient;

    public function __construct(TraxClient $traxClient)
    {
        $this->traxClient = $traxClient;
    }

    /**
    * Add a Pickup Address.
    *
    * @param array $data
    *   An associative array containing data for adding a pickup address.
    *   - person_of_contact: Name of the person who will be coordinating for pickup (Mandatory, String, Character limit: 100).
    *   - phone_number: Phone number of the coordinator for pickup (Mandatory, Integer, Format: 03001234567).
    *   - email_address: Email address of the coordinator for pickup (Mandatory, Email format).
    *   - address: The address from which the shipment will be picked (Mandatory, String, Character limit: 190).
    *   - city_id: ID of the city from where the shipment will be picked (Mandatory, Integer).
    *
    * @return array
    *   Decoded response data.
    */
    public function addPickupAddress(array $data)
    {
        $this->validateAddPickupAddressData($data);
        $endpoint = '/api/pickup_address/add';
        $method = 'POST';
        return $this->traxClient->makeRequest($endpoint, $method, $data);
    }
    /**
    * Validate data for adding a pickup address.
    *
    * @param array $data
    *   An associative array containing data for adding a pickup address.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateAddPickupAddressData(array $data)
    {
        if (empty($data['person_of_contact']) || mb_strlen($data['person_of_contact']) > 100) {
            throw new TraxException('Invalid person_of_contact. It is mandatory and should be within 100 characters.');
        }
    }

    /**
    * List Pickup Addresses.
    *
    * @return array
    *   Decoded response data.
    */
    public function listPickupAddresses()
    {
        $endpoint = '/api/pickup_addresses';
        $method = 'GET';
        return $this->traxClient->makeRequest($endpoint, $method);
    }

    /**
    * Get City List and Information.
    *
    * @return array
    *   Decoded response data.
    */
    public function cityList()
    {
        $endpoint = '/api/cities';
        $method = 'GET';
        return $this->traxClient->makeRequest($endpoint, $method);
    }

    /**
    * Add a Regular Shipment.
    *
    * @param array $data
    *   An associative array containing data for adding a regular shipment.
    *   Mandatory
    *   - delivery_type_id: If you are using Corporate Invoicing Account. Please be informed that you have to provide the type of delivery (Door-Step/Hub to Hub). Define the type of delivery:  1 (Door Step), 2 (Hub to Hub).
    *   - service_type_id: Defines the service that you are going to use i.e., Regular Replacement, or Try & Buy.
    *   - pickup_address_id: The address from which the shipment will be picked.
    *   - information_display: Option to show or hide your contact details on the air waybill.
    *   - consignee_city_id: Float ID of the city where the shipment will be delivered.
    *   - consignee_name: Name of the receiver to whom the shipment will be delivered.
    *   - consignee_address: The address where the shipment will be delivered.
    *   - consignee_phone_number_1: Phone number of the receiver.
    *   - consignee_email_address: Email address of the coordinator for pickup 
    *   - item_product_type_id: Category of the item(s) in the order to be delivered.
    *   - item_description: Nature and details of the item(s) in the order to be delivered.
    *   - item_quantity: Number of item(s)
    *   - item_insurance: Provision to opt for insurance claim in case of loss of item.
    *   - pickup_date: Requested pickup date for the order.
    *   - estimated_weight: Estimated mass of the shipment.
    *   - shipping_mode_id: The method of shipping through which the shipment will be delivered.
    *   - amount: The amount to be collected at the time of delivery.
    *   - payment_mode_id: How the amount will be collected, either COD, card, or mobile wallet.
    *   - charges_mode_id: How the shipper would want TRAX to collect their service charges, either from the shipper or from their consignees via 2Pay option.
    *
    *   Optional
    *   - consignee_phone_number_2: Another phone number of the receiver.
    *   - order_id: Shipper's own reference ID 
    *   - item_price: Value of the item(s) in the order.
    *   - special_instructions: Any reference or remarks regarding the delivery.
    *   - same_day_timing_id: For same-day shipping mode, define the timeline in which the shipment will be delivered.
    *   - open_shipment: Customer allows opening the shipment at the time of delivery.
    *   - pieces_quantity: To book a shipment for multiple pieces.
    *   - shipper_reference_number_1: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_2: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_3: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_4: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_5: If the shipper wants to add any reference with respect to his shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function addRegularShipment(array $data)
    {
        $data['service_type_id'] = 1; //Regular Shipment
        $endpoint = '/api/shipment/book';
        $method = 'POST';
        return $this->traxClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Add a Replacement Shipment.
    *
    * @param array $data
    *   An associative array containing data for adding a replacement shipment.
    *   Mandatory
    *   - delivery_type_id: If you are using Corporate Invoicing Account. Please be informed that you have to provide the type of delivery (Door-Step/Hub to Hub). Define the type of delivery:  1 (Door Step), 2 (Hub to Hub).
    *   - service_type_id: Defines the service that you are going to use i.e., Regular Replacement, or Try & Buy.
    *   - pickup_address_id: The address from which the shipment will be picked.
    *   - information_display: Option to show or hide your contact details on the air waybill.
    *   - consignee_city_id: Float ID of the city where the shipment will be delivered.
    *   - consignee_name: Name of the receiver to whom the shipment will be delivered.
    *   - consignee_address: The address where the shipment will be delivered.
    *   - consignee_phone_number_1: Phone number of the receiver.
    *   - consignee_email_address: Email address of the coordinator for pickup 
    *   - item_product_type_id: Category of the item(s) in the order to be delivered.
    *   - item_description: Nature and details of the item(s) in the order to be delivered.
    *   - item_quantity: Number of item(s)
    *   - item_insurance: Provision to opt for insurance claim in case of loss of item.
    *   - replacement_item_product_type_id: Category of the item(s) in the order to be exchanged.
    *   - replacement_item_description: Nature and details of the item(s) in the order to be exchanged.
    *   - replacement_item_quantity: Number of item(s)
    *   - replacement_item_image: Add replacement image.
    *   - pickup_date: Requested pickup date for the order.
    *   - estimated_weight: Estimated mass of the shipment.
    *   - shipping_mode_id: The method of shipping through which the shipment will be delivered.
    *   - amount: The amount to be collected at the time of delivery.
    *   - payment_mode_id: How the amount will be collected, either COD, card, or mobile wallet.
    *   - charges_mode_id: How the shipper would want TRAX to collect their service charges, either from the shipper or from their consignees via 2Pay option.
    *
    *   Optional
    *   - consignee_phone_number_2: Another phone number of the receiver.
    *   - order_id: Shipper's own reference ID 
    *   - item_price: Value of the item(s) in the order.
    *   - special_instructions: Any reference or remarks regarding the delivery.
    *   - same_day_timing_id: For same-day shipping mode, define the timeline in which the shipment will be delivered.
    *   - open_shipment: Customer allows opening the shipment at the time of delivery.
    *   - pieces_quantity: To book a shipment for multiple pieces.
    *   - shipper_reference_number_1: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_2: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_3: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_4: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_5: If the shipper wants to add any reference with respect to his shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function addReplacementShipment(array $data)
    {
        $data['service_type_id'] = 2; //Replacement Shipment
        $endpoint = '/api/shipment/book';
        $method = 'POST';
        return $this->traxClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Add a Try And Buy Shipment.
    *
    * @param array $data
    *   An associative array containing data for adding a replacement shipment.
    *   Mandatory
    *   - delivery_type_id: If you are using Corporate Invoicing Account. Please be informed that you have to provide the type of delivery (Door-Step/Hub to Hub). Define the type of delivery:  1 (Door Step), 2 (Hub to Hub).
    *   - service_type_id: Defines the service that you are going to use i.e., Regular Replacement, or Try & Buy.
    *   - pickup_address_id: The address from which the shipment will be picked.
    *   - information_display: Option to show or hide your contact details on the air waybill.
    *   - consignee_city_id: Float ID of the city where the shipment will be delivered.
    *   - consignee_name: Name of the receiver to whom the shipment will be delivered.
    *   - consignee_address: The address where the shipment will be delivered.
    *   - consignee_phone_number_1: Phone number of the receiver.
    *   - consignee_email_address: Email address of the coordinator for pickup 
    *   - items[n][product_type_id]: Category of the item number "n" in the order to be delivered, where "n" is any number of items in a Try & Buy.
    *   - items[n][item_description]: Nature and details of the item number "n" in the order to be delivered.
    *   - items[n][item_quantity]: Number of item(s)
    *   - items[n][item_insurance]: Provision to opt for insurance claim in case of loss of item.
    *   - items[n][product_value]: Specify the value of each product.
    *   - items[n][item_price]: Value of the item number "n" in the order.
    *   - package_type: Defines whether the Try & Buy will be complete, i.e., all the items will be delivered or returned, or partial, i.e., some of the items will be delivered and the remaining will be returned.
    *   - try_and_buy_fees: Fees that will be charged to the consignee.
    *   - pickup_date: Requested pickup date for the order.
    *   - estimated_weight: Estimated mass of the shipment.
    *   - shipping_mode_id: The method of shipping through which the shipment will be delivered.
    *   - amount: The amount to be collected at the time of delivery.
    *   - payment_mode_id: How the amount will be collected, either COD, card, or mobile wallet.
    *   - charges_mode_id: How the shipper would want TRAX to collect their service charges, either from the shipper or from their consignees via 2Pay option.
    *
    *   Optional
    *   - consignee_phone_number_2: Another phone number of the receiver.
    *   - order_id: Shipper's own reference ID 
    *   - special_instructions: Any reference or remarks regarding the delivery.
    *   - same_day_timing_id: For same-day shipping mode, define the timeline in which the shipment will be delivered.
    *   - open_shipment: Customer allows opening the shipment at the time of delivery.
    *   - pieces_quantity: To book a shipment for multiple pieces.
    *   - shipper_reference_number_1: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_2: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_3: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_4: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_5: If the shipper wants to add any reference with respect to his shipment.
    *
    * @return array
    *   Decoded response data.
    */
    public function addTryAndBuyShipment(array $data)
    {
        $data['service_type_id'] = 3; //Try & Buy Shipment
        $endpoint = '/api/shipment/book';
        $method = 'POST';
        return $this->traxClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get Current Status of a Shipment.
    *
    * @param int $trackingNumber
    *   The number generated upon booking of the shipment.
    * @param int $type
    *   Defines the type of status tracking, either for shipper or general.
    *
    * @return array
    *   Decoded response data.
    */
    public function getShipmentStatus($trackingNumber, $type)
    {
        $this->validateShipmentStatusData($trackingNumber, $type);
        $endpoint = '/api/shipment/status';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
            'type' => $type,
        ];

        // Make the request
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }
    /**
    * Validate data for getting Shipment Status.
    *
    * @param int $trackingNumber
    *   The number generated upon booking of the shipment.
    * @param int $type
    *   Defines the type of status tracking, either for shipper or general.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateShipmentStatusData($trackingNumber, $type)
    {
        if (!is_numeric($trackingNumber) || !is_numeric($type) || !in_array($type, [0, 1])) {
            throw new TraxException('Invalid tracking_number or type for getting shipment status.');
        }
    }

    /**
     * Track a Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     * @param int $type
     *   Defines the type of status tracking, either for shipper or general.
     *
     * @return array
     *   Decoded response data.
     */
    public function trackShipment($trackingNumber, $type)
    {
        $this->validateShipmentTrackingData($trackingNumber, $type);
        $endpoint = '/api/shipment/track';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
            'type' => $type,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }

    /**
    * Validate data for tracking a Shipment.
    *
    * @param int $trackingNumber
    *   The number generated upon booking of the shipment.
    * @param int $type
    *   Defines the type of status tracking, either for shipper or general.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateShipmentTrackingData($trackingNumber, $type)
    {
        if (!is_numeric($trackingNumber) || !is_numeric($type) || !in_array($type, [0, 1])) {
            throw new TraxException('Invalid tracking_number or type for tracking a shipment.');
        }
    }

    /**
     * Get Charges of a Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @return array
     *   Decoded response data.
     */
    public function getShipmentCharges($trackingNumber)
    {
        $this->validateShipmentChargesData($trackingNumber);
        $endpoint = '/api/shipment/charges';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }

    /**
    * Validate data for getting Shipment Charges.
    *
    * @param int $trackingNumber
    *   The number generated upon booking of the shipment.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateShipmentChargesData($trackingNumber)
    {
        if (!is_numeric($trackingNumber)) {
            throw new TraxException('Invalid tracking_number for getting shipment charges.');
        }
    }

    /**
     * Get Payment Status of a Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @return array
     *   Decoded response data.
     */
    public function getPaymentStatus($trackingNumber)
    {
        $this->validatePaymentStatusData($trackingNumber);
        $endpoint = '/api/shipment/payment_status';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }

    /**
     * Validate data for getting Payment Status.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validatePaymentStatusData($trackingNumber)
    {
        if (!is_numeric($trackingNumber)) {
            throw new TraxException('Invalid Tracking_number for getting payment status.');
        }
    }

    /**
     * Get Invoice of a Shipment.
     *
     * @param int $id
     *   Invoice id and payment id.
     * @param int $type
     *   For Invoice 1 and for payment 2.
     *
     * @return array
     *   Decoded response data.
     */
    public function getInvoice($id, $type)
    {
        $this->validateInvoiceData($id, $type);
        $endpoint = '/api/invoice';
        $method = 'GET';
        $queryParams = [
            'id' => $id,
            'type' => $type,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }

    /**
    * Validate data for getting an Invoice.
    *
    * @param int $id
    *   Invoice id and payment id.
    * @param int $type
    *   For Invoice 1 and for payment 2.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateInvoiceData($id, $type)
    {
        if (!is_numeric($id) || !is_numeric($type) || !in_array($type, [1, 2])) {
            throw new TraxException('Invalid id or type for getting an invoice.');
        }
    }

     /**
     * Get Payment Details of a Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @return array
     *   Decoded response data.
     */
    public function getPaymentDetails($trackingNumber)
    {
        $this->validatePaymentDetailsData($trackingNumber);
        $endpoint = '/api/shipment/payments';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
    }

    /**
     * Validate data for getting Payment Details.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validatePaymentDetailsData($trackingNumber)
    {
        if (!is_numeric($trackingNumber)) {
            throw new TraxException('Invalid tracking_number for getting payment details.');
        }
    }

    /**
     * Print a Shipping Label and store the image locally.
     *
     * @param int $trackingNumber
     *   The tracking number of the shipment.
     * @param int $type
     *   Type of print, whether pdf or jpeg.
     *
     * @return string
     *   URL of the locally stored image.
     */
    public function printShippingLabel($trackingNumber, $type)
    {
        $this->validatePrintShippingLabelData($trackingNumber, $type);
        if($type == 0 || $type == 2){
            $return_type = 0;
        } else if ($type == 1 || $type == 3){
            $return_type = 1;
        }
        $endpoint = '/api/shipment/air_waybill';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
            'type' => $return_type,
        ];

        $responseContent = $this->traxClient->makeRequestFile($endpoint, $queryParams, $savePath = "");
        if($type == 0){
            header('Content-Type: image/jpeg');
            return $responseContent;
        } else if($type == 1){
            header('Content-Type: application/pdf');
            return $responseContent;
        } else if($type == 2){
            $file_url = $savePath . uniqid(mt_rand(), true) . ".jpeg";
        } else if($type == 3){
            $file_url = $savePath . uniqid(mt_rand(), true) . ".pdf";
        } 
        if(file_put_contents($file_url, $responseContent)){
            return array(
                "status" => 1,
                "filename" => $file_url
            );
        } else {
            throw new TraxException('Unable to save file: ' . error_get_last());
        }
    }

    /**
     * Validate data for printing Shipping Label.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     * @param int $type
     *   Type of print, whether pdf or jpeg (0 for jpeg, 1 for pdf).
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validatePrintShippingLabelData($trackingNumber, $type)
    {
        if (!is_numeric($trackingNumber) || !is_numeric($type) || !in_array($type, [0, 1,2,3])) {
            throw new TraxException('Invalid tracking_number or type for printing shipping label.');
        }
    }

    /**
     * Cancel a Booked Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @return array
     *   Decoded response data.
     */
    public function cancelShipment($trackingNumber)
    {
        $this->validateCancelShipmentData($trackingNumber);
        $endpoint = '/api/shipment/cancel';
        $method = 'POST';
        $postData = [
            'tracking_number' => $trackingNumber,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $postData);
    }

    /**
     * Validate data for canceling a booked Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validateCancelShipmentData($trackingNumber)
    {
        if (!is_numeric($trackingNumber)) {
            throw new TraxException('Invalid tracking_number for canceling a booked shipment.');
        }
    }

    /**
     * Calculate Rates for a Destination.
     *
     * @param int $serviceTypeId
     *   Defines the service that you are going to use i.e., Regular, Replacement, or Try & Buy.
     * @param int $originCityId
     *   Float ID of the city from where the shipment will be picked.
     * @param int $destinationCityId
     *   Float ID of the city from where the shipment will be picked.
     * @param float $estimatedWeight
     *   Estimated mass of the shipment.
     * @param int $shippingModeId
     *   The method of shipping through which the shipment will be delivered.
     * @param int $amount
     *   The amount to be collected at the time of delivery. Do not use commas or dots for this parameter.
     *
     * @return array
     *   Decoded response data.
     */
    public function calculateRates($serviceTypeId, $originCityId, $destinationCityId, $estimatedWeight, $shippingModeId, $amount)
    {
        $this->validateCalculateRatesData($serviceTypeId, $originCityId, $destinationCityId, $estimatedWeight, $shippingModeId, $amount);
        $endpoint = '/api/charges_calculate';
        $method = 'POST';
        $postData = [
            'service_type_id' => $serviceTypeId,
            'origin_city_id' => $originCityId,
            'destination_city_id' => $destinationCityId,
            'estimated_weight' => $estimatedWeight,
            'shipping_mode_id' => $shippingModeId,
            'amount' => $amount,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $postData);
    }

    /**
     * Validate data for calculating Rates.
     *
     * @param int $serviceTypeId
     *   Defines the service that you are going to use i.e., Regular, Replacement, or Try & Buy.
     * @param int $originCityId
     *   Float ID of the city from where the shipment will be picked.
     * @param int $destinationCityId
     *   Float ID of the city from where the shipment will be picked.
     * @param float $estimatedWeight
     *   Estimated mass of the shipment.
     * @param int $shippingModeId
     *   The method of shipping through which the shipment will be delivered.
     * @param int $amount
     *   The amount to be collected at the time of delivery.
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validateCalculateRatesData($serviceTypeId, $originCityId, $destinationCityId, $estimatedWeight, $shippingModeId, $amount)
    {
        if (!is_numeric($serviceTypeId) || !is_numeric($originCityId) || !is_numeric($destinationCityId)
            || !is_numeric($estimatedWeight) || !is_numeric($shippingModeId) || !is_numeric($amount)) {
            throw new TraxException('Invalid data for calculating rates.');
        }
    }

    /**
     * Create a Receiving Sheet.
     *
     * @param array $trackingNumbers
     *   An array of tracking numbers generated upon booking of the shipment.
     *
     * @return array
     *   Decoded response data.
     */
    public function createReceivingSheet(array $trackingNumbers)
    {
        $this->validateCreateReceivingSheetData($trackingNumbers);
        $endpoint = '/api/receiving_sheet/create';
        $method = 'POST';
        $postData = [
            'tracking_numbers' => $trackingNumbers,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $postData);
    }

    /**
     * Validate data for creating a Receiving Sheet.
     *
     * @param array $trackingNumbers
     *   An array of tracking numbers generated upon booking of the shipment.
     *
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validateCreateReceivingSheetData(array $trackingNumbers)
    {
        foreach ($trackingNumbers as $trackingNumber) {
            if (!is_numeric($trackingNumber)) {
                throw new TraxException('Invalid tracking number for creating a receiving sheet.');
            }
        }
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
    public function viewReceivingSheet($receivingSheetId, $type)
    {
        $this->validateViewReceivingSheetData($receivingSheetId, $type);

        if($type == 0 || $type == 2){
            $return_type = 0;
        } else if ($type == 1 || $type == 3){
            $return_type = 1;
        }
        $endpoint = '/api/receiving_sheet/view';
        $method = 'POST';
        $queryParams = [
            'receiving_sheet_id' => $receivingSheetId,
            'type' => $return_type,
        ];

        $responseContent = $this->traxClient->makeRequestFile($endpoint, $queryParams, $savePath = "");
        if($type == 0){
            header('Content-Type: image/jpeg');
            return $responseContent;
        } else if($type == 1){
            header('Content-Type: application/pdf');
            return $responseContent;
        } else if($type == 2){
            $file_url = $savePath . uniqid(mt_rand(), true) . ".jpeg";
        } else if($type == 3){
            $file_url = $savePath . uniqid(mt_rand(), true) . ".pdf";
        } 
        if(file_put_contents($file_url, $responseContent)){
            return array(
                "status" => 1,
                "filename" => $file_url
            );
        } else {
            throw new TraxException('Unable to save file: ' . error_get_last());
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
     * @throws TraxException
     *   If the data does not meet the required conditions.
     */
    private function validateViewReceivingSheetData($receivingSheetId, $type)
    {
        if (!is_numeric($receivingSheetId) || !is_numeric($type)) {
            throw new TraxException('Invalid data for viewing/printing a receiving sheet.');
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
    /**
    * Get Form Fields.
    *
    * @param array $config
    *   Configuration settings for form display.
    *   Regular
    *   Mandatory
    *   - delivery_type_id: If you are using Corporate Invoicing Account. Please be informed that you have to provide the type of delivery (Door-Step/Hub to Hub). Define the type of delivery:  1 (Door Step), 2 (Hub to Hub).
    *   - service_type_id: Defines the service that you are going to use i.e., Regular Replacement, or Try & Buy.
    *   - pickup_address_id: The address from which the shipment will be picked.
    *   - information_display: Option to show or hide your contact details on the air waybill.
    *   - consignee_city_id: Float ID of the city where the shipment will be delivered.
    *   - consignee_name: Name of the receiver to whom the shipment will be delivered.
    *   - consignee_address: The address where the shipment will be delivered.
    *   - consignee_phone_number_1: Phone number of the receiver.
    *   - consignee_email_address: Email address of the coordinator for pickup 
    *   - item_product_type_id: Category of the item(s) in the order to be delivered.
    *   - item_description: Nature and details of the item(s) in the order to be delivered.
    *   - item_quantity: Number of item(s)
    *   - item_insurance: Provision to opt for insurance claim in case of loss of item.
    *   - pickup_date: Requested pickup date for the order.
    *   - estimated_weight: Estimated mass of the shipment.
    *   - shipping_mode_id: The method of shipping through which the shipment will be delivered.
    *   - amount: The amount to be collected at the time of delivery.
    *   - payment_mode_id: How the amount will be collected, either COD, card, or mobile wallet.
    *   - charges_mode_id: How the shipper would want TRAX to collect their service charges, either from the shipper or from their consignees via 2Pay option.
    *
    *   Optional
    *   - consignee_phone_number_2: Another phone number of the receiver.
    *   - order_id: Shipper's own reference ID 
    *   - item_price: Value of the item(s) in the order.
    *   - special_instructions: Any reference or remarks regarding the delivery.
    *   - same_day_timing_id: For same-day shipping mode, define the timeline in which the shipment will be delivered.
    *   - open_shipment: Customer allows opening the shipment at the time of delivery.
    *   - pieces_quantity: To book a shipment for multiple pieces.
    *   - shipper_reference_number_1: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_2: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_3: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_4: If the shipper wants to add any reference with respect to his shipment.
    *   - shipper_reference_number_5: If the shipper wants to add any reference with respect to his shipment.
    *
    * @return array
    *   Decoded response data.
    */
    
    public function getFormFields($config)
    {
        if(!isset($config['type']) || !in_array($config['type'], ["regular", "replacement", "tryandbuy"])){
            throw new TraxException('Ivalid shipment type. Available: regular, replacement, tryandbuy');
        }
        if(!isset($config['response']) || !in_array($config['response'], ["form", "json"])){
            throw new TraxException('Ivalid response type. Available: form, json');
        }
        if(isset($config['cities'])){
            $cities = $config['cities'];
            $this->validateIdNameData($cities);
        } else {
            $cities = json_decode(file_get_contents(__DIR__ . '/' . 'cities.json'),true);
            foreach ($cities as &$item) {
                $item = ['value' => $item['id'], 'label' => $item['name']];
            }
        }
        $pickupAddressess = $this->listPickupAddresses()['pickup_addresses'];
        foreach ($pickupAddressess as &$item) {
            $item = ['value' => $item['id'], 'label' => $item['address']];
        }
        $appendixB = array(
            array(
                "label" => "Apparel",
                "value" => 1
            ),
            array(
                "label" => "Automotive Parts",
                "value" => 2
            ),
            array(
                "label" => "Accessories",
                "value" => 3
            ),
            array(
                "label" => "Personal Electronics (Mobile Phones, Laptops, etc.)",
                "value" => 4
            ),
            array(
                "label" => "Electronics Accessories (Cases, Chargers, etc.)",
                "value" => 5
            ),
            array(
                "label" => "Gadgets",
                "value" => 6
            ),
            array(
                "label" => "Jewellery",
                "value" => 7
            ),
            array(
                "label" => "Cosmetics",
                "value" => 8
            ),
            array(
                "label" => "Stationery",
                "value" => 9
            ),
            array(
                "label" => "Handicrafts",
                "value" => 10
            ),
            array(
                "label" => "Home-made Items",
                "value" => 11
            ),
            array(
                "label" => "Footwear",
                "value" => 12
            ),
            array(
                "label" => "Watches",
                "value" => 13
            ),
            array(
                "label" => "Leather Items",
                "value" => 14
            ),
            array(
                "label" => "Organic and Health Products",
                "value" => 15
            ),
            array(
                "label" => "Appliances and Consumer Electronics",
                "value" => 16
            ),
            array(
                "label" => "Home Decor and Interior Items",
                "value" => 17
            ),
            array(
                "label" => "Toys",
                "value" => 18
            ),
            array(
                "label" => "Pet Supplies",
                "value" => 19
            ),
            array(
                "label" => "Athletics and Fitness Items",
                "value" => 20
            ),
            array(
                "label" => "Vouchers and Coupons",
                "value" => 21
            ),
            array(
                "label" => "Marketplace",
                "value" => 22
            ),
            array(
                "label" => "Documents and Letters",
                "value" => 23
            ),
            array(
                "label" => "Other",
                "value" => 24
            ),
        );
        $appendixG =  array(
            array(
                "label" => "Door Step",
                "value" => 1
            ),
            array(
                "label" => "Hub to Hub",
                "value" => 2
            ),
        );
        $appendixC =  array(
            array(
                "label" => "Rush",
                "value" => 1
            ),
            array(
                "label" => "Saver Plus",
                "value" => 2
            ),
            array(
                "label" => "Swift",
                "value" => 3
            ),
            array(
                "label" => "Same Day",
                "value" => 4
            ),
        );
        $appendixD =  array(
            array(
                "label" => "Cash on Delivery",
                "value" => 1
            ),
            array(
                "label" => "CCD",
                "value" => 2
            ),
            array(
                "label" => "Prepaid",
                "value" => 4
            ),
        );
        $appendixF =  array(
            array(
                "label" => "Invoicing",
                "value" => 3
            ),
            array(
                "label" => "Reimbursement",
                "value" => 4
            ),
        );
        
        if($config['type'] == "regular"){
            $form_fields = array(
                array(
                    "name" => "delivery_type_id",
                    "field_type" => "required",
                    "classes" => isset($config['delivery_type_id-class']) ? $config['delivery_type_id-class'] : "",
                    "attr" => isset($config['delivery_type_id-attr']) ? $config['delivery_type_id-attr'] : "",
                    "wrapper" => isset($config['delivery_type_id-wrapper']) ? $config['delivery_type_id-wrapper'] : "",
                    "label" => isset($config['delivery_type_id-label']) ? $config['delivery_type_id-label'] : "Delivery Type",
                    "type" => "select",
                    "default" => isset($config['delivery_type_id']) && in_array($config['delivery_type_id'], array_column($appendixG, "label")) ? $config['delivery_type_id'] : 1,
                    "options" => $appendixG
                ),
                array(
                    "name" => "pickup_address_id",
                    "field_type" => "required",
                    "classes" => isset($config['pickup_address_id-class']) ? $config['pickup_address_id-class'] : "",
                    "attr" => isset($config['pickup_address_id-attr']) ? $config['pickup_address_id-attr'] : "",
                    "wrapper" => isset($config['pickup_address_id-wrapper']) ? $config['pickup_address_id-wrapper'] : "",
                    "label" => isset($config['pickup_address_id-label']) ? $config['pickup_address_id-label'] : "Pickup Location",
                    "type" => "select",
                    "default" => isset($config['pickup_address_id']) && in_array($config['pickup_address_id'], array_column($pickupAddressess, "label")) ? $config['pickup_address_id'] : $pickupAddressess[0]['value'],
                    "options" => $pickupAddressess
                ),
                array(
                    "name" => "information_display",
                    "field_type" => "required",
                    "classes" => isset($config['information_display-class']) ? $config['information_display-class'] : "",
                    "attr" => isset($config['information_display-attr']) ? $config['information_display-attr'] : "",
                    "wrapper" => isset($config['information_display-wrapper']) ? $config['information_display-wrapper'] : "",
                    "label" => isset($config['information_display-label']) ? $config['information_display-label'] : "Airway Bill Contact Details",
                    "type" => "select",
                    "default" => isset($config['information_display']) && in_array($config['information_display'], [1,0]) ? $config['information_display'] : 1,
                    "options" => array(
                        array(
                            "label" => "Displayed",
                            "value" => 1
                        ),
                        array(
                            "label" => "Hidden",
                            "value" => 0
                        ),
                    )
                ),
                array(
                    "name" => "consignee_city_id",
                    "field_type" => "required",
                    "classes" => isset($config['consignee_city_id-class']) ? $config['consignee_city_id-class'] : "",
                    "attr" => isset($config['consignee_city_id-attr']) ? $config['consignee_city_id-attr'] : "",
                    "wrapper" => isset($config['consignee_city_id-wrapper']) ? $config['consignee_city_id-wrapper'] : "",
                    "label" => isset($config['consignee_city_id-label']) ? $config['consignee_city_id-label'] : "Consignee City",
                    "type" => "select",
                    "default" => isset($config['consignee_city_id']) && in_array($config['consignee_city_id'], array_column($cities, "id")) ? $config['consignee_city_id'] : 223,
                    "options" => $cities
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
                    "name" => "consignee_phone_number_1",
                    "field_type" => "required",
                    "classes" => isset($config['consignee_phone_number_1-class']) ? $config['consignee_phone_number_1-class'] : "",
                    "attr" => isset($config['consignee_phone_number_1-attr']) ? $config['consignee_phone_number_1-attr'] : "",
                    "wrapper" => isset($config['consignee_phone_number_1-wrapper']) ? $config['consignee_phone_number_1-wrapper'] : "",
                    "label" => isset($config['consignee_phone_number_1-label']) ? $config['consignee_phone_number_1-label'] : "Consignee Phone",
                    "type" => "phone",
                    "default" => isset($config['consignee_phone_number_1']) ? $config['consignee_phone_number_1'] : "",
                ),
                array(
                    "name" => "consignee_email_address",
                    "field_type" => "required",
                    "classes" => isset($config['consignee_email_address-class']) ? $config['consignee_email_address-class'] : "",
                    "attr" => isset($config['consignee_email_address-attr']) ? $config['consignee_email_address-attr'] : "",
                    "wrapper" => isset($config['consignee_email_address-wrapper']) ? $config['consignee_email_address-wrapper'] : "",
                    "label" => isset($config['consignee_email_address-label']) ? $config['consignee_email_address-label'] : "Consignee Email",
                    "type" => "email",
                    "default" => isset($config['consignee_email_address']) ? $config['consignee_email_address'] : "",
                ),
                array(
                    "name" => "item_product_type_id",
                    "field_type" => "required",
                    "classes" => isset($config['item_product_type_id-class']) ? $config['item_product_type_id-class'] : "",
                    "attr" => isset($config['item_product_type_id-attr']) ? $config['item_product_type_id-attr'] : "",
                    "wrapper" => isset($config['item_product_type_id-wrapper']) ? $config['item_product_type_id-wrapper'] : "",
                    "label" => isset($config['item_product_type_id-label']) ? $config['item_product_type_id-label'] : "Product Type",
                    "type" => "select",
                    "default" => isset($config['item_product_type_id']) && in_array($config['item_product_type_id'], array_column($appendixB, "label")) ? $config['item_product_type_id'] : 22,
                    "options" => $appendixB
                ),
                array(
                    "name" => "item_description",
                    "field_type" => "required",
                    "classes" => isset($config['item_description-class']) ? $config['item_description-class'] : "",
                    "attr" => isset($config['item_description-attr']) ? $config['item_description-attr'] : "",
                    "wrapper" => isset($config['item_description-wrapper']) ? $config['item_description-wrapper'] : "",
                    "label" => isset($config['item_description-label']) ? $config['item_description-label'] : "Item Description",
                    "type" => "text",
                    "default" => isset($config['item_description']) ? $config['item_description'] : "",
                ),
                array(
                    "name" => "item_quantity",
                    "field_type" => "required",
                    "classes" => isset($config['item_quantity-class']) ? $config['item_quantity-class'] : "",
                    "attr" => isset($config['item_quantity-attr']) ? $config['item_quantity-attr'] : "",
                    "wrapper" => isset($config['item_quantity-wrapper']) ? $config['item_quantity-wrapper'] : "",
                    "label" => isset($config['item_quantity-label']) ? $config['item_quantity-label'] : "Number of Items",
                    "type" => "number",
                    "default" => isset($config['item_quantity']) ? $config['item_quantity'] : "",
                ),
                array(
                    "name" => "item_insurance",
                    "field_type" => "required",
                    "classes" => isset($config['item_insurance-class']) ? $config['item_insurance-class'] : "",
                    "attr" => isset($config['item_insurance-attr']) ? $config['item_insurance-attr'] : "",
                    "wrapper" => isset($config['item_insurance-wrapper']) ? $config['item_insurance-wrapper'] : "",
                    "label" => isset($config['item_insurance-label']) ? $config['item_insurance-label'] : "Insurance Type",
                    "type" => "select",
                    "default" => isset($config['item_insurance']) && in_array($config['item_insurance'], [1,0]) ? $config['item_insurance'] : 0,
                    "options" => array(
                        array(
                            "label" => "Insured",
                            "value" => 1
                        ),
                        array(
                            "label" => "No Insurance",
                            "value" => 0
                        ),
                    )
                ),
                array(
                    "name" => "pickup_date",
                    "field_type" => "required",
                    "classes" => isset($config['pickup_date-class']) ? $config['pickup_date-class'] : "",
                    "attr" => isset($config['pickup_date-attr']) ? $config['pickup_date-attr'] : "",
                    "wrapper" => isset($config['pickup_date-wrapper']) ? $config['pickup_date-wrapper'] : "",
                    "label" => isset($config['pickup_date-label']) ? $config['pickup_date-label'] : "Pickup Date",
                    "type" => "date",
                    "default" => isset($config['pickup_date']) ? $config['pickup_date'] : "",
                ),
                array(
                    "name" => "estimated_weight",
                    "field_type" => "required",
                    "classes" => isset($config['estimated_weight-class']) ? $config['estimated_weight-class'] : "",
                    "attr" => isset($config['estimated_weight-attr']) ? $config['estimated_weight-attr'] : "",
                    "wrapper" => isset($config['estimated_weight-wrapper']) ? $config['estimated_weight-wrapper'] : "",
                    "label" => isset($config['estimated_weight-label']) ? $config['estimated_weight-label'] : "Estimated Weight",
                    "type" => "number",
                    "default" => isset($config['estimated_weight']) ? $config['estimated_weight'] : "",
                ),
                array(
                    "name" => "shipping_mode_id",
                    "field_type" => "required",
                    "classes" => isset($config['shipping_mode_id-class']) ? $config['shipping_mode_id-class'] : "",
                    "attr" => isset($config['shipping_mode_id-attr']) ? $config['shipping_mode_id-attr'] : "",
                    "wrapper" => isset($config['shipping_mode_id-wrapper']) ? $config['shipping_mode_id-wrapper'] : "",
                    "label" => isset($config['shipping_mode_id-label']) ? $config['shipping_mode_id-label'] : "Shipping Mode",
                    "type" => "select",
                    "default" => isset($config['shipping_mode_id']) && in_array($config['shipping_mode_id'], array_column($appendixC, "label")) ? $config['shipping_mode_id'] : 1,
                    "options" => $appendixC
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
                    "name" => "payment_mode_id",
                    "field_type" => "required",
                    "classes" => isset($config['payment_mode_id-class']) ? $config['payment_mode_id-class'] : "",
                    "attr" => isset($config['payment_mode_id-attr']) ? $config['payment_mode_id-attr'] : "",
                    "wrapper" => isset($config['payment_mode_id-wrapper']) ? $config['payment_mode_id-wrapper'] : "",
                    "label" => isset($config['payment_mode_id-label']) ? $config['payment_mode_id-label'] : "Payment Mode",
                    "type" => "select",
                    "default" => isset($config['payment_mode_id']) && in_array($config['payment_mode_id'], array_column($appendixD, "label")) ? $config['payment_mode_id'] : 1,
                    "options" => $appendixD
                ),
                array(
                    "name" => "charges_mode_id",
                    "field_type" => "required",
                    "classes" => isset($config['charges_mode_id-class']) ? $config['charges_mode_id-class'] : "",
                    "attr" => isset($config['charges_mode_id-attr']) ? $config['charges_mode_id-attr'] : "",
                    "wrapper" => isset($config['charges_mode_id-wrapper']) ? $config['charges_mode_id-wrapper'] : "",
                    "label" => isset($config['charges_mode_id-label']) ? $config['charges_mode_id-label'] : "Charges Mode",
                    "type" => "select",
                    "default" => isset($config['charges_mode_id']) && in_array($config['charges_mode_id'], array_column($appendixF, "label")) ? $config['charges_mode_id'] : 3,
                    "options" => $appendixF
                ),
            );
        }
        if($config['response'] == "form"){
            return $this->getForm($form_fields, $config);
        } else {
            return $form_fields;
        }
    }
    public function getForm($form_fields, $config){
        $form_html = "";
        $label_class = isset($config['label_class']) ? $config['label_class'] : "";
        foreach($form_fields as $field){
            if(isset($config['wrappers'][$field['name']]['input_wrapper_start'])){
                $form_html .= $config['wrappers'][$field['name']]['input_wrapper_start'];
            }
            $form_html .= '<label class="' . $label_class . '" for="' . $field['name'] . '">' . $field['label'] . '</label>';
            $wrapper_data = "name='" . $field['name'] . "' " . " class='" . $field['classes'] . "' " . $field['attr'] . " " . $field['field_type'] . " placeholder='" . $field['label'] . "'";
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
                $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . '></' . $wrapper . ' value = "' . $field['default'] . '">';
            } else if($field['type'] == "phone"){
                $wrapper = "input";
                if($field['wrapper'] != ""){
                    $wrapper = $field['wrapper'];
                }
                $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . '></' . $wrapper . ' ' . $field['default'] . '>';
            } else if($field['type'] == "email"){
                $wrapper = "input";
                if($field['wrapper'] != ""){
                    $wrapper = $field['wrapper'];
                }
                $form_html .= '<' . $wrapper . ' type = "email" ' . $wrapper_data . '></' . $wrapper . ' ' . $field['default'] . '>';
            } else if($field['type'] == "number"){
                $wrapper = "input";
                if($field['wrapper'] != ""){
                    $wrapper = $field['wrapper'];
                }
                $form_html .= '<' . $wrapper . ' type = "number" ' . $wrapper_data . '></' . $wrapper . ' ' . $field['default'] . '>';
            } else if($field['type'] == "date"){
                $wrapper = "input";
                if($field['wrapper'] != ""){
                    $wrapper = $field['wrapper'];
                }
                $form_html .= '<' . $wrapper . ' type = "date" ' . $wrapper_data . '></' . $wrapper . ' ' . $field['default'] . '>';
            }
            if(isset($config['wrappers'][$field['name']]['input_wrapper_end'])){
                $form_html .= $config['wrappers'][$field['name']]['input_wrapper_end'];
            }
        }
        return $form_html;
    }
}
