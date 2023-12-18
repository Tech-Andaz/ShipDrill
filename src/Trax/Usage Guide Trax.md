
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
## Usage Guide - Trax