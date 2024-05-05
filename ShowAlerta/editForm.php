<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Edición</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Estilos personalizados para este formulario -->
</head>

<body>
    <!-- <?php
    // Incluir el archivo que realiza la conexión a la base de datos
    // require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/banco/sqlcommand.php";
    // require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/banco/sqldatareader.php";
    ?> -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Alerta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí puedes colocar tu formulario de edición -->
                    <form id="editForm">
                        <!-- Campos del formulario -->
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Campo 1</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="Ingrese valor">
                        </div>
                        <!-- Otros campos del formulario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>



</body>

</html>