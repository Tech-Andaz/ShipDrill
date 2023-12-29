<?php

require 'vendor/autoload.php';

use TechAndaz\CallCourier\CallCourierClient;
use TechAndaz\CallCourier\CallCourierAPI;

$CallCourierClient = new CallCourierClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production. Call courier doesnt have a sandbox so in sandbox mode test credentials will be applied automatically unless specified otherwise.
    "login_id" => "test-0001", // Optional if sandbox
    "password" => "test0001new", // Optional if sandbox
    "account_id" => "242", // Optional if sandbox - Found as Account Code ID in profile on dashboard
));

$CallCourierAPI = new CallCourierAPI($CallCourierClient);

//Get Return City List By Shipper
function getReturnCityListByShipper($CallCourierAPI){
    try {
        $response = $CallCourierAPI->getReturnCityListByShipper();
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Origin City List By Shipper
function getOriginCityListByShipper($CallCourierAPI){
    try {
        $response = $CallCourierAPI->getOriginCityListByShipper();
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Service Types
function getServiceTypes($CallCourierAPI){
    try {
        $response = $CallCourierAPI->getServiceTypes();
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Check if Service is COD
function checkIfServiceIsCOD($CallCourierAPI){
    try {
        $service_id = "1";
        $response = $CallCourierAPI->checkIfServiceIsCOD($service_id);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get City List by Service
function getCityListByService($CallCourierAPI){
    try {
        $service_id = "1";
        $response = $CallCourierAPI->getCityListByService($service_id);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Areas by City
function getAreasByCity($CallCourierAPI){
    try {
        $city_id = "1";
        $response = $CallCourierAPI->getAreasByCity($city_id);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Create Bookings
function createBookings($CallCourierAPI){
    try {
        $data = array(
            "shipper_name" => "Tech Andaz",
            "shipper_cell" => "+924235113700",
            "shipper_area" => "1",
            "shipper_city" => "1",
            "shipper_landline" => "+924235113700",
            "shipper_address" => "119/2 M Quaid-e-Azam Industrial Estate, Kot Lakhpat", // Optional
            "shipper_return_address" => "119/2 M Quaid-e-Azam Industrial Estate, Kot Lakhpat", // Optional
            "shipper_email" => "email@techandaz.com", // Optional
            "bookings" => array(
                array(
                    "name" => "Consigne name",
                    "reference_number" => "56270876367",
                    "cell" => "03001234567",
                    "address" => "abc",
                    "city_id" => "1",
                    "service_type" => "7",
                    "pieces" => "01",
                    "weight" => "01",
                    "description" => "Test Description",
                    "origin" => "Domestic", // Optional - Defaults to "Domestic"
                    "amount" => "100",
                    "box_id" => "My Box ID",
                    "special_handling" => "false", // Optional
                    "holiday" => "false", // Optional
                    "remarks" => "Bulk Test Remarks 1" // Optional
                    
                ),
                array(
                    "name" => "Consigne name",
                    "reference_number" => "56270876367",
                    "cell" => "03001234567",
                    "address" => "abc",
                    "city_id" => "1",
                    "service_type" => "7",
                    "pieces" => "01",
                    "weight" => "01",
                    "description" => "Test Description",
                    "origin" => "Domestic", // Optional - Defaults to "Domestic"
                    "amount" => "100",
                    "box_id" => "My Box ID",
                    "special_handling" => "false", // Optional
                    "holiday" => "false", // Optional
                    "remarks" => "Bulk Test Remarks 1" // Optional
                    
                )
            )
        );
        $response = $CallCourierAPI->createBookings($data);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Shipping Label
function getShippingLabel($CallCourierAPI){
    try { 
        //0 = PDF
        //1 = PDF file name - Locally Saved
        //2 = PDF URL
        $cn_number = "10002423232893";
        $type = "0";
        $response = $CallCourierAPI->getShippingLabel($cn_number, $type);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Tracking History
function getTrackingHistory($CallCourierAPI){
    try { 
        $cn_number = "10002423232893";
        $response = $CallCourierAPI->getTrackingHistory($cn_number);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Tracking By Reference Number
function getTrackingByReferenceNumber($CallCourierAPI){
    try { 
        $order_reference = "56270876367";
        $response = $CallCourierAPI->getTrackingByReferenceNumber($order_reference);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Tracking Status List
function getTrackingStatusList($CallCourierAPI){
    try {
        $response = $CallCourierAPI->getTrackingStatusList();
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($CallCourierAPI){
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
                "shipper_cell" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_city" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_area" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_landline" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_address" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_return_address" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "shipper_email" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings_row" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                    "input_wrapper_end" => "</div></div>"
                ),
                "bookings[name]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[reference_number]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[cell]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[address]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[city]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[service_type]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[pieces]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[weight]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[description]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[amount]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "bookings[box_id]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
        );
        $response = $CallCourierAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// echo json_encode(getReturnCityListByShipper($CallCourierAPI));
// echo json_encode(getOriginCityListByShipper($CallCourierAPI));
// echo json_encode(getServiceTypes($CallCourierAPI));
// echo json_encode(checkIfServiceIsCOD($CallCourierAPI));
// echo json_encode(getCityListByService($CallCourierAPI));
// echo json_encode(getAreasByCity($CallCourierAPI));
// echo json_encode(createBookings($CallCourierAPI));
// echo json_encode(getShippingLabel($CallCourierAPI));
// echo json_encode(getTrackingHistory($CallCourierAPI));
// echo json_encode(getTrackingByReferenceNumber($CallCourierAPI));
// echo json_encode(getTrackingStatusList($CallCourierAPI));
echo (getFormFields($CallCourierAPI));
?>
