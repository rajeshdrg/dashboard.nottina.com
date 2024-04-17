<?php 

require_once '/dados/classes/tww/tww.php';

class SendSMS {
	private $conexao;
	private $cliente;
	private $senha;
	public $resultado;

	public function sendsms($cliente,$senha,$celular,$mensagem) {
		$this->resultado 	= null;
		$cod_cliente 	= null;
		$this->cliente 	= $cliente;
		$this->senha 	= $senha;

		$this->conecta();

		$result = pg_query_params($this->conexao,
			"select cod_cliente from cliente where cliente = $1 and senha = md5('sms'||$2)" , 
			array ($this->cliente,$this->senha ));
		
		if($result) {
			$linhas = pg_num_rows($result);
			if($linhas > 0 ) {
				$cod_cliente = pg_fetch_result($result,0,0);
				$result2 = pg_query_params($this->conexao,
					'insert into sms (cod_cliente,celular,mensagem) values ($1,$2,$3)',
					array($cod_cliente,$celular,$mensagem));
				if($result2) {
					$result3 = pg_query($this->conexao,"select currval('sms_cod_sms_seq')");
					$cod_sms = pg_fetch_result($result3,0,0);
					pg_free_result($result2);
					pg_free_result($result3);
					$tww = new TWW();
					$this->resultado = $tww->send($cod_sms,$celular,$mensagem); 
				}
			}
		}
		pg_free_result($result);
	}

	private function conecta() {

		$this->conexao= pg_connect("host=localhost port=5432  dbname=sms user=ideiavox password=ideiavox@1500");
		if(! $this->conexao) {
		        die("Não pode conectar ao banco de dados.");
		}
		$sqlset = "set DATESTYLE to European,European;";
		pg_query($this->conexao,$sqlset);

	}

}
