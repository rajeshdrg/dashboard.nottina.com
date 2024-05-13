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

    function guardarEdicion($codAlerta, $quando, $analista)
    {
        

        if (empty($codAlerta) || empty($quando) || empty($analista)) {

            echo "Error: Todos los campos son obligatorios.";
            exit();
        }
        var_dump($codAlerta, $quando, $analista);

        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;


        $Sql->query = "UPDATE alerta
               SET cod_usuario = $1, quando = TO_DATE($2 || ' ' || TO_CHAR(CURRENT_TIMESTAMP, 'HH24:MI:SS'), 'YYYY-MM-DD HH24:MI:SS')
               FROM usuario
               WHERE alerta.cod_usuario = usuario.cod_usuario
               AND alerta.fechamento IS NULL";
        $Sql->params = array($analista, $quando);


        try {
            $Sql->Execute();
        } catch (Exception $e) {
            // Si hay algún error durante la ejecución de la consulta, se mostrará un mensaje de error
            echo 'Error al ejecutar la consulta: ',  $e->getMessage();
            exit();
        }

        // Si la actualización se realiza correctamente, se redirige a la página de visualización de alertas
        // header("Location: /editForm.php");
        // exit();
        var_dump($codAlerta, $quando, $analista);
    }
    
}

// Instancia la clase y llama a la función guardarEdicion con los datos del formulario
$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['quando'])) {
    
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['analista'],
        $_POST['quando']
    );
    var_dump($guardarEdicion);
} else {
    // Manejo de errores si los campos no están configurados correctamente
    echo "Error: Todos los campos son obligatorios.";
}


