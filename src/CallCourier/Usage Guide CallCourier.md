
## Usage Guide - Call Courier
## Table of Contents - Call Courier Usage Guide
- [Initialize Call Courier Client](#initialize)
- [Get Return City List](#get-return-city-list)
- [Get Origin City List](#get-origin-city-list)
- [Get Service Types](#get-service-types)
- [Check if Service is COD](#check-if-service-is-cod)
- [Get City List By Service](#get-city-list-by-service)
- [Get Areas By Cities](#get-areas-by-city)
- [Get Shipping Label](#get-shipping-label)
- [Get Tracking History](#get-tracking-history)
- [Get Tracking By Reference Number](#get-tracking-by-reference-number)
- [Get Tracking Status List](#get-tracking-status-list)
- [Create Booking](#create-booking)
- [Get Form Fields](#get-form-fields)
## Initialize
```php
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
?>
```
## Get Return City List
```php
<?php
try {
    $response = $CallCourierAPI->getReturnCityListByShipper();
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Origin City List
```php
<?php
try {
    $response = $CallCourierAPI->getOriginCityListByShipper();
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Service Types
```php
<?php
try {
    $response = $CallCourierAPI->getServiceTypes();
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Check if Service is COD
```php
<?php
try {
    $service_id = "1";
    $response = $CallCourierAPI->checkIfServiceIsCOD($service_id);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get City List By Service
```php
<?php
try {
    $service_id = "1";
    $response = $CallCourierAPI->getCityListByService($service_id);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Areas By Cities
```php
<?php
try {
    $city_id = "1";
    $response = $CallCourierAPI->getAreasByCity($city_id);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Shipping Label
```php
<?php
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
?>
```
## Get Tracking History
```php
<?php
try { 
    $cn_number = "10002423232893";
    $response = $CallCourierAPI->getTrackingHistory($cn_number);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Tracking By Reference Number
```php
<?php
try { 
    $order_reference = "56270876367";
    $response = $CallCourierAPI->getTrackingByReferenceNumber($order_reference);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Tracking Status List
```php
<?php
try {
    $response = $CallCourierAPI->getTrackingStatusList();
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Create Booking
```php
<?php
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
                "amount" => "100",
                "box_id" => "My Box ID",
                "origin" => "Domestic", // Optional - Defaults to "Domestic"
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
                "amount" => "100",
                "box_id" => "My Box ID",
                "origin" => "Domestic", // Optional - Defaults to "Domestic"
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
?>
```
## Get Form Fields

Get Form Fields allows you to easily get and customize form fields.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|shipper_name | Text | - | Required | The name of the Shipper  |
|shipper_cell | Phone | - | Required | Phone Number of Shipper |
|shipper_city | Select | - | Required | City of the Shipper |
|shipper_area | Select | - | Required | Area of the Shipper |
|shipper_landline | Phone | - | Required | Phone Number of Shipper |
|shipper_address | Text | - | Optional | Address of the Shipper |
|shipper_return_address | Text | - | Optional | Return Address of the Shipper |
|shipper_email | Email | - | Optional | Email of the Shipper |
|bookings_row | Row | - | - | Row that encapsulates shipment entries |
|- | - | - | - | - |
|bookings[0][name] | Text | - | Required | Name of the Consignee |
|bookings[0][reference_number] | Text | - | Required | Reference Number of Order |
|bookings[0][cell] | Phone | - | Required | Phone Number of the Consignee |
|bookings[0][address] | Text | - | Required | Address of the Consignee |
|bookings[0][city] | Select | - | Required | City of the Consignee |
|bookings[0][pieces] | Number | - | Required | Number of Pieces |
|bookings[0][weight] | Number | - | Required | Weight of Package |
|bookings[0][description] | Text | - | Required | Description of the Package |
|bookings[0][amount] | Number | - | Required | Amount of the Package |
|bookings[0][box_id] | Text | - | Required | Box ID |
|bookings[0][special_handling] | Select | - | Optional | True / False |
|bookings[0][holiday] | Select | - | Optional | True / False |
|bookings[0][remarks] | Text | - | Optional | Remarks |
|bookings[0][origin] | Text | - | Optional | Origin |

```php
<?php

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

?>
```

### Customize Form Fields

All fields of the form can be customized using the following syntax. Pass these keys along with the value in the Config.


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|Classess | {field_name}-class | reference_number-class | Add classess to the input field |
|Attributes | {field_name}-attr | address-attr | Add custom attributes to the input field |
|Wrappers | {field_name}-wrapper | bookings[0][name]-wrapper | Add custom html element types to the input field. For example '<div>' or '<custom>' |
|Labels | {field_name}-label | shipper_area-label | Add custom labels to the input field |
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
        "weight-class" => "custom_class",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
#### Customize Form Fields - Attributes

```php
<?php

try {
    $config = array(
        "weight-attr" => "step='0.00' min='0'",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Wrappers

```php
<?php

try {
    $config = array(
        "description-wrapper" => "textarea",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Labels

```php
<?php

try {
    $config = array(
        "shipper_name" => "Shipper Name",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Default Value

```php
<?php

try {
    $config = array(
        "shipper_name" => "Tech Andaz",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Input Wrappers

```php
<?php

try {
    $config = array(
        "wrappers" => array(
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
        )
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```


#### Customize Form Fields - Label Class


```php
<?php

try {
    $config = array(
        "label_class" => "form-label",
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Example Configuration


```php
<?php
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
?>
```

#### Customize Form Fields - Sort Order

```php
<?php

try {
    $config = array(
        "sort_order" => array(
            "shipper_name",
            "shipper_return_address",
        )
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

#### Customize Form Fields - Custom Options

```php
<?php

try {
    $config = array(
        "custom_options" => array(
            "shipper_city" => array(
                array(
                    "label" => "LAHORE",
                    "value" => "1"
                )
            )
        )
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

#### Customize Form Fields - Optional Fields

```php
<?php

try {
    $config = array(
        "optional" => false
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

#### Customize Form Fields - Selective Optional Fields

```php
<?php

try {
    $config = array(
        "optional" => false,
        "optional_selective" => array(
            "bookings[0][remarks]",
        ),
    );
    $response = $CallCourierAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\CallCourier\CallCourierException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```