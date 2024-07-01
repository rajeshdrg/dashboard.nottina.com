<?php
var_dump($_POST);

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

    public function guardarCbcRelatorio($id_xml, $estado, $operadora, $mme_amf, $tecnolgia, $status, $teste, $roteamento)
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
            $tecnolgia,
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


// Verificar se o ID foi fornecido
$id = isset($data['id']) ? $data['id'] : null;
if ($id === null) {
    exit(json_encode(['success' => false, 'message' => 'ID da alerta não fornecido.']));
}

// Processar os dados recebidos
$estado = isset($data['estado']) ? $data['estado'] : null;
$operadora = isset($data['operadora']) ? $data['operadora'] : null;
$mme_amf = isset($data['mme_amf']) ? $data['mme_amf'] : null;
$tecnologia = isset($data['tecnologia']) ? $data['tecnologia'] : null;
$status = isset($data['status']) ? $data['status'] : null;
$teste = isset($data['teste']) ? $data['teste'] : null;
$roteamento = isset($data['roteamento']) ? $data['roteamento'] : null;

// Verificar se todos os campos necessários foram fornecidos
if ($estado === null || $operadora === null || $mme_amf === null || $tecnologia === null || $status === null || $teste === null || $roteamento === null) {
    exit(json_encode(['success' => false, 'message' => 'Dados incompletos fornecidos.']));
}


// Extraer valores de cada ítem y llamar al método para guardar en la base de datos
$result = $cbcRelatorio->guardarCbcRelatorio(
    $id,
    $estado,
    $operadora,
    $mme_amf,
    $tecnologia,
    $status,
    $test,
    $roteamento
);




echo json_encode(['success' => true, 'results' => $result]);

