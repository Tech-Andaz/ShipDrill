<?php

require 'vendor/autoload.php';

use TechAndaz\Trax\TraxClient;
use TechAndaz\Trax\TraxAPI;

$traxClient = new TraxClient('eTNZQjRwQ1ZVQjkxQ2hvaWwxdmR6aExjSE9aV0R4b2xNMThMNm93WTdkUHgyNmpqOGF6dHAzemN4THRP5c10b0414332f', 'https://app.sonic.pk');
$traxAPI = new TraxAPI($traxClient);

//Add Pickup Address
function addPickUpAddress($traxAPI){
    $pickupAddressData = [
        'person_of_contact' => 'Tech Andaz',
        'phone_number' => '03000000000',
        'email_address' => 'contact@techandaz.com',
        'address' => 'Tech Andaz, Lahore, Pakistan.',
        'city_id' => 202,
    ];
    try {
        $response = $traxAPI->addPickupAddress($pickupAddressData);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//List Pickup Address
function listPickupAddresses($traxAPI){
    try {
        $response = $traxAPI->listPickupAddresses();
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//List Cities
function cityList($traxAPI){
    try {
        $response = $traxAPI->cityList();
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Add Regular Shipment
function addRegularShipment($traxAPI){
    $shipmentDetails = [
        "pickup_address_id" => 4184,
        "information_display" => 1,
        "consignee_city_id" => 223,
        "consignee_name" => "John Doe",
        "consignee_address" => "John Doe House, DHA Phase 1",
        "consignee_phone_number_1" => "03234896599",
        "consignee_email_address" => "contact@techandaz.com",
        "order_id" => "TA-123",
        "item_product_type_id" => 1, //Appendix B
        "item_description" => "Shirt and Jeans",
        "item_quantity" => 10,
        "item_insurance" => 0,
        "pickup_date" => date("Y-m-d"),
        "estimated_weight" => 1.05,
        "shipping_mode_id" => 1, //Appendix C
        "amount" => 10650,
        "payment_mode_id" => 1, //Appendix D
    ];
    try {
        $response = $traxAPI->addRegularShipment($shipmentDetails);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Add Replacement Shipment
function addReplacementShipment($traxAPI){
    $shipmentDetails = [
        "pickup_address_id" => 4184,
        "information_display" => 1,
        "consignee_city_id" => 223,
        "consignee_name" => "John Doe",
        "consignee_address" => "John Doe House, DHA Phase 1",
        "consignee_phone_number_1" => "03234896599",
        "consignee_email_address" => "contact@techandaz.com",
        "order_id" => "TA-123",
        "item_product_type_id" => 1, //Appendix B
        "item_description" => "Shirt and Jeans",
        "item_quantity" => 10,
        "item_insurance" => 0,
        "item_price" => 10650,
        "replacement_item_product_type_id" => 1, //Appendix B
        "replacement_item_description" => "Shirt and Jeans",
        "replacement_item_quantity" => 10,
        "estimated_weight" => 1.05,
        "shipping_mode_id" => 1, //Appendix C
        "amount" => 10650,
        "charges_mode_id" => 4, //Appendix F
        "payment_mode_id" => 1, //Appendix D        
    ];
    try {
        $response = $traxAPI->addReplacementShipment($shipmentDetails);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Add Try & Buy Shipment
function addTryAndBuyShipment($traxAPI){
    $shipmentDetails = [
        "pickup_address_id" => 4184,
        "information_display" => 1,
        "consignee_city_id" => 223,
        "consignee_name" => "John Doe",
        "consignee_address" => "John Doe House, DHA Phase 1",
        "consignee_phone_number_1" => "03234896599",
        "consignee_email_address" => "contact@techandaz.com",
        "order_id" => "TA-123",
        "items" => array(
            array(
                "item_product_type_id" => 1, //Appendix B
                "item_description" => "Shirt and Jeans",
                "item_quantity" => 10,
                "item_insurance" => 0,
                "product_value" => 500,
                "item_price" => 1000,
            )
        ),
        "package_type" => 1, //1=Complete, 2=Partial
        "pickup_date" => date("Y-m-d"),
        "try_and_buy_fees" => 500,
        "estimated_weight" => 1.05,
        "shipping_mode_id" => 1, //Appendix C
        "amount" => 10650,
        "charges_mode_id" => 4, //Appendix F
        "payment_mode_id" => 1, //Appendix D        
    ];
    try {
        $response = $traxAPI->addTryAndBuyShipment($shipmentDetails);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipment Status
function getShipmentStatus($traxAPI){
    try {
        $response = $traxAPI->getShipmentStatus(202223372182, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Track Shipment
function trackShipment($traxAPI){
    try {
        $response = $traxAPI->trackShipment(202223372182, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Shipment Charges
function getShipmentCharges($traxAPI){
    try {
        $response = $traxAPI->getShipmentCharges(202223372182);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Payment Status of a Shipment
function getPaymentStatus($traxAPI){
    try {
        $response = $traxAPI->getPaymentStatus(202223372182);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Invoice of a Shipment
function getInvoice($traxAPI){
    try {
        $response = $traxAPI->getInvoice(930, 1);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Payments of a Shipment
function getPaymentDetails($traxAPI){
    try {
        $response = $traxAPI->getPaymentDetails(202223372182);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Shipping Label of a Shipment
function printShippingLabel($traxAPI){
    try {
        //0 = Image
        //1 = PDF
        //2 = Image file name - Locally Saved
        //3 = PDF file name - Locally Saved
        $response = $traxAPI->printShippingLabel(202223372182, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Cancel a shipment
function cancelShipment($traxAPI){
    try {
        $response = $traxAPI->cancelShipment(202223372182);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Calculate rates for a shipment
function calculateRates($traxAPI){
    try { 
        $serviceTypeId = 1;
        $originCityId = 202;
        $destinationCityId = 203;
        $estimatedWeight = 1.05;
        $shippingModeId = 1;
        $amount = 1000;
        $response = $traxAPI->calculateRates($serviceTypeId, $originCityId, $destinationCityId, $estimatedWeight, $shippingModeId, $amount);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Create a receiving sheet
function createReceivingSheet($traxAPI){
    try { 
        $trackingNumbers = [202223372184, 202223372185];
        $response = $traxAPI->createReceivingSheet($trackingNumbers);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//View a receiving sheet
function viewReceivingSheet($traxAPI){
    try { 
        //0 = Image
        //1 = PDF
        //2 = Image file name - Locally Saved
        //3 = PDF file name - Locally Saved
        $response = $traxAPI->viewReceivingSheet(6504, 3);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// echo json_encode(addPickUpAddress($traxAPI));
// echo json_encode(listPickupAddresses($traxAPI));
// echo json_encode(cityList($traxAPI));
// echo json_encode(addRegularShipment($traxAPI));
// echo json_encode(addReplacementShipment($traxAPI));
// echo json_encode(addTryAndBuyShipment($traxAPI));
// echo json_encode(getShipmentStatus($traxAPI));
// echo json_encode(trackShipment($traxAPI));
// echo json_encode(getShipmentCharges($traxAPI));
// echo json_encode(getPaymentStatus($traxAPI));
// echo (getInvoice($traxAPI));
// echo json_encode(getPaymentDetails($traxAPI));
// echo (printShippingLabel($traxAPI));
// echo json_encode(cancelShipment($traxAPI));
// echo json_encode(calculateRates($traxAPI));
// echo json_encode(createReceivingSheet($traxAPI));
// echo (viewReceivingSheet($traxAPI));

?>
