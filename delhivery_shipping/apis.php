<?php
//APIS

/** CHECK PINCODE API **/
function checkPincode($filter_codes){
	// HEADERS
	$headers[] = "";

	// PARAMS
	$token =  getAPIToken();
	$mode  =  getApiMode();

	//$filter_codes = "110094";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
		 "https://test.delhivery.com/c/api/pin-codes/json/?token=$token&filter_codes=$filter_codes" :
		 "https://track.delhivery.com/c/api/pin-codes/json/?token=$token&filter_codes=$filter_codes" ;								
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** CREATE PACKAGE ORDER API **/
function createPackageOrder($data){
	// HEADERS
	$headers[] = "";

	// PARAMS
	$token =  getAPIToken();
	$mode  =  getApiMode();

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
			"https://test.delhivery.com/cmu/push/json/?token=$token" :
			"https://track.delhivery.com/cmu/push/json/?token=$token" ;
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"format=".$data['format']."&data=".$data['data']); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** PICKUP REQUEST API **/
function createPickupRequest($data){

	$token =  getAPIToken();
	$mode  =  getApiMode();

	// headers
	$headers[] = "Authorization: Token $token";
	$headers[] = "Content-Type: application/json";

	// PARAMS
	//$token =  "d1cd19fbc1261f7ebe65ac3f5dc85866109719b8";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
				"https://test.delhivery.com/fm/request/new/":
				"https://track.delhivery.com/fm/request/new/";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
        
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** WAY BILL FETCH API **/
function wayBillFetch(){
	// HEADERS
	$headers[] = "";

	// PARAMS
	$token =  getAPIToken();
	$mode  =  getApiMode();
	$cl="alam";
	$format = "json";
	$action="fetch";
	$wbn="12";
	$client_name="tes";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
			"https://test.delhivery.com/waybill/api/action/json/?cl=$cl&format=$format&action=$action&wbn=$wbn&client_name=$client_name&token=$token":
			"https://track.delhivery.com/waybill/api/action/json/?cl=$cl&format=$format&action=$action&wbn=$wbn&client_name=$client_name&token=$token";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** PACKAGE SLIP API **/
function createPackageSlip(){

	$token =  getAPIToken();
	$mode  =  getApiMode();


	// headers
	$headers[] = "authorization: token $token";
	$headers[] = "accept: application/json";

	// PARAMS
	$wbns  = "2";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
					"https://test.delhivery.com/api/p/packing_slip?wbns=$wbns":
					"https://track.delhivery.com/api/p/packing_slip?wbns=$wbns";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** PACKAGE/ORDER TRACKER  **/
function trackOrder($waybill){


	// HEADERS
	$headers[] = "";

	// PARAMS
	$format  = "json";
	$token =  getAPIToken();
	$mode  =  getApiMode();
	$ref_nos = "";
	$waybill = $waybill;
	$verbose = "0";
	$output = "json";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
			"https://test.delhivery.com/api/packages/json/?token=$token&format=$format&ref_nos=$ref_nos&waybill=$waybill&verbose=$verbose&output=$output":
			"https://track.delhivery.com/api/packages/json/?token=$token&format=$format&ref_nos=$ref_nos&waybill=$waybill&verbose=$verbose&output=$output";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** SHIPPING CHARGE API  **/
function getShippingCharge($opin,$dpin,$total_weight){
	// HEADERS
	$headers[] = "";

	// PARAMS
	//$format  = "json";
	//$cl​  = "test";
	$pt  = "Prepaid";
	$token =  getAPIToken();
	$mode  =  getApiMode();
	//$cod  = "100";
	$gm  = $total_weight;
	$o_pin  = $opin;
	$d_pin  = $dpin;
	//$o_city  = "delhi";
	//$d_city  = "delhi";
	//$md = "E";

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
			"https://test.delhivery.com/kinko/api/invoice/charges/json/?pt=$pt&token=$token&gm=$gm&o_pin=$o_pin&d_pin=$d_pin":
			"https://track.delhivery.com/kinko/api/invoice/charges/json/?pt=$pt&token=$token&gm=$gm&o_pin=$o_pin&d_pin=$d_pin";

	//$myurl = "https://test.delhivery.com/kinko/api/invoice/charges/json/?format=$format&cl​=$cl&pt=$cod&token=$token&cod=$cod&gm=$gm&o_pin=$o_pin&d_pin=$d_pin&o_city=$o_city&d_city=$d_city&md=$md";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}


/** EDIT PACKAGE API **/
function editPackage($data){

	$token =  getAPIToken();
	$mode  =  getApiMode();

	// headers
	$headers[] = "Authorization: token $token";
	$headers[] = "Content-Type: application/json";
	$headers[] = "Accept: application/json";

	// PARAMS
	$edit_waybill_data =  $data;

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
					"https://test.delhivery.com/api/p/edit":
					"https://track.delhivery.com/api/p/edit";
	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$edit_waybill_data);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}

/** CANCEL PACKAGE API **/
function cancelPackage($waybill){

	$token =  getAPIToken();
	$mode  =  getApiMode();

	// headers
	$headers[] = "Authorization: token $token";
	$headers[] = "Content-Type: application/json";
	$headers[] = "Accept: application/json";

	// PARAMS
	$cancel_waybill_data =  json_encode(array(
					'waybill'=>$waybill,
					'cancellation'=>'true'
			));

	$ch = curl_init();
	$timeout = 100; // set to zero for no timeout

	$myurl = $mode =='0' ?
				"https://test.delhivery.com/api/p/edit":
				"https://track.delhivery.com/api/p/edit";


	curl_setopt ($ch, CURLOPT_URL, $myurl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$cancel_waybill_data);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$result = curl_exec($ch);
	$curl_error = curl_errno($ch);
	curl_close($ch);
	return $result;
}
?>