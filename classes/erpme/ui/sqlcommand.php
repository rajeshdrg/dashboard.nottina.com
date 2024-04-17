<?php


class SqlCommand {
	public $name;
	public $query;
	public $connection;
	public $params;
	public $exception;
	public function textbox($nome) {
		$this->name = $nome;
		
		$this->params = NULL;
		
	}	   
	public function ExecuteReader() {
		
		if($this->params!=NULL) {
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
	public function Execute() {
		
		if($this->params!=NULL) {
			$Result = pg_query_params($this->connection,$this->query, $this->params);
		}
		else {
			$Result = pg_query($this->connection,$this->query);
		}
		if($Result==false) {	
			$this->exception = 	pg_last_error();
			print "Query:$this->query<br>";
			print "Exceção:$this->exception<br>";
		}
		
		return $Result;
	}
	
	
	
};
?>