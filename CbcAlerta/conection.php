<!-- -- Crear tipo ENUM para status
CREATE TYPE status_type AS ENUM ('ok', 'fora');

-- Crear tipo ENUM para roteamento
CREATE TYPE roteamento_type AS ENUM ('sim', 'não');


-- Crear la tabla cbc_alerta con los tipos ENUM definidos
CREATE TABLE cbc_alerta (
    id SERIAL PRIMARY KEY,
    estado VARCHAR(100) NOT NULL,
    operadora VARCHAR(100) NOT NULL,
    mme VARCHAR(100),
    amf VARCHAR(100),
    status status_type DEFAULT 'fora',
    teste TEXT,
    roteamento roteamento_type DEFAULT 'não'
); -->


<?php

header('Content-Type: application');
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

    public function guardarCbcRelatorio($estado, $operadora, $mme, $amf, $status, $teste, $roteamento)
    {
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