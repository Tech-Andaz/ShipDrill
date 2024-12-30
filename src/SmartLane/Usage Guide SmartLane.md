
## Usage Guide - Smart Lane
## Table of Contents - Smart Lane Usage Guide
- [Initialize Smart Lane Client](#initialize)
- [Get City List](#get-city-list)
- [Get Warehouse List](#get-warehouse-list)
- [Get Shipping Label](#get-shipping-label)
- [Track Shipment](#track-shipment)
- [Cancel Shipment](#cancel-shipment)
- [Create Shipment](#create-shipment)
- [Get Form Fields](#get-form-fields)
## Initialize
```php
<?php

require 'vendor/autoload.php';

use TechAndaz\SmartLane\SmartLaneClient;
use TechAndaz\SmartLane\SmartLaneAPI;

$SmartLaneClient = new SmartLaneClient(array(
    "api_token" => "kktelzTjknBvP3qDrxU28rrgd6Ywn32PraaM6re7", //Token determins sandbox or production
));
$SmartLaneAPI = new SmartLaneAPI($SmartLaneClient);
?>
```
## Get City List
```php
<?php
try {
    $response = $SmartLaneAPI->getCityList();
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Warehouse List
```php
<?php
try {
    $response = $SmartLaneAPI->getWarehouseList();
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Shipping Label
```php
<?php
try {
    $store_order_id = "AF-100171";
    $response = $SmartLaneAPI->printShippingLabel($store_order_id);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Track Shipment
```php
<?php
try {
    $store_order_id = "AF-10017";
    $response = $SmartLaneAPI->trackShipment($store_order_id);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Cancel Shipment
```php
<?php
try {
    $store_order_id = "AF-10017";
    $response = $SmartLaneAPI->cancelShipment($store_order_id);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Create Booking
```php
<?php
try {
    $data = [
        'warehouse_code' => 'WH1690289367237',
        'store_order_id' => "AF-1001712", //Optional, will assign unique if not provided
        'consignee_name' => 'Tech Andaz',
        'consignee_phone' => '+924235113700',
        'consignee_email' => 'contact@techandaz.com',
        'consignee_address' => '119/2 M Quaid-e-Azam Industrial Estate, Kot Lakhpat',
        'consignee_city' => 'Lahore',
        'description' => 'Order ID: 12345', // Optional
        'payment_method' => "cod",
        'amount' => 1000,
        'product_count' => 4,
        'products' => array(
            array(
                "sku" => "1002",
                "name" => "Web Development",
                "qty" => 2,
            ),
            array(
                "sku" => "1003",
                "name" => "App Development",
                "qty" => 2,
            ),
        )
        
    ];
    $response = $SmartLaneAPI->createBookings($data);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Form Fields

Get Form Fields allows you to easily get and customize form fields.


| Field Name | Type | Default Value | Field Type | Options/Info |
| -------- | ------- | ------- | ------- | ------- |
|warehouse_code | Select | - | Required | The Warehouse Code |
|store_order_id | Text | - | Optional | Store Order ID |
|consignee_name | Text | - | Required | Name of the Consignee |
|consignee_email | Email | - | Required | Email of the Consignee |
|consignee_phone | Phone | - | Required | Phone Number of Consignee |
|consignee_address | Text | - | Required | Address of the Consignee |
|consignee_city | Select | - | Required | City of the Consignee |
|description | Text | - | Optional | Description of the Order |
|payment_method | Select | - | Required | cod/paid |
|product_count | Number | - | Required | Number of Products |
|amount | Number | - | Required | Amount of Order |
|products_row | Row | - | - | Row that encapsulates Product entries |
|- | - | - | - | - |
|products[0][sku] | Text | - | Required | SKU of the Product |
|products[0][name] | Text | - | Required | Name of the Product |
|products[0][qty] | Number | - | Required | Quantity of the Product |

```php
<?php
try { 
    $config = array(
        "response" => "form",
        "label_class" => "form-label",
        "input_class" => "form-control",
        "wrappers" => array(
            "warehouse_code" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "store_order_id" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_email" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "consignee_phone" => array(
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
            "description" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "payment_method" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_count" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "amount" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "products_row" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                "input_wrapper_end" => "</div></div>"
            ),
            "product_sku" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-4">',
                "input_wrapper_end" => "</div>"
            ),
            "product_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-4">',
                "input_wrapper_end" => "</div>"
            ),
            "quantity" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-4">',
                "input_wrapper_end" => "</div>"
            ),
        ),
        "optional" => true,
    );
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
            "products_row" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                "input_wrapper_end" => "</div></div>"
            ),
            "products[name]" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        )
    );
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
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
    $response = $SmartLaneAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\SmartLane\SmartLaneException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```