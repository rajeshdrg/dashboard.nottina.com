<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alerta</title>
    <link rel="stylesheet" href="editForm.css">
</head>

<body>
    <h2>Editar Alerta</h2>
    <form action="guardar_edicion.php" method="POST">
        <div>
            <label for="prioridade">Prioridad:</label>
            <input type="text" id="prioridade" name="prioridade" required>
        </div>
        <div>
            <label for="cod_alerta">Cod. Alerta:</label>
            <input type="text" id="cod_alerta" name="cod_alerta" required>
        </div>
        <div>
            <label for="quando">Cuándo:</label>
            <input type="datetime-local" id="quando" name="quando" required>
        </div>
        <div>
            <label for="modulo">Módulo:</label>
            <input type="text" id="modulo" name="modulo" required>
        </div>
        <div>
            <label for="item">Item:</label>
            <input type="text" id="item" name="item" required>
        </div>
        <div>
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" required>
        </div>
        <div>
            <label for="descricao">Descripción:</label>
            <textarea id="descricao" name="descricao" required></textarea>
        </div>
        <div>
            <label for="analista">Analista:</label>
            <input type="text" id="analista" name="analista" required>
        </div>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>