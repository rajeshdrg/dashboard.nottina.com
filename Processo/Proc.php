<?php

class Proc {

	public $hostname;
	public $process;
	public $cmd;
	public $ok;
        public $date;
    	public $obj;
    	public $status;
	public $di;

    public function __construct($hostname,$process,$cmd) {
        $this->hostname = $hostname;
        $this->process  = $process;
        $this->cmd      = $cmd;
	$this->status   = "Missing";
    }
    
    
     public function get_data() {
         
        $filename = "/dados/cap/status/".$this->hostname.".process";
        $arq = @fopen($filename,"r");
        $al = new alerta();
        
	$this->ok = "false";
        if($arq==null) {
		error_log("ERRO: /dados/cap/status/".$this->hostname.".process");
              
        }
	else {
		$j = fgets($arq);
		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			error_log("Erro json");
			error_log(json_last_error());
		}
                else {
                    $this->date = $obj->date;

		    $dt = strtotime($this->date);
		    $this->di=ceil((time()-$dt)/60);
		    if($this->di < 40 ) {
			    foreach($obj->process as $p) {
				if($p->processo == $this->process && $p->cmd == $this->cmd) {
					$this->status = $p->status;
					if($p->status=='sleeping' || $p->status =='running') 
						$this->ok = 'true';
				}
			    }
	
		    }
                    
                    
                }
		fclose($arq);
                if($this->ok!='true') {
                         $al->registra("Processo","Processo $this->hostname $this->process $this->cmd",$this->date , "", 1, 2);
                }

	}
     }
    
    public function ShowMe() {
        print "<tr>";
        print "<td>$this->hostname</td>";
        print "<td>$this->process</td>";
        print "<td>$this->cmd</td>";
        print "<td>$this->status</td>";
        
        if($this->ok=='true') {
	        print "<td><font color=green>OK </font></td>";
        }
        else {
        	print "<td><font color=red>NOK</font></td>";
        }
        print "<td><font color=green>$this->date - ($this->di)  </font></td>";
        print "</tr>";
	print_r($this->obj);
    }
    
}


