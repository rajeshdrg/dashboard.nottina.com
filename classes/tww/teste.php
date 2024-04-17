<?php 

require_once '/dados/classes/tww/tww_abs.php';
#require_once '/dados/classes/tww/tww.php';

class SendSMS {

	public function testesendsms($codigo,$celular,$mensagem) {
            $tww = new TWW();
            $this->resultado = $tww->send($codigo,$celular,$mensagem); 

	    print_r($this->resultado);
	
	}


}

$t = new SendSMS();
$t->testesendsms(1,'21983690117','NMP - Teste TWW');
$t->testesendsms(1,'61981220266','NMP - Teste TWW');
