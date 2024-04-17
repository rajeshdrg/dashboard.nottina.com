<?php 
date_default_timezone_set ("America/Sao_Paulo");
$operadora=array();
$operadora['0341']='TIM';
$operadora['0315']='Vivo';
$operadora['0343']='Sercomtel';
$operadora['0312']='Algar';
$operadora['0321']='Claro';
$operadora['0351']='Nextel';
$operadora['0331']='Oi';
$operadora['0377']='Nextel I';


$gateway[0] = 'Rio de Janeiro';
$gateway[1] = 'São Paulo';

$arquivo[0] = "/dados/cap/status/status_rj.xml";
$arquivo[1] = "/dados/cap/status/status_sp.xml";



$cod=0;

$cth_cor = 'green';
if($cod==1) {
	$len = filesize('/dados/cap/status/sp_certificado_cleartech.xml');
	$arq = fopen('/dados/cap/status/sp_certificado_cleartech.xml',"r");
}
else {
	$len = filesize('/dados/cap/status/rj_certificado_cleartech.xml');
	$arq = fopen('/dados/cap/status/rj_certificado_cleartech.xml',"r");
}
	if($arq!=null) {
		$xmlstr = fread($arq,$len);
		fclose($arq);
		$xml= new SimpleXMLElement($xmlstr);
		$data =  $xml->data;
		$ano = substr($xml->data,4,4);
		$mes = substr($xml->data,2,2);
		$dia = substr($xml->data,0,2);
		$hora = substr($xml->data,9,2);
		$minuto = substr($xml->data,11,2);

		$d1 =  new DateTime();
		$d2 =  new DateTime("$ano-$mes-$dia $hora:$minuto");
		print "$ano-$mes-$dia $hora:$minuto";
		$interval = $d1->diff($d2);
		print_r($d1);
		print_r($d2);
		print_r($interval);

		if($interval->y + $interval->m + $interval->h > 0) {
			$cth_cor = 'red';
		}
		else {
			if($interval->i>10) 
				$cth_cor = 'red';
			else
				$cth_cor = 'green';
		}

		
	}
else {
				$cth_cor = 'red';
}


$len = filesize($arquivo[$cod]);
$atualizacao =  date ( "d/m/Y H:i:s.", filemtime($arquivo[$cod]));
$arq = fopen($arquivo[$cod],"r");

if($arq==null) {
	print "Erro: arquivo xml não encontrado<br>;";
	exit(0);
}

$xmlstr = fread($arq,$len);

fclose($arq);

$xml= new SimpleXMLElement($xmlstr);
//$xml=simplexml_load_file("status.xml");

$status =  $xml->status;
if(strpos($xml->status,"running")===false) {
	$status = "Gateway parado";
        $status_class = ' is-danger ';
}
else {
	
	$status = "Gateway executando";
        $status_class = '';
}

$smscs = $xml->smscs;



//print_r($xml);
?>
    <div class="card">
         <header class="card-header">
   <h1>GLOBAL</h1> 
      <div class="card-footer-item notification  <?php print $status_class; ?>">
	<?php 
	print $gateway[$cod];
	print ' - ';
        print $status;
	 ?>
	<br><br>
	Atualização:
	<?php print "$dia/$mes/$ano $hora:$minuto"; ?><br>
	<font color=<?php print $cth_cor; ?>><b>Cleartech - webserver</b></font>
      </div>
   
   
  </header>
  <div class="card-content">
    <p >
<?php  print "Atualização: $atualizacao";
	?>
<br>
    </p>
    <?php 
    foreach($smscs->smsc as $smsc) {
        $status = substr($smsc->status,0,strpos($smsc->status," "));

	if(strpos($smsc->id,"all")>0) {
        print "<p>";

        if($status == "online") 
            print  "<span style='display:inline-block; width:90px;'><font color=green>";
	else 
            print  "<span style='display:inline-block; width:90px;'><font color=red>";
        print "<b>".$operadora[substr($smsc->id,1,4)]."</b></span>";
        print "</font>";

        print "<b>Fila</b> $smsc->queued";
        $in = substr($smsc->sms->inbound,0,strpos($smsc->sms->inbound,","));
        $out = substr($smsc->sms->outbound,0,strpos($smsc->sms->outbound,","));
        print "<b>TPS</b><font color=green> $in <i class='far fa-arrow-alt-circle-down'></i></font>";
        print "<font color=blue>  $out <i class='far fa-arrow-alt-circle-up'></i></font>";
        print "</p>";
}
    }
    ?>
  </div>
  </div>


