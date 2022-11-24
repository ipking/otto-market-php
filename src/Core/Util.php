<?php

namespace OttoMarket\Core;

class Util{
	
	/**
	 * 获取下一页的游标
	 * @pamam array $links
	 * @return string
	 */
	public static function getNextCursorByLink($links){
		if(!$links){
			return  '';
		}
		$href = $links[0]['href'];
		$info = parse_url($href);
		$query_arr = self::decodeUrlQuery($info['query']);
		return $query_arr['nextcursor'];
	}
	
	
	/**
	 * 将字符串参数变为数组
	 * @param $query string
	 * @return array
	 * */
	public static function decodeUrlQuery($query_str)
	{
		$query_pairs = explode('&', $query_str);
		$params = [];
		foreach ($query_pairs as $query_pair) {
			$item = explode('=', $query_pair);
			$params[$item[0]] = $item[1];
		}
		return $params;
	}
}