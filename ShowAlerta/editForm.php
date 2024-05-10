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
                <button type="submit" class="btn-submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <button id="openModalBtn" class="btn-submit">Editar Alerta</button>

    <script>
                // Obtiene la ventana modal y el botón de abrir
        var modal = document.getElementById("myModal");
        var openModalBtn = document.getElementById("openModalBtn");
        var closeBtn = document.getElementsByClassName("close")[0];

        // Abre la ventana modal cuando se hace clic en el botón
        openModalBtn.onclick = function() {
            modal.style.display = "block";
        }

        // Cierra la ventana modal cuando se hace clic en el botón de cerrar
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Cierra la ventana modal cuando se hace clic fuera de ella
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Envía el formulario al servidor
        var form = document.getElementById("editForm");
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que se recargue la página al enviar el formulario
            // Aquí puedes agregar el código para enviar los datos del formulario al servidor utilizando AJAX
            // Por ejemplo, puedes usar fetch() o XMLHttpRequest
        });
    </script>
</body>

</html>


