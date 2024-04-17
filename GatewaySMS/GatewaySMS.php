<?php

class GatewaySMS {


	public $name;
	public $file;
        public $operadora;
        public $xml;
        public $status;
        public $smscs;
        public $file_date;
        public $global;
        public $emergencia;
    
    public function __construct($name,$file) {
        
       
        
        $this->file = $file;
	$this->name = $name;
        
        $this->operadora=array();
        $this->operadora['0341']='TIM';
        $this->operadora['0320']='Vivo';
        $this->operadora['0343']='Sercomtel';
        $this->operadora['0312']='Algar';
        $this->operadora['0321']='Claro';
        $this->operadora['0331']='Oi';
        $this->operadora['0307']='Americanet';
        $this->operadora['0315']='Telecall';   
        $this->operadora['0322']='Brisanet';
        $this->operadora['0309']='Unifique';
        $this->operadora['0301']='Datora';
        
        $this->global = false;
        $this->emergencia = false;
        
    }
    
    
     public function get_data() {
        $al = new alerta();
         
        $len = filesize($this->file);
        
        $this->file_date  =  date ( "d/m/Y H:i:s.", filemtime($this->file));
	$arq = fopen($this->file,"r");
	if($arq==null) {
		print "Erro: arquivo xml não encontrado $this->file<br>;";
            	$al->registra("Esms", $this->name, $this->file_date, "XML não encontrado", 1, 1);
		exit(0);
	}
	$xmlstr = fread($arq,$len);
	fclose($arq);
        
        $this->xml= new SimpleXMLElement($xmlstr);
        
        if(strpos($this->xml->status,"running")===false) {
            $this->status = "Gateway parado";
            $al->registra("Esms", $this->name, $this->file_date, "Gateway parado", 1, 1);
        }
        else {
            $this->status = "Gateway executando";
            foreach($this->smscs->smsc as $smsc) {
                $status = substr($smsc->status,0,strpos($smsc->status," "));
                    if($status != "online")                 {
                         $al->registra("Esms", $this->operadora[substr($smsc->id,1,4)], $this->file_date, "Falha kannel", 1, 1);
                    }
            }
            
        }

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
	print "<b>$this->name</b><br>";
        print  "<span> Status $this->status</span><br>";
        print  "<span> Atualização $this->file_date</span>";
        print "</header>";
	print "<div class='card-content'>";
        
        foreach($this->smscs->smsc as $smsc) {
            if(($this->global && strpos($smsc->id,"all")>0 ) || ($this->emergencia && strpos($smsc->id,"sinai")===false && strpos($smsc->id,"mc")===false  && strpos($smsc->id,"all")===false) && strpos($smsc->id,"posi")===false) {
                print "<p>";

                $status = substr($smsc->status,0,strpos($smsc->status," "));
                if($status == "online") 
                    print  "<span style='display:inline-block; width:90px;'><font color=green>";
                else 
                    print  "<span style='display:inline-block; width:90px;'><font color=red>";
                
                print "<b>".$this->operadora[substr($smsc->id,1,4)]."</b></span>";
                print  "<span style='display:inline-block; width:120px;'>".$smsc->{'admin-id'}."</span>";
                print "</font>";

                print "<b>Fila</b> $smsc->queued";
                $in = substr($smsc->sms->inbound,0,strpos($smsc->sms->inbound,","));
                $out = substr($smsc->sms->outbound,0,strpos($smsc->sms->outbound,","));
                print "<b>TPS</b><font color=green> $in <i class='far fa-arrow-alt-circle-down'></i></font>";
                print "<font color=blue>  $out <i class='far fa-arrow-alt-circle-up'></i></font>";
                print "</p>";
            }
        }
        
        print "</div>";
        print "</div>";

    }
    
}


