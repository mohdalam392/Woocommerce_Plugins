<?php
/** 
*		FRONTEND  PAGE OF CREMICA
**/
function frontend_delhivery_shipping() {

	/** TRACK ORDER **/
	if(isset($_POST['checkOrderShipping'])){
		//$html.=$_REQUEST['search'];
		$track_order_status = trackOrder($_POST['waybill_no']);
		$track_order_status = json_decode($track_order_status);

		
		if(isset($track_order_status->Error) ){
			echo $track_order_status->Error;
		}else if(isset($track_order_status->ShipmentData[0]->Shipment->Status->Status) ){
			echo "Pickup Date is ".$track_order_status->ShipmentData[0]->Shipment->PickUpDate."<br/>";
			echo "Status is ".$track_order_status->ShipmentData[0]->Shipment->Status->Status;
		}
	}

	/** CANCEL ORDER **/
	if(isset($_POST['cancelOrderShipping'])){

		// first check the order status 
		$track_order_status = trackOrder($_POST['waybill_no']);
		$track_order_status = json_decode($track_order_status);

		// allowed status in which cancel order will work
		$allowed_status = array('In Transit','Pending','Scheduled','Open');

		
		if(isset($track_order_status->Error) ){
			echo $track_order_status->Error;
		}else{
			if(in_array($track_order_status->ShipmentData[0]->Shipment->Status->Status,$allowed_status) ){
				
				// call cancel api
				$cancel_order_status = cancelPackage($_POST['waybill_no']);
				$cancel_order_status = json_decode($cancel_order_status);
				if(isset($cancel_order_status->Error) ){
					echo $cancel_order_status->Error;
				}else if($cancel_order_status->status==true){
					echo "Order Cancelled Successfully";
				}else if($cancel_order_status->status==false){
					echo "There is some error to cancel this order";
				}
			}else{
				echo "Cannot Cancel Order,Order Status is ".$track_order_status->ShipmentData[0]->Shipment->Status->Status;
			}	
		}
	}

	/** EDIT ORDER **/
	if(isset($_POST['editOrderShipping'])){
		// first check the order status 
		$track_order_status = trackOrder($_POST['waybill_no']);
		$track_order_status = json_decode($track_order_status);

		// allowed status in which cancel order will work
		$allowed_status = array('In Transit','Pending','Scheduled');

		
		if(isset($track_order_status->Error) ){
			echo $track_order_status->Error;
		}else{
			if(in_array($track_order_status->ShipmentData[0]->Shipment->Status->Status,$allowed_status) )
			{
				$waybill_no = $_POST['waybill_no'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$name = $_POST['name1'];
				$gm = $_POST['gm'];
				$shipment_width = $_POST['shipment_width'];
				$shipment_height = $_POST['shipment_height'];
				$shipment_length = $_POST['shipment_length'];

				// setting variables
				$edit_order_data = array();
				if(isset($waybill_no) && !empty($waybill_no)){
					$edit_order_data['waybill'] = $waybill_no;
				}
				if(isset($phone) && !empty($phone)){
					$edit_order_data['phone'] = $phone;
				}
				if(isset($address) && !empty($address)){
					$edit_order_data['add'] = $address;
				}
				if(isset($gm) && !empty($gm)){
					$edit_order_data['gm'] = (float)$gm;
				}
				if(isset($name) && !empty($name)){
					$edit_order_data['name'] = $name;
				}
				if(isset($shipment_width) && !empty($shipment_width)){
					$edit_order_data['volb'] = (int)$shipment_width;
				}
				if(isset($shipment_height) && !empty($shipment_height)){
					$edit_order_data['volh'] = (int)$shipment_height;
				}
				if(isset($shipment_length) && !empty($shipment_length)){
					$edit_order_data['voll'] = (int)$shipment_length;
				}

				// allowed status in which cancel order will work
				$allowed_status = array('In Transit','Pending','Scheduled','Open');


				//print_r(json_encode($edit_order_data) );
				//die;
				$edit_order_status = editPackage(json_encode($edit_order_data) );
				$edit_order_status = json_decode($edit_order_status);

				
				if(isset($edit_order_status->status) && ($edit_order_status->status=='true') ){
					echo "Order Updated Successfully";
				}else if($edit_order_status->status=="Failure"){
					echo "Order Updation Failed";
				}
			}else{
				echo "Cannot Edit Order,Order Status is ".$track_order_status->ShipmentData[0]->Shipment->Status->Status;
			}
		}
	}	



	$html = "";
	$html .= "
		<script>
			function isNumber(evt) {
				evt = (evt) ? evt : window.event;
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				    return false;
				}
				return true;
			}
		</script>
		<style>
			.mycont .a{
				height:200px;
				float:left;
				margin-right:10px;
				margin-bottpm:10px;
				margin-left:0%;
				background:white;
				padding:5px 10px 5px 10px;
				width:330px;
				border:1px solid rgba(158, 152, 152, 0.31);
			}
			.form_big form label { width:250px; float:left; display:block; margin: 10px 0;}
			.form_big form input[type=text] {margin: 5px 0;}
			.form_big form .button_new {    background: #77A47A;
    padding: 8px 12px;
    border: 0;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 12px;
    border-radius: 4px;
    margin: 20px 0;}
    .form_sml .button_new {    background: #77A47A;
    padding: 8px 12px;
    border: 0;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 12px;
    border-radius: 4px;
    margin: 20px 0;}
    .form_sml  label {width: 180px;}
    .form_sml  input[type=text] {}
		</style>
		<div style='width:100%;width: 100%; overflow:hidden; padding: 25px;background:white;' class='mycont' >
		<div class='col-lg-6 form_sml'>
			<div style='margin-bottom:5px;border-bottom:1px solid rgba(51, 48, 48, 0.22);'><h3>Check Order Shipping Status</h3></div>
			<form action='' method='post'>
				 <label>Enter Your Waybill No : </label> <input type='text' name='waybill_no' id='waybill_no' onkeypress='return isNumber(event)' required='required'/>
				 <input type='submit' class='button_new' value='Search' name='checkOrderShipping'/>
			</form>
		</div>
		<div class='col-lg-6 form_sml'>
			<div style='margin-bottom:5px;border-bottom:1px solid rgba(51, 48, 48, 0.22);'><h3>Cancel Your Shipping Package Request</h3></div>
			<form action='' method='post'>
				 <label>Enter Your Waybill No :</label>  <input type='text' name='waybill_no' id='waybill_no' onkeypress='return isNumber(event)' required='required'/>
				 <input type='submit' class='button_new' value='Search' name='cancelOrderShipping'/>
			</form>
		</div>

		<div class='col-lg-12 form_big'>
			<div style='margin-bottom:5px;border-bottom:1px solid rgba(51, 48, 48, 0.22);'><h3>Edit Your Shipping Package Request</h3></div>
			<form action='' method='post'>
				 <div><label>Enter Waybill No :</label>  <input type='text' name='waybill_no' id='waybill_no' onkeypress='return isNumber(event)' required='required'/></div>
				 <div><label>Enter New Name :</label>  <input type='text' name='name1' id='name' /></div>
				 <div><label>Enter Phone No : </label> <input type='text' name='phone_no' id='phone_no' onkeypress='return isNumber(event)' minlength='10' maxlength='10' required='required'/></div>
				 <div><label>Enter New Address : </label> <input type='text' name='address' id='address' required='required' /></div>
				 <div><label>Enter New Shipment weight:</label>  <input type='text' name='gm' id='gm' onkeypress='return isNumber(event)'  required='required'/></div>
				 <div><label>Enter New Shipment Width : </label> <input type='text' name='shipment_width' id='shipment_width' onkeypress='return isNumber(event)' required='required'/></div>
				 <div><label>Enter New Shipment Height : </label> <input type='text' name='shipment_height' id='shipment_height' onkeypress='return isNumber(event)' required='required'/></div>
				 <div><label>Enter New Shipment Length : </label> <input type='text' name='shipment_length' id='shipment_length' onkeypress='return isNumber(event)' required='required'/></div>
				 <div><input type='submit' class='button_new' value='Search' name='editOrderShipping' /></div>
			</form>
		</div>
	  </div>	
	";
	
	return $html;
}
add_shortcode( 'frontend_delhivery_shipping', 'frontend_delhivery_shipping' );

?>