<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #dfdfdf;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .input-block {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"] {
            width: calc(100% - 24px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #b3d4f8;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm" action="guardar_edicion.php" method="post">
                <div class="input-block">
                    <label for="analista">Analista:</label>
                    <input type="text" id="analista" name="analista" required>
                </div>
                <div class="input-block">
                    <label for="quando">Quándo:</label>
                    <input type="date" id="quando" name="quando" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; // Mostrar el modal al cargar la página
        });

        var form = document.getElementById("editForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que se recargue la página al enviar el formulario

            var formData = new FormData(form);

            fetch('guardar_edicion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Hubo un problema al enviar la solicitud.');
                    }
                    // Redireccionar a la página de visualización de alertas después de guardar los cambios
                    window.location.href = '../ShowAlerta.php';
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                    alert('Hubo un error al enviar la solicitud. Por favor, intenta nuevamente más tarde.');
                });
        });
    </script>
</body>

</html>

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