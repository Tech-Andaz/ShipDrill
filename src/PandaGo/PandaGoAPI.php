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
}
