<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/GatewaySMS/GatewaySMS.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/BrokerGlobal/GlobalFile.php";

class BrokerGlobal extends modulo {


	public $server;
        public $gateway;
        public $GlobalFile;
 
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        
        $this->name  = "BrokerGlobal";
        $this->sigla = "Broker Global";
        $this->icone = "fa fa-mobile";
        
        $this->gateway[1]    = new GatewaySMS('São Paulo',"/dados/cap/status/status_sp.xml");
        $this->gateway[2]    = new GatewaySMS('Curitiba',"/dados/cap/status/status_pr.xml");
        $this->GlobalFile[1] = new GlobalFile("/dados/cap/status/wspre_volume.xml");
        
    }
    
    public function get_data() {
        
        $hora = date('G');

        foreach($this->gateway as $s) {
            $s->get_data();
            $s->global = true;

        }
        foreach($this->GlobalFile as $sf) {
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
        foreach($this->GlobalFile as $sf) {
            $sf->ShowMe();
        }
        
    }    
    
}

$glob = new BrokerGlobal();

if(isset($_GET['back'])) {
    $glob->back_call();
    $glob->ShowMe();
}



