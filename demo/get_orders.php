<?php

use OttoMarket\Core\Util;

include '.config.php';
/**
 * @var array $options
 */

$arr = array_merge($options,[
	'grant_type'=>'password',
	'client_id'=>'token-otto-api',
]);
$token = new \OttoMarket\Api\Token();
$tokens = $token->getToken($arr);

$api = new \OttoMarket\Api\Orders();
$api->setAccessToken($tokens['access_token']);

$limit = 20;
$nextcursor = '';
$data = [
	'fromDate'          => "2022-11-20T09:00:00",
	'fromOrderDate'     => "",
	'toOrderDate'       => "",
	'fulfillmentStatus' => "",
	'orderDirection'    => "",
	'orderColumnType'   => "",
	'mode'              => "",
	'nextcursor'        => $nextcursor,
	'limit'             => $limit,
];

$order_arr = [];
while(1){
	$rsp = $api->getOrders($data);

	if(!$api->isSuccess()){
		die();
	}
	if(!$rsp['resources']){
		break;
	}
	$order_arr = array_merge($order_arr,$rsp['resources']);
	
	$nextcursor = Util::getNextCursorByLink($rsp['links']);
	if($nextcursor){
		$data = [
			'nextcursor'        => $nextcursor,
			'limit'             => $limit,
		];
	}else{
		break;
	}
}

print_r($order_arr);


$order_no = "ORDER_A";
$rsp = $api->getOrder($order_no);
print_r($rsp);
if(!$api->isSuccess()){
	die();
}

