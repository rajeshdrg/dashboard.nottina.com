<?php

class Plano {
    public $cod_plano;
    public $sqlcod_plano;

    public function Plano($connection,$cod_operadora) {
        
        $this->sqlcod_plano = new SqlCommand("cod_plano");
        $this->sqlcod_plano->connection = $connection;

        $this->sqlcod_plano->query = "select cod_plano, plano "
        . "from plano "
                . "where cod_operadora = $1"
        . "order by plano";
        
        $this->sqlcod_plano->params = array($cod_operadora);
        
        $this->cod_plano = new DropDownList("cod_plano");
	$this->cod_plano->SqlCommand = $this->sqlcod_plano;
               
	$this->cod_plano->bind();
     
	$this->cod_plano->Value = "cod_plano";
	$this->cod_plano->Text = "plano";
	$this->cod_plano->size = 1;

    
    }

    public function ShowMe() {
        $this->cod_plano->ShowMe();
    }
}

?>