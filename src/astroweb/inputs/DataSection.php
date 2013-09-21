<?php

class DataSection {
	
	public function __construct($sec) {
		$this->section = $sec;
		$this->data = array();
	}
	
	public function addItem($key,$element) {
		$this->data[]= array($key,$element);
	}

	public function toString() {
		$buffer = "[{$this->section}]\n";
		foreach ($this->data as $row) {
			$buffer .= $row[0] . '=' . $row[1] . "\n";
		}
		$buffer .= "\n";
		return $buffer;
	}
	
	
	private $data;
	private $section;
}