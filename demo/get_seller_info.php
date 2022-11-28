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

$seller_info = base64_decode(explode('.',$tokens['access_token'])[1]);

print_r($seller_info);