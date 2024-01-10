<?php

require 'vendor/autoload.php';

use TechAndaz\TCS\TCSClient;
use TechAndaz\TCS\TCSAPI;

$TCSClient = new TCSClient(array(
    "environment" => "sandbox", //Optional - Defaults to production. Options are: sandbox / production
    "username" => "testenvio", //Optional if sandbox, Defaults to testenvio. Required if production
    "password" => "abc123+", //Optional if sandbox, Defaults to abc123+. Required if production
    "client_id" => "33b3ef31-8474-45d8-aa0f-afed317ef8b8", //Optional if sandbox, Defaults to 33b3ef31-8474-45d8-aa0f-afed317ef8b8. Required if production,
    "cost_centers" => array(
        array(
            "city" => "KARACHI", //Sender City
            "code" => "Test", // Cost Center Code
            "name" => "Karachi Cost Center", //Sender City
        )
    ), //Optional if sandbox, Defaults to Karachi Center. Required array if production.
    "tracking_url" => "https://www.tcsexpress.com/track/" //Optional for URL based tracking - Defaults to https://www.tcsexpress.com/track/
));
$TCSAPI = new TCSAPI($TCSClient);

//Add Shipment
function addShipment($TCSAPI){
    try {
        $data = [
            'cost_center' => 'Test',
            'consignee_name' => 'Tech Andaz',
            'consignee_phone' => '+924235113700',
            'consignee_email' => 'contact@techandaz.com',
            'consignee_address' => '119/2 M Quaid-e-Azam Industrial Estate, Kot Lakhpat',
            'consignee_city' => 'Lahore',
            'weight' => 1,
            'pieces' => 1,
            'amount' => 0,
            'order_id' => '12345', // Optional - Defaults to unique ID
            'service_id' => 'overnight', //Options are: overnight / second_day / same_day / self_collection
            'order_details' => 'Order ID: 12345', // Optional
            'fragile' => 0, // Optional - Defaults to 0. Options are: 0 / 1, where 0 = No, 1 = Yes
            'remarks' => 'Come in the evening', // Optional
            'insurance_value' => 100, // Optional - Defaults to 0
        ];
        $response = $TCSAPI->addShipment($data);
        return $response;
    } catch (TechAndaz\TCS\TCSException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Track Shipment
function trackShipment($TCSAPI){
    try {
        $tracking_number = "779404467784";
        $type = "data"; //Optional - Defaults to url. Options are: data / url / redirect
        $response = $TCSAPI->trackShipment($tracking_number, $type);
        return $response;
    } catch (TechAndaz\TCS\TCSException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($TCSAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "cost_center" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_name" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_phone" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "consignee_email" => array(
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
                "weight" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "pieces" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "order_id" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "service_id" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "order_details" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "fragile" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "remarks" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "insurance_value" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                )
            ),
            "optional" => true,
        );
        $response = $TCSAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\TCS\TCSException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(addShipment($TCSAPI));
echo json_encode(trackShipment($TCSAPI));
// echo (getFormFields($TCSAPI));

?>
