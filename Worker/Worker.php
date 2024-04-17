<?php 

$_SERVER["DOCUMENT_ROOT"] = '..';
chdir('/dados/sites/painel.hugtak.com/Worker');
require_once '../xcon/conecta.php';
require_once '../erpme/banco/sqlcommand.php';
require_once '../erpme/banco/sqldatareader.php';

require_once "/usr/src/sinch/sinch.php";

// Set your Bot ID and Chat ID.
$telegrambot='1549324629:AAHR5PKsFJPu2lKtSuauQilfOajGIVM7Qhc';



date_default_timezone_set ("America/Sao_Paulo");


class SendSMS {
        public function testesendsms($codigo,$celular,$mensagem) {
 	    $mensagem = str_replace("/", " ", $mensagem);
 	    $mensagem = str_replace(".", "_", $mensagem);
            $sinch = new Sinch();
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




$Sql = new SqlCommand("Sql");
$Sql->connection = $conexao;
$Sql->query = "select * from modulo where modulo != 'ShowAlerta' ";

$dr = $Sql->ExecuteReader();
while($o=$dr->GetObject()) {
    require_once "../$o->modulo/$o->modulo.php";
    eval("\$m = new $o->modulo();");
    $m->get_data();
}

$Sql->query = "select * from alerta where cod_usuario is null;";
$dr = $Sql->ExecuteReader();

if($dr->HasRows) {
    while($o=$dr->GetObject()) {
        
        $SMS = "$o->descricao $o->valor $o->item";
        
        $t = new SendSMS();
        
        $t->testesendsms(1,'5561981220266',' '.$SMS);
        $t->testesendsms(1,'5541998417308',' '.$SMS);
	$t->testesendsms(1,'5521983690117',' '.$SMS);
	telegram("$SMS","891145665"); //Talamonti
	telegram("$SMS","1107279877");//Carlos
	telegram("$SMS","41998417308");//Renato
    
    }
}

exit(0);
