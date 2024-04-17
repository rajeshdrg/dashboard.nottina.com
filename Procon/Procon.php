<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";

class Procon extends modulo {
    
    public $data;
    public $data_file;
    public $operadora;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Procon";
        $this->sigla = "Procon";
        $this->icone = "fa fa-volume-control-phone";

    }
    
    
    public function front_call() {
        
         parent::front_call();

    }
    
    
    public function get_data() {
        
        $hora = date('G');
        
        $jfile= file_get_contents("/dados/cap/status/procon.json");
        
        $this->data = json_decode($jfile);
        
    }
    
    public function ShowMe() {
    $hora = date('G');
	if($hora > 19 || $hora < 6 )
        	$dark = "dark";
	else
        	$dark = "";

       $volume      = 0;
       $gateway     = 0;
       $operadora   = 0;
       $dlr         = 0;
       $retorno     = 0;
       $arquivos    = 0;
       
       print  "<div class='card $dark' style='width:90%;height:auto'>";
       print "<header class=r'card-header'>PROCON<br></header>";
       print "<div class='card-content'>";
       print "<table width='100%' border=0 cellspacing=0 >\n";
       print "<tr style='background-color:#006699;color:white'>";
       print "<td>Origem</td>";
       print "<td>Volume</td>";
       print "</tr>";
       print "<tr><td>$dark</td></tr>";
	

       if(strlen($dark)>1) {
	       $b1 = "black";
	       $b2 = "#2f2f2f";
       }
       else {
	       $b1 = "#b3e6ff";
	       $b2 = "#cceeff";
       }

       foreach ($this->data as $origem) {
            print "<tr><td>$origem->origem</td><td>$origem->qtd</td></tr>";
          
       }
       print "</table>";
       print "</div>\n";
       print "</div>\n";
       
       
    }
  
    public function back_call() {
        
       $this->get_data();

    }
}

$procon = new Procon();

if(isset($_GET['back'])) {
    $procon->back_call();
    $procon->ShowMe();
}



