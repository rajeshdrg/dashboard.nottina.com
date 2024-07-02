<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class Options
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    public function getOptions()
    {
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $options = [
            'estados' => [],
            'operadoras' => [],
            'tecnologias' => []
        ];

        $sql = "SELECT DISTINCT estado FROM cbc_relatorio";
        $sqlCommand->query = $sql;
        $result = $sqlCommand->Execute();

        while ($row = pg_fetch_assoc($result)) {
            $options['estados'][] = $row['estado'];
        }

        $sql = "SELECT DISTINCT operadora FROM cbc_relatorio";
        $sqlCommand->query = $sql;
        $result = $sqlCommand->Execute();

        while ($row = pg_fetch_assoc($result)) {
            $options['operadoras'][] = $row['operadora'];
        }

        $sql = "SELECT DISTINCT tecnologia FROM cbc_relatorio";
        $sqlCommand->query = $sql;
        $result = $sqlCommand->Execute();

        while ($row = pg_fetch_assoc($result)) {
            $options['tecnologias'][] = $row['tecnologia'];
        }

        echo json_encode(['success' => true, 'options' => $options]);
    }
}

$options = new Options();
$options->getOptions();

?>