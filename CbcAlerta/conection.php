<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

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
        // Log de datos recibidos
        $log = error_log("Datos recibidos: Estado: $estado, Operadora: $operadora, MME: $mme, AMF: $amf, Status: $status, Teste: $teste, Roteamento: $roteamento");
        echo "<script>console.log($log);</script>";

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

// Crear instancia de la clase y procesar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['estado'], $data['operadora'], $data['mme'], $data['amf'], $data['status'], $data['teste'], $data['roteamento'])) {
        echo json_encode(['success' => false, 'message' => 'Faltan dados requeridos']);
        exit;
    }

    $relatorio = new cbcRelatorio();
    $relatorio->guardarCbcRelatorio(
        $data['estado'],
        $data['operadora'],
        $data['mme'],
        $data['amf'],
        $data['status'],
        $data['teste'],
        $data['roteamento']
    );
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}


