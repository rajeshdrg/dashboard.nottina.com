<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/SmsPortabilidade/GlobalFilePor.php";

class SmsPortabilidade extends modulo {


	public $server;
        public $gateway;
        public $GlobalFile;
 
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        
        $this->name  = "SmsPortabilidade";
        $this->sigla = "SMS Portabilidade";
        $this->icone = "fa fa-mobile";
        
        $this->GlobalFile[1] = new GlobalFilePor("/dados/cap/status/wspre_portabilidade.xml");
        
    }
    
    public function get_data() {
        
        $hora = date('G');

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
        
        foreach($this->GlobalFile as $sf) {
            $sf->ShowMe();
        }
        
    }    
    
}

$smsPor = new SmsPortabilidade();

if(isset($_GET['back'])) {
    $smsPor->back_call();
    $smsPor->ShowMe();
}



