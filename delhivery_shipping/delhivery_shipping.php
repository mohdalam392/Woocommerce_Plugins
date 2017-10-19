<?php
/**
 * Plugin Name: Delhivery Shipping
 * Plugin URI: http://facebook.com/Alamdeveloper
 * Description: Delhivery Shipping 
 * Version: 1.0.0
 * Author: Mohd Alam
 * Author URI: http://facebook.com/Alamdeveloper
 * License: IPL
 */

// create table for delhivery plugin
// function to create the DB / Options / Defaults		
/** --------------------------- MYSQL --------------------------------------------------  **/

function create_delhivery_table() {
   	global $wpdb;

   	// order with waybill table  // delhiveryShippingDetails table
  	$your_db_name = $wpdb->prefix ."delhivery_shipping_details";
 	$charset_collate = $wpdb->get_charset_collate();
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$your_db_name'") != $your_db_name){
		$sql = "CREATE TABLE $your_db_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`orderid` varchar(255) NOT NULL COMMENT 'Order Id',
		`waybill` varchar(255) NOT NULL COMMENT 'Waybill no of order',
		`pincode_status` varchar(255) NOT NULL COMMENT 'Pincode Status',
		`order_status` varchar(255) NOT NULL COMMENT 'Order Status',
		`pickup_status` varchar(255) NOT NULL COMMENT 'Pickup Status',
		 UNIQUE KEY id (id));";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	// delhiveryShipping login Credentials table
  	$your_db_name = $wpdb->prefix ."delhivery_shipping_credentials";
 	$charset_collate = $wpdb->get_charset_collate();
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$your_db_name'") != $your_db_name){
		$sql = "CREATE TABLE $your_db_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`token` varchar(255) NOT NULL COMMENT 'Token Of Delhivery Api',
		`mode` varchar(255) NOT NULL COMMENT '0 for testing , 1 for live',
		`items_per_package` varchar(255) NOT NULL COMMENT 'Items Per Package',
		 UNIQUE KEY id (id));";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	// delhiveryShipping pickup location
  	$your_db_name = $wpdb->prefix ."delhivery_pickup_location";
 	$charset_collate = $wpdb->get_charset_collate();
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$your_db_name'") != $your_db_name){
		$sql = "CREATE TABLE $your_db_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL COMMENT 'Name Of Pickup Location',
		`phone` varchar(10) NOT NULL COMMENT 'Phone Of Pickup Location',
		`pincode` varchar(6) NOT NULL COMMENT 'Pincode Of Pickup Location',
		`address` varchar(255) NOT NULL COMMENT 'Address Of Pickup Location',
		`city` varchar(255) NOT NULL COMMENT 'City Of Pickup Location',
		`state` varchar(255) NOT NULL COMMENT 'State Of Pickup Location',
		`country` varchar(255) NOT NULL COMMENT 'Country Of Pickup Location',
		`is_default` tinyint(4) NOT NULL default '0' COMMENT 'Default Pickup Location',
		 UNIQUE KEY id (id));";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	// delhiveryShipping pickup location
  	$your_db_name = $wpdb->prefix ."delhivery_shipment_return";
 	$charset_collate = $wpdb->get_charset_collate();
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$your_db_name'") != $your_db_name){
		$sql = "CREATE TABLE $your_db_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(255) NOT NULL COMMENT 'Name Of Shipment Return Location',
		`phone` varchar(10) NOT NULL COMMENT 'Phone Of Shipment Return Location',
		`pincode` varchar(6) NOT NULL COMMENT 'Pincode Of Shipment Return Location',
		`address` varchar(255) NOT NULL COMMENT 'Address Of Shipment Return Location',
		`city` varchar(255) NOT NULL COMMENT 'City Of Shipment Return Location',
		`state` varchar(255) NOT NULL COMMENT 'State Of Shipment Return Location',
		`country` varchar(255) NOT NULL COMMENT 'Country Of Shipment Return Location',
		`is_default` tinyint(4) NOT NULL default '0'  COMMENT 'Default Shipping Location',
		 UNIQUE KEY id (id));";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}


	$wpdb->get_results( "SELECT id FROM ".$wpdb->prefix ."delhivery_shipping_credentials" );
	$rows = $wpdb->num_rows;
	if(!empty($rows) && $rows>0){
		//$sql = $wpdb->prepare("insert into ".$wpdb->prefix."delhivery_shipping_credentials(token,mode,items_per_package) values('','0','1')");
		//$wpdb->query($sql);
	}else{
		$sql = $wpdb->prepare("insert into ".$wpdb->prefix."delhivery_shipping_credentials(token,mode,items_per_package) values('','0','1')");
		$wpdb->query($sql);	
	}

	
}

