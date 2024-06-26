<?php
header('Content-Type: application/json');

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/ui/dropdownlist.php";
class Analista {
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function obterAnalistas() {

        $cod_usuario = new DropDownList("cod_usuario");
        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        $Sql->query = "select cod_usuario, nome from usuario order by usuario";
        $cod_usuario->SqlCommand =  $Sql;



       

        try {
            $Sql->Execute();
            $analistasReader = $Sql->ExecuteReader();
            $analistas = [];
            while ($o = $analistasReader->GetObject()) {
                $analistas[] = $o;
            }
            error_log(print_r($analistas, 1)); 
            return $analistas;
        } catch (Exception $e) {
            throw new Exception('Erro ao executar consulta: ' . $e->getMessage());
        }
     
    }
}


$selecao = new Analista();

if (isset($_GET['action']) && $_GET['action'] == 'obter_analistas') {
    $selecao = new Analista(); 
    try {
        $analistas = $selecao->obterAnalistas(); 
        echo json_encode(['success' => true, 'analistas' => $analistas]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro: Todos os campos são obrigatórios.']);
}

$print = print_r($analistas, 1);
error_log($print);