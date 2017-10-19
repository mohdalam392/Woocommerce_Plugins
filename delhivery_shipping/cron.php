<?php 

/** UPDATE ORDER STATUS **/
function custom_woocommerce_auto_complete_order( $order_ids ) {
    global $woocommerce;
     if ( !$order_id )
        return;
    $order = new WC_Order( $order_id );
    $order->update_status( 'Completed' );
}

?>