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

        // Actualizar el registro en la tabla alerta
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

    function obtenerAnalistas($analista, $cod_usuario) {

        // Preparar y ejecutar la consulta SQL
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        $Sql->query = "SELECT cod_usuario, nome FROM usuario";
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

$guardarEdicion = new GuardarEdicion();

if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['fechamento'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['fechamento'],
        $_POST['analista']
    );
}elseif (isset($_GET['action']) && $_GET['action'] == 'obtener_analistas') {
    try {
        $analistas = $guardarEdicion->obtenerAnalistas();
        echo json_encode(['success' => true, 'analistas' => $analistas]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao obter analistas: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
}

// $Sql->query = "UPDATE alerta
//     SET cod_usuario = $1, quando = TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS')
//     FROM usuario
//     WHERE alerta.cod_usuario = usuario.cod_usuario
//     AND alerta.cod_alerta = $3
//     AND alerta.fechamento IS NULL";
// $Sql->params = array($analista, $quandoFormateado, $codAlerta);