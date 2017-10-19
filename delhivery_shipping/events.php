<?php
/**
*  -------------------------------------------------------------
*  ADD ACTION AFTER ORDER CREATED OR PROCESSED OR AFTER PAYMENT
*  -------------------------------------------------------------	
**/

// order created
//add_action( 'woocommerce_new_order', 'newOrderProcessed',  1, 1  );

// order processed
//add_action( 'woocommerce_checkout_order_processed', 'newOrder',  1, 1  );

// order payment processed
add_action( 'woocommerce_payment_complete', 'newOrderAfterPayment',  1, 1  );


function newOrder($orderid,$retry = false){
	
	$token =  getAPIToken();
        $valid_token = isValidToken('110094');
	if(!empty($token) && $valid_token){
		global $wpdb;	

		if($retry){
			$order_det = existsOrderDetails($orderid);
			
			if($order_det==false){
				insertShippingOrder($orderid);	
			}
		}else{
			insertShippingOrder($orderid);	
		}
		

		$waybill = "";

		// GET PINCODE
		$pincode = getShippingPincode($orderid);

		// CALL CHECK PINCODE API
		$res_1  = checkPincode($pincode);
		$pincode_json = json_decode($res_1);
		//if(($res_1!="Login or API Key Required") && is_array($pincode_json)){
		if(true){
			updateOrderPincodeJson($orderid,"pincode done");
			//GET ORDER CREATION DATA    
			$data = getOrderCreationData($orderid);

			// CALL API FOR ORDER CREATION
			$res_2 = createPackageOrder($data);
			$order_creation = json_decode($res_2);
			
			
			
			if($order_creation->packages[0]->status == "Success"){
				updateOrderJson($orderid,"order done");

				
				$waybill = $order_creation->packages[0]->waybill;
				updateOrderWaybill($orderid,$waybill);

				// GET DATA FOR PICKUP REQUEST
				$pickup_data =  json_encode(array(
					'pickup_time'=> date('H:i:s',current_time( 'timestamp' )),
					'pickup_date'=> date('Ymd',strtotime(' +1 day')),
					'pickup_location'=>"CREMICA",  // do not change cremica to any address
					'expected_package_count'=>ceil(getTotalItemsInOrder($orderid) / getItemsPerPackage())
				));
 
				$res_3 = createPickupRequest($pickup_data);
				$pickup_order_request_response_data = json_decode($res_3);

				
				// check if pickup request
				if(isset($pickup_order_request_response_data->pickup_id) && !empty($pickup_order_request_response_data->pickup_id)){
					updateOrderPickupRequest($orderid,$pickup_order_request_response_data->pickup_id);
				}else{
					updateOrderPickupRequest($orderid,"pickup request fail");
				}
				
			}else{
				updateOrderJson($orderid,$order_creation->packages[0]->remarks."ORDER FAIL");
			}
			
		//}else{
		//	updateOrderPincodeJson($orderid,"pincode fail");
		}
                return true;
	}else{
            updateOrderPincodeJson($orderid,"pincode fail");
            return $valid_token;
	}	
}

//function newOrderProcessed($orderid){		
//}

//function newOrderAfterPayment($orderid){	
//}


// GET ORDER CREATION DATA FROM ORDER
function getOrderCreationData($orderid){

	// order details   ORDER DETAILS WILL COME HERE
	$shipping_return_address = getDefaultShippingLocation();
	$pickup_address = getDefaultPickupLocation();

	$data = array();
	$data['format']="json";
	$data['data'] = json_encode(array(
				  	"shipments"=> array(
					  		array(
						      "total_amount"=> getOrderTotalAmount($orderid),
						      "cod_amount"=>getOrderPaymentMethod($orderid)=="Cash on Delivery"? (float) getOrderTotalAmount($orderid):'0.0',
						      //"cod_amount"=>'10.0',
						      "phone"=> getBillingPhone($orderid),
						      "weight"=> !empty(getTotalWeightOfItems($orderid))?getTotalWeightOfItems($orderid):0.0,
						      //"weight"=> "10.0",
						      "seller_tin"=> "EF100028389",
						      "state"=> getShippingState($orderid),
						      "seller_cst"=> "EF100028389",

						      "dispatch_date"=>getOrderDate($orderid),
						      "add"=> getShippingAddress($orderid),
						      "country"=> getShippingCountry($orderid),
						      "city"=> getShippingCity($orderid),
						      "billable_weight"=> getTotalWeightOfItems($orderid),
						      "order"=> $orderid.'_'.time(),
						      "seller_inv_date"=> "2016-02-10T12:36:57+05:30",
						      "pin"=> getBillingPincode($orderid),
						      "volumetric"=>"",
						      "products_desc"=> "",
						      "seller_inv"=> "EF1000283891",
						      "name"=> getShippingFirstName($orderid).' '.getShippingLastName($orderid),
						      "payment_mode"=> getOrderPaymentMethod($orderid),

						      "return_add"=> $shipping_return_address[0]->address,
						      "return_city"=>$shipping_return_address[0]->address,
						      "return_country"=>$shipping_return_address[0]->country,
						      "return_name"=>$shipping_return_address[0]->name,
						      "return_phone"=> $shipping_return_address[0]->phone,
						      "return_pin"=> $shipping_return_address[0]->pincode,
						      "return_state"=> $shipping_return_address[0]->state,

						      "dispatch_id"=> $orderid,
						      "order_date"=>getOrderDate($orderid),
						     // "end_date"=> "2016-02-10T12:36:57+05:30"
					 	 	)
					),
					/**					
					"pickup_location"=>array(
					    "phone"=> "9620501234",
					    "pin"=> "560067",
					    "name"=> "CREMICA",
					    "add"=> 'address',
					    "country"=>"IN",
					    "city"=> "Bangalore"
				  	)
					**/
					
				  	"pickup_location"=>array(
					    "phone"=> $pickup_address[0]->phone,
					    "pin"=> $pickup_address[0]->pincode,
					    "name"=> $pickup_address[0]->name,
					    "add"=> $pickup_address[0]->address,
					    "country"=>$pickup_address[0]->country,
					    "city"=> $pickup_address[0]->city
				  	)
				));
	return $data;
}

?>
