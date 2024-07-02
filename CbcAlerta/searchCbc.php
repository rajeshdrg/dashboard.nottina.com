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

    public function search($estado, $operadora, $tecnologia)
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        // Construir la consulta SQL dinámicamente según los parámetros proporcionados
        $sql = "SELECT * FROM cbc_relatorio WHERE 1=1";

        if ($estado) {
            $sql .= " AND estado = $1";
            $params[] = $estado;
        }
        if ($operadora) {
            $sql .= " AND operadora = $2";
            $params[] = $operadora;
        }
        if ($tecnologia) {
            $sql .= " AND tecnologia = $3";
            $params[] = $tecnologia;
        }

        $sqlCommand->query = $sql;
        $sqlCommand->params = $params;

        try {
            $result = $sqlCommand->Execute(); // Ejecutar la consulta SQL
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

// Obtener parámetros de la URL
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;
$operadora = isset($_GET['operadora']) ? $_GET['operadora'] : null;
$tecnologia = isset($_GET['tecnologia']) ? $_GET['tecnologia'] : null;

// Crear una instancia de la clase Search y ejecutar la consulta
$search = new Search();
$search->search($estado, $operadora, $tecnologia);

?>