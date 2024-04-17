<?php
$hora - date('G');
if($hora > 19 || $hora < 6 ) 
	$dark = "dark";
else 
	$dark = "";
$server=array();
$server[ 0]='sp2.abstract.com.br';
$server[ 1]='rj2.abstract.com.br';
$server[ 2]='sv-sql';
$server[ 3]='sp26.abstract.com.br';
$server[ 4]='sp27.abstract.com.br';
$server[ 5]='apache-100';
$server[ 6]='vsp250.abstract.com.br';
$server[ 7]='vps246';
$server[ 8]='sp29.hugtak.com';
//$server[ 9]='sp29-broker.hugtak.com';

$dash= "";
$dash.= "<div class='card  $dark'>";
$dash.= "<header class='card-header'>";
$dash.= "<font color=black>PostgreSQL</font><br>";
$dash.= "</header>";
$dash.= "<div class='card-content'>";

$dash.= "<table>";
$dash.= "<tr>";
$dash.= "<td><b>Serviço</b></td>";
$dash.= "<td><b>Status</b></td>";
$dash.= "<td><b>Data</b></td>";
$dash.= "</tr>";


$html = "";

$d_ok = true;


foreach($server as $s) {

	$sucesso = true;
        $arq = @fopen("/dados/cap/status/banco_$s.j","r");

        if($arq==null) {
		$obj = new \stdClass();
		$obj->connection = "false";
	

        }
	else {
		$j = fgets($arq);

		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			$obj = new \stdClass();
			$obj->connection = "false";
		}

		fclose($arq);
	}


        $html.= "<tr>";
        $html.=  "<td>";
        $html.= "<b>".$obj->hostname."</b>";
        $html.= "</td>";
        $html.= "<td>";
        if($obj->connection=='true') {
	        $html.=  "<td><font color=green>OK $obj->detail </font></td>";
        }
        else {
        	$html.=  "<td><font color=red>NOK</font></td>";
		$d_ok = false;
        }
	$html.= "<td>";
        if($obj->date > 1) {
                $html.=  "<font color=green>$obj->date - OK</font></td>";
        }
        else {
                $html.=  "<font color=green>$obj->date - OK</font></td>";
                #$d_ok = false;
        }
        $html.= "</tr>";
}
$dash.=$html;
$dash.= "</table>";

if(!$d_ok) {
$dash.=  "<audio autoplay>";
        $dash.=  "<source src='/alerta.wav' type='audio/wav'>";
        $dash.=  "</audio>";
}

$dash.= "</div>";
$dash.= "</div>";

print $dash;

include "get_servicos.php";
include "get_conectividade.php";
