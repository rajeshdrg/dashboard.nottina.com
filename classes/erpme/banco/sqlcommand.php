<?php


class SqlCommand {
	public $name;
	public $query;
	public $connection;
	public $params;
	public $exception;
	public $types;
	public $error;
	public $AffectedRows;
	public function SqlCommand($nome) {
		$this->name = $nome;
		
		$this->params = NULL;
		$this->error  = NULL;
		$this->AffectedRows  = NULL;
		
	}	   
	public function ExecuteReader() {
	
		if($this->params!=NULL) {
   			if($this->types!=NULL) {
   				foreach($this->params as $k =>$v ) {
	   				if(isset($this->types[$k]) == 'n') {
	   					if($this->types[$k] == 'n') {
	   						$this->params[$k] = str_replace(',', '.', str_replace('.', '', $v));
	   					}
	   					if(empty($this->params[$k]))
	   					 $this->params[$k]=NULL;
   					}
   				}
   			}
			$Result = pg_query_params($this->connection,$this->query, $this->params);
			

		}
		else {
			$Result = pg_query($this->connection,$this->query);
			if($Result==0) {
			//print $this->query;
			}
		}
			
		$this->exception = 	pg_last_error();
		
		$SqlResult = new SqlDataReader();
		$SqlResult->SetResult($Result);
		
		return $SqlResult;
	}
	
	public function DateDBBR($date) {
		if($date==null) 
				return NULL;
	
		if(strlen($date)!=10 )
			return(NULL);
		
		
		list($y, $m, $d) = preg_split('/-/', $date);
		
		return(sprintf('%02d/%02d/%4d', $d, $m, $y));
	}


	public function NumeroDB($numero) {
		if($numero==null) 
				return NULL;
		if(empty($numero))
			return NULL;

		return strtr ( $numero , "," , "." );
	}
	public function NumeroDBBR($numero) {
		if($numero==null) 
				return NULL;

		return strtr ( $numero , "." , "," );
	}


	public function DateDB($date) {
		if($date==NULL) 
				return NULL;

	
		if(strlen($date)!=10 )
			return(NULL);
		
		
		list($d, $m, $y) = preg_split('/\//', $date);
		
		return(sprintf('\'%4d%02d%02d\'', $y, $m, $d));
	}
	
	public function NullDB($valor) {
	
			if($valor==null) 
				return NULL;

			if(strlen($valor)==0 )
				return NULL;
			else
				return $valor;

	}
	public function Execute() {
		
		if($this->params!=NULL) {
   			if($this->types!=NULL) {
   				foreach($this->params as $k =>$v ) {
	   				if(isset($this->types[$k])) {
	   					if(empty($v))
	   						$this->params[$k] = NULL;
	   					else {
		   					if($this->types[$k] == 'n') {
		   						$this->params[$k] = str_replace(',', '.', str_replace('.', '', $v));
		   					}
	   					}
   					}
   				}
   			}
   			
   			 $var = print_r($this->params, true);
   			 // error_log("Importando arquivo $var", 0);

		
			$Result = pg_query_params($this->connection,$this->query, $this->params);
		}
		else {
			$Result = pg_query($this->connection,$this->query);
		}
		if($Result==false) 	
			$this->exception = 	pg_last_error();

		if($Result==false and $this->error == NULL) {	
			print "<font color=red>Ocorreu um erro de sistema ao tentar salvar no banco de dados.<hr></font>";
			
			print "<b>Nossa equipe de suporte técnico já foi acionada para tratar do assunto<br><br>";
			error_log("SIXVOX BD 1 :$this->query<br><br>",0);
			error_log("SIXVOX BD 2 :$this->exception<br><br>",0);
			
			$p = print_r($this->params,true);
			error_log("SIXVOX BD 3 :$p",0);
			
			exit(0);
		}
		$this->AffectedRows  = pg_affected_rows ( $Result );
		return $Result;
	}
	
	
	
};
?>
