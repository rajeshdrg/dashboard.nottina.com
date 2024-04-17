<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/ui/dropdownlist.php";

class DropDownUf {
	public $name;
        public $DropDownList;
	
	public function DropDownUf($name,$connection) {
            
            $sql = new SqlCommand("$name"."_sql");
            $sql->connection= $connection;
            $sql->query="select uf from uf order by uf";

            $this->DropDownList = new DropDownList($name);
            $this->DropDownList->SqlCommand = $sql;
            $this->DropDownList->bind();
            $this->DropDownList->Value = "uf";
            $this->DropDownList->Text  = "uf";
            $this->DropDownList->size  = 1;
            $this->DropDownList->itens  = array(0 => "Selecione a UF");
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