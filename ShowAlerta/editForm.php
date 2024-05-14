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
                    <label for="fechamento">Fechamento:</label>
                    <input type="date" id="quando" name="quando" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="/js/sweetalert2.all.js"></script>'

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; // Mostrar el modal al cargar la página

            // var closeButton = document.getElementsByClassName("close")[0];
            // closeButton.addEventListener("click", function() {
            //     modal.style.display = "none"; // Ocultar el modal al hacer clic en el botón de cierre
            // });
        });

        var form = document.getElementById("editForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita que se recargue la página al enviar el formulario

            var formData = new FormData(form);

            // Agrega un console.log para verificar los datos del formulario antes de enviarlos
            // console.log("Datos del formulario:", {
            //     cod_alerta: formData.get('cod_alerta'),
            //     analista: formData.get('analista'),
            //     quando: formData.get('quando')
            // });

            fetch('/ShowAlerta/guardar_edicion.php', { // Ruta completa al archivo guardar_edicion.php
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ocorreu um problema ao enviar a solicitação.');
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Os campos foram alterados corretamente',
                    showConfirmButton: true,
                    confirmButtonText: 'Fechar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'ShowAlerta.php';
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao enviar solicitação:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao executar consulta',
                    text: error.message
                });
            });
        });


</script>
</body>

</html>

