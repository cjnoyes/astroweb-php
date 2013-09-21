<?php

class ChartConfig {
	
	// code value
	const NATAL_CH = 1;
	const PROGR_CH = 2;
	const COMPA_CH = 4;
	const TRANS_CH = 8;
	const COMPO_CH = 256;

	// flags values
	const DEFAULT_FLAGS = 224;
	// indidual values which are ored together
	const SIDEREAL=1;
	const HOUSES=32;
	const ASPECTS=64;
	const EXT_ASPECTS=128;
	const VERT_EAST=2048;
	const NOBIRTHTIM=4096;
	const ASTEROID=16384;
	
	// values for houses;
	const  EQUAL=0;
	const  KOCH=1;
	const  PLACIDUS=2;
	const  M_HOUSE=3;
	const  COMPANUS=4;
	const  REGIOMONT=5;
	const  MORINUS=6;
	const  PORPHYRYX=7;
	const  TOPOCENTRIC=8;
	const  MERIDIAN=9;
	
	
	
	public function __construct() {
		$this->flags = self::DEFAULT_FLAGS;
		$this->rect = 0;
		$this->houses = self::PLACIDUS;
		$this->code = self::NATAL_CH;
	}
	
	public function getFlags() {
		return $this->flags;
	}
	
	public function setFlags($f) {
		$this->flags = $f;
	}
	
	public function getRectify() {
		return $this->rect;
	}
	
	public function setRectify($f) {
		$this->rect = $f;
	}
	
	public function getHouseMethod() {
		return $this->houses;
	}
	
	public function setHouseMethod($f) {
		$this->houses = $f;
	}
	
	public function getChartCode() {
		return $this->code;
	}
	
	public function setChartCode($f) {
		$this->code = $f;
	}
	
	public function writeConfig($file) {
		$text=<<<END
flags={$this->flags}
rect={$this->rect}
houses={$this->houses}
code={$this->code}

END;
	file_put_contents($file,$text);
	}
	
	public function setChartType($type) {
		switch ($type) {
			case 'natal':
				$this->code = self::NATAL_CH;
				break;
			case 'compat' :
				$this->code = self::COMPA_CH;
				break;
			case 'trans' :
				$this->code = self::TRANS_CH;
				break;
			case 'progr' :
				$this->code = self::PROGR_CH;
				break;
			case 'compos' :
				$this->code = self::COMPO_CH;
				break;
			default:
				throw new Exception("Unknown type $type");
				break;
		}
	}
	
	private $flags;
	private $rect;
	private $houses;
	private $code;
}



