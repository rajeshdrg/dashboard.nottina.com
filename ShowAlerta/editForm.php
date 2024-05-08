<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <title>EditAlerta</title>


</head>

<body>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Contenido de la modal -->
            <div id="iframe" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Alerta</h4>
                </div>
                <div class="modal-body">
                    <!-- Aquí puedes agregar el formulario de edición u otro contenido -->
                    <form action="guardar_edicion.php" method="post">
                        <!-- Agrega los campos del formulario aquí -->
                        <!-- Por ejemplo: -->
                        <div class="form-group">
                            <label for="analista">Analista:</label>
                            <input type="text" class="form-control" id="analista" name="analista">
                        </div>

                        <div class="form-group">
                            <label for="quando">Quándo:</label>
                            <input type="date" class="form-control" id="quanto" name="quando">
                        </div>
                        <!-- Agrega más campos según sea necesario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <!-- Puedes agregar un botón para guardar los cambios en el formulario si lo deseas -->
                </div>
            </div>

        </div>
    </div>



    <!-- <section class="forms-section">

        <div class="forms">
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

    </section> -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>