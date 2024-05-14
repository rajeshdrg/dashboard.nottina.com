<?php

if ($_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class GuardarEdicion {
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'] . '/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }

    function guardarEdicion($codAlerta, $quando, $analista) {
        if (empty($codAlerta) || empty($quando) || empty($analista)) {
            echo "Erro: Todos os campos são obrigatórios.";
            exit();
        }

        // Transformar la fecha 'quando' para incluir la hora actual
        $dataCompleta = $quando . ' ' . date('H:i:s');

        // Preparar y ejecutar la consulta SQL
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;

        // Actualizar el registro en la tabla alerta
        $Sql->query = "
            UPDATE alerta
            SET cod_usuario = $1, quando = TO_DATE($2, 'YYYY-MM-DD HH24:MI:SS')
            WHERE cod_alerta = $3 AND fechamento IS NULL
        ";
        $Sql->params = array($analista, $dataCompleta, $codAlerta);

        try {
            $Sql->Execute();
            echo'<script>

					swal({
						  type: "success",
						  title: "Os campos foram alterados corretamente",
						  showConfirmButton: true,
						  confirmButtonText: "Fechar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ShowAlerta/Showalerta.php";

									}
								})

					</script>';
        } catch (Exception $e) {
            echo 'Erro ao executar consulta: ', $e->getMessage();
            exit();
        }

        var_dump($codAlerta, $quando, $analista);
    }
}

// Instancia la clase y llama a la função guardarEdicion com os dados do formulário
$guardarEdicion = new GuardarEdicion();
if (isset($_POST['cod_alerta'], $_POST['analista'], $_POST['quando'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['quando'], 
        $_POST['analista']
    );
    var_dump($guardarEdicion);
} else {
    // Manejo de errores si los campos no están configurados correctamente
    echo "Erro: Todos os campos são obrigatórios.";
}
