<?php

class GlobalFile {
    
    public $file;
    public $xml;
    public $file_date;
    
    public function __construct($file) {
        
        $this->file = $file;
        
    }
    
    
     public function get_data() {
        $len = filesize($this->file);
        
        $this->file_date  =  date ( "d/m/Y H:i:s.", filemtime($this->file));
	$arq = fopen($this->file,"r");
	if($arq==null) {
		print "Erro: arquivo xml não encontrado<br>;";
		exit(0);
	}
	$xmlstr = fread($arq,$len);
	fclose($arq);
        
        $this->xml= new SimpleXMLElement($xmlstr);
        

         
     }
    
    public function ShowMe() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        
        print  "<div class='card $dark'>";
	print "<header class=r'card-header'>";
	print "<b>Global - Volume</b><br>";
        print  "<span> Atualização $this->file_date</span>";
        print "</header>";
	print "<div class='card-content'>";
        
        foreach($this->xml->volume as $vol) {

            print "<p>";

            print  "<span style='display:inline-block; width:90px;'>";
            print "<b>".substr($vol->data,8,2)."/".substr($vol->data,5,2)."/".substr($vol->data,0,4)."</b></span>";
            print  "<span style='display:inline-block; width:90px;'>";
            print "<b>".number_format("$vol->enviados", 0, ',', '.')."</b></span>";

            print "</p>";
        }
        print "</div>";
        print "</div>";

    }
    
}


