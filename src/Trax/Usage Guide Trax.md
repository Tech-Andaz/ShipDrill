
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
- [Print/View a Receiving Sheet](#view-receiving-sheet)
- [Get Form Fields](#get-form-fields)


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


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |
|type | type | 1 | 0 = Shipper-related tracking. 1 = General Tracking. Appendix E|

```php
<?php

try {
    $tracking_number = "202223372182";
    $type = 0;
    $response = $traxAPI->getShipmentStatus($tracking_number, $type);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Track Shipment


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |
|type | type | 1 | 0 = Shipper-related tracking. 1 = General Tracking. Appendix E|

```php
<?php

try {
    $tracking_number = "202223372182";
    $type = 0;
    $response = $traxAPI->trackShipment($tracking_number, $type);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Charges of a Shipment


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |

```php
<?php

try {
    $tracking_number = "202223372182";
    $response = $traxAPI->getShipmentCharges($tracking_number);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
## Payment Details of a Shipment


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |

```php
<?php

try {
    $tracking_number = "202223372182";
    $response = $traxAPI->getPaymentStatus($tracking_number);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Invoice


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|id | id | 930 | Invoice or Payment ID |
|type | type | 1 | 1 = Invoice. 2 = Payment|

```php
<?php

try {
    $id = "930";
    $type = 0;
    $response = $traxAPI->getInvoice($id, $type);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Print/View Shipping Label


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |
|type | type | 0 | 0 = Image. 1 = PDF|

### Direct Image/PDF view
```php
<?php

try {
    $tracking_number = "202223372182";
    $type = 0;
    $response = $traxAPI->printShippingLabel($tracking_number, $type);
    echo $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

### Save Image/PDF and return file name

| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |
|type | type | 2 | 2 = Image Locally Saved. 3 = PDF locally saved|
|save_path | "/path/to/save/" | "assets/" | Save path of the downloaded file |

```php
<?php

try {
    $tracking_number = "202223372182";
    $save_path = "assets/";
    $type = 3;
    $response = $traxAPI->printShippingLabel($tracking_number, $type, $save_path);
    echo json_encode($response);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Cancel Shipment

| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_number | tracking_number | 202223372182 | Tracking ID of the shipment |

```php
<?php

try {
    $tracking_number = "202223372182";
    $response = $traxAPI->cancelShipment($tracking_number);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Calculate Rates for a Delivery


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|service_type_id | service_type_id | 1 | Appendix A |
|origin_city_id | origin_city_id | 202 | City IDs can be viewed from City List API|
|destination_city_id | destination_city_id | 202 | City IDs can be viewed from City List API|
|estimated_weight | estimated_weight | 1.05| Please note that this will not be the final weight of the shipment and no charges will be calculated based on this value |
|shipping_mode_id | shipping_mode_id | 1 | Appendix C |
|amount | amount | 1000 | Do not use commas or dots for this parameter. |


```php
<?php

try { 
    $service_type_id = 1;
    $origin_city_id = 202;
    $destination_city_id = 203;
    $estimated_weight = 1.05;
    $shipping_mode_id = 1;
    $amount = 1000;
    $response = $traxAPI->calculateRates($service_type_id, $origin_city_id, $destination_city_id, $estimated_weight, $shipping_mode_id, $amount);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Create a Receiving Sheet

| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|tracking_numbers | tracking_numbers[] | 202223372184 | Array of tracking numbers|
|tracking_numbers | tracking_numbers[] | 202223372185 | Array of tracking numbers|

```php
<?php

try { 
    $trackingNumbers = [202223372184, 202223372185];
    $response = $traxAPI->createReceivingSheet($trackingNumbers);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Print/View a Receiving Sheet


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|receiving_sheet_id | receiving_sheet_id | 6504 | Receiving Sheet ID|
|type | type | 0 | 0 = Image. 1 = PDF|

### Direct Image/PDF view
```php
<?php

try {
    $receiving_sheet_id = 6504;
    $type = 0;
    $response = $traxAPI->viewReceivingSheet($receiving_sheet_id, $type);
    echo $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

### Save Image/PDF and return file name

| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|receiving_sheet_id | receiving_sheet_id | 6504 | Receiving Sheet ID|
|type | type | 2 | 2 = Image Locally Saved. 3 = PDF locally saved|
|save_path | "/path/to/save/" | "assets/" | Save path of the downloaded file |

```php
<?php

try {
    $receiving_sheet_id = 6504;
    $save_path = "assets/";
    $type = 3;
    $response = $traxAPI->viewReceivingSheet($receiving_sheet_id, $type, $save_path);
    echo json_encode($response);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


## Get Form Fields - Regular Shipment

Get Form Fields allows you to easily get and customize form fields setup based on the shipment type provided.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|delivery_type_id | Select | Regular | Required | Appendix G |
|pickup_address_id | Select | First Location | Required | List of pick up locations added in Trax. |
|information_display | Select | Show | Required | Show or Hide contact details on Shipping Label/Airway Bill |
|consignee_city_id | Select | Lahore | Required | List of cities from Trax. Can be overridden by providing "cities" in config. |
|consignee_name | Text | - | Required | Name of Consignee |
|consignee_address | Text | - | Required | Address of Consignee |
|consignee_phone_number_1 | Phone Number / Text| - | Required | Phone Number of Consignee |
|consignee_email_address | Email | - | Required | Email of Consignee |
|item_product_type_id | Select | Marketplace | Required | Appendix B |
|item_description | Text | - | Required | Description of Goods |
|item_quantity | Number | 1 | Required | Number of Items |
|item_insurance | Select | No Insurance | Required | Insured, No Insurance |
|pickup_date | Date | - | Required | Date of Shipment |
|estimated_weight | Number | 1 | Required | Estimated weight of shipment |
|shipping_mode_id | Select | Rush | Required | Appendix C |
|amount | Number | 500 | Required | Amount of shipment |
|payment_mode_id | Select | Cash on Delivery | Required | Appendix D |
|charges_mode_id | Select | Invoicing | Required | Appendix F |
|consignee_phone_number_2 | Phone Number / Text | - | Optional | Additional phone number of Consignee |
|order_id | Text | - | Optional | Unique Shipper's Order ID |
|item_price | Number | - | Optional | Subjected to selecting item_insurance. Value of items |
|special_instructions | Textarea | - | Optional | Special Instructions for Delivery |
|same_day_timing_id | Textarea | - | Optional | For same-day shipping mode, define the timeline in  which the shipment will be delivered|
|open_shipment | Select | - | Optional | Allow opening of shipment |
|pieces_quantity | Number | - | Optional | To book multiple parcels per shipment. Number of parcels. |
|shipper_reference_number_1 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_2 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_3 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_4 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_5 | Text | - | Optional | Custom attributes/reference that shipper wants to add |

```php
<?php

try {
    $config = array(
        "type" => "regular",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

## Get Form Fields - Replacement Shipment

Get Form Fields allows you to easily get and customize form fields setup based on the shipment type provided.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|delivery_type_id | Select | Regular | Required | Appendix G |
|pickup_address_id | Select | First Location | Required | List of pick up locations added in Trax. |
|information_display | Select | Show | Required | Show or Hide contact details on Shipping Label/Airway Bill |
|consignee_city_id | Select | Lahore | Required | List of cities from Trax. Can be overridden by providing "cities" in config. |
|consignee_name | Text | - | Required | Name of Consignee |
|consignee_address | Text | - | Required | Address of Consignee |
|consignee_phone_number_1 | Phone Number / Text| - | Required | Phone Number of Consignee |
|consignee_email_address | Email | - | Required | Email of Consignee |
|item_product_type_id | Select | Marketplace | Required | Appendix B |
|item_description | Text | - | Required | Description of Goods |
|item_quantity | Number | 1 | Required | Number of Items |
|item_insurance | Select | No Insurance | Required | Insured, No Insurance |
|item_price | Number | - | Required | Subjected to selecting item_insurance. Value of items |
|replacement_item_product_type_id | Select | Marketplace | Required | Appendix B |
|replacement_item_quantity | Number | 1 | Required | Replacement Number of Items |
|pickup_date | Date | - | Required | Date of Shipment |
|estimated_weight | Number | 1 | Required | Estimated weight of shipment |
|shipping_mode_id | Select | Rush | Required | Appendix C |
|amount | Number | 500 | Required | Amount of shipment |
|payment_mode_id | Select | Cash on Delivery | Required | Appendix D |
|charges_mode_id | Select | Invoicing | Required | Appendix F |
|consignee_phone_number_2 | Phone Number / Text | - | Optional | Additional phone number of Consignee |
|order_id | Text | - | Optional | Unique Shipper's Order ID |
|replacement_item_image | File | - | Optional | Replacement Item Image |
|special_instructions | Textarea | - | Optional | Special Instructions for Delivery |
|same_day_timing_id | Textarea | - | Optional | For same-day shipping mode, define the timeline in  which the shipment will be delivered|
|open_shipment | Select | - | Optional | Allow opening of shipment |
|pieces_quantity | Number | - | Optional | To book multiple parcels per shipment. Number of parcels. |
|shipper_reference_number_1 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_2 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_3 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_4 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_5 | Text | - | Optional | Custom attributes/reference that shipper wants to add |

```php
<?php

try {
    $config = array(
        "type" => "replacement",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

## Get Form Fields - Try & Buy Shipment

Get Form Fields allows you to easily get and customize form fields setup based on the shipment type provided.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|delivery_type_id | Select | Regular | Required | Appendix G |
|pickup_address_id | Select | First Location | Required | List of pick up locations added in Trax. |
|information_display | Select | Show | Required | Show or Hide contact details on Shipping Label/Airway Bill |
|consignee_city_id | Select | Lahore | Required | List of cities from Trax. Can be overridden by providing "cities" in config. |
|consignee_name | Text | - | Required | Name of Consignee |
|consignee_address | Text | - | Required | Address of Consignee |
|consignee_phone_number_1 | Phone Number / Text| - | Required | Phone Number of Consignee |
|consignee_email_address | Email | - | Required | Email of Consignee |
|items[n][item_product_type_id] | Select | Marketplace | Required | Appendix B |
|items[n][item_description] | Text | - | Required | Description of Goods |
|items[n][item_quantity] | Number | 1 | Required | Number of Items |
|items[n][item_insurance] | Select | No Insurance | Required | Insured, No Insurance |
|items[n][item_value] | Number | 1 | Required | Value of Item |
|items[n][item_price] | Number | - | Required | Subjected to selecting item_insurance. Value of items |
|package_type | Select | 1 | Required | 1=Complete, 2 = Partial |
|try_and_buy_fees | Number | 500 | Required | The fees for try and buy |
|pickup_date | Date | - | Required | Date of Shipment |
|estimated_weight | Number | 1 | Required | Estimated weight of shipment |
|shipping_mode_id | Select | Rush | Required | Appendix C |
|amount | Number | 500 | Required | Amount of shipment |
|payment_mode_id | Select | Cash on Delivery | Required | Appendix D |
|charges_mode_id | Select | Invoicing | Required | Appendix F |
|consignee_phone_number_2 | Phone Number / Text | - | Optional | Additional phone number of Consignee |
|order_id | Text | - | Optional | Unique Shipper's Order ID |
|replacement_item_image | File | - | Optional | Replacement Item Image |
|special_instructions | Textarea | - | Optional | Special Instructions for Delivery |
|same_day_timing_id | Textarea | - | Optional | For same-day shipping mode, define the timeline in  which the shipment will be delivered|
|open_shipment | Select | - | Optional | Allow opening of shipment |
|pieces_quantity | Number | - | Optional | To book multiple parcels per shipment. Number of parcels. |
|shipper_reference_number_1 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_2 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_3 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_4 | Text | - | Optional | Custom attributes/reference that shipper wants to add |
|shipper_reference_number_5 | Text | - | Optional | Custom attributes/reference that shipper wants to add |

```php
<?php

try {
    $config = array(
        "type" => "tryandbuy",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

### Customize Form Fields

All fields of the form can be customized using the following syntax. Pass these keys along with the value in the Config.


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|Classess | {field_name}-class | item_description-class | Add classess to the input field |
|Attributes | {field_name}-attr | item_quantity-attr | Add custom attributes to the input field |
|Wrappers | {field_name}-wrapper | item_description-wrapper | Add custom html element types to the input field. For example '<div>' or '<custom>' |
|Labels | {field_name}-label | consignee_address-label | Add custom labels to the input field |
|Cities | cities | - | Provide a custom list of cities to replace the trax list. May cause issue if value does not match Trax system. |
|Default Value | {field_name} | consignee_name | Add a default value to the input field |
|Input Wrappers | wrappers | - | Add a custom wrappers to the entire input and label field element. For example, wrap everything within a <div> |
|Label Class | label_class | - | Add classess to the label field |
|Sort Order | sort_order | sort_order[] | An array with field names, any missing items will use default order after the defined order |
|Custom Options | custom_options | custom_options[] | An array with label and value keys. Only applicable to select fields |
|Optional Fields | optional | optional | Enable/Disable optional fields. true/false |
|Selective Optional Fields | optional_selective[] | optional_selective[] | Enable/Disable only certain optional fields. An array of optional field names to enable |
|Try & Buy Row| try_buy_fees_row | try_buy_fees_row | Wrappers can be aded to Try and Buy item row. It will wrap all internal fields, item description, price, quantity etc within a row which can be configured to create add and remove rows for dynamic items. Only for Try and Buy type. |

#### Customize Form Fields - Classess

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "consignee_address-class" => "custom_class",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
#### Customize Form Fields - Attributes

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "item_quantity-attr" => "min='0' max='10'",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Wrappers

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "item_description-wrapper" => "textarea",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Labels

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "consignee_city_id" => "Karachi",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Cities

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "cities" => array(array("value" => "223", "label" => "Lahore")),
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Default Value

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "item_insurance" => "Insured",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Input Wrappers

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "wrappers" => array(
            "delivery_type_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "pickup_address_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        )
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


#### Customize Form Fields - Label Class


```php
<?php

try {
    $config = array(
        "type" => "regular",
        "label_class" => "form-label",
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Example Configuration


```php
<?php

try {
    $config = array(
        "type" => "regular",
        "response" => "form",
        "label_class" => "form-label",
        "input_class" => "form-control",
        "wrappers" => array(
            "delivery_type_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "pickup_address_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "information_display" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_city_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_phone_number_1" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_email_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "item_product_type_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "item_description" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "item_quantity" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "item_insurance" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "pickup_date" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "estimated_weight" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipping_mode_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "amount" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "payment_mode_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "charges_mode_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        )
    );
    $response = $traxAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Sort Order

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "sort_order" => array(
            "consignee_name",
            "information_display",
            "consignee_city_id",
        )
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Custom Options

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "custom_options" => array(
            "same_day_timing_id" => array(
                array(
                    "label" => "6 Hours",
                    "value" => 1
                )
            )
        )
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Optional Fields

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "optional" => false
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Selective Optional Fields

```php
<?php

try {
    $config = array(
        "type" => "regular",
        "optional" => false,
        "optional_selective" => array(
            "shipper_reference_number_1",
            "order_id"
        ),
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Try & Buy Row

To contain all try and buy items [n] a helper is provided to wrap row into a wrapper allowing for customization using javascript/jquery to create dynamic row entries. All [n] fields can be customized as previously. Below example will wrap all fields into a parent div.

```php
<?php

try {
    $config = array(
        "type" => "tryandbuy",
        "wrappers" => array(
            "try_buy_fees_row" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row try_buy_item_row">',
                "input_wrapper_end" => "</div></div>"
            ),
        ),
    );
    $response = $traxAPI->getFormFields($config);
} catch (TechAndaz\Trax\TraxException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```