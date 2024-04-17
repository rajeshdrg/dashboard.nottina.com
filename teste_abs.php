<?php 
require_once '/dados/classes/tww/tww_abs.php';
class SendSMS {
	public function testesendsms($codigo,$celular,$mensagem) {
            $tww = new TWW();
            $this->resultado = $tww->send($codigo,$celular,$mensagem); 
	}
}
$t = new SendSMS();
$t->testesendsms(1,'61983690117','PAINEL - Teste ALERTA ');
$t->testesendsms(1,'61981220266','PAINEL - Teste ALERTA ');
$t->testesendsms(1,'351934901541','PAINEL - Teste ALERTA ');
print_r($t);
