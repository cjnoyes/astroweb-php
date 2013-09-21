<?php

include_once 'Base.php';

class Rectify extends Base {
	
	// system values
	const SOLARCHART = 0;
	const FLATCHART  = 1;
	
	public function __construct($other=false) {
		parent::__construct($other===true?Base::OTHER_RECT:Base::BIRTH_RECT);
	}
	
	public function assemble() {
		$this->section->addItem("known", $this->birthTimeKnown===true?1:0);
		$this->section->addItem("system",$this->system);
	}
	
	var $birthTimeKnown = true;
	
	 var $system = 0;
}