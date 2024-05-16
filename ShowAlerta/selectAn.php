<?php
header('Content-Type: application/json');

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class GuardarEdicion {
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

  

    function obtenerAnalistas($analista, $cod_usuario) {

           // Preparar y ejecutar la consulta SQL
     $Sql = new SqlCommand("Sql");
     $Sql->connection = $this->conexao;

     $Sql->query = "
     SELECT  nome, cod_usuario FROM usuario
     ";
     $Sql->params = array($analista, $cod_usuario);

     try {
        $Sql->Execute();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
        exit();
    }
       
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'obtener_analistas') {
    try {
        $analistas = $guardarEdicion->obtenerAnalistas();
        echo json_encode(['success' => true, 'analistas' => $analistas]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao obter analistas: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
}