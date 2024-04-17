<?php

class Conectividade {

	public $hostname;
	public $connection;
        public $date;
        public $destination;
        public $status;
    
    public function __construct($hostname) {
        $this->hostname = $hostname;
    }
    
    
     public function get_data() {
         
        $filename = "/dados/cap/status/conectividade_".$this->hostname.".j";
        $arq = @fopen($filename,"r");
        
        $al = new alerta();
        
        if($arq==null) {
		$this->connection = "false";
                print "Falso;";
        }
	else {
		$j = fgets($arq);
		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			$this->connection = "false";
		}
                else {
                   // $this->connection   = $obj->connection;
                    $this->date         = $obj->date;
                    $this->destination  = $obj->destino;
                    $this->status       = $obj->status;
                }
		fclose($arq);
	}
        if($this->status!='true') {
           $al->registra("Servico",$this->hostname,$this->date , "Sem conectividade", 1, 2);
        }
        
     }
    
    public function ShowMe() {
        print "<tr>";
        print "<td>$this->hostname</td>";
        
        if($this->status=='true') {
	        print "<td><font color=green>OK</font></td>";
        }
        else {
        	print "<td><font color=red>NOK</font></td>";
        }
        if($this->date > 1) 
                print "<td><font color=green>$this->date - OK</font></td>";
        else 
                print "<td><font color=green>$this->date - OK</font></td>";
        print "</tr>";
    }
    
}


