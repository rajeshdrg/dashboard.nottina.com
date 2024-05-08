<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
     <title>EditAlerta</title>


</head>

<body>
 <section class="forms-section">

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

    </section>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>