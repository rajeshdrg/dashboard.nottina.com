<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Corretor {
    public $cod_corretor;
    public $sqlcod_corretor;

    public function Corretor($connection) {
        
        $this->sqlcod_corretor = new SqlCommand("cod_corretor");
        $this->sqlcod_corretor->connection = $connection;

        $this->sqlcod_corretor->query = "select cod_corretor, case when codigo is null then 'xxx' else codigo::varchar end || '- '||corretor as corretor "
        . "from corretor "
        . "order by corretor.corretor";

        $this->cod_corretor = new DropDownList("cod_corretor");
	$this->cod_corretor->SqlCommand = $this->sqlcod_corretor;
               
	$this->cod_corretor->bind();
     
	$this->cod_corretor->Value = "cod_corretor";
	$this->cod_corretor->Text = "corretor";
	$this->cod_corretor->size = 1;
        $this->cod_corretor->itens[0]="Todos";
    
    }

    public function ShowMe() {
        
        
  
        $this->cod_corretor->ShowMe();
    }
    
}

?>