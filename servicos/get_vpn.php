<?php
$hora - date('G');
if($hora > 19 || $hora < 6 ) 
	$dark = "dark";
else 
	$dark = "";
$server=array();
$server[ 0]='sp_o4.hugtak.com';

$dash= "";
$dash.= "<div class='card $dark' style='width:auto;height:auto'>";
$dash.= "<header class=r'card-header'>";
$dash.= "<font color=white>VPN</font><br>";
$dash.= "</header>";
$dash.= "<div class='card-content'>";

$dash.= "<table width=100%>";
$dash.= "<tr>";
$dash.= "<td><b>CLIENTE</b></td>";
$dash.= "<td><b>ADDR</b></td>";
$dash.= "<td><b>INFO</b></td>";
$dash.= "<td><b>STATUS</b></td>";
$dash.= "<td><b>DATA</b></td>";
$dash.= "</tr>";


$html = "";

$d_ok = true;


foreach($server as $s) {

	$sucesso = true;
        $arq = @fopen("/dados/cap/status/vpn$s.j","r");
	
        if($arq==null) {
		$obj = new \stdClass();
		$obj->connection = "false";
        }
	else {
	    while(!feof($arq))
            {
		$j = fgets($arq);

		$obj=json_decode($j);
		if(json_last_error()!=JSON_ERROR_NONE) {
			$obj = new \stdClass();
			$obj->connection = "false";
		}
 	$html.= "<tr>";
        $html.=  "<td>";
        $html.= "<b>".$obj->cliente."</b>";
        $html.= "</td>";
        $html.=  "<td>";
        $html.= "<b>".$obj->peer."</b>";
        $html.= "</td>";
	$html.=  "<td>";
        $html.= "<b>Up:".$obj->tempo."h in:".$obj->pktin." out:".$obj->pktout."</b>";
        $html.= "</td>";	
        $html.= "<td>";
        if($obj->status=='OK') {
                $html.=  "<font color=green>OK";
        }
        else {
                $html.=  "<font color=red>NOK";
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
		fclose($arq);
	}
}
$dash.=$html;
$dash.= "</table>";

$dash.= "</div>";
$dash.= "</div>";

print $dash;
