<?php

require 'vendor/autoload.php';

use TechAndaz\AlfalahAPG\AlfalahAPGClient;
use TechAndaz\AlfalahAPG\AlfalahAPGAPI;

$AlfalahAPGClient = new AlfalahAPGClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production
    "key1" => "KEY1",
    "key2" => "KEY2",
    "channel_id" => "CHANNELID",
    "merchant_id" => "MERCHANTID",
    "store_id" => "STOREID",
    "redirection_request" => "0", // Optional - Defaults to 0
    "merchant_hash" => "MERCHANTHASH",
    "merchant_username" => "USERNAME",
    "merchant_password" => "PASSWORD",
    "transaction_type" => "3", // Optional - Defaults to 3
    "cipher" => "CIPHER", // Optional - Defaults to aes-128-cbc
    "return_url" => "https://techandaz.com",
    "currency" => "PKR", // Optional - Defaults to PKR
));

$AlfalahAPGAPI = new AlfalahAPGAPI($AlfalahAPGClient);

//Create Checkout Link
function createCheckoutLink($AlfalahAPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "redirect"; // redirect / form / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values, data will return array with all values
        $response = $AlfalahAPGAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\AlfalahAPG\AlfalahAPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($AlfalahAPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $AlfalahAPGAPI->createCheckoutLink($data, $response_type);
        $AlfalahAPGAPI->dynamicRedirect($response);
        return;
    } catch (TechAndaz\AlfalahAPG\AlfalahAPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo (createCheckoutLink($AlfalahAPGAPI));
// echo (dynamicRedirect($AlfalahAPGAPI));
?>
