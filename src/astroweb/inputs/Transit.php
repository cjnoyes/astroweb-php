<?php

include_once 'Base.php';
include_once 'DataHelpers.php';

class Transit extends Base {
	
	public function __construct($sectname = Base::TRANS) {
		parent::__construct($sectname);
	}
	
	public function assemble() {
		$this->section->addItem("tzhours", $this->tzHours);
		$this->section->addItem("tzminutes",$this->tzMinutes);
		$lat = $this->latitude;
		if ($this->longLatType==Base::STRING) {
			$lat = DataHelpers::formatLongLatFromStr($lat);
		}
		else if ($this->longLatType==Base::FLOAT) {
			$lat = DataHelpers::formatFloatAsLatitude($lat);
		}
		$this->section->addItem("lat", $lat);
		
		$long = $this->longitude;
		if ($this->longLatType==Base::STRING) {
			$long = DataHelpers::formatLongLatFromStr($long);
		}
		else if ($this->longLatType==Base::FLOAT) {
			$long = DataHelpers::formatFloatAsLongitude($long);
		}
		$this->section->addItem("long", $long);
		
		switch ($this->dateType) {
			case Base::DATETIME:
				$date = DataHelpers::formatDateFromDBDatetime($this->date);
				break;
			case Base::PARTS :
				$date = DataHelpers::formatDate($this->month, $this->day, $this->year);
				break;
			case Base::TIMESTAMP:
				$date = DataHelpers::formatTimestampTimeAsDate($this->date);
				break;
			default:
				$date = $this->date;
				break;
		}
		$this->section->addItem("date", $date);
		switch ($this->timeType) {
			case Base::DATETIME:
				$time = DataHelpers::formatTimeFromDBDatetime($this->time);
				break;
			case Base::PARTS :
				$time = DataHelpers::formatTime($this->hours, $this->minutes, 0);
				break;
			case Base::TIMESTAMP:
				$time = DataHelpers::formatTimestampTimeAsTime($this->time);
				break;
			default:
				$time = $this->time;
				break;
		}
		$this->section->addItem("time", $time);
	}
	
	// constants from Base
	var $dateType;
	var $timeType;
	var $longlatType;
	
	var $date;
	var $time;
	var $longitude;
	var $latitude;
	var $tzHours;
	var $tzMinutes;
	var $day;
	var $month;
	var $year;
	var $hours;
	var $minutes;
	
	
}