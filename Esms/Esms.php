<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/GatewaySMS/GatewaySMS.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Esms/EsmsAlerta.php";

class Esms extends modulo {


	public $server;
        public $gateway;
        public $alerta;
 
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        $this->name  = "Esms";
        $this->sigla = "E-SMS";
        $this->icone = "fa fa-mobile";
        
        $this->gateway[0] = new GatewaySMS('Curitiba',"/dados/cap/status/status_pr.xml");
        $this->gateway[1] = new GatewaySMS('São Paulo',"/dados/cap/status/status_sp.xml");
        $this->gateway[2] = new GatewaySMS('Kannel51',"/dados/cap/status/status_kannel51.xml");
        
        $this->alerta[0] = new EsmsAlerta("/dados/cap/status/alerta.xml");
        
        
        
        
    }
    
    public function get_data() {
        
        $hora = date('G');

        foreach($this->gateway as $s) {
            $s->get_data();
            $s->emergencia = true;
        }
        foreach($this->alerta as $sf) {
            $sf->get_data();
        }
        
    }
    
    public function front_call() {
        
         parent::front_call();

    }
    
    public function back_call() {
        $this->get_data();
    }
    
    public function ShowMe() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        
        foreach($this->gateway as $g) {
            $g->ShowMe();
        }
        foreach($this->alerta as $sf) {
            $sf->ShowMe();
        }
        
    }    
    
}

$esms = new Esms();

if(isset($_GET['back'])) {
    $esms->back_call();
    $esms->ShowMe();
}



