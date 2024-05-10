<?php

if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class GuardarEdicion
{

    public $conexao;

    function __construct()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function guardarEdicion($codAlerta, $quando,  $analista)
    {
       
        if (empty($codAlerta) || empty($quando) || empty($analista)) {
           
            echo "Error: Todos los campos son obligatorios.";
            exit();
        }

        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        
        $Sql->query = "UPDATE alerta SET cod_usuario = $1, quando = TO_DATE($2, 'YYYY-MM-DD') WHERE cod_alerta = $3";
        $Sql->params = array($analista, $quando, $codAlerta);
        
        try {
            $Sql->Execute();
        } catch (Exception $e) {
            // Se houver algum erro durante a execução da consulta, será exibida uma mensagem de erro
            echo 'Error al ejecutar la consulta: ',  $e->getMessage();
            exit();
        }

        // Se a atualização for bem-sucedida, ela redirecionará para a página de exibição de alerta
        header("Location: /ShowAlerta.php");
        exit();
    }
}

// Instancie a classe e chame a função saveEdition com os dados do formulário
$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['quando'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['analista'],
        $_POST['quando']
    );
} else {
    // Manejo de errores si los campos no están configurados correctamente
    echo "Erro: Todos os campos são obrigatórios.";
}
