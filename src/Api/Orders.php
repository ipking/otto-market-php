<?php

namespace OttoMarket\Api;

use OttoMarket\Core\Client;

class Orders extends Client {

	/**
	* Operation getOrders
	 * @param array $query
	*/
	public function getOrders($query = [])
	{
		return $this->send("/v4/orders", [
		  'method' => 'GET',
		  'query'  => $query,
		]);
	}
	
	/**
	 * Operation get one Order
	 * @param string $order_no
	 */
	public function getOrder($order_no)
	{
		return $this->send("/v4/orders/".$order_no, [
			'method' => 'GET',
		]);
	}
	
}
