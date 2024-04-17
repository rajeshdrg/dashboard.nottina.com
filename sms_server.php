<?php 
require_once "/usr/src/sinch/sinch.php";

date_default_timezone_set ("America/Sao_Paulo");
$hora = date('G');

class Painel {
	public $sms;
	public $smscd;
}


class SendSMS {
        public function testesendsms($codigo,$celular,$mensagem) {
            $sinch = new Sinch();

 	    $mensagem = str_replace("/", " ", $mensagem);
 	    $mensagem = str_replace(".", "_", $mensagem);
	
            $this->resultado = $sinch->send($codigo,$celular,$mensagem);
        }
}

function telegram($msg,$telegramchatid) {
        global $telegrambot;
        $url='https://api.telegram.org/bot'.$telegrambot.'/sendMessage';$data=array('chat_id'=>$telegramchatid,'text'=>$msg);
        $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
        $context=stream_context_create($options);
        $result=file_get_contents($url,false,$context);
        return $result;
}

// Set your Bot ID and Chat ID.
$telegrambot='1549324629:AAHR5PKsFJPu2lKtSuauQilfOajGIVM7Qhc';

$t = new SendSMS();

$painel = new Painel();



date_default_timezone_set ("America/Sao_Paulo");
// ---------------------SMS CD -----------------------------
$fAlertaCD='/dados/cap/status/alertacd.xml';
$len = filesize($fAlertaCD);
$arq = fopen($fAlertaCD,"r");
if($arq==null) {
	print "Erro: arquivo xml não encontrado $this->file<br>;";
        exit(0);
}
$xmlstr = fread($arq,$len);
fclose($arq);

$xml= new SimpleXMLElement($xmlstr);
$qtd_alertas =  $xml->quantidade;
//if($qtd_alertas > 32 ) {
//	 $t->testesendsms(1,'5541999576796',' '."SMS CD NOVO ALERTA N-$qtd_alertas");
//	 $t->testesendsms(1,'5561981220266',' '."SMS CD NOVO ALERTA N-$qtd_alertas");
//	 $t->testesendsms(1,'5561998277077',' '."SMS CD NOVO ALERTA");
//}

$painel->smscd = (int) $qtd_alertas;

// ---------------------SMS  -------------------------------
$fAlerta='/dados/cap/status/alerta.xml';
$len = filesize($fAlerta);
$arq = fopen($fAlerta,"r");
if($arq==null) {
	print "Erro: arquivo xml não encontrado $this->file<br>;";
        exit(0);
}
$xmlstr = fread($arq,$len);
fclose($arq);

$xml= new SimpleXMLElement($xmlstr);
$qtd_alertas =  $xml->quantidade;
$painel->sms = (int) $qtd_alertas;


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
//$server[10]='/dados/cap/status/disco_kannel51.xml';
$server[11]='/dados/cap/status/disco_sp27.abstract.com.br.xml';
//$server[12]='/dados/cap/status/disco_vsp250.abstract.com.br.xml';
//$server[13]='/dados/cap/status/disco_vps246.xml';


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

	$memoriapercent = intval($xmlc->memoriausada);
        if($memoriapercent <99) {

	 	    $m_ok = true;
        }
        else {
                    $m_ok = false;
        }


        $d_ok = true;
	foreach($xmlc->capacidade->item as $i) {

		$percentual = intval($i->percentual);
       		if($percentual >85) {
                    $d_ok = false;
		    $SMS.=" ".$xmlc->hostname."  ".$i->pasta."  ".$i->percentual;
                }
#       		if($percentual > 80 || $hora > 8 || $hora < 18 ) {
#                    $d_ok = false;
#		    $SMS.=" ".$xmlc->hostname."  ".$i->pasta."  ".$i->percentual;
#                }
        }


   	$i_ok = true;
        foreach($xmlc->inodes->item as $i) {

                $percentual = intval($i->percentual);
                if($percentual >85) {

                    $i_ok = false;
		    $SMS.=" ".$xmlc->hostname." -> Inodes: ".$i->pasta." = ".$i->percentual;
                }
        }
 

    if ($d_ok==false || $i_ok==false) {

	$t->testesendsms(1,'5561981220266',' '.$SMS);
	$t->testesendsms(1,'5541999576796',' '.$SMS);
	telegram("$SMS","891145665"); //Talamonti
	telegram("$SMS","1107279877");//Carlos
    }
}
    

//Fila Global
$arquivo= "/dados/cap/status/status_sp.xml";
$len = filesize($arquivo);
$atualizacao =  date ( "d/m/Y H:i:s.", filemtime($arquivo));
$arq = fopen($arquivo,"r");
if($arq==null) {
	print "Erro: arquivo xml não encontrado<br>;";
	exit(0);
}

$xmlstr = fread($arq,$len);
fclose($arq);

$xml= new SimpleXMLElement($xmlstr);

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
foreach($smscs->smsc as $smsc) {
    $status = substr($smsc->status,0,strpos($smsc->status," "));
    if(strpos($smsc->id,"all")>0) {
	$id = $smsc->id;
        $fila =$smsc->queued;
        $in = substr($smsc->sms->inbound,0,strpos($smsc->sms->inbound,","));
        $out = substr($smsc->sms->outbound,0,strpos($smsc->sms->outbound,","));
        
        if($fila >=600000 && $out < 15 ) {
            $t->testesendsms(1,'5541999576796',' '."Pre pago:$id Fila:$fila TPS:$out");
            $t->testesendsms(1,'5561981220266',' '."Pre pago:$id Fila:$fila TPS:$out");
	        if($fila >=7000) {
        	    $t->testesendsms(1,'61999515528',' '."Pre pago:$id Fila:$fila TPS:$out");
		}
        }
    }
}



$fp = fopen('/dados/cap/status/painel.json', 'w');
fwrite($fp, json_encode($painel));
fclose($fp);
