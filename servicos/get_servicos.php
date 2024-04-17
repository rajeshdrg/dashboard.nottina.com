<?php
$hora - date('G');
if($hora > 19 || $hora < 6 ) 
	$dark = "dark";
else 
	$dark = "";
$server=array();
$server[ 0]='eqabr251.abstract.com.br';
$server[ 1]='kannel51.abstract.com.br';
$server[ 2]='apache-100';
$server[ 3]='sp27.abstract.com.br';

$dash= "";
$dash.= "<div class='card  $dark'>";
$dash.= "<header class=r'card-header'>";
$dash.= "<font color=black>APACHE</font><br>";
$dash.= "</header>";
$dash.= "<div class='card-content'>";

$dash.= "<table width=100%>";
$dash.= "<tr>";
$dash.= "<td><b>Servidor</b></td>";
$dash.= "<td><b>Apache Running</b></td>";
$dash.= "<td><b>Conexões</b></td>";
$dash.= "<td><b>Data</b></td>";
$dash.= "</tr>";


$html = "";

$d_ok = true;

foreach($server as $s) {

	$sucesso = true;
        $arq = @fopen("/dados/cap/status/apache_$s.j","r");
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
        $html.= "<b>".$s."</b>";
        $html.= "</td>";
        $html.= "<td>";
        if($obj->apache=='true') {
                $html.=  "<font color=green>OK";
        }
        else {
                $html.=  "<font color=red>NOK";
                $d_ok = false;
        }
        $html.= "</font>";
        $html.= "</td>";
	
	$html.= "<td>";
        if($obj->connection < 100) {
                $html.=  "<font color=green>$obj->connection - OK";
        }
        else {
                $html.=  "<font color=red>$obj->connection - NOK";
                $d_ok = false;
        }
        $html.= "</font>";
        $html.= "</td>";
       
	$html.= "<td>";
        if($obj->date > 1) {
                $html.=  "<font color=green>$obj->date - OK";
        }
        else {
                $html.=  "<font color=red>$obj->date - NOK";
                $d_ok = false;
        }
        $html.= "</font>";
        $html.= "</td>"; 
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
