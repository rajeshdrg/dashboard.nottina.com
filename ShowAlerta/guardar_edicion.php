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

        // Transformar la fecha 'fechamento' para incluir la hora actual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');

        // Preparar y ejecutar la consulta SQL
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        // Atualizar o registro na tabela alerta
        $Sql->query = "
        UPDATE alerta
        SET fechamento = :TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS'),
            cod_usuario = ($1, SELECT cod_usuario FROM usuario WHERE nome = :nuevo_nome)
        WHERE cod_alerta = $3;  
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

$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['fechamento'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['fechamento'],
        $_POST['analista']
    );
}
