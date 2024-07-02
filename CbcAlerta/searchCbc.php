<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class Search
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    public function search($estado, $operadora, $tecnologia, $data_inicio, $data_fim)
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        // Converter datas para o formato apropriado para o banco de dados (yy/mm/dd)
        $data_inicio_db = date_format(date_create_from_format('m/d/y', $data_inicio), 'Y-m-d');
        $data_fim_db = date_format(date_create_from_format('m/d/y', $data_fim), 'Y-m-d');

        // Converter datas para o formato apropriado para o banco de dados (yy/mm/dd)
        $data_inicio_db = date_format(date_create_from_format('m/d/y', $data_inicio), 'Y-m-d');
        $data_fim_db = date_format(date_create_from_format('m/d/y', $data_fim), 'Y-m-d');

        // Crie a consulta SQL dinamicamente com base nos parâmetros fornecidos
        $sql = "SELECT id_xml, estado, operadora, mme_amf, tecnologia, status, teste, roteamento, to_char(created_at, 'YYYY-MM-DD') AS created_at FROM cbc_relatorio WHERE 1=1";
        $params = [];
        $paramIndex = 1;

        if (!empty($estado)) {
            $sql .= " AND UPPER(estado) = $" . $paramIndex++;
            $params[] = strtoupper($estado);
        }
        if (!empty($operadora)) {
            $sql .= " AND UPPER(operadora) = $" . $paramIndex++;
            $params[] = strtoupper($operadora);
        }
        if (!empty($tecnologia)) {
            $sql .= " AND tecnologia = $" . $paramIndex++;
            $params[] = $tecnologia;
        }
        if (!empty($data_inicio) && !empty($data_fim)) {
            $sql .= " AND created_at BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
            $params[] = $data_inicio_db;
            $params[] = $data_fim_db;
        } elseif (!empty($data_inicio)) {
            $sql .= " AND created_at >= $" . $paramIndex++;
            $params[] = $data_inicio_db;
        } elseif (!empty($data_fim)) {
            $sql .= " AND created_at <= $" . $paramIndex++;
            $params[] = $data_fim_db;
        }

        $sqlCommand->query = $sql;
        $sqlCommand->params = $params;

        try {
            $result = $sqlCommand->Execute();
            $data = [];

            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }

            echo json_encode(['success' => true, 'results' => $data]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
        }
    }
}

$estado = isset($_GET['estado']) ? strtoupper($_GET['estado']) : null;
$operadora = isset($_GET['operadora']) ? strtoupper($_GET['operadora']) : null;
$tecnologia = isset($_GET['tecnologia']) ? $_GET['tecnologia'] : null;
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : null;
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : null;

$search = new Search();
$search->search($estado, $operadora, $tecnologia, $data_inicio, $data_fim);

