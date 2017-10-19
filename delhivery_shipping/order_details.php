<?php 
/** ------------ ORDER DETAILS FUNCTIONS -------------------------------- **/
/** Get Order Status by order id **/
function getOrderStatus($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->get_status();
}
// GET SHIPPING PINCODE
function getShippingPincode($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_postcode;
}

// GET BILLING PINCODE
function getBillingPincode($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_postcode;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET SHIPPING CITY
function getShippingCity($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_city;
}

// GET BILLING CITY
function getBillingCity($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_city;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET SHIPPING STATE
function getShippingState($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_state;
}

// GET BILLING STATE
function getBillingState($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_state;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET SHIPPING COUNTRY
function getShippingCountry($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_country;
}

// GET BILLING COUNTRY
function getBillingCountry($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_country;
}
/** ------------------------------------------------------------------- **/


/** ------------------------------------------------------------------- **/
// GET SHIPPING ADDRESS
function getShippingAddress($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_address_1.' '.$order->shipping_address_2.' '.$order->shipping_address_3;
}

// GET BILLING ADDRESS
function getBillingAddress($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_address_1.' '.$order->billing_address_2.' '.$order->billing_address_3;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET SHIPPING FIRSTNAME
function getShippingFirstName($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_first_name;
}
// GET BILLING FIRSTNAME
function getBillingFirstName($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_first_name;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET SHIPPING LASTNAME
function getShippingLastName($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_last_name;
}
// GET BILLING LASTNAME
function getBillingLastName($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_last_name;
}
/** ------------------------------------------------------------------- **/


/** ------------------------------------------------------------------- **/
// GET SHIPPING PHONE
function getShippingPhone($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->shipping_phone;
}

// GET BILLING PHONE
function getBillingPhone($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->billing_phone;
}
/** ------------------------------------------------------------------- **/


/** ------------------------------------------------------------------- **/
// GET PAYMENT METHOD
function getOrderPaymentMethod($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->payment_method_title;
	//return $order->payment_method;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET ORDER TOTAL AMOUNT
function getOrderTotalAmount($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->order_total;
}
/** ------------------------------------------------------------------- **/

/** ------------------------------------------------------------------- **/
// GET ORDER DATE
function getOrderDate($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	return $order->order_date;
}
/** ------------------------------------------------------------------- **/


/** ------------------------------------------------------------------- **/
// GET ORDER TOTAL WEIGHT OF ITEMS
function getTotalWeightOfItems($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	$items = $order->get_items();
	$total_weight = 0;
	foreach( $items as $item ) {
		$item_metas = get_post_meta( $item['product_id'] );
		$weight = $item_metas['_weight']['0'];
		$quantity = $item['qty'];
		$item_weight = ( $weight * $quantity );
		$total_weight += $item_weight;
	}
	return $total_weight;
}
/** ------------------------------------------------------------------- **/




/**  INSERT ORDER INTO TABLE  ----------------------------------------**/
function insertShippingOrder($orderid){
	global $wpdb;
	$sql = $wpdb->prepare("insert into ".$wpdb->prefix."delhivery_shipping_details(orderid) values('".$orderid."')",array());
	$wpdb->query($sql);
}

// INSERT PINCODE JSON INTO TABLE
function updateOrderPincodeJson($orderid,$pincodeJson){
	////global $wpdb;
	//$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipping_details set pincode_status='".$pincodeJson."' where orderid='".$orderid."'");
	//$wpdb->query($sql);
}

// INSERT ORDER JSON INTO TABLE
function updateOrderJson($orderid,$orderJson){
	global $wpdb;
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipping_details set order_status='".$orderJson."' where orderid='".$orderid."'",array());
	$wpdb->query($sql);
}

// INSERT PICKUP REQUEST INTO TABLE
function updateOrderPickupRequest($orderid,$pickupJson){
	global $wpdb;
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipping_details set pickup_status='".$pickupJson."' where orderid='".$orderid."'",array());
	$wpdb->query($sql);
}

// INSERT WAYBILL INTO TABLE
function updateOrderWaybill($orderid,$waybill){
	global $wpdb;
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipping_details set waybill='".$waybill."' where orderid='".$orderid."'",array());
	$wpdb->query($sql);
}



// GET TOKEN OF API
function getAPIToken(){
	global $wpdb;
	$rs = $wpdb->get_results( "SELECT token FROM ".$wpdb->prefix ."delhivery_shipping_credentials" );
	return $rs[0]->token;
}

// GET MODE OF API
function getAPIMode(){
	global $wpdb;
	$rs = $wpdb->get_results( "SELECT mode FROM ".$wpdb->prefix ."delhivery_shipping_credentials" );
	return $rs[0]->mode;
}


// GET ITEMS PER PACKAGE
function getItemsPerPackage(){
	global $wpdb;
	$rs = $wpdb->get_results( "SELECT items_per_package FROM ".$wpdb->prefix ."delhivery_shipping_credentials" );
	return $rs[0]->items_per_package;
}

// GET TOTAL ITEMS IN ORDER
function getTotalItemsInOrder($orderid){
	global $woocommerce, $post;
	$order = new WC_Order($orderid);
	$items = $order->get_items();
	return count($items);
}



// CHECK TOKEN IS vALID
function isValidToken($pincode){
	$res_1  = checkPincode($pincode);

	$pincode_json = json_decode($res_1);
	//echo "<pre>";
	//|| $res_1=="Login or API Key Required" || !is_array($pincode_json)
	if(!isset($pincode_json->delivery_codes[0]->postal_code->pin) ){
            return false;
	}else{
            return true;
	}
}


// GET ALL PICKUP LOCATIONS
function getAllPickupLocations(){
	global $wpdb;
	$result = $wpdb->get_results( "SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_pickup_location" );
	return $result;
}

// GET DEFAULT PICKUP LOCATION ADDRESS
function getDefaultPickupLocation(){
	global $wpdb;

	$wpdb->get_results( "SELECT id FROM ".$wpdb->prefix ."delhivery_pickup_location where is_default='1'" );
	
	if($wpdb->num_rows > 0 ){
		$result = $wpdb->get_results( "SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_pickup_location where is_default='1' limit 0,1" );
		return $result;
	}else{
		$result = $wpdb->get_results( "SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_pickup_location limit 0,1" );
		return $result;
	}
}

// GET ALL SHIPPING RETURN 
function getAllShippingReturn(){
	global $wpdb;
	$result = $wpdb->get_results("SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_shipment_return");
	return $result;
}


// GET DEFAULT SHIPPING LOCATION ADDRESS
function getDefaultShippingLocation(){
	global $wpdb;

	$wpdb->get_results( "SELECT id FROM ".$wpdb->prefix ."delhivery_shipment_return where is_default='1'" );
	if($wpdb->num_rows >0){
		$result = $wpdb->get_results( "SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_shipment_return where is_default='1' limit 0,1" );
		return $result;
	}else{
		$result = $wpdb->get_results( "SELECT id,name,phone,pincode,address,city,state,country,is_default FROM ".$wpdb->prefix ."delhivery_shipment_return limit 0,1" );
		return $result;
	}
}

// GET ORDER DETAILS
function existsOrderDetails($orderid){
	global $wpdb;
	$rs = $wpdb->get_results( "SELECT id FROM ".$wpdb->prefix ."delhivery_shipping_details where orderid='".$orderid."'" );
	if($rs->num_rows >0){
		return true;
	}else{
		return false;
	}
}



// DELETE PICKUP ADDRESS
function deletePickupAddresses($pickupids){
	global $wpdb;
	$sql = $wpdb->prepare("delete from ".$wpdb->prefix."delhivery_pickup_location where id in($pickupids)",array());
	$wpdb->query($sql);
}

// SET DEFAULT PICKUP ADDRESS 
function setDefaultPickupAddress($pickupId){
	global $wpdb;
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_pickup_location set is_default='0'",array());
	$wpdb->query($sql);
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_pickup_location set is_default='1' where id='".$pickupId."'",array());
	$wpdb->query($sql);	
}

// DELETE SHIIPING ADDRESS
function deleteShippingAddresses($shippingsids){
	global $wpdb;
	$sql = $wpdb->prepare("delete from ".$wpdb->prefix."delhivery_shipment_return where id in($shippingsids)",array());
	$wpdb->query($sql);
}

// SET DEFAULT SHIPPING ADDRESS 
function setDefaultShippingAddress($shippingAddressId){
	global $wpdb;
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipment_return set is_default='0'",array());
	$wpdb->query($sql);
	$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipment_return set is_default='1' where id ='".$shippingAddressId."'",array());
	$wpdb->query($sql);	
}
?>