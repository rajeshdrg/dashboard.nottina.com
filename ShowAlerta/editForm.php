<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Edición</title>

    
    <!-- Estilos personalizados para este formulario -->
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">

</head>

<body>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Formulario de Edición</h2>
            <form>
                <label for="prioridad">Prioridad:</label>
                <input type="text" id="prioridad" name="prioridad"><br><br>
                <label for="cod_alerta">Código de Alerta:</label>
                <input type="text" id="cod_alerta" name="cod_alerta"><br><br>
                <!-- Agrega más campos según tus necesidades -->
                <input type="submit" value="Guardar">
            </form>
        </div>
    </div>

    
</body>

</html>