<?php

class Administradora {
    public $cod_administradora;
    public $sqlcod_administradora;

    public function Administradora($connection) {
        
        $this->sqlcod_administradora = new SqlCommand("cod_administradora");
        $this->sqlcod_administradora->connection = $connection;

        $this->sqlcod_administradora->query = "select cod_administradora, administradora "
        . "from administradora "
        . "order by administradora";

        $this->cod_administradora = new DropDownList("cod_administradora");
	$this->cod_administradora->SqlCommand = $this->sqlcod_administradora;
               
	$this->cod_administradora->bind();
     
	$this->cod_administradora->Value = "cod_administradora";
	$this->cod_administradora->Text = "administradora";
	$this->cod_administradora->size = 1;
        $this->cod_administradora->itens[0]="-= Direto =-";
    
    }

    public function ShowMe() {
        $this->cod_administradora->ShowMe();
    }
}

?>