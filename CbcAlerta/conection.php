<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

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

    public function guardarCbcRelatorio($id_xml, $estado, $operadora, $mme, $amf, $status, $teste, $roteamento)
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->sql = "INSERT INTO cbc_relatorio (id_xml, estado, operadora, mme, amf, status, teste, roteamento, created_at)
                            VALUES ($1, $2, $3, $4, $5, $6, $7, $8, NOW())";
        $sqlCommand->params = array(
            $id_xml,
            $estado,
            $operadora,
            $mme,
            $amf,
            $status,
            $teste,
            $roteamento
        );

        try {
            $sqlCommand->Execute();
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()];
        }
    }
}

// Obtener datos del cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);


// Verificar si se recibieron datos válidos
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Erro ao decodificar dados JSON: ' . json_last_error_msg()]);
    exit;
}

// Crear una instancia de la clase cbcRelatorio
$cbcRelatorio = new cbcRelatorio();

// Obtener el ID desde los datos enviados por cbcEditForm.php
$id = isset($data[0]['id']) ? $data[0]['id'] : null;

// Verificar si se recibió un ID válido
if ($id === null) {
    echo json_encode(['success' => false, 'message' => 'ID da alerta não fornecido.']);
    exit;
}

// Procesar cada conjunto de datos recibidos
$results = [];
foreach ($data as $item) {

    // Extraer valores de cada ítem y llamar al método para guardar en la base de datos
    $result = $cbcRelatorio->guardarCbcRelatorio(
        $id,
        $item['estado'],
        $item['operadora'],
        $item['mme'],
        $item['amf'],
        $item['status'],
        $item['teste'],
        $item['roteamento']
    );

    $results[] = $result;
}

echo json_encode(['success' => true, 'results' => $results]);

