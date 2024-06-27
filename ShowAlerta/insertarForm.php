<?php

if($_SERVER['DOCUMENT_ROOT']==null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class GuardarEdicion {
    
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'].'/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }
    
    function guardarEdicion($codAlerta, $prioridade, $quando, $modulo, $item, $valor, $descricao, $analista) {
        // Actualizar la entrada correspondiente en la base de datos de alertas
        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;
        
        // Aquí debes escribir las consultas SQL necesarias para insertar los datos del formulario en la base de datos.
        // Asumiendo que estás insertando nuevos registros en lugar de actualizar, el SQL sería algo como esto:
        $Sql->query = "INSERT INTO alerta (cod_alerta, prioridade, quando, modulo, item, valor, descricao, analista) 
                       VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $Sql->params = array($codAlerta, $prioridade, $quando, $modulo, $item, $valor, $descricao, $analista);
        $Sql->Execute();
        
        
        
        // Redireccionar a la página de visualización de alertas
        header("Location: /ShowAlerta.php");
        exit();
    }
}


    