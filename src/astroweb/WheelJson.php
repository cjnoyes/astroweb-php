<?php
/*
 * Created on Aug 18, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
class WheelJson {
	
	public function __construct($type,$source,$filename) {
		$this->type = $type;
		$this->source = $source;
		$this->filename = $filename;
		$this->data = array();
		$this->maxpt = -1;
		$this->legend = false;
	}
	
	public function setMaxPt($max) {
		$this->maxpt = $max;
	}
	
	public function setLegendData($ary) {
		$this->legend = $ary;
	}
	
	
	protected function realType() {
		switch ($this->type) {
			case 'natal':
			return "Natal";
			case 'compat':
			return 'Compatibility';
			case 'compos':
			return 'Composite';
			case 'trans':
			return 'Transits';
			case 'progr':
			return 'Progressed';
		}
	}
	
	public function save() {
		$str = json_encode($this->data);
		file_put_contents($this->filename,$str);
	}
	
	protected function planetsToMinutes($ary) {
		$return = array();
		foreach ($ary as $ele) {
			$return[] = $ele['total_minutes'];
		}
		return $return;
	}
	
	protected function convertAspects($planets,$aspects) {
		$mins = $this->planetsToMinutes($planets);
		$return = array();
		foreach ($aspects as $aspect) {
			$return [] = array('first'=>$mins[$aspect['first']],'second'=>$mins[$aspect['second']],'aspect'=>$aspect['aspect']);
		}
		return $return;
	}
	
	protected function convertArray($ary) {
		$return = array();
		
		if (isset($ary['houses'])) {
			$return['housecusps']=$ary['houses'];
		}
		else {
			$return['housecusps']=array();
		}
		if (isset($ary['planets'])) {
			$return['datapoints']=$ary['planets'];
			$return['minutes']=$this->planetsToMinutes($ary['planets']);
		}
		else {
			$return['datapoints']=array();
			$return['minutes']=array();
		}
		if (isset($ary['aspects'])) {
			$return['gridaspects']=$ary['aspects'];
			$return['aspects'] = $this->convertAspects($ary['planets'],$ary['aspects']);
		}
		else {
			$return['aspects']=array();
			$return['gridaspects']=array();
		}
		$return['numaspects']=count($return['aspects']);
		$return['numgridaspects']=count($return['gridaspects']);
		$return['numdatapoints']=count($return['datapoints']);
		if (is_array($this->legend)) {
			foreach ($this->legend as $key=>$value) {
				$return[$key]=$value;
			}
		}
		return $return;
	}
	
	
	protected function natal() {
		$this->data['natal'] = $this->convertArray($this->source['natal']);
		$this->data['numcharts']=0;
		$this->data['strType']=$this->realType();
		if ($this->maxpt != -1) {
			$this->data['maxpt'] = $this->maxpt;
		}
		else {
			$this->data['maxpt']= count($this->source['natal']['planets']);
		}
	}
	
	protected function biwheel() {
		$this->natal();
		$this->data['other'] = $this->convertArray($this->source['other']);
		$this->data['numcharts']=0;
	}
	
	protected function transits() {
		$this->natal();
		$this->data['other'] = $this->convertArray(isset($this->source['other'])?$this->source['other']:array());
	}
	
	public function setup() {
		switch ($this->type) {
			case 'natal':
			case 'compos':
			    $this->natal();
			break;
			case 'compat':
			case 'progr':
			    $this->biwheel();
			break;
			case 'trans' :
			    $this->transits();
			break;
		}
	}
	
	var $legend;
	var $type;
	var $source;
	var $data;
	var $filename;
	var $maxpt;
} 
 
?>
