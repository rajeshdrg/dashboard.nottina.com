<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Edición</title>
    <!-- <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
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
    </style> -->
</head>

<body>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Formulario de Edición</h2>
            <form>
                <label for="prioridad">Prioridad:</label>
                <input type="text" id="prioridad" name="prioridad"><br><br>
                <label for="cod_alerta">Código de Alerta:</label>
                <input type="text" id="cod_alerta" name="cod_alerta"><br><br>
                <!-- Agrega más campos según tus necesidades -->
                <input type="submit" value="Guardar">
            </form>
        </div>
    </div>

    <!-- <script>
    // Obtener la ventana modal
    var modal = document.getElementById("myModal");

    // Obtener el botón que abre la ventana modal
    var btn = document.getElementById("myBtn");

    // Obtener el botón para cerrar la ventana modal
    var span = document.getElementsByClassName("close")[0];

    // Cuando el usuario haga clic en el botón, abrir la ventana modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Cuando el usuario haga clic en <span> (x), cerrar la ventana modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cuando el usuario haga clic en cualquier lugar fuera de la ventana modal, cerrarla
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script> -->

</body>

</html>