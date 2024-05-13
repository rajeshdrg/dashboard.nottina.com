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
            echo "Erro: Todos os campos são obrigatórios.";
            exit();
        }
    
        // Convertir el formato de 'quando' al formato esperado en la consulta SQL
        $quandoFormateado = date('Y-m-d H:i:s', strtotime($quando));
    
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;
    
        // Modificar la consulta para usar $quandoFormateado y $codAlerta
        $Sql->query ="UPDATE alerta
            SET cod_usuario = $1, quando = TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS')
            WHERE cod_alerta = $3";
        $Sql->params = array($analista, $quandoFormateado, $codAlerta);
    
        try {
            $Sql->Execute();
        } catch (Exception $e) {
            // Si hay algún error durante la ejecución de la consulta, se mostrará un mensaje de error
            echo 'Erro ao executar consulta: ',  $e->getMessage();
            exit();
        }
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
    echo "Los datos se actualizaron correctamente.";
} else {
    // Manejo de errores si los campos no están configurados correctamente
    echo "Erro: Todos os campos são obrigatórios.";
}


