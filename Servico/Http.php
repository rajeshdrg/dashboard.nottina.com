<?php

class Http {

	public $hostname;
	public $apache;
        public $date;
    
    public function __construct($hostname) {
        $this->hostname = $hostname;
    }
    
    
     public function get_data() {
         
        $filename = "/dados/cap/status/apache_".$this->hostname.".j";
        $arq = @fopen($filename,"r");
        
        if($arq==null) {
		$this->apache = "false";
        }
	else {
		$j = fgets($arq);
		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			$this->apache = "false";
		}
                else {
                    $this->apache = $obj->apache;
                    $this->date = $obj->date;
                }
		fclose($arq);
	}
     }
    
    public function ShowMe() {
        print "<tr>";
        print "<td>$this->hostname</td>";
        
        if($this->apache=='true') {
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


