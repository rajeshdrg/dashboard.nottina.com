<?php

class SqlDataReader {
	public $name;
	public $Result;
	public $Rows;
	public $HasRows;
	
	function SqlDataReader() {
		$this->HasRows = false;
	}
	function SetResult($Result) {
			if($Result) {
			if(pg_num_rows($Result)> 0) {
				$this->Rows = pg_num_rows($Result);
				$this->HasRows = true;
				$this->Result = $Result;
			}
		}
	}
	function GetObject() {
		if($this->HasRows==false) return null;
		return pg_fetch_object($this->Result);
		
	}
};
?>