<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <title>Editar Alerta</title>
    <?php include '../dashboard.nottina.com/top.php' ?>

</head>

<body>

    <section class="forms-section"></section>
    <h2 class="section-title">Editar Alerta</h2>
    <div class="forms">
        <form id="editForm" action="guardar_edicion.php" method="post">
            <fieldset>
                <div class="input-block">
                    <label for="prioridade">Prioridade</label>
                    <input type="text" id="prioridade" name="prioridade" required>
                </div>

                <div class="input-block">
                    <label for="cod_alerta">Cod. Alerta:</label>
                    <input type="text" id="cod_alerta" name="cod_alerta" required>
                </div>


                <div class="input-block">
                    <label for="quando">Quándo:</label>
                    <input type="datetime-local" id="quando" name="quando" required>
                </div>

                <div class="input-block">
                    <label for="modulo">Módulo:</label>
                    <input type="text" id="modulo" name="modulo" required>
                </div>

                <div class="input-block">
                    <label for="item">Item:</label>
                    <input type="text" id="item" name="item" required>
                </div>

                <div class="input-block">
                    <label for="valor">Valor:</label>
                    <input type="text" id="valor" name="valor" required>
                </div>

                <div class="input-block">
                    <label for="analista">Analista:</label>
                    <input type="text" id="analista" name="analista" required>
                </div>

                <div class="input-block>
                    <label for=" descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="10" cols="30" required></textarea>
                </div>


            </fieldset>
            <button type="submit" class="btn-submit">Submit</button>

        </form>

    </div>


</body>

</html>