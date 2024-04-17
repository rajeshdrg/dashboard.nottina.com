<?php

ini_set('default_socket_timeout', 600);

class TWW {
	private $client;
	
	function tww() {
		$this->client = new SoapClient("https://webservices2.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL",array('trace'=>1,'exceptions'=>1,"location"=>"https://webservices2.twwwireless.com.br/reluzcap/wsreluzcap.asmx?WSDL"));
	}

	function send($cod_sms,$celular,$mensagem) {
        	try {
                	$arguments= array(
                        	'NumUsu'=>"abstract",
	                        'Senha'=>'4esT1t%h+X59KzveZ',
        	                'SeuNum'=>$cod_sms,
                	        'Celular'=>$celular,
                        	'Mensagem'=>$mensagem
	                );

			$resultado =  $this->client->EnviaSMS($arguments);
		}
		catch (SoapFault $fault) {
			print $fault->faultstring;
		}
               
		return $resultado;
	}
}