function remove_delhivery_table() {
	/**
    global $wpdb;
    $table = $wpdb->prefix."delhivery_shipping_details";
    $table2 = $wpdb->prefix."delhivery_shipping_credentials";

	$wpdb->query("DROP TABLE IF EXISTS $table");
	$wpdb->query("DROP TABLE IF EXISTS $table2");

	**/
}

// remove table from database if plugin removes
register_deactivation_hook( __FILE__, 'remove_delhivery_table' );

// create table in database if  delhivery plugin installed
register_activation_hook(__FILE__,'create_delhivery_table');

/** ------------------------------------------------------------------------------------  **/

// APIS
require_once('apis.php');

// ORDER DETAILS
require_once('order_details.php');

// EVENTS
require_once('events.php');

// FRONTEND
require_once('frontend.php');


// ADDING MENU IN ADMIN FOR Delhivery Shipping
/** Step 2 (from text above). */
add_action( 'admin_menu', 'admin_delhivery_plugin_menu' );


//add_action( 'woocommerce_single_product_summary', 'test', 10,2);
//
//function test($postid ) {
//    //return "Hello wrold";
//}


/** Step 1. */
function admin_delhivery_plugin_menu() {
    //add_menu_page( 'Delhivery Shipping', 'Delhivery Shipping', 'manage_options', 'delhiveryShipping', 'delhiveryShipping' );
   add_submenu_page( 'woocommerce', 'Delhivery Shipping', 'Delhivery Shipping', 'manage_options', 'delhiveryShipping', 'delhiveryShipping' ); 
}

