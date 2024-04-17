<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/ui/dropdownlist.php";

class operadora {
	public $name;
        public $DropDownList;
	
	public function operadora($name,$connection) {
            
            $sql = new SqlCommand("$name"."_sql");
            $sql->connection= $connection;
            $sql->query="select cod_operadora,operadora from operadora order by operadora";

            $this->DropDownList = new DropDownList($name);
            $this->DropDownList->SqlCommand = $sql;
            $this->DropDownList->bind();
            $this->DropDownList->Value = "cod_operadora";
            $this->DropDownList->Text  = "operadora";
            $this->DropDownList->size  = 1;
            $this->DropDownList->itens  = array(0 => "Todas Operadoras");
	}
	
	public function ShowMe()
        {
            $this->DropDownList->ShowMe();
        } 
    
    	public function __invoke()
        {
            $this->ShowMe();
        }
   
	public function Set($value)
        {
            $this->DropDownList->Set($value);
        }
};
?>