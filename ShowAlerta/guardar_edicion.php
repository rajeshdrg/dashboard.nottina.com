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
            // Si hay algún error durante la ejecución de la consulta, muestra un mensaje de error
            echo 'Error al ejecutar la consulta: ',  $e->getMessage();
            exit();
        }

        // Si la actualización se realizó correctamente, redirige a la página de visualización de alertas
        header("Location: /ShowAlerta.php");
        exit();
    }
}

// Instanciar la clase y llamar a la función guardarEdicion con los datos del formulario
$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['analista'],
        $_POST['quando']
    );
}
