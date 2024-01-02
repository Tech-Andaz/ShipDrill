<?php

require 'vendor/autoload.php';

use TechAndaz\PandaGo\PandaGoClient;
use TechAndaz\PandaGo\PandaGoAPI;

$PandaGoClient = new PandaGoClient(array(
    "credentials" => array(
        "grant_type"=>"client_credentials",
        "client_id"=>"pandago:sg:bf2029da-89f5-48d1-8f44-f34c03542b2b",
        "client_assertion_type"=>"urn:ietf:params:oauth:client-assertion-type:jwt-bearer",
        "client_assertion"=>"eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6ImNhYjdhNTZmLWFiNTctNGJjOS04MTViLTg3MmVlMGQwODkxYyJ9.eyJleHAiOjIwMTk2ODYzOTksImlzcyI6InBhbmRhZ286c2c6YmYyMDI5ZGEtODlmNS00OGQxLThmNDQtZjM0YzAzNTQyYjJiIiwic3ViIjoicGFuZGFnbzpzZzpiZjIwMjlkYS04OWY1LTQ4ZDEtOGY0NC1mMzRjMDM1NDJiMmIiLCJqdGkiOiJhZGI4ZTRkMS0yZjIzLTRlNzQtODQ1MS04MmJhNWUwYjhiM2QiLCJhdWQiOiJodHRwczovL3N0cy5kZWxpdmVyeWhlcm8uaW8ifQ.pZqBn5U6MdQuloGRzWK6hnFLcU1qfzraX7RLJ5CEONwbFat2HbrEtPHvJhnESL4aTfZOKrr35wICFdPkU9bin8f77Lgno0dFdWxMp3jg9be-7B56hgfOJF4ScyQjS2nBqF4-tauFo9j9qWm99FOYEfTRqQ4aXGWkEg6Huh0G8qXVP19Jdt8mDXUk4UDTwNhcqU4gojGkczixra1OheJVSPGFAUyq0P1UZH3atxSuAp_2Jm-U6eGY4UQGWUjkG_RDpWEJRbD1NasaYYrsqeULA9d8TqHxdX1csKgUgs2WoIJst9Lp2Y-P4b6agAZ3LiFqoXoal0d9ImPkrHHTO__rig",
        "scope"=>"pandago.api.sg.*",
    ),
    "token_url" => "https://sts-st.deliveryhero.io/",
    "api_url" => "https://pandago-api-sandbox.deliveryhero.io/sg/api/v1/"
    
));
$PandaGoAPI = new PandaGoAPI($PandaGoClient);

