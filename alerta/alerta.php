<?php


if($_SERVER['DOCUMENT_ROOT']==null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
class alerta {
    
    public $conexao;

    public $name;
    public $id;
    public $icone;
    public $sigla;
    

    function __construct() {
        

        
        
        require $_SERVER['DOCUMENT_ROOT'].'/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }
    
    function registra ($modulo,$item,$valor,$descricao,$prioridade,$procedimento) {
        
        
       
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;
        
        $Sql->query = "select cod_modulo from modulo where modulo = $1 ";
        $Sql->params = array ($modulo);
        $dr=$Sql->ExecuteReader();
        if($dr->HasRows)
            $cod_modulo=$dr->GetObject()->cod_modulo;
        else
            $cod_modulo = 0;
        

        $Sql->query = "select cod_procedimento from procedimento where procedimento = $1 ";
        $Sql->params = array ($procedimento);
        $dr=$Sql->ExecuteReader();
        if($dr->HasRows)
            $cod_procedimento=$dr->GetObject()->cod_procedimento;
        else
            $cod_procedimento = 0;

        
        $Sql->query = "select * from alerta where cod_modulo = $1 and item = $2 and fechamento is null ";
         $Sql->params = array ($cod_modulo,$item);
        $dr=$Sql->ExecuteReader();
        if(!$dr->HasRows) {
            $Sql->query = "insert into alerta (cod_modulo,item,valor,descricao,prioridade) values ($1,$2,$3,$4,$5) ";
            $Sql->params = array ($cod_modulo,$item,$valor,$descricao,$prioridade);
            $Sql->Execute();
        }
    }

}
