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

    public function guardarCbcRelatorio($id_xml, $estado, $operadora, $mme_amf, $tecnologia, $status, $teste, $roteamento)
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "INSERT INTO cbc_relatorio (id_xml, estado, operadora, mme_amf, tecnologia, status, teste, roteamento)
                            VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $sqlCommand->params = array(
            $id_xml,
            $estado,
            $operadora,
            $mme_amf,
            $tecnologia,
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


$data = json_decode(file_get_contents('php://input'), true);


if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Erro ao decodificar dados JSON: ' . json_last_error_msg()]);
    exit;
}


$cbcRelatorio = new cbcRelatorio();


$id = isset($data['id']) ? $data['id'] : null;
if ($id === null) {
    exit(json_encode(['success' => false, 'message' => 'ID da alerta não fornecido.']));
}


$estado = isset($data['estado']) ? $data['estado'] : null;
$operadora = isset($data['operadora']) ? $data['operadora'] : null;
$mme_amf = isset($data['mme']) ? $data['mme'] : null;
$tecnologia = isset($data['tecnologia']) ? $data['tecnologia'] : null;
$status = isset($data['status']) ? $data['status'] : null;
$teste = isset($data['test']) ? $data['test'] : null;
$roteamento = isset($data['roteamento']) ? $data['roteamento'] : null;


if ($estado == null || $operadora == null || $mme_amf == null || $tecnologia == null || $status == null || $teste == null || $roteamento == null) {
    exit(json_encode(['success' => false, 'message' => 'Dados incompletos fornecidos.']));
}


$result = $cbcRelatorio->guardarCbcRelatorio(
    $id,
    $estado,
    $operadora,
    $mme_amf,
    $tecnologia,
    $status,
    $teste,
    $roteamento
);


echo json_encode(['success' => true, 'results' => $result]);
