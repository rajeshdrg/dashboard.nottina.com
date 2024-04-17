<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Servico/Banco.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Servico/Http.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Servico/Conectividade.php";

class Servico extends modulo {
    
    public $bancos;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Servico";
        $this->sigla = "Serviço";
        $this->icone = "fas fa-hashtag";
        
        $this->bancos=array();
        
        $this->bancos[ 0]= new Banco('sp2.abstract.com.br');
        $this->bancos[ 1]= new Banco('rj2.abstract.com.br');
        $this->bancos[ 2]= new Banco('sv-sql');
        $this->bancos[ 3]= new Banco('sp26.abstract.com.br');
        $this->bancos[ 4]= new Banco('sp27.abstract.com.br');
        $this->bancos[ 5]= new Banco('apache-100');
        $this->bancos[ 6]= new Banco('vsp250.abstract.com.br');
        $this->bancos[ 7]= new Banco('vps246');
        $this->bancos[ 8]= new Banco('sp29.hugtak.com');        
        $this->bancos[ 9]= new Banco('apache-101');
        $this->bancos[ 10]= new Banco('apache-102-app-1');
        $this->bancos[ 11]= new Banco('apache-102-app-2');
        
        
        $this->servicos=array();
        $this->servicos[ 0]= new http('eqabr251.abstract.com.br');
        $this->servicos[ 1]= new Http('kannel51.abstract.com.br');
        $this->servicos[ 2]= new Http('apache-100');
        $this->servicos[ 3]= new Http('sp27.abstract.com.br');
        $this->servicos[ 4]= new Http('apache-101');
        $this->servicos[ 5]= new Http('apache-102-app-1');
        $this->servicos[ 6]= new Http('apache-102-app-2');
        
        $this->connect=array();
        $this->connect[0] = new Conectividade('sp27.abstract.com.br');
        $this->connect[1] = new Conectividade('sp26.abstract.com.br');
        
        
    }
    
    public function get_data() {
        
        $hora = date('G');
        foreach($this->bancos as $b) {
            $b->get_data();
        }
        foreach($this->servicos as $s) {
            $s->get_data();
        }
        foreach($this->connect as $c) {
            $c->get_data();
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
        print "BANCOS";
        print "</header>";
	print "<div class='card-content'>";

	print "<table width=100%>";
	print "<tr>";
	print "<td><b>Hostname</b></td>";
	print "<td><b>Conexão</b></td>";
	print "<td><b>Data</b></td>";
	print "</tr>";

        
	foreach($this->bancos as $banco) {
            $banco->ShowMe();
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



