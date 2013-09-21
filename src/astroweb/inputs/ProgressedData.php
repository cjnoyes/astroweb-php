<?php

include_once 'Base.php';
include_once 'DataHelpers.php';

class ProgressedData extends Base {
	
	// system Values;
	const SECONDARY_PR = 0;
	const TERTIARY_PR = 1;
	const MINOR_PR    = 2;

	public function __construct() {
		parent::__construct(Base::PROGRESSED);
		$this->months = 0;
		$this->days = 0;
		$this->years = 0;
		$this->system = 0;
	}
	
	public function assemble() {
		$this->section->addItem("date", DataHelpers::formatDate($this->months, $this->days, $this->years));
		$this->section->addItem("system",$this->system);
	}
	
	var $months;
	
	var $days;
	
	var $years;
	
	 var $system;
}