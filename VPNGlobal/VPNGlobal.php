<?php

class Banco {

	public $hostname;
	public $connection;
        public $date;
    
    public function __construct($hostname) {
        $this->hostname = $hostname;
    }
    
    
     public function get_data() {
         
        $filename = "/dados/cap/status/banco_".$this->hostname.".j";
        $arq = @fopen($filename,"r");
        $al = new alerta();
        
        if($arq==null) {
		$this->connection = "false";
              
        }
	else {
		$j = fgets($arq);
		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			$this->connection = "false";
		}
                else {
                    $this->connection = $obj->connection;
                    $this->date = $obj->date;
                    
                    
                }
		fclose($arq);
             
                if($this->connection!='true') {
                         $al->registra("Servico",$this->hostname,$this->date , "banco sem conectividade", 1, 2);
                }

	}
     }
    
    public function ShowMe() {
        print "<tr>";
        print "<td>$this->hostname</td>";
        
        if($this->connection=='true') {
	        print "<td><font color=green>OK </font></td>";
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


