<?php

namespace TechAndaz\PandaGo;

class PandaGoAPI
{
    private $PandaGoClient;

    public function __construct(PandaGoClient $PandaGoClient)
    {
        $this->PandaGoClient = $PandaGoClient;
    }

    /**
    * Submit a New Order
    *
    * @param array $data
    *   An associative array containing data for submitting a new order.
    *
    * @return array
    *   Decoded response data.
    */
    public function submitOrder(array $data)
    {
        $endpoint = 'orders';
        $method = 'POST';
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Get a Specific Order
    *
    * @param string $order_id
    *   The order id.
    *
    * @return array
    *   Decoded response data.
    */
    public function fetchOrder(string $order_id)
    {
        
        $endpoint = 'orders/' . $order_id;
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, []);
    }

    /**
    * Cancel a Specific Order
    *
    * @param string $order_id
    *   The order id.
    * @param string $reason
    *   The reason for cancelling the order.
    *
    * @return array
    *   Decoded response data.
    */
    public function cancelOrder(string $order_id, string $reason)
    {
        
        $endpoint = 'orders/' . $order_id;
        $method = 'DELETE';
        $data = array(
            "reason" => $reason
        );
        $reasons_list = array("DELIVERY_ETA_TOO_LONG", "MISTAKE_ERROR", "REASON_UNKNOWN");
        if(!in_array($reason, $reasons_list)){
            return array(
                "status" => 0,
                "error" => "Not a valid reason. Valid reasons are: " . implode(", " , $reasons_list)
            );
        }
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Update a Specific Order
    *
    * @param string $order_id
    *   The order id.
    * @param array $data
    *   An associative array containing updated data.
    *
    * @return array
    *   Decoded response data.
    */
    public function updateOrder(string $order_id, array $data)
    {
        
        $endpoint = 'orders/' . $order_id;
        $method = 'PUT';
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Proof of Pickup
    *
    * @param string $order_id
    *   The order id.
    *
    * @return array
    *   Decoded response data.
    */
    public function proofOfPickup(string $order_id)
    {
        
        $endpoint = 'orders/proof_of_pickup/' . $order_id;
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, []);
    }

    /**
    * Proof of Delivery
    *
    * @param string $order_id
    *   The order id.
    *
    * @return array
    *   Decoded response data.
    */
    public function proofOfDelivery(string $order_id)
    {
        
        $endpoint = 'orders/proof_of_delivery/' . $order_id;
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, []);
    }