/** Step 3. */
function delhiveryShipping() {
	global $wpdb;
        $shipping_return_table = "";
        $pickup_locations_table="";

	/** Cancel Shipping **/
	if(isset($_REQUEST['cancel_shipping']) && !empty($_REQUEST['cancel_shipping']) && isset($_REQUEST['postid']) && !empty($_REQUEST['postid'])&& isset($_REQUEST['waybill']) && !empty($_REQUEST['waybill'])){
		//print_r($_REQUEST);
		//echo  $_REQUEST['waybill'];
		//die;
		$waybill = $_REQUEST['waybill'];
		$cancel_order_status = json_decode(cancelPackage($waybill));
		//print_r($cancel_order_status);
		//die;
		if($cancel_order_status->status=="Failure" || $cancel_order_status->status==false){
			echo "<script>alert('Failed to cancel package')</script>";
			wp_redirect( get_site_url()."/wp-admin/post.php?post=".$_REQUEST['postid']."&action=edit&mess=Failed");
		}else{
			wp_redirect( get_site_url()."/wp-admin/post.php?post=".$_REQUEST['postid']."&action=edit&mess=Done");
		}
		
	}

	/** check for approve shipping **/
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="reject" && isset($_REQUEST['orderId']) && !empty($_REQUEST['orderId']) ){
		echo "Reject is here";
		die;
	}

	/** check for approve shipping **/
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="approve" && isset($_REQUEST['orderId']) && !empty($_REQUEST['orderId']) ){
                $orderid = $_REQUEST['orderId'];
		$status = newOrder($orderid);
                if($status){
                    wp_redirect( get_site_url().'/wp-admin/edit.php?post_type=shop_order');
                }else{
                    echo "<script>alert('Error,Invalid Api Or Token');</script>";
                    //wp_redirect( get_site_url().'/wp-admin/edit.php?post_type=shop_order');
                }
		
	}

	


	// RECALL SHIPPING FROM ADMIN 
	if(isset($_REQUEST['type']) && $_REQUEST['orderId'] && !empty($_REQUEST['type']) && !empty($_REQUEST['orderId'])){
		if(function_exists('newOrder')){
			newOrder($_REQUEST['orderId'],true);
			wp_redirect( get_site_url().'/wp-admin/edit.php?post_type=shop_order');
		}else{
			wp_redirect( get_site_url().'/wp-admin/edit.php?post_type=shop_order');
		}
		
	}


	/** SAVE API SETTINGS **/
	$api_update_message = "";
	// check api post settings 
	if(isset($_POST['save_api_settings'])){
		$api_token = $_POST['token'];
		$api_mode = $_POST['mode'];
		$items_per_package = $_POST['items_per_package'];

		$sql = $wpdb->prepare("update ".$wpdb->prefix."delhivery_shipping_credentials set token='".$api_token."', mode='".$api_mode."' ,items_per_package='".$items_per_package."'");
		$wpdb->query($sql);
		$api_update_message = "<p style='color:green'>Credentials Saved Successfully</p>";
	}

	/** SAVE PICKUP SETTINGS **/
	$pickup_update_message = "";
	if(isset($_POST['save_pickup_settings'])){
		$pickup_name = $_POST['pickup_name'];
		$pickup_phone = $_POST['pickup_phone'];
		$pickup_pincode = $_POST['pickup_pincode'];
		$pickup_address = $_POST['pickup_address'];
		$pickup_city = $_POST['pickup_city'];
		$pickup_state = $_POST['pickup_state'];
		$pickup_country = $_POST['pickup_country'];
		
		
		$sql = $wpdb->prepare("insert into ".$wpdb->prefix."delhivery_pickup_location(name,phone,pincode,address,city,state,country) values('".$pickup_name."','".$pickup_phone."','".$pickup_pincode."','".$pickup_address."','".$pickup_city."','".$pickup_state."','".$pickup_country."')");
		if($wpdb->query($sql)){
			$pickup_update_message = "<p style='color:green'>Credentials Saved Successfully</p>";
		}else{
			$shipment_update_message = "<p style='color:red'>".mysql_error()."</p>";
		}	
	}

	/**  PICKUP LOCATION REQUEST FOR DELETE **/
	if(isset($_POST['pickup_delete_button'])){
		if(isset($_POST['pickup_delete'])){
			$pickup_delete_ids = implode($_POST['pickup_delete']);
			deletePickupAddresses($pickup_delete_ids);
		}
	}

	/**  PICKUP LOCATION REQUEST FOR DEFAULT **/
	if(isset($_POST['pickup_default_button'])){
		$default_pickup_address = $_POST['pickup_default'];
		setDefaultPickupAddress($default_pickup_address);
	}


	/**  SHIPPING LOCATION REQUEST FOR DELETE **/
	if(isset($_POST['shipping_delete_button'])){
		if(isset($_POST['shipping_delete'])){
			$shipping_delete_ids = implode($_POST['shipping_delete']);
			deleteShippingAddresses($shipping_delete_ids);
		}
	}

	/**  SHIPPING LOCATION REQUEST FOR DEFAULT **/
	if(isset($_POST['shipping_default_button'])){
		$default_shipping_address = $_POST['shipping_default'];
		setDefaultShippingAddress($default_shipping_address);
	}






	/** SAVE SHIPMENT RETURNS SETTINGS **/
	$shipment_update_message = "";
	if(isset($_POST['save_shipment_returns_settings'])){
		$shipment_name = $_POST['shipment_name'];
		$shipment_phone = $_POST['shipment_phone'];
		$shipment_pincode = $_POST['shipment_pincode'];
		$shipment_address = $_POST['shipment_address'];
		$shipment_city = $_POST['shipment_city'];
		$shipment_state = $_POST['shipment_state'];
		$shipment_country = $_POST['shipment_country'];
		

		$sql = $wpdb->prepare("insert into ".$wpdb->prefix."delhivery_shipment_return (name,phone,pincode,address,city,state,country) values('".$shipment_name."','".$shipment_phone."','".$shipment_pincode."','".$shipment_address."','".$shipment_city."','".$shipment_state."','".$shipment_country."')");
		if($wpdb->query($sql)){
			$shipment_update_message = "<p style='color:green'>Credentials Saved Successfully</p>";
		}else{
			$shipment_update_message = "<p style='color:red'>".mysql_error()."</p>";
		}	
	}



	/**   FETCH DATA FOR API SETTINGS FROM DB  **/
	$rs = $wpdb->get_results( "SELECT token,mode,items_per_package FROM ".$wpdb->prefix ."delhivery_shipping_credentials" );
	$is_demo_mode = $rs[0]->mode == '0' ? "checked='checked'" : '';
	$is_live_mode = $rs[0]->mode == '1' ? "checked='checked'" : '';

	// FRONTEND VIEW
	$html = "
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
		<div style='width:90%;background:white;border:1px solid rgba(45, 42, 42, 0.11);margin-top:10px;padding:20px;'>
			<div class='header' style='border-bottom:1px solid rgba(45, 42, 42, 0.11)'><h1 style='text-align:center;'>Welcome to Delhivery Shipping</h1></div>
			<!--h1>FRONTEND STEPS ....</h1>
			<div>
			<p style='font-size:12pt'>
				Create Page OR Post where you want to show frontend of delhivery shipping form
				and put short code in your page or post.<br/>
				Short Code is <mark>frontend_delhivery_shipping</mark>
			</p>
			</div-->
			<div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11)'></div>
	";

	// API SETTINGS
	$html.= "
			<style>
			.api_form label {width: 350px;display: block;float: left;line-height: 26px;}
			.api_form label .error{ color:red;}
			.api_form input[type=text] {padding: 5px;font-size: 14px; outline: 0; margin-bottom: 10px; background-color: #fff;}
            .api_form .button { margin: 10px 0;}
            .api_table {    width: 100%; border-collapse: collapse;}
            .api_table tr {}
            .api_table tr td {border: 1px solid #ccc; border-collapse: collapse; padding: 5px;}
			</style>
			<h1>API SETTINGS ....         $api_update_message</h1>
			<div class='api_form'>
				<form action='' method='post' style='font-size:12pt'>
					<label>Enter Token No <span class='error'>*</span> </label><input type='text' name='token' required='required' value='".$rs[0]->token."'/><br/>
					<label>Enter Items Per Package <span class='error'>*</span></label><input type='text' name='items_per_package' required='required' value='".$rs[0]->items_per_package."' onkeypress='return isNumber(event)'/><br/>
					<label>Select Mode Of Delhivery Shipping Api<span class='error'>*</span> </label>
						Test Mode <input type='radio' name='mode' $is_demo_mode value='0'/>
						Live Mode <input type='radio' name='mode' $is_live_mode value='1'/>

						<div class='clear:both'></div>
					<input type='submit' value='Save' class='button button-primary button-large' name='save_api_settings'/>
				</form>
			</div><br/>
			<div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11)'>
			</div>
	";

	// PICKUP LOCATION SETTINGS
	$html.= "
			<div class='api_form'>
				<h1>PICKUP LOCATION SETTINGS  ....         $pickup_update_message</h1>
				
					<form action='' method='post' style='font-size:12pt'>
						<label>Enter Name <span class='error'>*</span> </label><input type='text' name='pickup_name' required='true'/><br/>
						<label>Enter Phone <span class='error'>*</span> </label><input type='text' name='pickup_phone' minlength='10' maxlength='10' required='true' onkeypress='return isNumber(event)'/><br/>
						<label>Enter Pin <span class='error'>*</span></label><input type='text' name='pickup_pincode' minlength='6' maxlength='6'required='true' onkeypress='return isNumber(event)'/><br/>
						<label>Enter Address <span class='error'>*</span></label><input type='text' name='pickup_address' required='true'/><br/>
						<label>Enter City <span class='error'>*</span></label><input type='text' name='pickup_city' required='true'/><br/>
						<label>Enter State <span class='error'>*</span> </label><input type='text' name='pickup_state' required='true'/><br/>
						<label>Enter Country <span class='error'>*</span> </label><select name='pickup_country' required='true'><option value='IN'>India</option></select><br/>
						<input type='submit' value='Save' class='button button-primary button-large' name='save_pickup_settings'/>
					</form>
			<br/>
			<div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11); margin-bottom: 30px;'></div>
	";

	/**
	*	----------------------------------------------------------------------
	*	PICKUP  LOCATIONS LIST
	*	----------------------------------------------------------------------
	**/
	$pickup_locations_list = getAllPickupLocations();
	$pickup_locations_table .="<form name='pickpup' method='post' action=''>";
	$pickup_locations_table .="	
								<table class='table api_table'>
									<tr>
										<td>Delete</td>
										<td>Make Default</td>
										<td>Name</td>
										<td>Phone</td>
										<td>Address</td>
										<td>Pincode</td>
										<td>City</td>
										<td>State</td>
										<td>Country</td>
									</tr>
							 ";
	if(count($pickup_locations_list)>0){	
							 
		foreach($pickup_locations_list as $pickup){
			if($pickup->is_default=='1'){
				$checked = "checked='checked'";
			}else{
				$checked="";
			}
			$pickup_locations_table .="
				<tr>
					<td><input type='checkbox' name='pickup_delete[]' value='".$pickup->id."'/></td>
					<td><input type='radio' name='pickup_default' $checked value='".$pickup->id."'/></td>
					<td>".$pickup->name."</td>
					<td>".$pickup->phone."</td>
					<td>".$pickup->address."</td>
					<td>".$pickup->pincode."</td>
					<td>".$pickup->city."</td>
					<td>".$pickup->state."</td>
					<td>".$pickup->country."</td>
				</tr>";
		}
		
	}else{
		$pickup_locations_table .="
				<tr>
					<td colspan=9>There is no location available</td>
				</tr>
				
				";
	}
	$pickup_locations_table.="</table>";
	if(count($pickup_locations_list)>0){
		$pickup_locations_table .="
						<input type='submit' value='Delete' name='pickup_delete_button'  class='button button-primary button-large' onclick='document.pickpup.submit()'/>
						<input type='submit' value='Make Default'  class='button button-primary button-large' name='pickup_default_button' onclick='document.pickpup.submit()'/>
			";
	}
	$pickup_locations_table.="</form><div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11)'></div>";
	

	// adding pickup location to html
	$html.=$pickup_locations_table;


	// SHIPMENT RETURN ADDRESS
	$html.= "
			<h1>SHIPMENT RETURN ADDRESS SETTINGS ....         $shipment_update_message</h1>
			<div>
				<form action='' method='post' style='font-size:12pt'>
					<label>Enter Name <span class='error'>*</span></label><input type='text' name='shipment_name' required='true'/><br/>
					<label>Enter Phone <span class='error'>*</span></label><input type='text' name='shipment_phone' minlength='10' maxlength='10' required='true' onkeypress='return isNumber(event)'/><br/>
					<label>Enter Pin <span class='error'>*</span></label><input type='text' name='shipment_pincode' minlength='6' maxlength='6' required='true' onkeypress='return isNumber(event)'/><br/>
					<label>Enter Address <span class='error'>*</span></label><input type='text' name='shipment_address' required='true'/><br/>
					<label>Enter City <span class='error'>*</span></label><input type='text' name='shipment_city' required='true'/><br/>
					<label>Enter State <span class='error'>*</span> </label><input type='text' name='shipment_state' required='true'/><br/>
					<label>Enter Country <span class='error'>*</span></label><select name='shipment_country' required='true'><option value='IN'>India</option></select><br/>
					<input type='submit'   class='button button-primary button-large' value='Save' name='save_shipment_returns_settings'/>
				</form>
			</div><br/>
	";

	$html.="<div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11); margin-bottom: 30px;'></div>";
	/**
	*	----------------------------------------------------------------------
	*	SHIPPING RETURN LIST
	*	----------------------------------------------------------------------
	**/
	$shipping_return_list = getAllShippingReturn();
	$shipping_return_table .="<form name='shipping_return' method='post' action=''>";	
	$shipping_return_table .="	
								<table class='table api_table'>
									<tr>
										<td>Delete</td>
										<td>Make Default</td>
										<td>Name</td>
										<td>Phone</td>
										<td>Address</td>
										<td>Pincode</td>
										<td>City</td>
										<td>State</td>
										<td>Country</td>
									</tr>
							 ";
	if(count($shipping_return_list)>0){		

		foreach($shipping_return_list as $shipping_return){
			if($shipping_return->is_default=='1'){
				$checked = "checked='checked'";
			}else{
				$checked="";
			}
			$shipping_return_table .="
				<tr>
					<td><input type='checkbox' name='shipping_delete[]' value='".$shipping_return->id."'/></td>
					<td><input type='radio' name='shipping_default' $checked value='".$shipping_return->id."'/></td>
					<td>".$shipping_return->name."</td>
					<td>".$shipping_return->phone."</td>
					<td>".$shipping_return->address."</td>
					<td>".$shipping_return->pincode."</td>
					<td>".$shipping_return->city."</td>
					<td>".$shipping_return->state."</td>
					<td>".$shipping_return->country."</td>
				</tr>";
		}
	}else{
		$shipping_return_table .="
				<tr>
					<td colspan=9>There is no location available</td>
				</tr>
				
				";
	}

	$shipping_return_table.="</table>";
	if(count($shipping_return_table)>0){
		$shipping_return_table .="
						<input type='submit'  class='button button-primary button-large' value='Delete' name='shipping_delete_button' onclick='document.shipping_return.submit()' />
						<input type='submit'  class='button button-primary button-large' value='Make Default' name='shipping_default_button' onclick='document.shipping_return.submit()'/>
			";
	}
	$shipping_return_table.="</form>";
	

	// adding pickup location to html
	$html.=$shipping_return_table;

	$html.="<div class='footer' style='border-top:1px solid rgba(45, 42, 42, 0.11)'>
			<h5 style='text-align:center;'>Delhivery Shipping Admin</h5>
			</div>
		</div>";
	echo $html;
}


