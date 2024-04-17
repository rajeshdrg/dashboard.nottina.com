<?php 

require_once '/dados/classes/tww/tww_adn.php';

class SendSMS {
	public $resultado;

	public function sendsms($cod_sms,$celular,$mensagem) {

		$tww = new TWW();
		$this->resultado = $tww->send($cod_sms,$celular,$mensagem); 
	}
}


