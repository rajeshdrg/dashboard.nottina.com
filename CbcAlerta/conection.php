<?php

header('Content-Type: application');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');


if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/ui/dropdownlist.php";


class cbcRelatorio
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function guardarCbcRelatorio($estado, $operadora, $mme, $amf, $status, $teste, $roteamento)
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

        $sqlCommand->sql = "INSERT INTO cbc_relatorio (id, estado, operadora, mme, amf, status, teste, roteamento, created_at)
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $sqlCommand->params = array(
            $estado,
            $operadora,
            $mme,
            $amf,
            $status,
            $teste,
            $roteamento
        );

        $sqlCommand->execute();

        try {
            $sqlCommand->execute();
            echo json_encode(['success' => true]);
        } catch (\Throwable $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
        }

        // header("Location: /CbcAlerta.php");
        // exit();
    }
}