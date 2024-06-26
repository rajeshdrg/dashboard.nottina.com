<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
var_dump($_POST);
if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class cbcRelatorio
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    public function guardarCbcRelatorio($estado, $operadora, $mme, $amf, $status, $teste, $roteamento)
    {
        // Generar el script de consola
        $script = "<script>console.log('Datos recibidos: ";
        $script .= "Estado: $estado, ";
        $script .= "Operadora: $operadora, ";
        $script .= "MME: $mme, ";
        $script .= "AMF: $amf, ";
        $script .= "Status: $status, ";
        $script .= "Teste: $teste, ";
        $script .= "Roteamento: $roteamento";
        $script .= "');</script>";

        // Imprimir el script de consola
        echo $script;

        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->sql = "INSERT INTO cbc_relatorio (estado, operadora, mme, amf, status, teste, roteamento, created_at)
                            VALUES ($1, $2, $3, $4, $5, $6, $7, NOW())";
        $sqlCommand->params = array(
            $estado,
            $operadora,
            $mme,
            $amf,
            $status,
            $teste,
            $roteamento
        );

        try {
            $sqlCommand->execute();
            echo json_encode(['success' => true]);
        } catch (\Throwable $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
        }
    }
}

// Imprimir los datos crudos recibidos para depuración en consola de navegador
$rawData = file_get_contents('php://input');
echo "<script>console.log('Datos crudos recibidos: " . json_encode($rawData) . "');</script>";


$data = json_decode(file_get_contents('php://input'), true);
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Erro ao decodificar dados JSON: ' . json_last_error_msg()]);
    exit;
}

if ($data) {
    $cbcRelatorio = new cbcRelatorio();
    foreach ($data as $item) {
        $cbcRelatorio->guardarCbcRelatorio(
            $item['estado'],
            $item['operadora'],
            $item['mme'],
            $item['amf'],
            $item['status'],
            $item['teste'],
            $item['roteamento']
        );
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido']);
}
