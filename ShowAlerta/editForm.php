<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta</title>
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <link rel="stylesheet" href="/ShowAlerta/editForm.js">
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
                <!-- Adicione um campo oculto para o código de alerta -->
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

    
</body>
</html>