//Submit a New Order
function submitOrder($PandaGoAPI){
    try {
        $orderData = [
            'sender' => array(
                "name" => "Tech Andaz",
                "phone_number" => "+924235113700",
                "notes" => "Use the left door",
                "location" => array(
                    "address" => "Test address",
                    "latitude" => 1.2923742,
                    "longitude" => 103.8486029,
                )
            ),
            'recipient' => array(
                "name" => "Customer",
                "phone_number" => "+924235113700",
                "notes" => "Use the front door",
                "location" => array(
                    "address" => "Test address",
                    "latitude" => 1.2923742,
                    "longitude" => 103.8486029,
                )
            ),
            "amount" => 500.00,
            "payment_method" => "PAID",
            "description" => "Order Description",
            "delivery_tasks" => array(
                "age_validation_required" => false
            )
        ];
        $response = $PandaGoAPI->submitOrder($orderData);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Fetch an Order
function fetchOrder($PandaGoAPI){
    try {
        $order_id = "a-xfen-a06d04";
        $response = $PandaGoAPI->fetchOrder($order_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Cancel an Order
function cancelOrder($PandaGoAPI){
    try {
        $order_id = "a-xfen-c0ad86";
        $reason = "REASON_UNKNOWN";
        $response = $PandaGoAPI->cancelOrder($order_id, $reason);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Update an Order
function updateOrder($PandaGoAPI){
    try {
        $order_id = "a-xfen-c0ad86";
        $orderData = [
            'location' => array(
                "notes" => "Use the left door",
                "address" => "Test address",
                "latitude" => 1.2923742,
                "longitude" => 103.8486029,
            ),
            "amount" => 500.00,
            "payment_method" => "PAID",
            "description" => "Order Description",
        ];
        $response = $PandaGoAPI->updateOrder($order_id, $orderData);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Proof of Pickup
function proofOfPickup($PandaGoAPI){
    try {
        $order_id = "a-xfen-147164";
        $response = $PandaGoAPI->proofOfPickup($order_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Proof of Delivery
function proofOfDelivery($PandaGoAPI){
    try {
        $order_id = "a-xfen-147164";
        $response = $PandaGoAPI->proofOfDelivery($order_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Proof of Return
function proofOfReturn($PandaGoAPI){
    try {
        $order_id = "a-xfen-147164";
        $response = $PandaGoAPI->proofOfReturn($order_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Rider's Coordinates
function getRiderCoordinates($PandaGoAPI){
    try {
        $order_id = "a-xfen-147164";
        $response = $PandaGoAPI->getRiderCoordinates($order_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Estimate Delivery Fees
function estimateDeliveryFees($PandaGoAPI){
    try {
        $orderData = [
            'sender' => array(
                "name" => "Tech Andaz",
                "phone_number" => "+924235113700",
                "notes" => "Use the left door",
                "location" => array(
                    "address" => "Test address",
                    "latitude" => 1.2923742,
                    "longitude" => 103.8486029,
                )
            ),
            'recipient' => array(
                "name" => "Customer",
                "phone_number" => "+924235113700",
                "notes" => "Use the front door",
                "location" => array(
                    "address" => "Test address",
                    "latitude" => 1.2923742,
                    "longitude" => 103.8486029,
                )
            ),
            "amount" => 500.00,
            "payment_method" => "PAID",
            "description" => "Order Description",
        ];
        $response = $PandaGoAPI->estimateDeliveryFees($orderData);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Estimate Delivery Time
function estimateDeliveryTime($PandaGoAPI){
    $orderData = [
        'sender' => array(
            "name" => "Tech Andaz",
            "phone_number" => "+924235113700",
            "notes" => "Use the left door",
            "location" => array(
                "address" => "Test address",
                "latitude" => 1.2923742,
                "longitude" => 103.8486029,
            )
        ),
        'recipient' => array(
            "name" => "Customer",
            "phone_number" => "+924235113700",
            "notes" => "Use the front door",
            "location" => array(
                "address" => "Test address",
                "latitude" => 1.2923742,
                "longitude" => 103.8486029,
            )
        ),
        "amount" => 500.00,
        "payment_method" => "PAID",
        "description" => "Order Description",
    ];
    try {
        $response = $PandaGoAPI->estimateDeliveryTime($orderData);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Create or Update an Outlet
function createUpdateOutlet($PandaGoAPI){
    try {
        $outlet_id = uniqid();
        $orderData = [
            "name" => "Tech Andaz",
            "address" => "Test address",
            "street" => "Test Street",
            "street_number" => "Street 2",
            "building" => "Building 1",
            "district" => "Township",
            "postal_code" => "12345",
            "rider_instructions" => "Use Left door",
            "latitude" => 1.2923742,
            "longitude" => 103.8486029,
            "city" => "Lahore",
            "phone_number" => "+924235113700",
            "currency" => "PKR",
            "locale" => "en-US",
            "description" => "Head Office",
            "halal" => true,
            "add_user" => array(
                "test@test.com",
                "test2@test.com"
            ),
        ];
        $response = $PandaGoAPI->createUpdateOutlet($outlet_id, $orderData);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get an Outlet
function getOutlet($PandaGoAPI){
    try {
        $outlet_id = "658aedab00869";
        $response = $PandaGoAPI->getOutlet($outlet_id);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get all Outlets
function getAllOutlets($PandaGoAPI){
    try {
        $response = $PandaGoAPI->getAllOutlets();
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}


//Get Form Fields
function getFormFields($PandaGoAPI){
    try { 
        
        $response = $PandaGoAPI->getAllOutlets();
        $locations = array(
            array(
                "label" => "Select Outlet",
                "value" => ""
            )
        );
        foreach($response['response'] as $locs){
            array_push($locations, array(
                "label" => $locs['name'],
                "value" => $locs['client_vendor_id'],
            ));
        }
        $config = array(
            "sender_type" => "sender_outlet",
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "sender[client_vendor_id]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "recipient[name]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "recipient[phone_number]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "recipient[location][address]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "recipient[location][latitude]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "recipient[location][longitude]" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "payment_method" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "description" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
            "sender[client_vendor_id]-custom_options"=> $locations
        );
        $response = $PandaGoAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\PandaGo\PandaGoException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(submitOrder($PandaGoAPI));
// echo json_encode(fetchOrder($PandaGoAPI));
// echo json_encode(cancelOrder($PandaGoAPI));
// echo json_encode(updateOrder($PandaGoAPI));
// echo json_encode(proofOfPickup($PandaGoAPI));
// echo json_encode(proofOfDelivery($PandaGoAPI));
// echo json_encode(proofOfReturn($PandaGoAPI));
// echo json_encode(getRiderCoordinates($PandaGoAPI));
// echo json_encode(estimateDeliveryFees($PandaGoAPI));
// echo json_encode(estimateDeliveryTime($PandaGoAPI));
// echo json_encode(createOutlet($PandaGoAPI));
// echo json_encode(getOutlet($PandaGoAPI));
// echo json_encode(getAllOutlets($PandaGoAPI));
echo (getFormFields($PandaGoAPI));


?>
