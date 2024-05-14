<!-- <!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alerta</title>
        <link rel="stylesheet" href="/ShowAlerta/editForm.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="/js/sweetalert2.all.js"></script>
    </head>

 <body>

    < Modal 
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" name="closeButton">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm" action="/ShowAlerta/guardar_edicion.php" method="post">
                <Agrega un campo oculto para el código de alerta -
                <input type="hidden" id="cod_alerta" name="cod_alerta" value="<?php echo $_GET['cod_alerta']; ?>">
                <div class="input-block">
                    <label for="analista">Analista:</label>
                    <input type="text" id="analista" name="analista" required>
                </div>
                <div class="input-block">
                    <label for="fechamento">Fechamento:</label>
                    <input type="date" id="fechamento" name="fechamento" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; // Mostrar o modal no carregamento da página

            
        });

        var form = document.getElementById("editForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); //Impedir que a página seja recarregada ao enviar o formulário

            var formData = new FormData(form);
            //Agrega un console.log para verificar los datos del formulario antes de enviarlos
        console.log("Datos del formulario:", {
            cod_alerta: formData.get('cod_alerta'),
            analista: formData.get('analista'),
            quando: formData.get('fechamento')
        });

            Swal.fire({
                title: '¿Está seguro?',
                text: "Deseja atualizar os dados do alerta?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, atualizar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                console.log("Response status:", result.status);
                if (result.isConfirmed) {
                    fetch('/ShowAlerta/guardar_edicion.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Os campos foram alterados corretamente',
                                showConfirmButton: true,
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao enviar solicitação:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao enviar solicitação',
                            text: 'Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente mais tarde.'
                        });
                    });
                }
            });
        });


    </script>
</body>

</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/sweetalert2.all.js"></script>
</head>
<body>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" name="closeButton">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm">
                <!-- Agrega un campo oculto para el código de alerta -->
                <input type="hidden" id="cod_alerta" name="cod_alerta" value="<?php echo $_GET['cod_alerta']; ?>">
                <div class="input-block">
                    <label for="analista">Analista:</label>
                    <input type="text" id="analista" name="analista" required>
                </div>
                <div class="input-block">
                    <label for="fechamento">Fechamento:</label>
                    <input type="date" id="fechamento" name="fechamento" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block"; // Mostrar o modal no carregamento da página

            var closeButton = document.getElementsByClassName("close")[0];
            closeButton.addEventListener("click", function() {
                modal.style.display = "none"; // Ocultar o modal ao clicar no botão de fechamento
            });
        });

        var form = document.getElementById("editForm");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Impedir que a página seja recarregada ao enviar o formulário

            var formData = new FormData(form);
            console.log("Datos del formulario:", {
                cod_alerta: formData.get('cod_alerta'),
                analista: formData.get('analista'),
                quando: formData.get('fechamento')
            });

            Swal.fire({
                title: '¿Está seguro?',
                text: "Deseja atualizar os dados do alerta?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, atualizar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/ShowAlerta/guardar_edicion.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Os campos foram alterados corretamente',
                                showConfirmButton: true,
                                confirmButtonText: 'Fechar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao enviar solicitação:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao enviar solicitação',
                            text: 'Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente mais tarde.'
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
