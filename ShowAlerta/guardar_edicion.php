<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/logs/php_errors.log');
error_reporting(E_ALL);


if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/ui/dropdownlist.php";


class GuardarEdicion
{
    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }



    function guardarEdicion($codAlerta, $fechamento, $analista)
    {
        if (empty($codAlerta) || empty($fechamento) || empty($analista)) {
            echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
            exit();
        }

        // Transformar la fecha 'fechamento' para incluir la hora actual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');
        $dataCompleta = date('Y-m-d H:i:s', strtotime($dataCompleta));

        echo "Datos recibidos:<br>";
        var_dump($codAlerta, $dataCompleta, $analista);
        echo "<br>";
        error_log("Datos recibidos: " . print_r([$codAlerta, $dataCompleta, $analista], true));

        // Atualizar o registro na tabela alerta
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "
          UPDATE alerta
          SET fechamento = :TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS'),
              cod_usuario = ($1, SELECT cod_usuario FROM usuario WHERE nome = :nuevo_nome)
          WHERE cod_alerta = $3;  
          ";

        $sqlCommand->params = array($analista, $dataCompleta, $codAlerta);


        echo "Consulta SQL:<br>";
        print_r($sqlCommand->query);
        echo "<br>";

        echo "Parámetros:<br>";
        print_r($sqlCommand->params);
        echo "<br>";
        error_log("Parámetros: " . print_r($sqlCommand->params, true));

        try {
            $sqlCommand->Execute();
            $Sql = $sqlCommand->ExecuteReader();
            $Sql->GetObject();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
            exit();
        }
    }


}

$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['fechamento'])) {
    echo "Datos POST recibidos:<br>";
    print_r($_POST);
    echo "<br>";
    error_log("Dados POST recibidos: " . print_r($_POST, true));
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['fechamento'],
        $_POST['analista']
    );
}
