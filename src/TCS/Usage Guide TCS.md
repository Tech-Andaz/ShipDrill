
## Usage Guide - TCS
## Table of Contents
- [Initialize TCS Client](#initialize)
- [Add Shipment](#add-shipment)
- [Track Shipment](#track-shipment)
- [Get City List](#get-city-list)
- [Print Shipping Label](#print-shipping-label)
- [Get Form Fields](#get-form-fields)
## Initialize
```php
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
    ) //Optional if sandbox, Defaults to Karachi Center. Required array if production.
));
$TCSAPI = new TCSAPI($TCSClient);
?>
```
## Add Shipment
```php
<?php
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
?>
```
## Track Shipment
```php
<?php
try {
    $tracking_number = "779404467784";
    $type = "data"; //Optional - Defaults to url. Options are: data / url / redirect
    $response = $TCSAPI->trackShipment($tracking_number, $type);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get City List
```php
<?php
try {
    $response = $TCSAPI->getCityList();
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Print Shipping Label
```php
<?php
try {
    $tracking_number = "779404467784";
    $type = "url"; //Optional - Defaults to url. Options are: url / redirect
    $response = $TCSAPI->printShippingLabel($tracking_number, $type);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Form Fields

Get Form Fields allows you to easily get and customize form fields.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|cost_center | Select | - | Required | The cost center/pick up location  |
|consignee_name | Phone | - | Required | Name of the Consignee |
|consignee_phone | Text | - | Required | Phone Number of the Consignee |
|consignee_email | Email | - | Required | Email of the Consignee |
|consignee_address | Text | - | Required | Address of the Consignee |
|consignee_city | Select | - | Required | City of the Consignee |
|weight | Number | - | Required | Weight of the package |
|pieces | Number | - | Required | Number of parcels |
|amount | Number | - | Required | Amount of the package |
|order_id | Text | - | Optional | Order ID |
|service_id | Select | - | Optional | Type of service |
|order_details | Text | - | Optional | Order Description |
|fragile | Select | - | Optional | Is the package fragile |
|remarks | Text | - | Optional | Order Remarks |
|insurance_value | Number | - | Optional | Insurance Value |

```php
<?php
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
?>
```

### Customize Form Fields

All fields of the form can be customized using the following syntax. Pass these keys along with the value in the Config.


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|Classess | {field_name}-class | cost_center-class | Add classess to the input field |
|Attributes | {field_name}-attr | consignee_name-attr | Add custom attributes to the input field |
|Wrappers | {field_name}-wrapper | consignee_phone-wrapper | Add custom html element types to the input field. For example '<div>' or '<custom>' |
|Labels | {field_name}-label | consignee_email-label | Add custom labels to the input field |
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
        "amount-class" => "custom_class",
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
#### Customize Form Fields - Attributes

```php
<?php

try {
    $config = array(
        "amount-attr" => "step='0.00' min='0'",
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Wrappers

```php
<?php

try {
    $config = array(
        "order_details-wrapper" => "textarea",
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Labels

```php
<?php

try {
    $config = array(
        "consignee_name" => "Customer Name",
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Default Value

```php
<?php

try {
    $config = array(
        "consignee_name" => "Tech Andaz",
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
        )
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
?>
```

#### Customize Form Fields - Sort Order

```php
<?php

try {
    $config = array(
        "sort_order" => array(
            "cost_center",
            "consignee_name",
        )
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
            "fragile" => array(
                array(
                    "label" => "Yes",
                    "value" => "1"
                )
            )
        )
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
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
            "order_details",
        ),
    );
    $response = $TCSAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\TCS\TCSException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```