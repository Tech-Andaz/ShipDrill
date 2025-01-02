<?php

require 'vendor/autoload.php';

use TechAndaz\SmartLane\SmartLaneClient;
use TechAndaz\SmartLane\SmartLaneAPI;

$SmartLaneClient = new SmartLaneClient(array(
    "environment" => "sandbox", //Optional - Defaults to production
    "api_token" => "kktelzTjknBvP3qDrxU28rrgd6Ywn32PraaM6re7", //Token determins sandbox or production
));
$SmartLaneAPI = new SmartLaneAPI($SmartLaneClient);

//Add Shipment
function addShipment($SmartLaneAPI){
    try {
        $data = [
            'warehouse_code' => 'WH1690289367237',
            'store_order_id' => "AF-1001712", //Optional, will assign unique if not provided
            'consignee_name' => 'Tech Andaz',
            'consignee_phone' => '+924235113700',
            'consignee_email' => 'contact@techandaz.com',
            'consignee_address' => '119/2 M Quaid-e-Azam Industrial Estate, Kot Lakhpat',
            'consignee_city' => 'Lahore',
            'description' => 'Order ID: 12345', // Optional
            'payment_method' => "cod",
            'amount' => 1000,
            'product_count' => 4,
            'products' => array(
                array(
                    "sku" => "1002",
                    "name" => "Web Development",
                    "qty" => 2,
                ),
                array(
                    "sku" => "1003",
                    "name" => "App Development",
                    "qty" => 2,
                ),
            )
            
        ];
        $response = $SmartLaneAPI->createBookings($data);
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Track Shipment
function trackShipment($SmartLaneAPI){
    try {
        $store_order_id = "AF-10017";
        $response = $SmartLaneAPI->trackShipment($store_order_id);
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Cancel Shipment
function cancelShipment($SmartLaneAPI){
    try {
        $store_order_id = "AF-10017";
        $response = $SmartLaneAPI->cancelShipment($store_order_id);
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Print Shipping Label
function printShippingLabel($SmartLaneAPI){
    try {
        $store_order_id = "AF-100171";
        $response = $SmartLaneAPI->printShippingLabel($store_order_id);
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get City List
function getCityList($SmartLaneAPI){
    try {
        $response = $SmartLaneAPI->getCityList();
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get Warehouse List
function getWarehouseList($SmartLaneAPI){
    try {
        $response = $SmartLaneAPI->getWarehouseList();
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get Form Fields
function getFormFields($SmartLaneAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "warehouse_code" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "store_order_id" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_email" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_phone" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_address" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_city" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "description" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "payment_method" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_count" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_sku" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "quantity" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => true,
        );
        $response = $SmartLaneAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\SmartLane\SmartLaneException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(addShipment($SmartLaneAPI));
// echo json_encode(trackShipment($SmartLaneAPI));
// echo json_encode(cancelShipment($SmartLaneAPI));
// echo (printShippingLabel($SmartLaneAPI));
// echo json_encode(getCityList($SmartLaneAPI));
// echo json_encode(getWarehouseList($SmartLaneAPI));
// echo (getFormFields($SmartLaneAPI));

?>
