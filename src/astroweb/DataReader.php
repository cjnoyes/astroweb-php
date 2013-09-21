<?php
/*
 * Created on Aug 18, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class DataReader {
	
	public function __construct($src,$type) {
		$this->source = $src;
		$this->type = $type;
		$this->data = array();
	}
	
	public function getData() {
		return $this->data;
	}
	
	protected function arrayToAssoc($ary, $keys) {
		$data = array();
		for ($i = 0; $i < count($keys); $i++) {
			if (isset($ary[$i])) {
			   $data[$keys[$i]] = $ary[$i];
			}
			else {
				$data[$keys[$i]] = false;
			}
		}
		return $data;
	}
	
	
	protected function getHouses($sec) {
		$houses = array();
		if (isset($this->ini[$sec])) {
			$data = $this->ini[$sec];
			for ($i = 1; $i <= 12; $i++) {
				$houses[] = $data["house$i"];
			}
			unset($this->ini[$sec]);
		}
		return $houses;
	}
	
	protected function getAspects($sec) {
		$aspects= array();
		if (isset($this->ini[$sec])) {
			$data = $this->ini[$sec];
	        $i = 1;
		    while (isset($data["aspect$i"])) {
		    	$line = $data["aspect$i"];
		    	$aspects[] = $this->arrayToAssoc(explode(',',$line),array('first','second','aspect','orb'));
		    	$i++;
		    }
		    unset($this->ini[$sec]);
		}
		return $aspects;
	}
	
	protected function getTransitDates($sec) {
		$dates= array();
		if (isset($this->ini[$sec])) {
			$data = $this->ini[$sec];
	        $i = 1;
		    while (isset($data["date$i"])) {
		    	$line = $data["date$i"];
		    	$dates[] = $line;
		    	$i++;
		    }
		    unset($this->ini[$sec]);
		}

		return $dates;
	}
	
	protected function getPlanets($sec) {
		$planets= array();
		if (isset($this->ini[$sec])) {
			$data = $this->ini[$sec];
	        $i = 1;
		    while (isset($data["planet$i"])) {
		    	$line = $data["planet$i"];
		    	$ary = $this->arrayToAssoc(explode(',',$line),array('planet','total_minutes','sign', 'cusp', 'degrees', 'minutes', 'house', 'house_cusp', 'intercepted', 'retrograde', 'misc_code'));
		    	$sign = $ary['sign'];
		    	$degrees = $ary['degrees'];
		    	$total = $sign * 30 + $degrees;
		    	$ary['total_degrees'] = $total;
		    	$planets[] = $ary;
		        $i++;
		    }
		    unset($this->ini[$sec]);
		}
		return $planets;
	}
	
	protected function natal() {
		$this->data['natal']['houses'] = $this->getHouses("Houses");
		$this->data['natal']['planets'] = $this->getPlanets("Planets");
		$this->data['natal']['aspects'] = $this->getAspects("Aspects");
	}
	
	protected function biwheel() {
		$this->natal();
		$this->data['other']['houses'] = $this->getHouses("OtherHouses");
		$this->data['other']['planets'] = $this->getPlanets("OtherPlanets");
		$this->data['other']['aspects'] = $this->getAspects("OtherAspects");
		$this->data['transits']=array();
	}
	
	protected function getTransit($index,$date) {
		$transit = array('date'=>$date);
		$transit['planets']=$this->getPlanets("TransitPlanets-{$index}");
		$transit['aspects']=$this->getAspects("TransitAspects-{$index}");
		return $transit;
	}
	
	
	protected function transits() {
		$this->natal();
		$dates = $this->getTransitDates("TransitDates");
		print_r($dates);
		for ($i = 0; $i < count($dates); $i++) {
			$this->data['transits'][] = $this->getTransit($i,$dates[$i]);
		}
	}
	
	
	public function readData() {
		$this->ini = @parse_ini_file($this->source, true);
		if ($this->ini === false) {
			throw new Exception("Can't read " . $this->source);
		}
		echo $this->type;
		switch ($this->type) {
			case 'natal':
			case 'compos':
			$this->natal();
			break;
			case 'compat':
			case 'progr' :
			$this->biwheel();
			break;
			case 'trans' :
			$this->transits();
		}
	}
	
	var $ini;
	var $data;
	var $source;
	var $type;
} 
 
?>
