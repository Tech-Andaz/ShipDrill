<?php

require 'vendor/autoload.php';

use TechAndaz\BlueEx\BlueExClient;
use TechAndaz\BlueEx\BlueExAPI;

$BlueExClient = new BlueExClient("KHI-00000", "64jkuyeh75hkjstgh87", "https://bigazure.com/api/json_v3/");
$BlueExAPI = new BlueExAPI($BlueExClient);

//Get All Pickup Locations
function getAllPickupLocations($BlueExAPI){
    try {
        $response = $BlueExAPI->getAllPickupLocations();
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Specific Pickup Location
function getPickupLocation($BlueExAPI){
    try {
        $location_id = 31;
        $response = $BlueExAPI->getPickupLocation($location_id);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipment Status
function getShipmentStatus($BlueExAPI){
    try {
        $consignment_no = "5027729334";
        $response = $BlueExAPI->getShipmentStatus($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipment Settlement
function getShipmentSettlement($BlueExAPI){
    try {
        $consignment_no = "5027729334";
        $response = $BlueExAPI->getShipmentSettlement($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipment Info
function getShipmentInfo($BlueExAPI){
    try {
        $consignment_no = "5027729334";
        $response = $BlueExAPI->getShipmentInfo($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipment Info
function getShipmentTracking($BlueExAPI){
    try {
        $consignment_no = "5027729334";
        $response = $BlueExAPI->getShipmentTracking($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Cities
function getCities($BlueExAPI){
    try {
        $country_code = "PK";
        $response = $BlueExAPI->getCities($country_code);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Service Type
function getServiceType($BlueExAPI){
    try {
        $response = $BlueExAPI->getServiceType();
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Create Shipment
function createShipment($BlueExAPI){
    try {
        $data = array(
            "shipper_name" => "Mubeen Dewani",
            "shipper_email" => "mubeen.dewani@blue-ex.com",
            "shipper_contact" => "03242646886",
            "shipper_address" => "Plot # 5 blueEx Awami Markaz Shahrah-E-Faisal Karachi",
            "shipper_city" => "LHE",
            "customer_name" => "FAHAD",
            "customer_email" => "mubeen.dewani@blue-ex.com",
            "customer_contact" => "03242646886",
            "customer_address" => "Plot # 5 blueEx Awami Markaz Shahrah-E-Faisal Karachi",
            "customer_city" => "KHI",
            "customer_country" => "PK",
            "customer_comment" => "demo",
            "shipping_charges" => "150",
            "payment_type" => "COD",
            "service_code" => "BE",
            "total_order_amount" => "4150.00",
            "total_order_weight" => "1",
            "order_refernce_code" => "bluedemo1",
            "fragile" => "N",
            "parcel_type" => "P",
            "insurance_require" => "N",
            "insurance_value" => "0",
            "testbit" => "Y",
            "cn_generate" => "Y",
            "multi_pickup" => "Y",
            "products_detail" => array(
                array(
                    "product_code" => "1005",
                    "product_name" => "Polo T shirt",
                    "product_price" => "1000",
                    "product_weight" => "0.5",
                    "product_quantity" => "2",
                    "product_variations" => "small-black",
                    "sku_code" => "12assk11aa"
                )
            )
        );
        $response = $BlueExAPI->createShipment($data);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Cancel Shipment
function cancelShipment($BlueExAPI){
    try {
        $consignment_no = "5027729332";
        $response = $BlueExAPI->cancelShipment($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Reverse Pickup
function reversePickup($BlueExAPI){
    try {
        $consignment_no = "5027729337";
        $response = $BlueExAPI->reversePickup($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Create Loadsheet
function createLoadsheet($BlueExAPI){
    try {
        $consignment_no = "5027729332, 5027729337";
        $response = $BlueExAPI->createLoadsheet($consignment_no);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($BlueExAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "shipper_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_email" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_contact" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_address" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_city" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "customer_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "customer_contact" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "customer_address" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "customer_city" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "customer_country" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "payment_type" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "service_code" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "total_order_amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "total_order_weight" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "order_refernce_code" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "fragile" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "parcel_type" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "insurance_require" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "cn_generate" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "products_detail_row" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                    "input_wrapper_end" => "</div></div>"
                ),
                "product_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_price" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_quantity" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "product_weight" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
        );
        $response = $BlueExAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\BlueEx\BlueExException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// echo json_encode(getAllPickupLocations($BlueExAPI));
// echo json_encode(getPickupLocation($BlueExAPI));
// echo json_encode(getShipmentStatus($BlueExAPI));
// echo json_encode(getShipmentSettlement($BlueExAPI));
// echo json_encode(getShipmentInfo($BlueExAPI));
// echo json_encode(getShipmentTracking($BlueExAPI));
// echo json_encode(getCities($BlueExAPI));
// echo json_encode(getServiceType($BlueExAPI));
// echo json_encode(createShipment($BlueExAPI));
// echo json_encode(cancelShipment($BlueExAPI));
// echo json_encode(reversePickup($BlueExAPI));
// echo json_encode(createLoadsheet($BlueExAPI));
// echo (getFormFields($BlueExAPI));
?>
