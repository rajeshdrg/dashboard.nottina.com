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
        // Obtener el formulario
        
        var form = document.getElementById("editForm");

        // Agregar un event listener para el evento submit del formulario
        form.addEventListener("submit", function(event) {
            // Evitar que el formulario se envíe de forma predeterminada (recargar la página)
            event.preventDefault();

            // Obtener los datos del formulario
            var formData = new FormData(form);

            // Enviar los datos del formulario al servidor utilizando fetch
            fetch('guardar_edicion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Verificar si la respuesta del servidor fue exitosa
                if (!response.ok) {
                    throw new Error('Hubo un problema al enviar la solicitud.');
                }
                // Si la respuesta fue exitosa, mostrar un mensaje de éxito
                alert('Los cambios se guardaron exitosamente.');
                // Otra opción es redireccionar a otra página después de guardar los cambios
                // window.location.href = '/ShowAlerta.php';
            })
            .catch(error => {
                // Si hay un error, mostrarlo en la consola del navegador
                console.error('Error al enviar la solicitud:', error);
                // También puedes mostrar un mensaje de error al usuario si lo deseas
                //alert('Hubo un error al enviar la solicitud. Por favor, intenta nuevamente más tarde.');
            });
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block"; // Mostrar el modal al cargar la página
    });
</script>

</body>

</html>
