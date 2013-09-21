<?php

include_once 'Transit.php';

class Birth extends Transit {
	
	public function __construct($other=false) {
		parent::__construct($other===true?Base::OTHER_BIRTH:Base::BIRTH);
	}
	
	function assemble() {
		parent::assemble();
	}
	
}