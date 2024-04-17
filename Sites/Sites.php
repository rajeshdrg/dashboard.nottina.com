<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class Sites extends modulo {

    public $xmlc;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Sites";
        $this->sigla = "Sites";
        $this->icone = "fab fa-chrome";
        
        
    }
    
    public function front_call() {
        
         parent::front_call();


    }
    
    public function ShowMe() {
        
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        

        $this->get_data();        
        
        
        print "<div class='xcard $dark'>";
        print "    <div >";
        print "        <header class=r'card-header'>";
        print "            <font color=black>SITES</font><br>";
        print "        </header>";
        print "        <div class='card-content'>";
        print "            <table width=100%>";
        print "                <tr>";
	print "<iframe src='https://grafana.hugtak.com/d-solo/d6ae973e-440b-4842-a07c-ab572f45a2dc/sites-hugtak?orgId=1&refresh=1m&from=1696260161299&to=1696263761299&theme=dark&panelId=2' width='450' height='200' frameborder='0'></iframe>"; 
        print "                </tr>";
        print "</table>";
    }
    
    public function back_call() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";
        
        $this->ShowMe();
       

    }
}

$site = new Sites();

if(isset($_GET['back']))
    $site->back_call();



