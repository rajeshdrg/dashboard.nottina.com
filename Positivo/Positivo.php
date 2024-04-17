<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";

class Positivo extends modulo {
    
    public $data;
    public $data_file;
    public $operadora;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "Positivo";
        $this->sigla = "SMS Inteligente";
        $this->icone = "fas fa-user-plus";
        
        $this->operadora[312] = "Algar";
        $this->operadora[315] = "Vivo";
        $this->operadora[321] = "Claro";
        $this->operadora[331] = "Oi";
        $this->operadora[341] = "TIM";
        $this->operadora[343] = "Sercomtel";
    }
    
    
    public function front_call() {
        
         parent::front_call();

    }
    
    
    public function get_data() {
        
        $hora = date('G');
        
        if (($handle = fopen("/dados/cap/status/positivo/positivo.csv", "r")) !== FALSE) {
            while (($this->data[] = fgetcsv($handle, 1000, ",")) !== FALSE) {
            }
            fclose($handle);
        }
        else 
            print "Não foi possível abrir o arquivo";

        
        if (($handle = fopen("/dados/cap/status/positivo/positivo_files.csv", "r")) !== FALSE) {
            while (($this->data_file[] = fgetcsv($handle, 1000, ",")) !== FALSE) {
            }
            fclose($handle);
        }
        else 
            print "Não foi possível abrir o arquivo";
        
        
        
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
       print "<header class=r'card-header'>SMS Inteligente<br></header>";
       print "<div class='card-content'>";
       print "<table width='100%' border=0 cellspacing=0 >\n";
        print "<tr style='background-color:#006699;color:white'>";
       print "<td>Arquivo</td>";
       print "<td>Timestamp</td>";
       print "<td>Volume</td>";
       print "<td>Fila Broker</td>";
       print "<td>Operadora</td>";
       print "<td>Delivery Report</td>";
       print "<td>Retorno</td>";
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
       foreach($this->data_file as $d) { 
           if($d!=null) {
               if(substr($d[1],0,10)==date('Y-m-d')) {
                    print "<tr style='background-color:$b1';>";
               }
               else {
                    print "<tr style='background-color:$b2';>";
               }
            print "<td>".$d[0]."</td>\n";
            print "<td>".substr($d[1],0,16)."</td>\n";
            print "<td>".number_format($d[3],0,",",".")."</td>\n";
            print "<td>".number_format($d[4],0,",",".")." (".number_format(($d[4]/$d[3])*100,1,",",".")."%) </td>\n";
            print "<td>".number_format($d[5],0,",",".")." (".number_format(($d[5]/$d[3])*100,1)."%) </td>\n";
            print "<td>".number_format($d[6],0,",",".")." (".number_format(($d[6]/$d[5])*100,1)."%) </td>\n";
	    if( ($d[7]/$d[3])*100 < 100)
		    print "<td><font color=red>".number_format($d[7],0,",",".")." (".number_format(($d[7]/$d[3])*100,1)."%)</font> </td>\n";
	    else
            print "<td>".number_format($d[7],0,",",".")." (".number_format(($d[7]/$d[3])*100,1)."%) </td>\n";
            print "</tr>\n";
            
            $volume+=$d[3];
            $gateway+=$d[4];
            $operadora+=$d[5];
            $dlr+=$d[6];
            $retorno+=$d[7];
            $arquivos++;
            
           }
       }
       
            print "<tr style='background-color:#cceeff';>";
            print "<td><b>Total</b></td>\n";
            print "<td><b>".$arquivos." arquivos</b></td>\n";
            print "<td><b>".number_format($volume,0,",",".")."</b></td>\n";
            print "<td><b>".number_format($gateway,0,",",".")." (".number_format(($gateway/$volume)*100,1,",",".")."%) </b></td>\n";
            print "<td><b>".number_format($operadora,0,",",".")." (".number_format(($operadora/$volume)*100,1)."%) </b></td>\n";
            print "<td><b>".number_format($dlr,0,",",".")." (".number_format(($dlr/$operadora)*100,1)."%) </b></td>\n";
            print "<td><b>".number_format($retorno,0,",",".")." (".number_format(($retorno/$volume)*100,1)."%) </b></td>\n";
            print "</tr>\n";
       
       
       print "</table>\n";
       print "</div>\n";
       print "</div>\n";
        

       //files
       
       $volume      = 0;
       $gateway     = 0;
       $operadora   = 0;
       $dlr         = 0;
       $retorno     = 0;
       $arquivos    = 0;
       $cor['Hoje']     = '#b3e6ff';
       $cor['Global']   = '#cceeff';
       
       print  "<div class='card $dark' style='width:90%;height:auto'>";
       print "<header class=r'card-header'>SMS Inteligente<br></header>";
       print "<div class='card-content'>";
       print "<table width='100%' border=0  cellspacing=0 >\n";
       print "<tr style='background-color:#006699;color:white'>";
       print "<td>Operadora</td>";
       print "<td>Volume</td>";
       print "<td>Fila Broker</td>";
       print "<td>Operadora</td>";
       print "<td>Delivery Report</td>";
       print "<td>Retorno</td>";
       print "</tr>";
       foreach($this->data as $d) { 
           if($d!=null) {
            print "<tr style='background-color:".$cor[$d[6]].";'>";
            print "<td>".$this->operadora[intval($d[0])]."</td>\n";
            print "<td>".number_format($d[1],0,",",".")."</td>\n";
            print "<td>".number_format($d[2],0,",",".")." (".number_format(($d[2]/$d[1])*100,1,",",".")."%) </td>\n";
            print "<td>".number_format($d[3],0,",",".")." (".number_format(($d[3]/$d[1])*100,1)."%) </td>\n";
            print "<td>".number_format($d[4],0,",",".")." (".number_format(($d[4]/$d[3])*100,1)."%) </td>\n";
            print "<td>".number_format($d[5],0,",",".")." (".number_format(($d[5]/$d[1])*100,1)."%) </td>\n";
            print "</tr>\n";
            if($d[6] != 'Hoje') {
            
                $volume+=$d[1];
                $gateway+=$d[2];
                $operadora+=$d[3];
                $dlr+=$d[4];
                $retorno+=$d[5];
            }
            
           }
       }
       
            print "<tr style='background-color:#cceeff';>";
            print "<td><b>Total</b></td>\n";
            print "<td><b>".number_format($volume,0,",",".")."</b></td>\n";
            print "<td><b>".number_format($gateway,0,",",".")." (".number_format(($gateway/$volume)*100,1,",",".")."%) </b></td>\n";
            print "<td><b>".number_format($operadora,0,",",".")." (".number_format(($operadora/$volume)*100,1)."%) </b></td>\n";
            print "<td><b>".number_format($dlr,0,",",".")." (".number_format(($dlr/$operadora)*100,1)."%) </b></td>\n";
            print "<td><b>".number_format($retorno,0,",",".")." (".number_format(($retorno/$volume)*100,1)."%) </b></td>\n";
            print "</tr>\n";
       
       
       print "</table>\n";
       print "</div>\n";
       print "</div>\n";
       
       
    }
  
    public function back_call() {
        
       $this->get_data();

    }
}

$pos = new Positivo();

if(isset($_GET['back'])) {
    $pos->back_call();
    $pos->ShowMe();
}