/**  ADD DELHIVERY COLUMN IN ORDER PAGE FOR SHIPPING API CALLED OR NOT **/
add_action( 'plugins_loaded', 'addDelhiveryShippingColumn' );
function addDelhiveryShippingColumn(){
    // Just to make clear how the filters work
    $posttype = "shop_order";

    // Priority 20, with 1 parameter (the 1 here is optional)
    add_filter( "manage_edit-{$posttype}_columns", 'addDelhiveryShippingColumn2', 20, 1 ); 

    // Priority 20, with 2 parameters
    add_action( "manage_{$posttype}_posts_custom_column", 'addDelhiveryShippingColumn3', 20, 2 ); 

    // Default priority, default parameters (zero or one)
    add_filter( "manage_edit-{$posttype}_sortable_columns", 'addDelhiveryShippingColumn4' ); 
}
function addDelhiveryShippingColumn2($columns){
    $columns['order_sales'] = "Delhivery Waybill";
    return $columns;
}
function addDelhiveryShippingColumn3($column_name,$post_id) {
    if ( 'order_sales' != $column_name ){
        return;
    } else{
    	global $wpdb;
    	$result = $wpdb->get_results( "SELECT waybill FROM ".$wpdb->prefix ."delhivery_shipping_details where orderid='".$post_id."'" );
    	
    	if(empty($result[0]->waybill)){
		$status = getOrderStatus($post_id);
    		if($status=='failed' || $status=='cancelled'){
    			$a = "Failed|Cancelled Order";
    		}else{
    			
    			$a = "<a href='admin.php?page=delhiveryShipping&action=approve&orderId=$post_id' >Approve</a>";
    		}
    		//$a = "<a href='admin.php?page=delhiveryShipping&action=approve&orderId=$post_id' >Approve</a>";
    		
    		//echo "Failed , "."<a href='admin.php?page=delhiveryShipping&type=shipagain&orderId=$post_id'>Retry</a>";
        	//$a.= " | <a href='admin.php?page=delhiveryShipping&action=reject&orderId=$post_id'>Reject</a>";
        	echo $a;
    	}else{
    		echo $result[0]->waybill;	
    	}
    	
    }	
}
function addDelhiveryShippingColumn4($columns){
    $columns['order_sales'] = 'order_sales';
    return $columns;
}



