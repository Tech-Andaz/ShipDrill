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
        $response = $traxAPI->getShipmentStatus(101101000405, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Track Shipment
function trackShipment($traxAPI){
    try {
        $response = $traxAPI->trackShipment(101101000405, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Shipment Charges
function getShipmentCharges($traxAPI){
    try {
        $response = $traxAPI->getShipmentCharges(101101000405);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Payment Status of a Shipment
function getPaymentStatus($traxAPI){
    try {
        $response = $traxAPI->getPaymentStatus(101101000405, 0);
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
        $response = $traxAPI->getPaymentDetails(101101000405);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Shipping Label of a Shipment
function printShippingLabel($traxAPI){
    try {
        $response = $traxAPI->printShippingLabel(101101000405, 0);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        // Handle any exceptions that may occur
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Cancel a shipment
function cancelShipment($traxAPI){
    try {
        $response = $traxAPI->cancelShipment(101101000405);
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
        $trackingNumbers = [202202366396, 202202366397];
        $response = $traxAPI->createReceivingSheet($trackingNumbers);
        return $response;
    } catch (TechAndaz\Trax\TraxException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//View a receiving sheet
function viewReceivingSheet($traxAPI){
    try { 
        $response = $traxAPI->viewReceivingSheet(105, 0);
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
// echo json_encode(getInvoice($traxAPI));
// echo json_encode(getPaymentDetails($traxAPI));
// echo json_encode(printShippingLabel($traxAPI));
// echo json_encode(cancelShipment($traxAPI));
// echo json_encode(calculateRates($traxAPI));
// echo json_encode(createReceivingSheet($traxAPI));
echo json_encode(viewReceivingSheet($traxAPI));
// echo json_encode(printShippingLabel($traxAPI));

?>
