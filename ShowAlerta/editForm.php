<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
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

<script>
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


</script>
</body>

</html>

