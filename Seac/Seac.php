<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Seac/SeacAlerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Seac/SeacConexao.php";

class Seac extends modulo {


	public $server;
        public $gateway;
        public $GlobalFile;
 
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        
        $this->name  = "Seac";
        $this->sigla = "SEaC";
        $this->icone = "fa fa-desktop";
        
        $this->SeacConexao[0]   = new SeacConexao('/dados/cap/status/seac_heartbeat.xml');
        //$this->SeacConexao[0]   = new SeacConexao('/dados/cap/status/seac_heartbeat_PR.xml');
        $this->SeacAlerta[0]    = new SeacAlerta('/dados/cap/status/alerta_tv.xml');
        
    }
    
    public function get_data() {
        
        $hora = date('G');

        foreach($this->SeacConexao as $s) {
            $s->get_data();
        }
        foreach($this->SeacAlerta as $sf) {
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
        
        foreach($this->SeacConexao as $g) {
            $g->ShowMe();
        }
        foreach($this->SeacAlerta as $sf) {
            $sf->ShowMe();
        }
        
    }    
    
}

$seac = new Seac();

if(isset($_GET['back'])) {
    $seac->back_call();
    $seac->ShowMe();
}



