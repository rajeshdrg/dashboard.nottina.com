<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
        if (empty($codAlerta) || empty($fechamento) || empty($analista)) {
            echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios']);
            exit();
        }

        // Transforme a data ‘fechamento’ para incluir a hora atual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');
        $dataCompleta = date('Y-m-d H:i:s', strtotime($dataCompleta));

        // Atualizar o registro na tabela alerta
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "
            UPDATE alerta
            SET fechamento = TO_TIMESTAMP($2, 'YYYY-MM-DD HH24:MI:SS'),
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

if (!empty($data['cod_alerta']) && !empty($data['analista']) && !empty($data['fechamento'])) {
    $guardarEdicion = new GuardarEdicion();

    $guardarEdicion->guardarEdicion(
        $data['cod_alerta'],
        $data['fechamento'],
        $data['analista']
    );
} else {
    echo json_encode(['success' => false, 'message' => 'Não se receberam dados do formulário']);
}











<!-- 
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Origin: *");
// Especifique dominios en lugar de usar '*'
// header("Access-Control-Allow-Origin: https://example.com");

ini_set('display_errors', 0); // No mostrar errores en producción
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
        // Validación de entradas
        if (!is_numeric($codAlerta) || !is_string($analista) || !$this->validarFecha($fechamento)) {
            echo json_encode(['success' => false, 'message' => 'Erro: Dados inválidos']);
            exit();
        }

        // Transformar y validar la fecha
        $dataCompleta = date('Y-m-d H:i:s', strtotime($fechamento . ' ' . date('H:i:s')));

        // Utilizar consultas preparadas
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "
            UPDATE alerta
            SET fechamento = TO_TIMESTAMP($2, 'YYYY-MM-DD HH24:MI:SS'),
                cod_usuario = $1
            WHERE cod_alerta = $3
        ";

        $sqlCommand->params = array($analista, $dataCompleta, $codAlerta);

        try {
            $sqlCommand->Execute();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // No mostrar detalles del error al usuario final
            error_log('Erro ao executar consulta: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta']);
            exit();
        }
    }

    // Función para validar la fecha
    private function validarFecha($fecha)
    {
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }
}

// Leer y decodificar los datos JSON
$rawPostData = file_get_contents("php://input");
$data = json_decode($rawPostData, true);

// Validar los datos recibidos
if (!empty($data['cod_alerta']) && !empty($data['analista']) && !empty($data['fechamento'])) {
    $guardarEdicion = new GuardarEdicion();
    $guardarEdicion->guardarEdicion(
        htmlspecialchars($data['cod_alerta']), // Escapar la entrada
        htmlspecialchars($data['fechamento']), // Escapar la entrada
        htmlspecialchars($data['analista'])    // Escapar la entrada
    );
} else {
    echo json_encode(['success' => false, 'message' => 'Não se receberam dados do formulário']);
} -->
