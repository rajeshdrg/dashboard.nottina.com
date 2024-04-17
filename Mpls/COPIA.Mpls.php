<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class Mpls extends modulo {

    public $xmlc;
    
    public function __construct() {
        
        
        parent::__construct();
        
        
        
        $this->name  = "Mpls";
        $this->sigla = "MPLS";
        $this->icone = "fab fa-mixcloud";
        
        
    }
    
    public function get_data() {
        
        $hora = date('G');
        
        $s = "/dados/cap/status/mpls_zabbix.abrtelecom.com.br.xml";


	$len = filesize($s);
	$arq = fopen($s,"r");
	if($arq==null) {
		print "Erro: arquivo xml não encontrado<br>;";
		exit(0);
	}

	$xmlstr = fread($arq,$len);
	fclose($arq);
        
        

	$this->xmlc= new SimpleXMLElement($xmlstr);   
        
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
        
        print "MPLS";
        print "<div class='xcard $dark'>";
        print "    <div >";
        print "        <header class=r'card-header'>";
        print "            <font color=blank>Circuitos testados em ".$this->xmlc->atualizacao."</font><br><br>";
        print "        </header>";
        print "        <div class='card-content'>";
        print "            <table width=100%>";
        print "                <tr>";
        print "                     <td><b>Empresa</b></td>";
        print "                     <td><b>Circuito</b></td>";
        print "                     <td><b>WAN</b></td>";
        print "                     <td><b>Status</b></td>";
        print "                     </tr>";
        

        foreach($this->xmlc->circuito as $i) {
		print "<tr>";
                print "<td>$i->empresa</td>";
                print "<td>$i->designacao</td>";
                print "<td>$i->wan</td>";
                print "<td>";
                if($i->status=="OK")
       			print  "<font color=green><b>".$i->status."</b></font>";
                else{
			if(preg_match('(BRE/IP/01451|SPO/IP/43603)', $i->designacao) === 1) { 
       		 		print  "<font color=green><b>Nao Monitorado</b></font>";
			}
                        else {
                            print  "<font color=red><b>NOK</b></font>";
			}
		}
                print "</td>";
		print "</tr>\n";
        }
        print "</table>";
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

$mpl = new Mpls();

if(isset($_GET['back']))
    $mpl->back_call();



