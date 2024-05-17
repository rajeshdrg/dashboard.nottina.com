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

        $Sql->query = "select cod_usuario,usuario from usuario order by usuario";
        $cod_usuario->SqlCommand =  $Sql;



        $cod_usuario->bind();
        $cod_usuario->ShowMe();

        try {
            $Sql->Execute();
            $analistas = $Sql->ExecuteReader(); 
            return $analistas;
        } catch (Exception $e) {
            throw new Exception('Erro ao executar consulta: ' . $e->getMessage());
        }
    }
}


$selecao = new Analista();

if (isset($_GET['action']) == 'obter_analistas') {
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
echo "<script>
console.log('$print')
</script>";