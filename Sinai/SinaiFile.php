<?php

class SinaiFile {
    
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
        

        $this->smscs = $this->xml->smscs;
         
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
	print "<b>Sinai - Arquivos</b><br>";
        print  "<span> Atualização $this->file_date</span>";
        print "</header>";
	print "<div class='card-content'>";
        
        $sinai_total = 0;
        foreach($this->xml->row  as $row) {

            print "<p>";

            print "<span>";
            print "<span>".substr($row->filename,0,14);
            print "<b>".substr($row->filename,14,8)."</b>";
            print "<font color=green>".substr($row->filename,22,6)."</font>";
            print substr($row->filename,28);
            print "</b></span>";
            print "<span>  &nbsp; ".$row->count." SMS</span>";
            print "</p>";
            $sinai_total += $row->count;
        }
        print "<p><font color=blue><b>".number_format($sinai_total,0,",",".")."</b></font> mensagens enviadas</p>";
        print "</div>";
        print "</div>";

    }
    
}


