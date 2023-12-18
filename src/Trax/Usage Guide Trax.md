
## Usage Guide - Trax
## Table of Contents - Trax Usage Guide
- [Initialize Trax Client](#initialize)
- [Add a Pickup Address](#add-a-pickup-address)
- [List of Pickup Addresses](#list-pickup-addresses)
- [List of Cities & Information](#list-cities)
- [Book a Regular Shipment](#book-a-regular-shipment)
- [Book a Replacement Shipment](#book-a-replacement-shipment)
- [Book a Try & Buy Shipment](#book-a-try-and-buy-shipment)
- [Current Status of a Shipment](#current-status-of-a-shipment)
- [Track Shipment](#track-shipment)
- [Charges of a Shipment](#charges-of-a-shipment)
- [Payment Details of a Shipment](#payment-details-of-a-shipment)
- [Get Invoice](#get-invoice)
- [Print/View Shipping Label](#shipping-label)
- [Cancel Shipment](#cancel-shipment)
- [Calculate Rates for a Delivery](#calculate-rates)
- [Create a Receiving Sheet](#create-receiving-sheet)
- [View a Receiving Sheet](#view-receiving-sheet)


## Initialize

```php
<?php

require 'vendor/autoload.php';

use TechAndaz\Trax\TraxClient;
use TechAndaz\Trax\TraxAPI;

// Initiliaze Client with API credentials and URL. If you don't provide URL it will use production URL automatically.
// Live: http://sonic.pk
// Testing: http://app.sonic.pk
// $traxClient = new TraxClient('your-api-key', 'your-api-url');

$traxClient = new TraxClient('eTNZQjRwQ1ZVQjkxQ2hvaWwxdmR6aExjSE9aV0R4b2xNMThMNm93WTdkUHgyNmpqOGF6dHAzemN4THRP5c10b0414332f', 'https://app.sonic.pk');
$traxAPI = new TraxAPI($traxClient);

?>
```
## Add a Pickup Address

```php
<?php

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

?>
```
## List of Pickup Addresses

```php
<?php

try {
    $response = $traxAPI->listPickupAddresses();
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## List of Pickup Addresses

```php
<?php

try {
    $response = $traxAPI->cityList();
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Book a Regular Shipment

```php
<?php

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

?>
```
Appendix and information on additional fields can be found at: [Trax API Docs](src/Trax/API%20Document%20-%20Trax.pdf)
## Book a Replacement Shipment

```php
<?php

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

?>
```
Appendix and information on additional fields can be found at: [Trax API Docs](src/Trax/API%20Document%20-%20Trax.pdf)
## Book a Try & Buy Shipment

```php
<?php

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

?>
```
Appendix and information on additional fields can be found at: [Trax API Docs](src/Trax/API%20Document%20-%20Trax.pdf)
## Current Status of a Shipment

```php
<?php

try {
    $response = $traxAPI->getShipmentStatus(202223372182, 0);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Track Shipment

```php
<?php

try {
    $response = $traxAPI->trackShipment(202223372182, 0);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Charges of a Shipment

```php
<?php

try {
    $response = $traxAPI->trackShipment(202223372182, 0);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Payment Details of a Shipment

```php
<?php

try {
    $response = $traxAPI->getPaymentStatus(202223372182, 0);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Invoice

```php
<?php

try {
    $response = $traxAPI->getInvoice(930, 1);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Print/View Shipping Label

```php
<?php

try {
    $response = $traxAPI->getInvoice(930, 1);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

