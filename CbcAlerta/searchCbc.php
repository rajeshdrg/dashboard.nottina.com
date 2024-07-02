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

        // Construir la consulta SQL dinámicamente según los parámetros proporcionados
        $sql = "SELECT id_xml, estado, operadora, mme_amf, tecnologia, status, teste, roteamento, to_char(created_at, 'YYYY-MM-DD') AS created_at FROM cbc_relatorio WHERE 1=1";
        $params = [];
        $paramIndex = 1;

        if (!empty($estado)) {
            $sql .= " AND UPPER(estado) = $" . $paramIndex++;
            $params[] = strtoupper($estado);
        }
        if (!empty($operadora)) {
            $sql .= " AND  = $" . $paramIndex++;
            $params[] = strtoupper($operadora);
        }
        if (!empty($tecnologia)) {
            $sql .= " AND tecnologia = $" . $paramIndex++;
            $params[] = strtoupper($tecnologia);
        }
        if (!empty($data_inicio) && !empty($data_fim)) {
            $sql .= " AND created_at BETWEEN $" . $paramIndex++ . " AND $" . $paramIndex++;
            $params[] = $data_inicio;
            $params[] = $data_fim;
        } elseif (!empty($data_inicio)) {
            $sql .= " AND created_at >= $" . $paramIndex++;
            $params[] = $data_inicio;
        } elseif (!empty($data_fim)) {
            $sql .= " AND created_at <= $" . $paramIndex++;
            $params[] = $data_fim;
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
$tecnologia = isset($_GET['tecnologia']) ? strtoupper($_GET['tecnologia']) : null;
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : null;
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : null;


$search = new Search();
$search->search($estado, $operadora, $tecnologia, $data_inicio, $data_fim);

?>