    /**
    * Proof of Return
    *
    * @param string $order_id
    *   The order id.
    *
    * @return array
    *   Decoded response data.
    */
    public function proofOfReturn(string $order_id)
    {
        
        $endpoint = 'orders/proof_of_return/' . $order_id;
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, []);
    }

    /**
    * Get Rider's current location
    *
    * @param string $order_id
    *   The order id.
    *
    * @return array
    *   Decoded response data.
    */
    public function getRiderCoordinates(string $order_id)
    {
        
        $endpoint = 'orders/' . $order_id . "/coordinates";
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, []);
    }

    /**
    * Estimate Order Delivery Fees
    *
    * @param array $data
    *   An associative array containing data for estimate.
    *
    * @return array
    *   Decoded response data.
    */
    public function estimateDeliveryFees(array $data)
    {
        $endpoint = 'orders/fee';
        $method = 'POST';
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }
    
    /**
    * Estimate Order Delivery Time
    *
    * @param array $data
    *   An associative array containing data for estimate.
    *
    * @return array
    *   Decoded response data.
    */
    public function estimateDeliveryTime(array $data)
    {
        $endpoint = 'orders/time';
        $method = 'POST';
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }

    /**
    * Create an Outlet
    *
    * @param string $outlet_id
    *   The new or existing outlet id.
    * @param array $data
    *   An associative array containing data for outlet.
    *
    * @return array
    *   Decoded response data.
    */
    public function createUpdateOutlet(string $outlet_id, array $data)
    {
        $endpoint = 'outlets/' . $outlet_id;
        $method = 'PUT';
        return $this->PandaGoClient->makeRequest($endpoint, $method, $data);
    }

    
    /**
    * Get an Outlet
    *
    * @param string $outlet_id
    *   The existing outlet id.
    *
    * @return array
    *   Decoded response data.
    */
    public function getOutlet(string $outlet_id)
    {
        $endpoint = 'outlets/' . $outlet_id;
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, array());
    }
    
    /**
    * Get all Outlets
    *
    * @return array
    *   Decoded response data.
    */
    public function getAllOutlets()
    {
        $endpoint = 'outletList';
        $method = 'GET';
        return $this->PandaGoClient->makeRequest($endpoint, $method, array());
    }

    /**
    * Get Form Fields
    *
    * @return array
    *   Decoded response data.
    */
    public function getFormFields($config)
    {
        if(!isset($config['sender_type']) || !in_array($config['sender_type'], ["sender_details", "sender_outlet"])){
            throw new PandaGoException('Ivalid sender type. Available: sender_details, sender_outlet');
        }
        if(!isset($config['response']) || !in_array($config['response'], ["form", "json"])){
            throw new PandaGoException('Ivalid response type. Available: form, json');
        }
        if(!isset($config['optional'])){
            $config['optional'] = false;
        }
        $vendor_outlets = array();
        if(isset($config['sender[client_vendor_id]-custom_options']) && is_array($config['sender[client_vendor_id]-custom_options']) && count($config['sender[client_vendor_id]-custom_options']) > 0){
            $vendor_outlets = $config['sender[client_vendor_id]-custom_options'];
        } else {
            $vendor_outlets_temp = $this->getAllOutlets()['response'];
            foreach ($vendor_outlets_temp as $item) {
                array_push($vendor_outlets,array(
                    "value" => $item['client_vendor_id'],
                    "label" => $item['name'],
                ));
            }
        }
        
        $payment_methods =  array(
            array(
                "label" => "Cash on Delivery",
                "value" => "CASH_ON_DELIVERY"
            ),
            array(
                "label" => "Paid",
                "value" => "PAID"
            ),
        );
        $coldbag =  array(
            array(
                "label" => "Not Required",
                "value" => false
            ),
            array(
                "label" => "Required",
                "value" => true
            ),
        );
        $age_verification =  array(
            array(
                "label" => "Not Required",
                "value" => false
            ),
            array(
                "label" => "Required",
                "value" => true
            ),
        );
        if($config['sender_type'] == "sender_details"){
            $form_fields = array(
                array(
                    "name" => "sender[name]",
                    "field_type" => "optional",
                    "classes" => isset($config['sender[name]-class']) ? $config['sender[name]-class'] : "",
                    "attr" => isset($config['sender[name]-attr']) ? $config['sender[name]-attr'] : "",
                    "wrapper" => isset($config['sender[name]-wrapper']) ? $config['sender[name]-wrapper'] : "",
                    "label" => isset($config['sender[name]-label']) ? $config['sender[name]-label'] : "Sender Name",
                    "type" => "text",
                    "default" => isset($config['sender[name]']) ? $config['sender[name]'] : "",
                ),
                array(
                    "name" => "sender[phone_number]",
                    "field_type" => "optional",
                    "classes" => isset($config['sender[phone_number]-class']) ? $config['sender[phone_number]-class'] : "",
                    "attr" => isset($config['sender[phone_number]-attr']) ? $config['sender[phone_number]-attr'] : "",
                    "wrapper" => isset($config['sender[phone_number]-wrapper']) ? $config['sender[phone_number]-wrapper'] : "",
                    "label" => isset($config['sender[phone_number]-label']) ? $config['sender[phone_number]-label'] : "Sender Phone Number",
                    "type" => "phone",
                    "default" => isset($config['sender[phone_number]']) ? $config['sender[phone_number]'] : "",
                ),
                array(
                    "name" => "sender[location][address]",
                    "field_type" => "required",
                    "classes" => isset($config['sender[location][address]-class']) ? $config['sender[location][address]-class'] : "",
                    "attr" => isset($config['sender[location][address]-attr']) ? $config['sender[location][address]-attr'] : "",
                    "wrapper" => isset($config['sender[location][address]-wrapper']) ? $config['sender[location][address]-wrapper'] : "",
                    "label" => isset($config['sender[location][address]-label']) ? $config['sender[location][address]-label'] : "Sender Address",
                    "type" => "text",
                    "default" => isset($config['sender[location][address]']) ? $config['sender[location][address]'] : "",
                ),
                array(
                    "name" => "sender[location][latitude]",
                    "field_type" => "required",
                    "classes" => isset($config['sender[location][latitude]-class']) ? $config['sender[location][latitude]-class'] : "",
                    "attr" => isset($config['sender[location][latitude]-attr']) ? $config['sender[location][latitude]-attr'] : "",
                    "wrapper" => isset($config['sender[location][latitude]-wrapper']) ? $config['sender[location][latitude]-wrapper'] : "",
                    "label" => isset($config['sender[location][latitude]-label']) ? $config['sender[location][latitude]-label'] : "Sender Latitude",
                    "type" => "number",
                    "default" => isset($config['sender[location][latitude]']) ? $config['sender[location][latitude]'] : "",
                ),
                array(
                    "name" => "sender[location][longitude]",
                    "field_type" => "required",
                    "classes" => isset($config['sender[location][longitude]-class']) ? $config['sender[location][longitude]-class'] : "",
                    "attr" => isset($config['sender[location][longitude]-attr']) ? $config['sender[location][longitude]-attr'] : "",
                    "wrapper" => isset($config['sender[location][longitude]-wrapper']) ? $config['sender[location][longitude]-wrapper'] : "",
                    "label" => isset($config['sender[location][longitude]-label']) ? $config['sender[location][longitude]-label'] : "Sender Longitude",
                    "type" => "number",
                    "default" => isset($config['sender[location][longitude]']) ? $config['sender[location][longitude]'] : "",
                ),
                array(
                    "name" => "sender[location][postalcode]",
                    "field_type" => "optional",
                    "classes" => isset($config['sender[location][postalcode]-class']) ? $config['sender[location][postalcode]-class'] : "",
                    "attr" => isset($config['sender[location][postalcode]-attr']) ? $config['sender[location][postalcode]-attr'] : "",
                    "wrapper" => isset($config['sender[location][postalcode]-wrapper']) ? $config['sender[location][postalcode]-wrapper'] : "",
                    "label" => isset($config['sender[location][postalcode]-label']) ? $config['sender[location][postalcode]-label'] : "Sender Postal Code",
                    "type" => "text",
                    "default" => isset($config['sender[location][postalcode]']) ? $config['sender[location][postalcode]'] : "",
                ),
                array(
                    "name" => "sender[notes]",
                    "field_type" => "optional",
                    "classes" => isset($config['sender[notes]-class']) ? $config['sender[notes]-class'] : "",
                    "attr" => isset($config['sender[notes]-attr']) ? $config['sender[notes]-attr'] : "",
                    "wrapper" => isset($config['sender[notes]-wrapper']) ? $config['sender[notes]-wrapper'] : "",
                    "label" => isset($config['sender[notes]-label']) ? $config['sender[notes]-label'] : "Sender Notes",
                    "type" => "text",
                    "default" => isset($config['sender[notes]']) ? $config['sender[notes]'] : "",
                ),
                array(
                    "name" => "recipient[name]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[name]-class']) ? $config['recipient[name]-class'] : "",
                    "attr" => isset($config['recipient[name]-attr']) ? $config['recipient[name]-attr'] : "",
                    "wrapper" => isset($config['recipient[name]-wrapper']) ? $config['recipient[name]-wrapper'] : "",
                    "label" => isset($config['recipient[name]-label']) ? $config['recipient[name]-label'] : "Recipient Name",
                    "type" => "text",
                    "default" => isset($config['recipient[name]']) ? $config['recipient[name]'] : "",
                ),
                array(
                    "name" => "recipient[phone_number]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[phone_number]-class']) ? $config['recipient[phone_number]-class'] : "",
                    "attr" => isset($config['recipient[phone_number]-attr']) ? $config['recipient[phone_number]-attr'] : "",
                    "wrapper" => isset($config['recipient[phone_number]-wrapper']) ? $config['recipient[phone_number]-wrapper'] : "",
                    "label" => isset($config['recipient[phone_number]-label']) ? $config['recipient[phone_number]-label'] : "Recipient Phone Number",
                    "type" => "phone",
                    "default" => isset($config['recipient[phone_number]']) ? $config['recipient[phone_number]'] : "",
                ),
                array(
                    "name" => "recipient[location][address]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][address]-class']) ? $config['recipient[location][address]-class'] : "",
                    "attr" => isset($config['recipient[location][address]-attr']) ? $config['recipient[location][address]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][address]-wrapper']) ? $config['recipient[location][address]-wrapper'] : "",
                    "label" => isset($config['recipient[location][address]-label']) ? $config['recipient[location][address]-label'] : "Recipient Address",
                    "type" => "text",
                    "default" => isset($config['recipient[location][address]']) ? $config['recipient[location][address]'] : "",
                ),
                array(
                    "name" => "recipient[location][latitude]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][latitude]-class']) ? $config['recipient[location][latitude]-class'] : "",
                    "attr" => isset($config['recipient[location][latitude]-attr']) ? $config['recipient[location][latitude]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][latitude]-wrapper']) ? $config['recipient[location][latitude]-wrapper'] : "",
                    "label" => isset($config['recipient[location][latitude]-label']) ? $config['recipient[location][latitude]-label'] : "Recipient Latitude",
                    "type" => "number",
                    "default" => isset($config['recipient[location][latitude]']) ? $config['recipient[location][latitude]'] : "",
                ),
                array(
                    "name" => "recipient[location][longitude]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][longitude]-class']) ? $config['recipient[location][longitude]-class'] : "",
                    "attr" => isset($config['recipient[location][longitude]-attr']) ? $config['recipient[location][longitude]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][longitude]-wrapper']) ? $config['recipient[location][longitude]-wrapper'] : "",
                    "label" => isset($config['recipient[location][longitude]-label']) ? $config['recipient[location][longitude]-label'] : "Recipient Longitude",
                    "type" => "number",
                    "default" => isset($config['recipient[location][longitude]']) ? $config['recipient[location][longitude]'] : "",
                ),
                array(
                    "name" => "recipient[location][postalcode]",
                    "field_type" => "optional",
                    "classes" => isset($config['recipient[location][postalcode]-class']) ? $config['recipient[location][postalcode]-class'] : "",
                    "attr" => isset($config['recipient[location][postalcode]-attr']) ? $config['recipient[location][postalcode]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][postalcode]-wrapper']) ? $config['recipient[location][postalcode]-wrapper'] : "",
                    "label" => isset($config['recipient[location][postalcode]-label']) ? $config['recipient[location][postalcode]-label'] : "Recipient Postal Code",
                    "type" => "text",
                    "default" => isset($config['recipient[location][postalcode]']) ? $config['recipient[location][postalcode]'] : "",
                ),
                array(
                    "name" => "recipient[notes]",
                    "field_type" => "optional",
                    "classes" => isset($config['recipient[notes]-class']) ? $config['recipient[notes]-class'] : "",
                    "attr" => isset($config['recipient[notes]-attr']) ? $config['recipient[notes]-attr'] : "",
                    "wrapper" => isset($config['recipient[notes]-wrapper']) ? $config['recipient[notes]-wrapper'] : "",
                    "label" => isset($config['recipient[notes]-label']) ? $config['recipient[notes]-label'] : "Recipient Notes",
                    "type" => "text",
                    "default" => isset($config['recipient[notes]']) ? $config['recipient[notes]'] : "",
                ),
                array(
                    "name" => "payment_method",
                    "field_type" => "required",
                    "classes" => isset($config['payment_method-class']) ? $config['payment_method-class'] : "",
                    "attr" => isset($config['payment_method-attr']) ? $config['payment_method-attr'] : "",
                    "wrapper" => isset($config['payment_method-wrapper']) ? $config['payment_method-wrapper'] : "",
                    "label" => isset($config['payment_method-label']) ? $config['payment_method-label'] : "Payment Method",
                    "type" => "select",
                    "default" => isset($config['payment_method']) && in_array($config['payment_method'], array_column($payment_methods, "label")) ? $config['payment_method'] : $payment_methods[0]['label'],
                    "options" => $payment_methods,
                    "custom_options" => isset($config['payment_method-custom_options']) ? $config['payment_method-custom_options'] : array(),
                ),
                array(
                    "name" => "coldbag_needed",
                    "field_type" => "optional",
                    "classes" => isset($config['coldbag_needed-class']) ? $config['coldbag_needed-class'] : "",
                    "attr" => isset($config['coldbag_needed-attr']) ? $config['coldbag_needed-attr'] : "",
                    "wrapper" => isset($config['coldbag_needed-wrapper']) ? $config['coldbag_needed-wrapper'] : "",
                    "label" => isset($config['coldbag_needed-label']) ? $config['coldbag_needed-label'] : "Coldbag Needed",
                    "type" => "select",
                    "default" => isset($config['coldbag_needed']) && in_array($config['coldbag_needed'], array_column($coldbag, "label")) ? $config['coldbag_needed'] : $coldbag[0]['label'],
                    "options" => $coldbag,
                    "custom_options" => isset($config['coldbag_needed-custom_options']) ? $config['coldbag_needed-custom_options'] : array(),
                ),
                array(
                    "name" => "amount",
                    "field_type" => "required",
                    "classes" => isset($config['amount-class']) ? $config['amount-class'] : "",
                    "attr" => isset($config['amount-attr']) ? $config['amount-attr'] : "",
                    "wrapper" => isset($config['amount-wrapper']) ? $config['amount-wrapper'] : "",
                    "label" => isset($config['amount-label']) ? $config['amount-label'] : "Amount",
                    "type" => "number",
                    "default" => isset($config['amount']) ? $config['amount'] : "",
                ),
                array(
                    "name" => "description",
                    "field_type" => "required",
                    "classes" => isset($config['description-class']) ? $config['description-class'] : "",
                    "attr" => isset($config['description-attr']) ? $config['description-attr'] : "",
                    "wrapper" => isset($config['description-wrapper']) ? $config['description-wrapper'] : "",
                    "label" => isset($config['description-label']) ? $config['description-label'] : "Description",
                    "type" => "text",
                    "default" => isset($config['description']) ? $config['description'] : "",
                ),
                array(
                    "name" => "preordered_for",
                    "field_type" => "optional",
                    "classes" => isset($config['preordered_for-class']) ? $config['preordered_for-class'] : "",
                    "attr" => isset($config['preordered_for-attr']) ? $config['preordered_for-attr'] : "",
                    "wrapper" => isset($config['preordered_for-wrapper']) ? $config['preordered_for-wrapper'] : "",
                    "label" => isset($config['preordered_for-label']) ? $config['preordered_for-label'] : "Preordered For",
                    "type" => "datetime",
                    "default" => isset($config['preordered_for']) ? $config['preordered_for'] : "",
                ),
                array(
                    "name" => "delivery_tasks[age_validation_required]",
                    "field_type" => "optional",
                    "classes" => isset($config['delivery_tasks[age_validation_required]-class']) ? $config['delivery_tasks[age_validation_required]-class'] : "",
                    "attr" => isset($config['delivery_tasks[age_validation_required]-attr']) ? $config['delivery_tasks[age_validation_required]-attr'] : "",
                    "wrapper" => isset($config['delivery_tasks[age_validation_required]-wrapper']) ? $config['delivery_tasks[age_validation_required]-wrapper'] : "",
                    "label" => isset($config['delivery_tasks[age_validation_required]-label']) ? $config['delivery_tasks[age_validation_required]-label'] : "Age Verification",
                    "type" => "select",
                    "default" => isset($config['delivery_tasks[age_validation_required]']) && in_array($config['delivery_tasks[age_validation_required]'], array_column($age_verification, "label")) ? $config['delivery_tasks[age_validation_required]'] : $age_verification[0]['label'],
                    "options" => $age_verification,
                    "custom_options" => isset($config['delivery_tasks[age_validation_required]-custom_options']) ? $config['delivery_tasks[age_validation_required]-custom_options'] : array(),
                ),
            );
        } else {
            $form_fields = array(
                array(
                    "name" => "sender[client_vendor_id]",
                    "field_type" => "required",
                    "classes" => isset($config['sender[client_vendor_id]-class']) ? $config['sender[client_vendor_id]-class'] : "",
                    "attr" => isset($config['sender[client_vendor_id]-attr']) ? $config['sender[client_vendor_id]-attr'] : "",
                    "wrapper" => isset($config['sender[client_vendor_id]-wrapper']) ? $config['sender[client_vendor_id]-wrapper'] : "",
                    "label" => isset($config['sender[client_vendor_id]-label']) ? $config['sender[client_vendor_id]-label'] : "Sender Outlet",
                    "type" => "select",
                    "default" => isset($config['sender[client_vendor_id]']) && in_array($config['sender[client_vendor_id]'], array_column($vendor_outlets, "label")) ? $config['sender[client_vendor_id]'] : $vendor_outlets[0]['label'],
                    "options" => $vendor_outlets,
                    "custom_options" => isset($config['sender[client_vendor_id]-custom_options']) ? $config['sender[client_vendor_id]-custom_options'] : array(),
                ),
                array(
                    "name" => "sender[notes]",
                    "field_type" => "optional",
                    "classes" => isset($config['sender[notes]-class']) ? $config['sender[notes]-class'] : "",
                    "attr" => isset($config['sender[notes]-attr']) ? $config['sender[notes]-attr'] : "",
                    "wrapper" => isset($config['sender[notes]-wrapper']) ? $config['sender[notes]-wrapper'] : "",
                    "label" => isset($config['sender[notes]-label']) ? $config['sender[notes]-label'] : "Sender Notes",
                    "type" => "text",
                    "default" => isset($config['sender[notes]']) ? $config['sender[notes]'] : "",
                ),
                array(
                    "name" => "recipient[name]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[name]-class']) ? $config['recipient[name]-class'] : "",
                    "attr" => isset($config['recipient[name]-attr']) ? $config['recipient[name]-attr'] : "",
                    "wrapper" => isset($config['recipient[name]-wrapper']) ? $config['recipient[name]-wrapper'] : "",
                    "label" => isset($config['recipient[name]-label']) ? $config['recipient[name]-label'] : "Recipient Name",
                    "type" => "text",
                    "default" => isset($config['recipient[name]']) ? $config['recipient[name]'] : "",
                ),
                array(
                    "name" => "recipient[phone_number]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[phone_number]-class']) ? $config['recipient[phone_number]-class'] : "",
                    "attr" => isset($config['recipient[phone_number]-attr']) ? $config['recipient[phone_number]-attr'] : "",
                    "wrapper" => isset($config['recipient[phone_number]-wrapper']) ? $config['recipient[phone_number]-wrapper'] : "",
                    "label" => isset($config['recipient[phone_number]-label']) ? $config['recipient[phone_number]-label'] : "Recipient Phone Number",
                    "type" => "phone",
                    "default" => isset($config['recipient[phone_number]']) ? $config['recipient[phone_number]'] : "",
                ),
                array(
                    "name" => "recipient[location][address]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][address]-class']) ? $config['recipient[location][address]-class'] : "",
                    "attr" => isset($config['recipient[location][address]-attr']) ? $config['recipient[location][address]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][address]-wrapper']) ? $config['recipient[location][address]-wrapper'] : "",
                    "label" => isset($config['recipient[location][address]-label']) ? $config['recipient[location][address]-label'] : "Recipient Address",
                    "type" => "text",
                    "default" => isset($config['recipient[location][address]']) ? $config['recipient[location][address]'] : "",
                ),
                array(
                    "name" => "recipient[location][latitude]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][latitude]-class']) ? $config['recipient[location][latitude]-class'] : "",
                    "attr" => isset($config['recipient[location][latitude]-attr']) ? $config['recipient[location][latitude]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][latitude]-wrapper']) ? $config['recipient[location][latitude]-wrapper'] : "",
                    "label" => isset($config['recipient[location][latitude]-label']) ? $config['recipient[location][latitude]-label'] : "Recipient Latitude",
                    "type" => "number",
                    "default" => isset($config['recipient[location][latitude]']) ? $config['recipient[location][latitude]'] : "",
                ),
                array(
                    "name" => "recipient[location][longitude]",
                    "field_type" => "required",
                    "classes" => isset($config['recipient[location][longitude]-class']) ? $config['recipient[location][longitude]-class'] : "",
                    "attr" => isset($config['recipient[location][longitude]-attr']) ? $config['recipient[location][longitude]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][longitude]-wrapper']) ? $config['recipient[location][longitude]-wrapper'] : "",
                    "label" => isset($config['recipient[location][longitude]-label']) ? $config['recipient[location][longitude]-label'] : "Recipient Longitude",
                    "type" => "number",
                    "default" => isset($config['recipient[location][longitude]']) ? $config['recipient[location][longitude]'] : "",
                ),
                array(
                    "name" => "recipient[location][postalcode]",
                    "field_type" => "optional",
                    "classes" => isset($config['recipient[location][postalcode]-class']) ? $config['recipient[location][postalcode]-class'] : "",
                    "attr" => isset($config['recipient[location][postalcode]-attr']) ? $config['recipient[location][postalcode]-attr'] : "",
                    "wrapper" => isset($config['recipient[location][postalcode]-wrapper']) ? $config['recipient[location][postalcode]-wrapper'] : "",
                    "label" => isset($config['recipient[location][postalcode]-label']) ? $config['recipient[location][postalcode]-label'] : "Recipient Postal Code",
                    "type" => "text",
                    "default" => isset($config['recipient[location][postalcode]']) ? $config['recipient[location][postalcode]'] : "",
                ),
                array(
                    "name" => "recipient[notes]",
                    "field_type" => "optional",
                    "classes" => isset($config['recipient[notes]-class']) ? $config['recipient[notes]-class'] : "",
                    "attr" => isset($config['recipient[notes]-attr']) ? $config['recipient[notes]-attr'] : "",
                    "wrapper" => isset($config['recipient[notes]-wrapper']) ? $config['recipient[notes]-wrapper'] : "",
                    "label" => isset($config['recipient[notes]-label']) ? $config['recipient[notes]-label'] : "Recipient Notes",
                    "type" => "text",
                    "default" => isset($config['recipient[notes]']) ? $config['recipient[notes]'] : "",
                ),
                array(
                    "name" => "payment_method",
                    "field_type" => "required",
                    "classes" => isset($config['payment_method-class']) ? $config['payment_method-class'] : "",
                    "attr" => isset($config['payment_method-attr']) ? $config['payment_method-attr'] : "",
                    "wrapper" => isset($config['payment_method-wrapper']) ? $config['payment_method-wrapper'] : "",
                    "label" => isset($config['payment_method-label']) ? $config['payment_method-label'] : "Payment Method",
                    "type" => "select",
                    "default" => isset($config['payment_method']) && in_array($config['payment_method'], array_column($payment_methods, "label")) ? $config['payment_method'] : $payment_methods[0]['label'],
                    "options" => $payment_methods,
                    "custom_options" => isset($config['payment_method-custom_options']) ? $config['payment_method-custom_options'] : array(),
                ),
                array(
                    "name" => "coldbag_needed",
                    "field_type" => "optional",
                    "classes" => isset($config['coldbag_needed-class']) ? $config['coldbag_needed-class'] : "",
                    "attr" => isset($config['coldbag_needed-attr']) ? $config['coldbag_needed-attr'] : "",
                    "wrapper" => isset($config['coldbag_needed-wrapper']) ? $config['coldbag_needed-wrapper'] : "",
                    "label" => isset($config['coldbag_needed-label']) ? $config['coldbag_needed-label'] : "Coldbag Needed",
                    "type" => "select",
                    "default" => isset($config['coldbag_needed']) && in_array($config['coldbag_needed'], array_column($coldbag, "label")) ? $config['coldbag_needed'] : $coldbag[0]['label'],
                    "options" => $coldbag,
                    "custom_options" => isset($config['coldbag_needed-custom_options']) ? $config['coldbag_needed-custom_options'] : array(),
                ),
                array(
                    "name" => "amount",
                    "field_type" => "required",
                    "classes" => isset($config['amount-class']) ? $config['amount-class'] : "",
                    "attr" => isset($config['amount-attr']) ? $config['amount-attr'] : "",
                    "wrapper" => isset($config['amount-wrapper']) ? $config['amount-wrapper'] : "",
                    "label" => isset($config['amount-label']) ? $config['amount-label'] : "Amount",
                    "type" => "number",
                    "default" => isset($config['amount']) ? $config['amount'] : "",
                ),
                array(
                    "name" => "description",
                    "field_type" => "required",
                    "classes" => isset($config['description-class']) ? $config['description-class'] : "",
                    "attr" => isset($config['description-attr']) ? $config['description-attr'] : "",
                    "wrapper" => isset($config['description-wrapper']) ? $config['description-wrapper'] : "",
                    "label" => isset($config['description-label']) ? $config['description-label'] : "Description",
                    "type" => "text",
                    "default" => isset($config['description']) ? $config['description'] : "",
                ),
                array(
                    "name" => "preordered_for",
                    "field_type" => "optional",
                    "classes" => isset($config['preordered_for-class']) ? $config['preordered_for-class'] : "",
                    "attr" => isset($config['preordered_for-attr']) ? $config['preordered_for-attr'] : "",
                    "wrapper" => isset($config['preordered_for-wrapper']) ? $config['preordered_for-wrapper'] : "",
                    "label" => isset($config['preordered_for-label']) ? $config['preordered_for-label'] : "Preordered For",
                    "type" => "datetime",
                    "default" => isset($config['preordered_for']) ? $config['preordered_for'] : "",
                ),
                array(
                    "name" => "delivery_tasks[age_validation_required]",
                    "field_type" => "optional",
                    "classes" => isset($config['delivery_tasks[age_validation_required]-class']) ? $config['delivery_tasks[age_validation_required]-class'] : "",
                    "attr" => isset($config['delivery_tasks[age_validation_required]-attr']) ? $config['delivery_tasks[age_validation_required]-attr'] : "",
                    "wrapper" => isset($config['delivery_tasks[age_validation_required]-wrapper']) ? $config['delivery_tasks[age_validation_required]-wrapper'] : "",
                    "label" => isset($config['delivery_tasks[age_validation_required]-label']) ? $config['delivery_tasks[age_validation_required]-label'] : "Age Verification",
                    "type" => "select",
                    "default" => isset($config['delivery_tasks[age_validation_required]']) && in_array($config['delivery_tasks[age_validation_required]'], array_column($age_verification, "label")) ? $config['delivery_tasks[age_validation_required]'] : $age_verification[0]['label'],
                    "options" => $age_verification,
                    "custom_options" => isset($config['delivery_tasks[age_validation_required]-custom_options']) ? $config['delivery_tasks[age_validation_required]-custom_options'] : array(),
                ),
            );
        }
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
