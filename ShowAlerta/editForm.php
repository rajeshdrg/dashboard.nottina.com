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
        <link rel="stylesheet" href="path/to/sweetalert2.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" name="closeButton">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm" action="/ShowAlerta/guardar_edicion.php" method="post">
                <!-- Agrega un campo oculto para el código de alerta -->
                <input type="hidden" id="cod_alerta" name="cod_alerta" value="<?php echo $_GET['cod_alerta']; ?>">
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

<!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // console.log("DOMContentLoaded event fired");
        var modal = document.getElementById("myModal");
        modal.style.display = "block"; // Mostrar el modal al cargar la página

        var closeButton = document.getElementsByClassName("close")[0];
        closeButton.addEventListener("click", function() {
           // console.log("Close button clicked");
            modal.style.display = "none"; // Ocultar el modal al hacer clic en el botón de cierre
        });
    });


    var form = document.getElementById("editForm");

    form.addEventListener("submit", function(event) {
        //console.log("Form submit event fired");
        event.preventDefault(); // Evita que se recargue la página al enviar el formulario

        // Agrega un console.log para verificar los datos del formulario antes de enviarlos
        // console.log("Datos del formulario:", {
        //     cod_alerta: form.cod_alerta.value,
        //     analista: form.analista.value,
        //     quando: form.quando.value
        // });

        

        var formData = new FormData(form);
    
        // Agrega un console.log para verificar los datos del formulario antes de enviarlos
        console.log("Datos del formulario:", {
            cod_alerta: formData.get('cod_alerta'),
            analista: formData.get('analista'),
            quando: formData.get('quando')
        });
        
        fetch('/ShowAlerta/guardar_edicion.php', { // Ruta completa al archivo guardar_edicion.php
            method: 'POST',
            body: formData
        })
        .then(response => {
             console.log("Response status:", response.status);
            if (!response.ok) {
                throw new Error('Ocorreu um problema ao enviar a solicitação.');
            }
            // Redireccionar a la página de visualización de alertas después de guardar los cambios
            setTimeout(function() {
                window.location.href = '../index.php';
            }, 30000); // Esperar 3 segundos (3000 milisegundos) antes de redirigir
        })

        .catch(error => {
            console.error('Erro ao enviar solicitação:', error);
            alert('Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente mais tarde.');
        });
    });


</script> -->


<script>
    $(document).ready(function() {
        $('#editForm').on('submit', function(event) {
            event.preventDefault(); // Evita el envío normal del formulario
            var formData = $(this).serialize(); // Serializa los datos del formulario

            $.ajax({
                url: $(this).attr('action'), // Obtiene la URL del action del formulario
                type: $(this).attr('method'), // Obtiene el método del formulario (POST)
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Os campos foram alterados corretamente',
                        showConfirmButton: true,
                        confirmButtonText: 'Fechar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "../index.php";
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao executar consulta',
                        text: errorThrown
                    });
                }
            });
        });
    });
</script>
</body>

</html>

