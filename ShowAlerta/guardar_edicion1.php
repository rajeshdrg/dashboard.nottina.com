<?php
header('Content-Type: application/json');
header('Accesss-Control-Allow-Methods: POST');
header("Access-Control-Allow-Origin: *");


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

        if(empty($codAlerta) || empty($fechamento) || empty($analista) ){
                echo json_encode(['success' =>false, 'message'=> 'Erro: Todos os campos são obrigatorios']);
                exit();
            }

        
        // Transformar la fecha 'fechamento' para incluir la hora actual
        $dataCompleta = $fechamento . ' ' . date('H:i:s');
        $dataCompleta = date('Y-m-d H:i:s', strtotime($dataCompleta));

     

        // Atualizar o registro na tabela alerta
        $sqlCommand = new SqlCommand("Sql");
        $sqlCommand->connection = $this->conexao;

        $sqlCommand->query = "
          UPDATE alerta
          SET fechamento = $2,
              cod_usuario = (SELECT cod_usuario FROM usuario WHERE nome = $3)
          WHERE cod_alerta = $1;  
          ";

        $sqlCommand->params = array($codAlerta, $dataCompleta, $analista,);


 

        try {
            $sqlCommand->Execute();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar consulta: ' . $e->getMessage()]);
            exit();
        }
    }


}


$rawPostData = file_get_contents("php://input");
$data = json_decode($rawPostData, true);

if (!empty($data['cod_alerta']) && !empty($data['analista']) && !empty($data['fechamento'])) {
    $guardarEdicion = new GuardarEdicion();

    $guardarEdicion->guardarEdicion(
        $data['cod_alerta'],
        $data['analista'],
        $data['fechamento']
        
    );
}else {
    echo json_encode(['success' =>false, 'message' => 'Não se recibieron dados do formulario']);
}
