<?php

class DataHelpers {
	
	public static function formatDate($month,$day,$year) {
		return "$month/$day/$year";
	}
	
	public static function formatDateFromDBDatetime($datetime) {
		$parts = split(' ', $datetime);
		$parts = split('-',$parts[0]);
		return self::formatDate($parts[1], $parts[2], $parts[0]);
	}
	
	
	public static function formatTime($hours,$minutes,$seconds=0) {
		return "$hours:$minutes:$seconds";
	}
	
	public static function formatTimeFromDbDatetime($datetime) {
		$parts = split(' ', $datetime);
		return $parts[1];
	}
	
	
	public static function formatLongLat($degrees,$minutes,$hem='N') {
		return "$degrees $minutes $hem";
	}
	
	
	public static function formatLongLatFromStr($str) {
		$matches = array();
		preg_match('/([0-9-]+)([NSEWnsew])([0-9]+)/',$str,$matches);
		return self::formatLongLat($matches[1], $matches[3], strupper($matches[2]));
	}
	
	public static function formatLongitude($degrees,$minutes,$west=true) {
		return self::formatLongLat($degrees,$minutes,$west === true?"W":"E");
	}
	
	public static function formatLatitude($degrees,$minutes,$north=true) {
		return self::formatLongLat($degrees,$minutes,$north === true?"N":"N");
	}
	
	public static function formatFloatAsLongitude($val) {
		$degrees = (int)abs($val);
		$minutes = (int)(abs($val) * 60) % 60;
		$west = $val < 0;
		return self::formatLongitude($degrees,$minutes,$west);
	}
	
	public static function formatFloatAsLatitude($val) {
		$degrees = (int)abs($val);
		$minutes = (int)(abs($val) * 60) % 60;
		$south = $val < 0;
		return self::formatLatitude($degrees,$minutes,$south);
	}
	
	public static function formatTimestampTimeAsDate($val) {
		return date("n/j/Y",$val);
	}
	
	public static function formatTimestampTimeAsTime($val) {
		return date("G:i:s",$val);
	}
}