<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/VPNGlobal/VPNGlobal.php";

class VPNGlobal extends modulo {
    
    public $vpns;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "VPNGlobal";
        $this->sigla = "VPN Global";
        $this->icone = "fas fa-hashtag";
        
        $this->vpns=array();
        $this->vpns[ 0]= new Banco('sp_o4.hugtak.com');
        $this->vpns[ 1]= new Banco('rj_o4.hugtak.com');
        $this->vpns[ 2]= new Banco('bsb_o4.hugtak.com');
    }
    
    public function get_data() {
        
        $hora = date('G');
        foreach($this->vpns as $b) {
            $b->get_data();
        }
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
        
        print  "<div class='card $dark'>";
	print "<header class=r'card-header'>";
        print "VPNs";
        print "</header>";
	print "<div class='card-content'>";

	print "<table width=100%>";
	print "<tr>";
	print "<td><b>Cliente</b></td>";
	print "<td><b>WAN/Subnet</b></td>";
	print "<td><b>Status</b></td>";
	print "</tr>";

        
	foreach($this->vpns as $vpn) {
            $vpn->ShowMe();
        }
        print "</table>";
        print "</div>";
        print "</div>";
        
        
        //HTTP
        
        print  "<div class='card $dark'>";
	print "<header class=r'card-header'>";
        print "HTTP";
        print "</header>";
	print "<div class='card-content'>";

	print "<table width=100%>";
	print "<tr>";
	print "<td><b>Hostname</b></td>";
	print "<td><b>Conexão</b></td>";
	print "<td><b>Data</b></td>";
	print "</tr>";

        
	foreach($this->servicos as $serv) {
            $serv->ShowMe();
        }
        print "</table>";
        print "</div>";
        print "</div>";
        
        
        //Connect
        
        print  "<div class='card $dark'>";
	print "<header class=r'card-header'>";
        print "Conectividade";
        print "</header>";
	print "<div class='card-content'>";

	print "<table width=100%>";
	print "<tr>";
	print "<td><b>Hostname</b></td>";
	print "<td><b>Conexão</b></td>";
	print "<td><b>Data</b></td>";
	print "</tr>";

        
	foreach($this->connect as $con) {
            $con->ShowMe();
        }
        print "</table>";
        print "</div>";
        print "</div>";
        
        
        
        
    }
    
    public function back_call() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 ) 
            $dark = "dark";
        else 
        	$dark = "";

        $this->get_data();
        $this->ShowMe();

    }
}

$ser = new Servico();

if(isset($_GET['back']))
    $ser->back_call();



