
## Usage Guide - PandaGo## Table of Contents - PandaGo Usage Guide
- [Initialize PandaGo Client](#initialize)
- [Submit a New Order](#submit-a-new-order)
- [Get Specific Order](#get-specific-order)
- [Cancel Specific Order](#cancel-specific-order)
- [Update Specific Order](#update-specific-order)
- [Proof of Pickup](#proof-of-pickup)
- [Proof of Delivery](#proof-of-delivery)
- [Proof of Return](#proof-of-return)
- [Get Rider Coordinates](#get-rider-coordinates)
- [Estimate Fee For an Order](#estimate-fee-for-an-order)
- [Estimate Time For an Order](#estimate-time-for-an-order)
- [Create Or Update an Outlet](#create-or-update-an-outlet)
- [Get an Outlet](#get-an-outlet)
- [Get all Outlets](#get-all-outlets)
- [Get Form Fields](#get-form-fields)
## Initialize

```php
<?php

require 'vendor/autoload.php';

use TechAndaz\PandaGo\PandaGoClient;
use TechAndaz\PandaGo\PandaGoAPI;

// Initiliaze Client API credentials and Token & API URL. If you don't provide URL it will use production URL automatically.
//TEST TOKEN URL - https://sts-st.deliveryhero.io/
//LIVE TOKEN URL - https://sts.deliveryhero.io/
//TEST API URL - https://pandago-api-sandbox.deliveryhero.io/sg/api/v1/
//LIVE TOKEN URL - https://pandago-api-sandbox.deliveryhero.io/sg/api/v1/

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
?>
```
## Submit a New Order

```php
<?php
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
?>
```
## Get Specific Order

```php
<?php
try {
    $order_id = "a-xfen-a06d04";
    $response = $PandaGoAPI->fetchOrder($order_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Cancel Specific Order

```php
<?php
try {
    $order_id = "a-xfen-c0ad86";
    $reason = "REASON_UNKNOWN";
    $response = $PandaGoAPI->cancelOrder($order_id, $reason);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Update Specific Order

```php
<?php
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
?>
```
## Proof of Pickup

```php
<?php
try {
    $order_id = "a-xfen-147164";
    $response = $PandaGoAPI->proofOfPickup($order_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Proof of Delivery

```php
<?php
try {
    $order_id = "a-xfen-147164";
    $response = $PandaGoAPI->proofOfDelivery($order_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Proof of Return

```php
<?php
try {
    $order_id = "a-xfen-147164";
    $response = $PandaGoAPI->proofOfReturn($order_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Rider Coordinates

```php
<?php
try {
    $order_id = "a-xfen-147164";
    $response = $PandaGoAPI->getRiderCoordinates($order_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Estimate Fee For an Order

```php
<?php
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
?>
```
## Estimate Time For an Order

```php
<?php
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
    $response = $PandaGoAPI->estimateDeliveryTime($orderData);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Create Or Update an Outlet

```php
<?php
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
?>
```
## Get an Outlet

```php
<?php
try {
    $outlet_id = "658aedab00869";
    $response = $PandaGoAPI->getOutlet($outlet_id);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get all Outlets

```php
<?php
try {
    $response = $PandaGoAPI->getAllOutlets();
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Form Fields - Sender Outlet

Get Form Fields allows you to easily get and customize form fields.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|sender[client_vendor_id] | Select | - | Required | The outlet from where the order is to be picked up from |
|sender[notes] | Text | - | Optional | Notes by the Sender |
|recipient[name] | Text | - | Optional | Name of the Recipient |
|recipient[phone_number] | Phone Number / Text | - | Optional | Phone number of the Recipient |
|recipient[location][address] | Text | - | Required | Phone Number of the Recipient |
|recipient[location][latitude] | Number | - | Required | Latitude of the Recipient |
|recipient[location][longitude] | Number | - | Required | Longitude of the Recipient |
|recipient[location][postalcode] | Text | - | Optional | Postal Code of the Recipient |
|recipient[location][notes] | Text | - | Optional | Notes by the Recipient |
|payment_method | Select | Cash on Delivery | Required | The payment method of the order|
|coldbag_needed | Select | Not Required | Optional | If a coldbag is needed|
|amount | Number | - | Required | Amount of the order|
|description | Text | - | Required | Description of the order |
|preordered_for | Date/Time | - | Optional | Date Time picker for scheduled delivery time|
|delivery_tasks[age_validation_required] | Select | Not Required | Optional | If age validation by rider is required|

```php
<?php

try { 
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
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

## Get Form Fields - Sender Details

Get Form Fields allows you to easily get and customize form fields.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|sender[name] | Text | - | Optional | Name of the Sender |
|sender[phone_number] | Phone Number / Text | - | Optional | Phone number of the sender |
|sender[location][address] | Text | - | Optional | Phone Number of the sender |
|sender[location][latitude] | Number | - | Required | Latitude of the Sender |
|sender[location][longitude] | Number | - | Required | Longitude of the Sender |
|sender[location][postalcode] | Text | - | Optional | Postal Code of the Sender |
|sender[notes] | Text | - | Optional | Notes by the Sender |
|recipient[name] | Text | - | Optional | Name of the Recipient |
|recipient[phone_number] | Phone Number / Text | - | Optional | Phone number of the Recipient |
|recipient[location][address] | Text | - | Required | Phone Number of the Recipient |
|recipient[location][latitude] | Number | - | Required | Latitude of the Recipient |
|recipient[location][longitude] | Number | - | Required | Longitude of the Recipient |
|recipient[location][postalcode] | Text | - | Optional | Postal Code of the Recipient |
|recipient[location][notes] | Text | - | Optional | Notes by the Recipient |
|payment_method | Select | Cash on Delivery | Required | The payment method of the order|
|coldbag_needed | Select | Not Required | Optional | If a coldbag is needed|
|amount | Number | - | Required | Amount of the order|
|description | Text | - | Required | Description of the order |
|preordered_for | Date/Time | - | Optional | Date Time picker for scheduled delivery time|
|delivery_tasks[age_validation_required] | Select | Not Required | Optional | If age validation by rider is required|

```php
<?php

try { 
    $config = array(
        "sender_type" => "sender_details",
        "response" => "form",
        "label_class" => "form-label",
        "input_class" => "form-control",
        "wrappers" => array(
            "sender[name]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "sender[phone_number]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "sender[location][address]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "sender[location][latitude]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "sender[location][longitude]" => array(
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
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

### Customize Form Fields

All fields of the form can be customized using the following syntax. Pass these keys along with the value in the Config.


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|Classess | {field_name}-class | sender[location][address]-class | Add classess to the input field |
|Attributes | {field_name}-attr | sender[location][latitude]-attr | Add custom attributes to the input field |
|Wrappers | {field_name}-wrapper | sender[location][longitude]-wrapper | Add custom html element types to the input field. For example '<div>' or '<custom>' |
|Labels | {field_name}-label | payment_method-label | Add custom labels to the input field |
|Default Value | {field_name} | amount | Add a default value to the input field |
|Input Wrappers | wrappers | - | Add a custom wrappers to the entire input and label field element. For example, wrap everything within a <div> |
|Label Class | label_class | - | Add classess to the label field |
|Sort Order | sort_order | sort_order[] | An array with field names, any missing items will use default order after the defined order |
|Custom Options | custom_options | custom_options[] | An array with label and value keys. Only applicable to select fields |
|Optional Fields | optional | optional | Enable/Disable optional fields. true/false |
|Selective Optional Fields | optional_selective[] | optional_selective[] | Enable/Disable only certain optional fields. An array of optional field names to enable |

#### Customize Form Fields - Classess

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "payment_method-class" => "custom_class",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
#### Customize Form Fields - Attributes

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "amount-attr" => "step='0.00' min='0'",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Wrappers

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "description-wrapper" => "textarea",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Labels

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "payment_method" => "Mode of Payment",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Default Value

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "recipient[name]" => "Tech Andaz",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Input Wrappers

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "wrappers" => array(
            "sender[client_vendor_id]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "recipient[name]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        )
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```


#### Customize Form Fields - Label Class


```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "label_class" => "form-label",
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Example Configuration


```php
<?php

try { 
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
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

#### Customize Form Fields - Sort Order

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "sort_order" => array(
            "amount",
            "payment_method",
            "sender[client_vendor_id]",
        )
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Custom Options

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "custom_options" => array(
            "sender[client_vendor_id]" => array(
                array(
                    "label" => "Tech Andaz",
                    "value" => "23456"
                )
            )
        )
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Optional Fields

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "optional" => false
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Selective Optional Fields

```php
<?php

try {
    $config = array(
        "sender_type" => "sender_details",
        "optional" => false,
        "optional_selective" => array(
            "coldbag_needed",
            "preordered_for"
        ),
    );
    $response = $PandaGoAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\PandaGo\PandaGoException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```