<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/logs/php_errors.log');
error_reporting(E_ALL);

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/ui/dropdownlist.php";

class GuardarEdicion
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function guardarEdicion($codAlerta, $fechamento, $analista)
    {
        if (empty($codAlerta) || empty($analista) || empty($fechamento)) {
            echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios']);
            exit();
        }

        // Transformar la fecha de 'fechamento' para incluir la hora actual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');
        $dataCompleta = date('Y-m-d H:i:s', strtotime($dataCompleta));

        // Actualizar el registro en la tabla alerta
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "
            UPDATE alerta
            SET fechamento = TO_TIMESTAMP($2, 'YYYY-MM-DD HH24:MI:SS'),  -- Asegúrate que TO_TIMESTAMP funcione según tu motor de base de datos
                cod_usuario = $1
            WHERE cod_alerta = $3
        ";

        $sqlCommand->params = array($analista, $dataCompleta, $codAlerta);

        try {
            $sqlCommand->Execute();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
            exit();
        }
    }
}

$rawPostData = file_get_contents("php://input");
$data = json_decode($rawPostData, true);

// // Depuración: imprimir datos recibidos
// echo "Datos recibidos: ";
// print_r($data);
// echo "\n";

if (!empty($data['cod_alerta']) && !empty($data['analista']) && !empty($data['fechamento']) && !empty($data['cod_usuario'])) {
    $guardarEdicion = new GuardarEdicion();

    $guardarEdicion->guardarEdicion(
        $data['cod_alerta'],
        $data['fechamento'],  // Asegúrate de que 'fechamento' esté en el formato correcto esperado en tu consulta SQL
        $data['analista']
    );
} else {
    echo json_encode(['success' => false, 'message' => 'Não se receberam dados do formulário']);
}



