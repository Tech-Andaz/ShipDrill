<?php

namespace TechAndaz\Trax;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

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
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($data['phone_number'], 'PK'); // Assuming Pakistani numbers
            if (!$phoneUtil->isValidNumber($phoneNumber)) {
                throw new TraxException('Invalid phone number.');
            }
        } catch (\giggsey\libphonenumber\NumberParseException $e) {
            throw new TraxException('Error parsing phone number: ' . $e->getMessage());
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
        $this->validateShipmentNumbers($data);
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
        $this->validateShipmentNumbers($data);
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
    *   - try_and_buy_fess: Fees that will be charged to the consignee.
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
        $this->validateShipmentNumbers($data);
        $endpoint = '/api/shipment/book';
        $method = 'POST';
        return $this->traxClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Validate data for shipments.
    *
    * @param array $data
    *   An associative array containing data for shipments.
    *
    * @throws TraxException
    *   If the data does not meet the required conditions.
    */
    private function validateShipmentNumbers(array $data)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        
        if(!isset($data['consignee_phone_number_1']) || $data['consignee_phone_number_1'] != ""){
            throw new TraxException('Invalid phone number.');
        }
        try {
            $phoneNumber = $phoneUtil->parse($data['consignee_phone_number_1'], 'PK'); // Assuming Pakistani numbers
            if (!$phoneUtil->isValidNumber($phoneNumber)) {
                throw new TraxException('Invalid phone number.');
            }
        } catch (\giggsey\libphonenumber\NumberParseException $e) {
            throw new TraxException('Error parsing phone number: ' . $e->getMessage());
        }
        if(isset($data['consignee_phone_number_2']) && $data['consignee_phone_number_2'] != ""){
            try {
                $phoneNumber = $phoneUtil->parse($data['consignee_phone_number_2'], 'PK'); // Assuming Pakistani numbers
                if (!$phoneUtil->isValidNumber($phoneNumber)) {
                    throw new TraxException('Invalid phone number.');
                }
            } catch (\giggsey\libphonenumber\NumberParseException $e) {
                throw new TraxException('Error parsing phone number: ' . $e->getMessage());
            }
        }
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
            'Tracking_number' => $trackingNumber,
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
     * Print Shipping Label of a Shipment.
     *
     * @param int $trackingNumber
     *   The number generated upon booking of the shipment.
     * @param int $type
     *   Type of print, whether pdf or jpeg (for jpeg, enter type=0, for pdf enter type=1).
     *
     * @return array
     *   Decoded response data.
     */
    public function printShippingLabel($trackingNumber, $type)
    {
        $this->validatePrintShippingLabelData($trackingNumber, $type);
        $endpoint = '/api/shipment/air_waybill';
        $method = 'GET';
        $queryParams = [
            'tracking_number' => $trackingNumber,
            'type' => $type,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $queryParams);
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
        if (!is_numeric($trackingNumber) || !is_numeric($type) || !in_array($type, [0, 1])) {
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
        $endpoint = '/api/receiving_sheet/view';
        $method = 'POST';
        $postData = [
            'receiving_sheet_id' => $receivingSheetId,
            'type' => $type,
        ];
        return $this->traxClient->makeRequest($endpoint, $method, [], $postData);
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
}
