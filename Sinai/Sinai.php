<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Sinai/Gateway.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Sinai/SinaiFile.php";

class Sinai extends modulo {


	public $server;
        public $gateway;
        public $SinaiFile;
 
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Sinai";
        $this->sigla = "SINAI";
        $this->icone = "fa fa-mobile";
        
        $this->gateway[0] = new Gateway('Curitiba',"/dados/cap/status/status_pr.xml");
        $this->gateway[1] = new Gateway('São Paulo',"/dados/cap/status/status_sp.xml");
        
        $this->SinaiFile[1] = new SinaiFile("/dados/cap/status/sinai_pr.xml");
        
    }
    
    public function get_data() {
        
        $hora = date('G');

        foreach($this->gateway as $s) {
            $s->get_data();
            
        }
        foreach($this->SinaiFile as $sf) {
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
        foreach($this->SinaiFile as $sf) {
            $sf->ShowMe();
        }
        
    }    
    
}

$sin = new Sinai();

if(isset($_GET['back'])) {
    $sin->back_call();
    $sin->ShowMe();
}



