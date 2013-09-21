<?php

class ChartRunner {
	
	public function __construct($program, $home, $type, $job) {
		$this->program = $program;
		$this->home = $home;
		$this->type = $type;
		$this->job = $job;
		$this->error = '';
	}
	
    public function execute() {
    	  $command = $this->program . ' --job ' . $this->job;
    	  $command .= " --type " . $this->type;
    	  $command .= " --home " . $this->home;
  
    	  $descriptorspec = array(
    	  		0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
    	  		1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
    	  		2 => array("pipe", "w") // stderr is a file to write to
    	  );
    	  
    	  echo $command;
    	  
    	  $cwd = $this->home;
    	  $env = array();
    	  
    	  $pipes = array();
    	  
    	  $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);
    	  if (is_resource($process)) {
    	  	 do {
    	  	 	$ary = proc_get_status($process);
    	  	 	sleep(.25);
    	  	 } while ($ary['running']==true);
    	  	 $err = stream_get_contents($pipes[2]);
    	  	 fclose($pipes[2]);
    	  	 fclose($pipes[1]);
    	  	 fclose($pipes[0]);
    	  	 $this->error = $err;
    	  	 $status =proc_close($process);
    	  	 if ($status == 0) {
    	  	 	return true;
    	  	 }
    	  	 else {
    	  	 	throw new Exception($err);
    	  	 }
    	  }
    	  else {
    	  	throw new Exception("Error executing");
    	  }
    	 
    }
	
    public function getError() {
    	return $this->error;
    }
    
    
    var $error;
	var $program;
	var $home;
	var $type;
	var $job;
}