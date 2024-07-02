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

    public function search($id_xml, $estado, $operadora, $mme_amf, $tecnologia, $status, $teste, $roteamento)
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        // Construir la consulta SQL dinámicamente según los parámetros proporcionados
        $sql = "SELECT * FROM cbc_relatorio WHERE 1=1";

        if ($id_xml) {
            $sql .= " AND id_xml = $id_xml";
        }
        if ($estado) {
            $sql .= " AND estado = '$estado'";
        }
        if ($operadora) {
            $sql .= " AND operadora = '$operadora'";
        }
        if ($mme_amf) {
            $sql .= " AND mme_amf = '$mme_amf'";
        }
        if ($tecnologia) {
            $sql .= " AND tecnologia = '$tecnologia'";
        }
        if ($status) {
            $sql .= " AND status = '$status'";
        }
        if ($teste) {
            $sql .= " AND teste = '$teste'";
        }
        if ($roteamento) {
            $sql .= " AND roteamento = '$roteamento'";
        }

        $sqlCommand->query = $sql;

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
$id_xml = isset($_GET['id_xml']) ? $_GET['id_xml'] : null;
$estado = isset($_GET['estado']) ? $_GET['estado'] : null;
$operadora = isset($_GET['operadora']) ? $_GET['operadora'] : null;
$mme_amf = isset($_GET['mme_amf']) ? $_GET['mme_amf'] : null;
$tecnologia = isset($_GET['tecnologia']) ? $_GET['tecnologia'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$teste = isset($_GET['teste']) ? $_GET['teste'] : null;
$roteamento = isset($_GET['roteamento']) ? $_GET['roteamento'] : null;

// Crear una instancia de la clase Search y ejecutar la consulta
$search = new Search();
$search->search($id_xml, $estado, $operadora, $mme_amf, $tecnologia, $status, $teste, $roteamento);

?>