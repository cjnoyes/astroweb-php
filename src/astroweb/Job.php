<?php

include_once 'config/ChartConfig.php';
include_once 'DataWriter.php';
include_once 'ChartRunner.php';
include_once 'DataReader.php';

class Job {

	const NATAL = "natal";
	const COMPAT = "compat";
	const TRANS = "trans";
	const PROGR = "progr";
	const COMPOS = "compos";
	
	public function __construct($type, $ini='config.ini') {
		$this->ini = $ini;
		$this->type = $type;
		
		$config = @parse_ini_file($this->ini);
		if ($config === false) {
			throw new Exception("can't parse " . $this->ini);
		}
		$this->astroweb = $config['program'];
		$this->home = $config['home'];
		if (substr($this->home,1,-1) != '\\' && substr($this->home,1,-1) != '/') {
			$this->workDir = $this->home . '/session';
		}
		else {
			$this->workDir = $this->home . 'session';
		}
		$this->session = "astrw" . rand(100,1000);
		$this->config = new ChartConfig();
		$this->config->setChartType($this->type);
	}

	
	public function &getChartConfig() {
		return $this->config;
	}
	
	public function addInput($input) {
        $this->getWriter()->writeSection($input);
	}
	
	public function &getWriter() {
		if ($this->writer === false) {
			$this->writer = new DataWriter($this->workDir . '/' . $this->session . '.in');
			$this->writer->open();
		}
		return $this->writer;
	}

	
	public function &getRunner() {
		if ($this->runner != false) {
			return $this->runner;
		}
		$this->config->writeConfig($this->workDir . '/' . $this->session . '.conf');
		$this->writer->close();
		$this->runner = new ChartRunner($this->astroweb, $this->home, $this->type, $this->session);
		return $this->getRunner();
	}
	
	public function execute() {
		return $this->getRunner()->execute();
	}
	
	public function &getReader() {
		if ($this->reader !== false) {
			return $this->reader;
		}
		$this->reader = new DataReader($this->workDir . '/' . $this->session . '.dat',$this->type);
		return $this->reader;
	}
	
	public function getData() {
	    $this->getReader()->readData();
	    return $this->getReader()->getData();
	}
	
	public function cleanup() {
		@unlink($this->workDir . '/' . $this->session . '.conf');
		@unlink($this->workDir . '/' . $this->session . '.in');
		@unlink($this->workDir . '/' . $this->session . '.dat');
	}
	
	var $reader = false;
	var $runner=false;
	var $writer=false;
	var $workDir;
	var $type;
	var $config;
	var $astroweb;
	var $home;
	var $session;
	var $ini;
}
