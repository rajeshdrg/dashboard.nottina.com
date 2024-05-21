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

            <h2>Atualizar Alerta</h2>
            <form id="editForm" method="post">
                <!--Adicione um campo oculto para o código de alerta-->
                <input type="hidden" id="cod_usuario" name="cod_usuario" value="<?php echo $_GET['cod_usuario']; ?>">
                <input type="hidden" id="cod_alerta" name="cod_alerta" value="<?php echo $_GET['cod_alerta']; ?>">
                <div class="input-block">
                    <label for="analista">Analista:</label>
                    <select id="analista" name="analista" required>
                        <option value="">Selecione um analista</option>
                    </select>
                </div>
                <div class="input-block">
                    <label for="fechamento">Fechamento:</label>
                    <input type="date" id="fechamento" name="fechamento" required>
                </div>
                <button type="submit" class="btn-submit">Enviar</button>
            </form>
        </div>
    </div>
    <script src="/ShowAlerta/editForm.js"></script>
</body>

</html>