<?php

include_once 'DataSection.php';

abstract class Base {
	// sectnames
	const BIRTH = "Birth";
	const OTHER_BIRTH  = "Comp";
	const TRANS = "Trans";
	const TRANSDAT = "TransData";
	const BIRTH_RECT = "BirthRect";
	const OTHER_RECT = "CompRect";
	const PROGRESSED  = "ProgrData";
	// formats
	const STRING = 0;
	// for date and time, use value as is
	// for longitude and latitude extract value from 44N33 type notation
	const FLOAT = 1;
	// for longitude and latitude use floating point notation
	const TIMESTAMP = 2;
	// use unix timestamp i.e. time() field
	const DATETIME = 4;
	// separate date and time fields, i.e. year, month, day
	const PARTS = 5;
	
	public function __construct($sectname) {
		$this->section = new DataSection($sectname);
	}
	
	abstract function assemble();

	
	public function toString() {
		$this->assemble();
		return $this->section->toString();
	}
	
	
	protected $section;
}