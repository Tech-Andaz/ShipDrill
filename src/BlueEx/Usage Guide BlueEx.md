
## Usage Guide - BlueEx
## Table of Contents - BlueEx Usage Guide
- [Initialize BlueEx Client](#initialize)
- [Place Order](#place-order)
- [Cancel Shipment](#cancel-shipment)
- [Reverse Pickup](#reverse-pickup)
- [Create Loadsheet](#create-loadsheet)
- [Get Service Types](#get-service-types)
- [Get Cities](#get-cities)
- [Get Tariff](#get-tariff)
- [Get Shipment Tracking](#get-shipment-tracking)
- [Get Shipment Info](#get-shipment-info)
- [Get Shipment Settlement](#get-shipment-settlement)
- [Get Shipment Status](#get-shipment-status)
- [Get All Pickup Locations](#get-all-pickup-locations)
- [Get Pickup Location](#get-pickup-location)
- [Print Shipping Label](#print-shipping-label)
- [Get Form Fields](#get-form-fields)
## Initialize

```php
<?php

require 'vendor/autoload.php';

use TechAndaz\BlueEx\BlueExClient;
use TechAndaz\BlueEx\BlueExAPI;

//LIVE URL - https://bigazure.com/api/json_v3/
$BlueExClient = new BlueExClient("KHI-00000", "64jkuyeh75hkjstgh87", "https://bigazure.com/api/json_v3/");
$BlueExAPI = new BlueExAPI($BlueExClient);
?>
```
## Place Order

```php
<?php
try {
    $data = array(
        "shipper_name" => "Mubeen Dewani",
        "shipper_email" => "mubeen.dewani@blue-ex.com",
        "shipper_contact" => "03242646886",
        "shipper_address" => "Plot # 5 blueEx Awami Markaz Shahrah-E-Faisal Karachi",
        "shipper_city" => "LHE",
        "customer_name" => "FAHAD",
        "customer_email" => "mubeen.dewani@blue-ex.com",
        "customer_contact" => "03242646886",
        "customer_address" => "Plot # 5 blueEx Awami Markaz Shahrah-E-Faisal Karachi",
        "customer_city" => "KHI",
        "customer_country" => "PK",
        "customer_comment" => "demo",
        "shipping_charges" => "150",
        "payment_type" => "COD",
        "service_code" => "BE",
        "total_order_amount" => "4150.00",
        "total_order_weight" => "1",
        "order_refernce_code" => "bluedemo1",
        "fragile" => "N",
        "parcel_type" => "P",
        "insurance_require" => "N",
        "insurance_value" => "0",
        "testbit" => "Y",
        "cn_generate" => "Y",
        "multi_pickup" => "Y",
        "products_detail" => array(
            array(
                "product_code" => "1005",
                "product_name" => "Polo T shirt",
                "product_price" => "1000",
                "product_weight" => "0.5",
                "product_quantity" => "2",
                "product_variations" => "small-black",
                "sku_code" => "12assk11aa"
            )
        )
    );
    $response = $BlueExAPI->createShipment($data);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Cancel Shipment

```php
<?php
try {
    $consignment_no = "5027729332";
    $response = $BlueExAPI->cancelShipment($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Reverse Pickup

```php
<?php
try {
    $consignment_no = "5027729337";
    $response = $BlueExAPI->reversePickup($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Create Loadsheet

```php
<?php
try {
    $consignment_no = "5027729332, 5027729337";
    $response = $BlueExAPI->createLoadsheet($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Service Types

```php
<?php
try {
    $response = $BlueExAPI->getServiceType();
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Cities

```php
<?php
try {
    $country_code = "PK";
    $response = $BlueExAPI->getCities($country_code);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Tariff

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
## Get Shipment Tracking

```php
<?php
try {
    $consignment_no = "5027729334";
    $response = $BlueExAPI->getShipmentTracking($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Shipment Info

```php
<?php
try {
    $consignment_no = "5027729334";
    $response = $BlueExAPI->getShipmentInfo($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Shipment Settlement

```php
<?php
try {
    $consignment_no = "5027729334";
    $response = $BlueExAPI->getShipmentSettlement($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Shipment Status

```php
<?php
try {
    $consignment_no = "5027729334";
    $response = $BlueExAPI->getShipmentStatus($consignment_no);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get All Pickup Locations

```php
<?php
try {
    $response = $BlueExAPI->getAllPickupLocations();
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Pickup Location

```php
<?php
try {
    $location_id = 31;
    $response = $BlueExAPI->getPickupLocation($location_id);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Print Shipping Label
```php
<?php
try {
    $tracking_number = "5027606021";
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
|shipper_name | Text | - | Required | Name of the Shipper |
|shipper_email | Email | - | Required | Email of the Shipper |
|shipper_contact | Phone Number / Text | - | Required | Phone number of the Shipper |
|shipper_address | Text | - | Required | Address of the Shipper |
|shipper_city | Select | - | Required | City of the Shipper |
|customer_name | Text | - | Required | Name of the Customer |
|customer_email | Email | - | Required | Email of the Customer |
|customer_contact | Phone Number / Text | - | Required | Phone number of the Customer |
|customer_address | Text | - | Required | Address of the Customer |
|customer_city | Select | - | Required | City of the Customer |
|customer_country | Select | - | Required | Country of the Customer |
|customer_comment | Text | - | Optional | Customer Comments |
|shipping_charges | Number | - | Optional | Shipping Charges |
|payment_type | Select | - | Required | Payment method |
|service_code | Select | - | Required | Service Type |
|total_order_amount | Number | - | Required | Total Order Amount |
|total_order_weight | Number | - | Required | Total Order Weight |
|order_refernce_code | Text | - | Required | Shipper Order ID or Reference Code |
|fragile | Select | - | Required | Is Item Fragile? |
|parcel_type | Select | - | Required | Parcel Type |
|insurance_require | Select | - | Required | Is Insurance Required? |
|insurance_value | Number | - | Optional | Insurance Amount |
|cn_generate | Select | - | Required | Generate CN? |
|multi_pickup | Select | - | Required | Is Multipickup requried? |
|product_code | Text | - | Optional | Product Code |
|product_name | Text | - | Required | Product Name |
|product_price | Number | - | Required | Product Price |
|product_weight | Number | - | Required | Product Weight |
|product_quantity | Number | - | Required | Quantity of Product |
|product_variations | Text | - | Optional | Product Variations |
|sku_code | Text | - | Optional | Product SKU |

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
            "shipper_email" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_contact" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_city" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_contact" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_city" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_country" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "payment_type" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "service_code" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "total_order_amount" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "total_order_weight" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "order_refernce_code" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "fragile" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "parcel_type" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "insurance_require" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "cn_generate" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "products_detail_row" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                "input_wrapper_end" => "</div></div>"
            ),
            "product_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_price" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_quantity" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_weight" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        ),
        "optional" => false,
        "optional_selective" => array(
        ),
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

### Customize Form Fields

All fields of the form can be customized using the following syntax. Pass these keys along with the value in the Config.


| Field Name | Format | Example | Options/Info |
| -------- | ------- | ------- | ------- |
|Classess | {field_name}-class | shipper_name-class | Add classess to the input field |
|Attributes | {field_name}-attr | shipper_email-attr | Add custom attributes to the input field |
|Wrappers | {field_name}-wrapper | shipper_contact-wrapper | Add custom html element types to the input field. For example '<div>' or '<custom>' |
|Labels | {field_name}-label | shipper_address-label | Add custom labels to the input field |
|Default Value | {field_name} | shipper_city | Add a default value to the input field |
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
        "shipper_name-class" => "custom_class",
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```
#### Customize Form Fields - Attributes

```php
<?php

try {
    $config = array(
        "total_order_amount-attr" => "step='0.00' min='0'",
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Wrappers

```php
<?php

try {
    $config = array(
        "customer_comment-wrapper" => "textarea",
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Labels

```php
<?php

try {
    $config = array(
        "payment_type" => "Mode of Payment",
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```

#### Customize Form Fields - Default Value

```php
<?php

try {
    $config = array(
        "customer_name" => "Tech Andaz",
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
            "shipper_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_email" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        )
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
            "shipper_email" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_contact" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "shipper_city" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_contact" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_address" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_city" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "customer_country" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "payment_type" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "service_code" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "total_order_amount" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "total_order_weight" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "order_refernce_code" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "fragile" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "parcel_type" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "insurance_require" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "cn_generate" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "products_detail_row" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-12"><div class = "row">',
                "input_wrapper_end" => "</div></div>"
            ),
            "product_name" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_price" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_quantity" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
            "product_weight" => array(
                "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                "input_wrapper_end" => "</div>"
            ),
        ),
        "optional" => false,
        "optional_selective" => array(
        ),
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
            "customer_address",
            "customer_city",
        )
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
            "customer_country" => array(
                array(
                    "label" => "Pakistan",
                    "value" => "PK"
                )
            )
        )
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
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
            "shipping_charges",
            "customer_comment"
        ),
    );
    $response = $BlueExAPI->getFormFields($config);
    return $response;
} catch (TechAndaz\BlueEx\BlueExException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
```