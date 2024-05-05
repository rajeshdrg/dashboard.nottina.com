<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ShowAlerta/editForm.css">
    <title>Editar Alerta</title>

</head>

<body>
    <!--=================================
           HEADER DESKTOP
   ===================================-->
    <div class="topo">
        <div style="width: 2%;height: 100%; float: left;">
            <button class="header_back" onclick="voltar();" style="margin:36px auto auto 8px; font-size: 15pt;">
                <i class="fa fa-arrow-left" style="color:#003366"></i>
            </button>
        </div>
        <div style="width: 30%;height: 100%; float: left;">
            <img src="images/nottina.png" style="margin:auto auto auto 12px; width: 250px; height: 85px;" />
        </div>
        <div style="width: 68%;height: 100%; float: left;">
            <a id="btnSair" href="sair.php" class="headerUser" style="width: 35px; height: 35px;margin-top: 50px;"><img
                    src="images/logout_small.png"></a>
            <h4 class="headerUser"><?php print $nome; ?></h4>
        </div>
    </div>


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