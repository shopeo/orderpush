<?php
/**
* Plugin Name: paynotify
* Plugin URI: https://shopeo.cn
* Description:   paynotify
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author: Ecshop
* Author URI: https://shopeo.cn
* License: Tompson
*/
include('noticeerp.php');

//add_action( 'woocommerce_order_status_completed', 'wpdesk_set_returnerp' );

function wpdesk_set_returnerp( $order_id ) {

	$order = wc_get_order( $order_id );
	 $api=new noticeerp();
$url='https://shell.obrase.com/hpiApp/web-module/mobileShell/pushTrade.req';
$as='pi6f4kwneq8qsn3dcn1qjvcm5amtv5paqhoego5u';
$ak='66666666';
$push_companyId='510002';
$order_data = $order->get_data(); // 获取订单数据

	$orderslist['tid']='8888888888'.$order_data['id'];
$orderslist['oid']='8888888888'.$order_data['id'];
foreach ($order->get_items() as $item_id => $item ) {
	

$orderslist['num']+=intval($item->get_quantity());
 $orderslist['outerSkuId'].='【'.$item->get_name().'X'.$item->get_quantity().'】-'; 
   // 等等...
}



$data=[array(

'tid'=>'8888888888'.$order_data['id'],
'shopName'=>'CustomCaseZone',
'buyerNick'=>$order_data['shipping']['first_name'].''.$order_data['shipping']['last_name'],
'receiverState'=>$order_data['shipping']['country']?$order_data['shipping']['country']:$order_data['shipping']['country'],
'receiverCity'=>$order_data['shipping']['city'],
'receiverDistrict'=>$order_data['shipping']['state'],
'receiverAddress'=>$order_data['shipping']['country'].$order_data['shipping']['state'].$order_data['shipping']['city'].$order_data['shipping']['address_1'].$order_data['shipping']['address_2'],
'receiverMobile'=>$order_data['shipping']['phone'],
'payTime'=>$order_data['date_paid'],
'totalFee'=>$order_data['total'],
'orders'=>[$orderslist]


)];

	file_put_contents(dirname(__FILE__) . '/my_logger.txt', var_export($data,true),FILE_APPEND);
/*订单推送接口调用*/
$api->pushorderapi($url,$ak,$push_companyId,$data,$as);

	

}

add_action( 'woocommerce_payment_complete', 'wpdesk_set_completed_for_paid_orders' );

function wpdesk_set_completed_for_paid_orders( $order_id ) {

  	$order = wc_get_order( $order_id );
	 $api=new noticeerp();
$url='https://shell.obrase.com/hpiApp/web-module/mobileShell/pushTrade.req';
$as='pi6f4kwneq8qsn3dcn1qjvcm5amtv5paqhoego5u';
$ak='66666666';
$push_companyId='510002';
$order_data = $order->get_data(); // 获取订单数据

	$orderslist['tid']='8888888888'.$order_data['id'];
$orderslist['oid']='8888888888'.$order_data['id'];
foreach ($order->get_items() as $item_id => $item ) {
	

$orderslist['num']+=intval($item->get_quantity());
 $orderslist['outerSkuId'].='【'.$item->get_name().'X'.$item->get_quantity().'】-'; 
   // 等等...
}



$data=[array(

'tid'=>'8888888888'.$order_data['id'],
'shopName'=>'CustomCaseZone',
'buyerNick'=>$order_data['shipping']['first_name'].''.$order_data['shipping']['last_name'],
'receiverState'=>$order_data['shipping']['country']?$order_data['shipping']['country']:$order_data['shipping']['country'],
'receiverCity'=>$order_data['shipping']['city'],
'receiverDistrict'=>$order_data['shipping']['state'],
'receiverAddress'=>$order_data['shipping']['country'].$order_data['shipping']['state'].$order_data['shipping']['city'].$order_data['shipping']['address_1'].$order_data['shipping']['address_2'],
'receiverMobile'=>$order_data['shipping']['phone'],
'payTime'=>$order_data['date_paid'],
'totalFee'=>$order_data['total'],
'orders'=>[$orderslist]


)];

	file_put_contents(dirname(__FILE__) . '/my_logger.txt', var_export($data,true),FILE_APPEND);
/*订单推送接口调用*/
$api->pushorderapi($url,$ak,$push_companyId,$data,$as);
    
}



/*物流api*/
//pushshipapi($url,$ak,$tid,$outSid,$expressCode);


/*物流轨迹api*/
//pushshiphistoryapi($url,$ak,$data);
?>