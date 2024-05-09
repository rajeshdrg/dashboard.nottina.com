<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <script src="/ShowAlerta/editForm.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <title>Alerta</title>


</head>

<body>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm">
                <label for="analista">Analista:</label>
                <input type="text" id="analista" name="analista" required>
                <label for="quando">Quándo:</label>
                <input type="date" id="quando" name="quando" required>
                <button type="submit" class="btn-submit">Guardar Cambios</button>
            </form>
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


</body>

</html>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editForm.css">
    <title>Editar Alerta</title>
</head>

<body>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Alerta</h2>
            <form id="editForm">
                <label for="analista">Analista:</label>
                <input type="text" id="analista" name="analista" required>
                <label for="quando">Quándo:</label>
                <input type="date" id="quando" name="quando" required>
                <button type="submit" class="btn-submit">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <script src="editForm.js"></script>
</body>

</html> -->