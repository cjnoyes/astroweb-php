<?php

include_once 'Base.php';
include_once 'DataHelpers.php';

class TransData extends Base {
	
	// planet values for start and end
    const SUN = 1;
    const MOON= 2;
    const MERCURY = 3;
    const VENUS = 4;
    const MARS = 5;
    const JUPITER = 6;
    const SATURN = 7;
    const URANUS = 8;
    const NEPTUNE = 9;
    const PLUTO = 10;

	public function __construct() {
		parent::__construct(Base::TRANSDAT);
		$this->months = 0;
		$this->days = 1;
		$this->years = 0;
		$this->count = 1;
		$this->start = self::SUN;
		$this->end = self::PLUTO;
	}
	
	public function assemble() {
		$this->section->addItem("offset", DataHelpers::formatDate($this->months, $this->days, $this->years));
		$this->section->addItem("count",$this->count);
		$this->section->addItem("start",$this->start);
		$this->section->addItem("end",$this->end);
	}
	
	var $months;
	
	var $days;
	
	var $years;
	
	var $count;
	
	var $start;
	
	var $end;
}