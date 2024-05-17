<?php
header('Content-Type: application/json');

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class Analista {
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function obtenerAnalistas() {
        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        $Sql->query = "
            SELECT nome FROM usuario
        ";

        try {
            $Sql->Execute();
            $analistas = $Sql->ExecuteReader(); 
            return $analistas;
        } catch (Exception $e) {
            throw new Exception('Erro ao executar consulta: ' . $e->getMessage());
        }
    }
}


$selecao = new Analista();

if (isset($_GET['action']) == 'obtener_analistas') {
    $selecao = new Analista(); 
    try {
        $analistas = $selecao->obtenerAnalistas(); 
        echo json_encode(['success' => true, 'analistas' => $analistas]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro: Todos los campos são obrigatórios.']);
}
