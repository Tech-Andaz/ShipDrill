<?php

namespace TechAndaz\SmartLane;

class SmartLaneAPI
{
    private $SmartLaneClient;
    private $callback_url;

    public function __construct(SmartLaneClient $SmartLaneClient)
    {
        $this->SmartLaneClient = $SmartLaneClient;
    }
    public function createBookings($data)
    {
        $warehouse_code = (isset($data['warehouse_code']) && $data['warehouse_code'] != "") ? $data['warehouse_code'] : throw new SmartLaneException("Warehouse Code is missing");
        $booking_list = array();
        $products = array();
        if(isset($data['products']) && is_array($data['products']) && count($data['products']) > 0){
            foreach($data['products'] as $product_index => $prod){
                array_push($products, array(
                    "sku" => (isset($prod['sku']) && $prod['sku'] != "") ? $prod['sku'] : "",
                    "name" => (isset($prod['name']) && $prod['name'] != "") ? $prod['name'] : "",
                    "qty" => (isset($prod['qty']) && $prod['qty'] != "") ? $prod['qty'] : "",
                ));
            }
        }
        array_push($booking_list, array(
            "store_order_id" => (isset($data['store_order_id']) && $data['store_order_id'] != "") ? $data['store_order_id'] : date("ymdhis"),
            "consignee_name" => (isset($data['consignee_name']) && $data['consignee_name'] != "") ? $data['consignee_name'] : throw new SmartLaneException("Consignee Name is missing for consignment at index: ". $index),
            "consignee_email" => (isset($data['consignee_email']) && $data['consignee_email'] != "") ? $data['consignee_email'] : throw new SmartLaneException("Consignee Email is missing for consignment at index: ". $index),
            "consignee_phone" => (isset($data['consignee_phone']) && $data['consignee_phone'] != "") ? $data['consignee_phone'] : throw new SmartLaneException("Consignee Phone is missing for consignment at index: ". $index),
            "consignee_address" => (isset($data['consignee_address']) && $data['consignee_address'] != "") ? $data['consignee_address'] : throw new SmartLaneException("Consignee Address is missing for consignment at index: ". $index),
            "consignee_city" => (isset($data['consignee_city']) && $data['consignee_city'] != "") ? $data['consignee_city'] : throw new SmartLaneException("Consignee City is missing for consignment at index: ". $index),
            "description" => (isset($data['description']) && $data['description'] != "") ? $data['description'] : "",
            "payment_method" => (isset($data['payment_method']) && $data['payment_method'] != "") ? $data['payment_method'] : throw new SmartLaneException("Payment Method is missing for consignment at index: ". $index),
            "amount" => (isset($data['amount']) && $data['amount'] != "") ? $data['amount'] : throw new SmartLaneException("Amount is missing for consignment at index: ". $index),
            "product_count" => (isset($data['product_count']) && $data['product_count'] != "") ? $data['product_count'] : throw new SmartLaneException("Product Count is missing for consignment at index: ". $index),
            "products" => $products
        ));
        $bookings_data = array(
            "store_warehouse_code" => $warehouse_code,
            "consignments" => $booking_list
        );
        $endpoint = "consignment/create";
        $method = 'POST';
        $payload = $this->SmartLaneClient->makeRequest($endpoint, $method, $bookings_data);
        return $payload;
    }
    public function trackShipment($store_order_id)
    {
        
        $endpoint = "consignment/track?store_order_id[]=" . $store_order_id;
        $method = 'GET';
        $payload = $this->SmartLaneClient->makeRequest($endpoint, $method, array());
        return $payload;
    }
    public function cancelShipment($store_order_id)
    {
        $data = array(
            "store_order_id" => $store_order_id,
        );
        $endpoint = "consignment/cancel";
        $method = 'POST';
        $payload = $this->SmartLaneClient->makeRequest($endpoint, $method, $data);
        return $payload;
    }
    public function printShippingLabel($store_order_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->SmartLaneClient->api_url . 'consignment/airway/bill?store_order_id[]='. $store_order_id . '&no_of_prints=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->SmartLaneClient->api_token
            ),
        ));
        $response = curl_exec($curl);
        return $response;
    }
    public function getCityList()
    {
        $endpoint = "consignment/city/list";
        $method = 'GET';
        $payload = $this->SmartLaneClient->makeRequest($endpoint, $method, array());
        return $payload;
    }
    public function getWarehouseList()
    {
        $endpoint = "consignment/warehouse/list";
        $method = 'GET';
        $payload = $this->SmartLaneClient->makeRequest($endpoint, $method, array());
        return $payload;
    }
    public function getFormFields($config)
    {
        if(!isset($config['response']) || !in_array($config['response'], ["form", "json"])){
            throw new BlueExException('Ivalid response type. Available: form, json');
        }
        if(!isset($config['optional'])){
            $config['optional'] = false;
        }
        if(isset($config['cities'])){
            $cities = $config['cities'];
        } else {
            $cities = array();
            $cities_temp = $this->getCityList();
            if($cities_temp['status'] == "success"){
                foreach ($cities_temp['data'] as $item) {
                    array_push($cities,array(
                        "value" => $item,
                        "label" => $item,
                    ));
                }
            }
        }
        if(isset($config['warehouses'])){
            $warehouses = $config['warehouses'];
        } else {
            $warehouses = array();
            $warehouses_temp = $this->getWarehouseList();
            if($warehouses_temp['status'] == "success"){
                foreach ($warehouses_temp['data'] as $item) {
                    array_push($warehouses,array(
                        "value" => $item['code'],
                        "label" => $item['name'],
                    ));
                }
            }
        }
        $cities = array_splice($cities, 0, 2);
        $payment_methods = array(
            array(
                "label" => "Cash on Delivery",
                "value" => "cod"
            ),
            array(
                "label" => "Paid",
                "value" => "paid"
            ),
        );

        $form_fields = array(
            array(
                "name" => "warehouse_code",
                "field_type" => "required",
                "classes" => isset($config['warehouse_code-class']) ? $config['warehouse_code-class'] : "",
                "attr" => isset($config['warehouse_code-attr']) ? $config['warehouse_code-attr'] : "",
                "wrapper" => isset($config['warehouse_code-wrapper']) ? $config['warehouse_code-wrapper'] : "",
                "label" => isset($config['warehouse_code-label']) ? $config['warehouse_code-label'] : "Shipper City",
                "type" => "select",
                "default" => isset($config['warehouse_code']) && in_array($config['warehouse_code'], array_column($warehouses, "value")) ? $config['warehouse_code'] : "",
                "options" => $warehouses,
                "custom_options" => isset($config['warehouse_code-custom_options']) ? $config['warehouse_code-custom_options'] : array(),
            ),
            array(
                "name" => "store_order_id",
                "field_type" => "required",
                "classes" => isset($config['store_order_id-class']) ? $config['store_order_id-class'] : "",
                "attr" => isset($config['store_order_id-attr']) ? $config['store_order_id-attr'] : "",
                "wrapper" => isset($config['store_order_id-wrapper']) ? $config['store_order_id-wrapper'] : "",
                "label" => isset($config['store_order_id-label']) ? $config['store_order_id-label'] : "Store Order ID",
                "type" => "text",
                "default" => isset($config['store_order_id']) ? $config['store_order_id'] : "",
            ),
            array(
                "name" => "consignee_name",
                "field_type" => "required",
                "classes" => isset($config['consignee_name-class']) ? $config['consignee_name-class'] : "",
                "attr" => isset($config['consignee_name-attr']) ? $config['consignee_name-attr'] : "",
                "wrapper" => isset($config['consignee_name-wrapper']) ? $config['consignee_name-wrapper'] : "",
                "label" => isset($config['consignee_name-label']) ? $config['consignee_name-label'] : "Consignee Name",
                "type" => "text",
                "default" => isset($config['consignee_name']) ? $config['consignee_name'] : "",
            ),
            array(
                "name" => "consignee_email",
                "field_type" => "required",
                "classes" => isset($config['consignee_email-class']) ? $config['consignee_email-class'] : "",
                "attr" => isset($config['consignee_email-attr']) ? $config['consignee_email-attr'] : "",
                "wrapper" => isset($config['consignee_email-wrapper']) ? $config['consignee_email-wrapper'] : "",
                "label" => isset($config['consignee_email-label']) ? $config['consignee_email-label'] : "Consignee Email",
                "type" => "email",
                "default" => isset($config['consignee_email']) ? $config['consignee_email'] : "",
            ),
            array(
                "name" => "consignee_phone",
                "field_type" => "required",
                "classes" => isset($config['consignee_phone-class']) ? $config['consignee_phone-class'] : "",
                "attr" => isset($config['consignee_phone-attr']) ? $config['consignee_phone-attr'] : "",
                "wrapper" => isset($config['consignee_phone-wrapper']) ? $config['consignee_phone-wrapper'] : "",
                "label" => isset($config['consignee_phone-label']) ? $config['consignee_phone-label'] : "Consignee Phone Number",
                "type" => "phone",
                "default" => isset($config['consignee_phone']) ? $config['consignee_phone'] : "",
            ),
            array(
                "name" => "consignee_address",
                "field_type" => "required",
                "classes" => isset($config['consignee_address-class']) ? $config['consignee_address-class'] : "",
                "attr" => isset($config['consignee_address-attr']) ? $config['consignee_address-attr'] : "",
                "wrapper" => isset($config['consignee_address-wrapper']) ? $config['consignee_address-wrapper'] : "",
                "label" => isset($config['consignee_address-label']) ? $config['consignee_address-label'] : "Consignee Address",
                "type" => "text",
                "default" => isset($config['consignee_address']) ? $config['consignee_address'] : "",
            ),
            array(
                "name" => "consignee_city",
                "field_type" => "required",
                "classes" => isset($config['consignee_city-class']) ? $config['consignee_city-class'] : "",
                "attr" => isset($config['consignee_city-attr']) ? $config['consignee_city-attr'] : "",
                "wrapper" => isset($config['consignee_city-wrapper']) ? $config['consignee_city-wrapper'] : "",
                "label" => isset($config['consignee_city-label']) ? $config['consignee_city-label'] : "Shipper City",
                "type" => "select",
                "default" => isset($config['consignee_city']) && in_array($config['consignee_city'], array_column($cities, "value")) ? $config['consignee_city'] : "lahore",
                "options" => $cities,
                "custom_options" => isset($config['consignee_city-custom_options']) ? $config['consignee_city-custom_options'] : array(),
            ),
            array(
                "name" => "description",
                "field_type" => "optional",
                "classes" => isset($config['description-class']) ? $config['description-class'] : "",
                "attr" => isset($config['description-attr']) ? $config['description-attr'] : "",
                "wrapper" => isset($config['description-wrapper']) ? $config['description-wrapper'] : "",
                "label" => isset($config['description-label']) ? $config['description-label'] : "Description",
                "type" => "text",
                "default" => isset($config['description']) ? $config['description'] : "",
            ),
            array(
                "name" => "payment_method",
                "field_type" => "required",
                "classes" => isset($config['payment_method-class']) ? $config['payment_method-class'] : "",
                "attr" => isset($config['payment_method-attr']) ? $config['payment_method-attr'] : "",
                "wrapper" => isset($config['payment_method-wrapper']) ? $config['payment_method-wrapper'] : "",
                "label" => isset($config['payment_method-label']) ? $config['payment_method-label'] : "Shipper City",
                "type" => "select",
                "default" => isset($config['payment_method']) && in_array($config['payment_method'], array_column($payment_methods, "value")) ? $config['payment_method'] : "cod",
                "options" => $payment_methods,
                "custom_options" => isset($config['payment_method-custom_options']) ? $config['payment_method-custom_options'] : array(),
            ),
            array(
                "name" => "product_count",
                "field_type" => "required",
                "classes" => isset($config['product_count-class']) ? $config['product_count-class'] : "",
                "attr" => isset($config['product_count-attr']) ? $config['product_count-attr'] : "",
                "wrapper" => isset($config['product_count-wrapper']) ? $config['product_count-wrapper'] : "",
                "label" => isset($config['product_count-label']) ? $config['product_count-label'] : "Product Count",
                "type" => "number",
                "default" => isset($config['product_count']) ? $config['product_count'] : "",
            ),
            array(
                "name" => "amount",
                "field_type" => "required",
                "classes" => isset($config['amount-class']) ? $config['amount-class'] : "",
                "attr" => isset($config['amount-attr']) ? $config['amount-attr'] : "",
                "wrapper" => isset($config['amount-wrapper']) ? $config['amount-wrapper'] : "",
                "label" => isset($config['amount-label']) ? $config['amount-label'] : "Amount",
                "type" => "number",
                "default" => isset($config['amount']) ? $config['amount'] : "",
            ),
            array(
                "name" => "products_row",
                "field_type" => "required",
                "classes" => isset($config['products_row-class']) ? $config['products_row-class'] : "",
                "attr" => isset($config['products_row-attr']) ? $config['products_row-attr'] : "",
                "wrapper" => isset($config['products_row-wrapper']) ? $config['products_row-wrapper'] : "",
                "label" => isset($config['products_row-label']) ? $config['products_row-label'] : "Products",
                "type" => "row",
                "default" => isset($config['products_row']) ? $config['products_row'] : "",
                "row_fields" => array(
                    array(
                        "name" => "products[0][sku]",
                        "field_type" => "required",
                        "classes" => isset($config['product_sku-class']) ? $config['product_sku-class'] : "",
                        "attr" => isset($config['product_sku-attr']) ? $config['product_sku-attr'] : "",
                        "wrapper" => isset($config['product_sku-wrapper']) ? $config['product_sku-wrapper'] : "",
                        "label" => isset($config['product_sku-label']) ? $config['product_sku-label'] : "SKU",
                        "type" => "text",
                        "default" => isset($config['product_sku']) ? $config['product_sku'] : "",
                    ),
                    array(
                        "name" => "products[0][name]",
                        "field_type" => "required",
                        "classes" => isset($config['product_name-class']) ? $config['product_name-class'] : "",
                        "attr" => isset($config['product_name-attr']) ? $config['product_name-attr'] : "",
                        "wrapper" => isset($config['product_name-wrapper']) ? $config['product_name-wrapper'] : "",
                        "label" => isset($config['product_name-label']) ? $config['product_name-label'] : "Name",
                        "type" => "text",
                        "default" => isset($config['product_name']) ? $config['product_name'] : "",
                    ),
                    array(
                        "name" => "products[0][qty]",
                        "field_type" => "required",
                        "classes" => isset($config['quantity-class']) ? $config['quantity-class'] : "",
                        "attr" => isset($config['quantity-attr']) ? $config['quantity-attr'] : "",
                        "wrapper" => isset($config['quantity-wrapper']) ? $config['quantity-wrapper'] : "",
                        "label" => isset($config['quantity-label']) ? $config['quantity-label'] : "Quantity",
                        "type" => "number",
                        "default" => isset($config['quantity']) ? $config['quantity'] : "",
                    ),
                )
            ),
        );
        if(isset($config["sort_order"])){
            $sorted_fields = $config["sort_order"];
            $sortedArray = array();
            foreach ($sorted_fields as $key) {
                foreach ($form_fields as $item) {
                    if ($item['name'] === $key) {
                        $sortedArray[] = $item;
                        break;
                    }
                }
            }
            foreach ($form_fields as $item) {
                if (!in_array($item['name'], $sorted_fields)) {
                    $sortedArray[] = $item;
                }
            }
            $form_fields = $sortedArray;
        }
        if($config['response'] == "form"){
            return $this->getForm($form_fields, $config);
        } else {
            return $form_fields;
        }
    }
    public function getField($form_fields, $config, $field){
        $form_html = "";
        $label_class = isset($config['label_class']) ? $config['label_class'] : "";
        $input_class = isset($config['input_class']) ? $config['input_class'] : "";
        if($field['field_type'] == "optional"){
            if($config['optional'] == false && !in_array($field['name'], $config['optional_selective'])){
                return "";
            }
        }
        if(isset($config['wrappers'][$field['name']]['input_wrapper_start'])){
            $form_html .= $config['wrappers'][$field['name']]['input_wrapper_start'];
        }
        $form_html .= '<label class="' . $label_class . '" for="' . $field['name'] . '">' . $field['label'] . '</label>';
        $wrapper_data = "name='" . $field['name'] . "' " . " class='" . $input_class . " " . $field['classes'] . "' " . $field['attr'] . " " . $field['field_type'] . " placeholder='" . $field['label'] . "'";
        if($field['type'] == "select"){
            $wrapper = "select";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $options_html = "";
            foreach($field['options'] as $option){
                $selected = "";
                if($field['default'] == $option['label']){
                    $selected = "selected";
                }
                $options_html .= '<option ' . $selected . ' value = "' . $option['value'] . '">' . $option['label'] . '</option>';
            }
            $form_html .= '<' . $wrapper . ' ' . $wrapper_data . '>' . $options_html . '</' . $wrapper . '>';
        } else if($field['type'] == "text"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "phone"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "text" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "email"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "email" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "number"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "number" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "date"){
            $wrapper = "input";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' type = "date" ' . $wrapper_data . ' value = "' . $field['default'] . '"></' . $wrapper . '>';
        } else if($field['type'] == "textarea"){
            $wrapper = "textarea";
            if($field['wrapper'] != ""){
                $wrapper = $field['wrapper'];
            }
            $form_html .= '<' . $wrapper . ' ' . $wrapper_data . '>' . $field['default'] . '</' . $wrapper . '>';
        }
        if(isset($config['wrappers'][$field['name']]['input_wrapper_end'])){
            $form_html .= $config['wrappers'][$field['name']]['input_wrapper_end'];
        }
        return $form_html;
    }
    public function getForm($form_fields, $config){
        $form_html = "";
        if(!isset($config['optional_selective']) || !is_array($config['optional_selective'])){
            $config['optional_selective'] = array();
        }
        //row
        foreach($form_fields as $field){
            if($field['type'] == "row"){
                
                if(isset($config['wrappers'][$field['name']]['input_wrapper_start'])){
                    $form_html .= $config['wrappers'][$field['name']]['input_wrapper_start'];
                }
                foreach($field['row_fields'] as $row_field){
                    $form_html .= $this->getField($field['row_fields'], $config, $row_field);
                }
                if(isset($config['wrappers'][$field['name']]['input_wrapper_end'])){
                    $form_html .= $config['wrappers'][$field['name']]['input_wrapper_end'];
                }
            } else {
                $form_html .= $this->getField($form_fields, $config, $field);
            }
        }
        return $form_html;
    }
}
