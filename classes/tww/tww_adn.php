<?php

ini_set('default_socket_timeout', 600);

class TWW {
	private $client;
	
		//$this->client = new SoapClient("https://webservices.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL",array('trace'=>1,'exceptions'=>1,"location"=>"https://webservices.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL"));
	function tww() {
		$this->client = new SoapClient("https://webservices2.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL",array('trace'=>1,'exceptions'=>1,"location"=>"https://webservices2.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL"));
	}

	function send($cod_sms,$celular,$mensagem) {
        	try {

                	$arguments= array(
                        	'NumUsu'=>"ADNSAUDE",
	                        'Senha'=>'ADN@2500',
        	                'SeuNum'=>$cod_sms,
                	        'Celular'=>$celular,
                        	'Mensagem'=>$mensagem
	                );

			$resultado =  $this->client->EnviaSMS($arguments);


			error_log(print_r($arguments,1));
			error_log(print_r($resultado,1));


		}
		catch (SoapFault $fault) {
			return($fault->faultstring);
		}
               
		return $resultado;
	}
}
