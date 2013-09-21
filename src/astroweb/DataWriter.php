<?php

class DataWriter {
	
	public function __construct($file) {
		$this->file = $file;
		$this->handle = false;
	}
	
	public function open() {
		$this->handle = @fopen($this->file,"w");
		if ($this->handle === false) {
			throw new Exception($this->file . ' cannot be opened');
		}
	}
	
	public function close() {
		if ($this->handle === false) {
			return false;
		}
		fclose($this->handle);
		return true;
	}
	
	public function writeSection($sec) {
		if ($this->handle === false) {
			return false;
		}
		
		fputs($this->handle,$sec->toString());
		return true;
	}
	
	public function writeSections($sections) {
		foreach ($sections as $sec) {
			$ret = $this->writeSection($sec);
			if ($ret === false) {
				return false;
			}
		}
		return true;
	}
	
	private $handle;
	private $file;
}