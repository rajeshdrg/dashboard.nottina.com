<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.3.1.js"></script>
   

    <title>Alerta</title>


</head>

<body>

    <!-- Modal -->
    <div class='modal fade' id='myModal' role='dialog'>
        <div class='modal-dialog'>
            <!-- Modal content-->
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Alerta</h4>
                </div>
                <div class='modal-body'>
                    <form id='editForm' action='guardar_edicion.php' method='post'>
                        <input type='hidden' id='cod_alerta' name='cod_alerta'>
                        <div class='form-group'>
                            <label for='analista'>Analista:</label>
                            <input type='text' class='form-control' id='analista' name='analista' required>
                        </div>
                        <div class='form-group'>
                            <label for='quando'>Quándo:</label>
                            <input type='date' class='form-control' id='quando' name='quando' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Submit</button>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>

</html>