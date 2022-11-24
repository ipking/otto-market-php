<?php

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

$api = new \OttoMarket\Api\Shipments();
$api->setAccessToken($tokens['access_token']);

$body = [
	"trackingKey"=> [
		"carrier"=> "HERMES",
        "trackingNumber"=> "H1234567890123456789"
	],
	"shipDate"=> "2019-10-11T07:49:12.642Z",
    "shipFromAddress"=> [
		"city"=> "Dresden",
        "countryCode"=> "DEU",
        "zipCode"=> "01067"
    ],
    "positionItems"=> [
        [
	        "positionItemId"=> "b01b8ad2-a49c-47fc-8ade-8629ec000020",
            "salesOrderId"=> "bf43d748-f13d-49ca-b2e2-1824e9000021",
            "returnTrackingKey"=> [
	            "carrier"=> "DHL",
                "trackingNumber"=> "577546565072"
            ]
        ],
	    [
	        "positionItemId"=> "b01b8ad2-a49c-47fc-8ade-8629ec000022",
            "salesOrderId"=> "bf43d748-f13d-49ca-b2e2-1824e9000021",
            "returnTrackingKey"=> [
	            "carrier"=> "DHL",
                "trackingNumber"=> "577546565072"
            ]
        ]
    ]
];

$rsp = $api->createShipments($body);
if(!$api->isSuccess()){
	print_r($rsp);
	die();
}
print_r($rsp);

$error_json = <<<EOL
{"errors":[{"title":"POSITION_ITEM_NOT_FOUND","detail":"The position item can not be found","path":"\/shipments","jsonPath":"positionItems[0]"},{"title":"POSITION_ITEM_NOT_FOUND","detail":"The position item can not be found","path":"\/shipments","jsonPath":"positionItems[1]"}]}
EOL;

