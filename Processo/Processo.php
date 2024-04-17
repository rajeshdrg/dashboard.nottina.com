<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/Processo/Proc.php";

class Processo extends modulo {
    
    public $bancos;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Processo";
        $this->sigla = "Processo";
        $this->icone = "fas fa-hashtag";
        
        $this->procs=array();
        
        $this->procs[ 0]= new Proc('sp2.abstract.com.br','python','/dados/wspre/fila_classe1.py');
        $this->procs[ 1]= new Proc('sp2.abstract.com.br','bearerbox','/kannel/smskannel.conf');
        $this->procs[ 2]= new Proc('sp2.abstract.com.br','smsbox','/kannel/smskannel.conf');
        $this->procs[ 3]= new Proc('sp2.abstract.com.br','smsbox','/kannel/sms_all.conf');
        $this->procs[ 1]= new Proc('rj2.abstract.com.br','bearerbox','/kannel/smskannel.conf');
        $this->procs[ 2]= new Proc('rj2.abstract.com.br','smsbox','/kannel/smskannel.conf');
        $this->procs[ 3]= new Proc('rj2.abstract.com.br','smsbox','/kannel/sms_all.conf');
#        $this->procs[ 4]= new Proc('sp2.abstract.com.br','python','parse_sftp.py');
        
    }
    
    public function get_data() {
        
        $hora = date('G');
        foreach($this->procs as $b) {
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
        
        print  "<div class='$dark'>";
	print "<header class=r'header'>";
        print "Processos";
        print "</header>";
	print "<div class='full-content $dark'>";

	print "<table width=100%>";
	print "<tr>";
	print "<td><b>Hostname</b></td>";
	print "<td><b>Processo</b></td>";
	print "<td><b>CMD</b></td>";
	print "<td><b>Status</b></td>";
	print "<td><b>Data</b></td>";
	print "</tr>";

        
	foreach($this->procs as $proc) {
            $proc->ShowMe();
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

$processo = new Processo();

if(isset($_GET['back']))
    $processo->back_call();



