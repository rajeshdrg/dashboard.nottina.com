<?php

class VolumeGtloc {
    
    public $file;

    public $xml;
    public $file_date;
    public $terminais;
    public $qtd_alertas;
    
    public function __construct($file) {
        
        $this->file = $file;

    }
    
    
     public function get_data() {
        $len = filesize($this->file);
        
        $this->file_date  =  date ( "d/m/Y H:i:s.", filemtime($this->file));
	$arq = fopen($this->file,"r");
	if($arq==null) {
		print "Erro: arquivo xml não encontrado $this->file<br>;";
		exit(0);
	}
	$xmlstr = fread($arq,$len);
	fclose($arq);
        
        $this->xml= new SimpleXMLElement($xmlstr);
        
        $terminais = 0;
        foreach($this->xml->alerta as $al) {
            $this->terminais+= (int) $al->enviados;
        }
        $this->qtd_alertas =  $this->xml->quantidade;
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
	print "<b>Alertas</b><br>";
        print  "<span> Atualização $this->file_date</span><br>";
        print  "<span '>$this->qtd_alertas alertas, ".number_format($this->terminais,0,',','.')." terminais</span>"; 

        print "</header>";
	print "<div class='card-content'>";
          foreach($this->xml->alerta as $al) {
            print '<div class="avatar"><div class=ufs>'. (string) $al->ufs .'</div></div>';
            print "<div class='messages $dark'>";
            print "<p>".(string) $al->evento."</p>";
            print "<p>Terminais:".number_format( (int) $al->enviados,0,',','.')."</p>";
            print "<time datetime=".$al->time." style='color=black;'>".substr($al->time,8,2).'/'.substr($al->time,5,2).'/'.substr($al->time,0,4)." ".substr($al->time,11,5)."</time>";

            print "</div>";
          }
        print "</div>";
        print "</div>";

    }
    
}