/** Delhivery Meta Boxes  **/

add_action( 'add_meta_boxes_shop_order','add_meta_boxes2');
function add_meta_boxes2(){
	// create PDF buttons
			add_meta_box(
				'abc',
				'Delhivery Shipping',
				'sidebar_box_content2',
				'shop_order',
				'advanced',
				'default'
			);

}

 function sidebar_box_content2( $post ) {
			global $post_id;
			global $wpdb;

			// Show Message if 
			if(isset($_REQUEST['mess'])){
				echo "<script>alert('Shipping Cancelled ".$_REQUEST['mess']."')</script>";
			}
			/** POST ID AND PICKUP LOCATION**/
			$d_pin = getShippingPincode($post_id);
			$d_pin = $d_pin !="" ? $d_pin : '';

			$total_weight = getTotalWeightOfItems($post_id);
			$total_weight = $total_weight !="0" ? $total_weight :'0.1';

			$default_pickup_location = getDefaultPickupLocation();
			$o_pin = $default_pickup_location[0]->pincode!="" ? $default_pickup_location[0]->pincode : "";
			
			$shipping_charges = json_decode(getShippingCharge($o_pin,$d_pin,$total_weight));
			
			$shipping_table = "<b>Shipping charges on this order </b>
			<table cellpadding='5px' cellspacing='0px' style='border:1px solid rgba(223, 223, 223, 0.37)' border=1>
				<tr>
					<td>Shipping Charges</td>
					<td>Pickup Charges</td>
					<td>Return Charges</td>
					<td>Cancel Charges</td>
				</tr>
				<tr>
					<td>".$shipping_charges->response->delivery_charges."</td>
					<td>".$shipping_charges->response->pickup_charges."</td>
					<td>".$shipping_charges->response->return_charges."</td>
					<td>".$shipping_charges->response->canc_charges."</td>
				</tr>
			</table>
			<hr/>";

			echo $shipping_table;


		// Fetch Waybill No From Table
    	$result = $wpdb->get_results( "SELECT waybill,pickup_status FROM ".$wpdb->prefix ."delhivery_shipping_details where orderid='".$post_id."'" );
    	if(!empty($result[0]->waybill)){ 
    		/** GET PICKUP DETAILS **/

    		$track_order = json_decode(trackOrder($result[0]->waybill));
    		
			$pickup_table = "<b>Waybill Id - ".$result[0]->waybill."</b><hr/>
							<b>Pickup Details</b><hr/>

							<table cellpadding='5px' cellspacing='0px' style='border:1px solid rgba(223, 223, 223, 0.37)' border=1>
								<tr>
									<td>Pickup Id</td>
									<td>Pickup Reference No</td>
									<td>Pickup Date</td>
									<td>SenderName</td>
									<td>AWB No</td>
								</tr>
								<tr>
									<td>".$result[0]->pickup_status."</td>
									<td>".$track_order->ShipmentData[0]->Shipment->ReferenceNo."</td>
									<td>".$track_order->ShipmentData[0]->Shipment->PickUpDate."</td>
									<td>".$track_order->ShipmentData[0]->Shipment->SenderName."</td>
									<td>".$track_order->ShipmentData[0]->Shipment->AWB."</td>
								</tr>
							</table>";
		
				echo $pickup_table;


			$cancel_shipping = "<hr/><b>Cancel Delivery Shipping</b><hr/>";

			$cancel_shipping.="<a href='".get_site_url()."/wp-admin/admin.php?page=delhiveryShipping&postid=".$post_id."&cancel_shipping=true&waybill=".$result[0]->waybill."'>Click To Cancel Shipping</a>";
			
			
			if(in_array($track_order->ShipmentData[0]->Shipment->Status->Status, array('Transit','Pending','Open','Scheduled'))){
				$cancel_shipping.="<a href='".get_site_url()."/wp-admin/admin.php?page=delhiveryShipping&postid=".$post_id."&cancel_shipping=true&waybill=".$result[0]->waybill."'>Click To Cancel Shipping</a>   ";

				$cancel_shipping.="You can cancel shipping";
			}else{
				$ms = "Cannot Cancel";
				$cancel_shipping.="<a href='javascript:void(0)'>Click To Cancel Shipping</a>   ";
				$cancel_shipping.= "Shipping Status is <u>".$track_order->ShipmentData[0]->Shipment->Status->Status."</u>, You cannot cancel shipping";	
			}

			/**
			if(in_array($track_order->ShipmentData[0]->Shipment->Status->Status, array('Transit','Pending','Open','Scheduled'))){
				$cancel_shipping.="You can cancel shipping";
			}else{
				$cancel_shipping.= "Shipping Status is ".$track_order->ShipmentData[0]->Shipment->Status->Status.", You cannot cancel shipping";	
			}
			**/
			$cancel_shipping.="<p>Note : Cancel Shipping Allowed Only , When Shipping Status In Transit,Pending,Open,Scheduled</p>";


			echo $cancel_shipping;


		}	
		?>
			
			<?php
			/**
			$meta_actions = array(
				'invoice'		=> array (
					'url'		=> "",
					'alt'		=> esc_attr__( 'PDF Invoice', 'wpo_wcpdf' ),
					'title'		=> __( 'PDF Invoice2', 'wpo_wcpdf' ),
				)
			);

			$meta_actions = apply_filters( 'wpo_wcpdf_meta_box_actions', $meta_actions, $post_id );

			?>
			<ul class="wpo_wcpdf-actionss">
				<?php
				foreach ($meta_actions as $action => $data) {
					printf('<li><a href="%1$s" class="button" target="_blank" alt="%2$s">%3$s</a></li>', $data['url'], $data['alt'],$data['title']);
				}
				?>
			</ul>
			<?php
			**/
}


?>
