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

    function guardarEdicion($codAlerta, $fechamento, $analista) {
        if (empty($codAlerta) || empty($fechamento) || empty($analista)) {
            echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
            exit();
        }

        // Transforme a data ‘datemento’ para incluir a hora atual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');

        // Preparar e executar a consulta SQL
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        // Atualizar o registro na tabela de alertas
        $Sql->query = "
            UPDATE alerta
            SET cod_usuario = $1, fechamento = TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS')
            WHERE cod_alerta = $3  
        ";
        $Sql->params = array($analista, $dataCompleta, $codAlerta);

        try {
            $Sql->Execute();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
            exit();
        }
    }
}

if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['fechamento'])) {
    $guardarEdicion = new GuardarEdicion();
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['fechamento'],
        $_POST['analista']
    );
} else {
    echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
}




