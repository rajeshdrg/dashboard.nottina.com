<?php 
date_default_timezone_set ("America/Sao_Paulo");
$server=array();
$server[ 0]='/dados/cap/status/disco_rj1.xml';
$server[ 1]='/dados/cap/status/disco_rj2.xml';
$server[ 2]='/dados/cap/status/disco_sp1.xml';
$server[ 3]='/dados/cap/status/disco_sp2.xml';
$server[ 4]='/dados/cap/status/disco_sv_site.xml';
$server[ 5]='/dados/cap/status/disco_sv_banco.xml';
$server[ 6]='/dados/cap/status/disco_sv_mail.xml';
$server[ 7]='/dados/cap/status/disco_sv-sql.xml';
$server[ 8]='/dados/cap/status/disco_sp26.xml';
$server[ 9]='/dados/cap/status/disco_sp25.xml';
$server[10]='/dados/cap/status/disco_kannel51.xml';
$server[11]='/dados/cap/status/disco_sp27.abstract.com.br.xml';
$server[12]='/dados/cap/status/disco_vsp250.abstract.com.br.xml';
$server[13]='/dados/cap/status/disco_vps246.xml';

$dash= "";
$dash.= "<table width=100%>";
$dash.= "<tr>";
$dash.= "<td><b>Servidor</b></td>";
$dash.= "<td><b>Status</b></td>";
$dash.= "</tr>";

$html = "{ \"data\": [ ";
$table = "";

$count = 0;
foreach($server as $s) {
	$len = filesize($s);
	$arq = fopen($s,"r");
	if($arq==null) {
		print "Erro: arquivo xml não encontrado<br>;";
		exit(0);
	}

	$xmlstr = fread($arq,$len);
	fclose($arq);

	$xmlc= new SimpleXMLElement($xmlstr);
	#var_dump($xmlc);
	$count++;
        $html.= "{
		\"id\": \"$count\",
      		\"contrato\": \"CTR.ABR.2019/00089\",
      		\"servico\": \"$xmlc->hostname\",
      		\"servidor\": \"$xmlc->hostname\",
      		\"status\": \"OK\",
      		\"data\": \"$xmlc->atualizacao\",
      		\"detail\": \"http://hugtak.com/doc1.txt\" },
	";
}
        $html.= "{
		\"id\": \"$count\",
      		\"contrato\": \"CTR.ABR.2019/00089\",
      		\"servico\": \"TESTE\",
      		\"servidor\": \"TESTE\",
      		\"status\": \"NOK\",
      		\"data\": \"TESTE\",
      		\"detail\": \"http://hugtak.com/doc1.txt\" }
	";
$html .= "] }";
print $html;
