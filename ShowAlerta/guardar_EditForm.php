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
        
        // Aquí debes escribir las consultas SQL necesarias para actualizar los campos de la alerta
        // Por ejemplo:
        $Sql->query = "UPDATE alerta SET prioridade = $1, quando = $2, modulo = $3, item = $4, valor = $5, descricao = $6, analista = $7 WHERE cod_alerta = $8";
        $Sql->params = array($prioridade, $quando, $modulo, $item, $valor, $descricao, $analista, $codAlerta);
        $Sql->Execute();
        
        // Puedes agregar comprobaciones adicionales, manejo de errores, etc., según sea necesario
        
        // Redireccionar a la página de visualización de alertas
        header("Location: /ShowAlerta.php");
        exit();
    }
}

// Instanciar la clase y llamar a la función guardarEdicion con los datos del formulario
$guardarEdicion = new GuardarEdicion();
if(isset($_POST['cod_alerta'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['prioridade'],
        $_POST['quando'],
        $_POST['modulo'],
        $_POST['item'],
        $_POST['valor'],
        $_POST['descricao'],
        $_POST['analista']
    );
}