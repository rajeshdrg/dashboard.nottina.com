<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/sqldatareader.php";

class ShowAlerta extends modulo
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->name = "ShowAlerta";
        $this->sigla = "Alerta";
        $this->icone = "fas fa-exclamation-circle";
    }

    public function get_data()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/conecta.php";

        $Sql = new SqlCommand("Sql");
        $Sql->connection = $conexao;
        $Sql->query = "SELECT md5('hgtk'||cod_alerta::varchar) id_alerta, * FROM alerta LEFT OUTER JOIN modulo ON alerta.cod_modulo = modulo.cod_modulo LEFT OUTER JOIN usuario ON alerta.cod_usuario = usuario.cod_usuario WHERE fechamento IS NULL ";
        $dr = $Sql->ExecuteReader();
        $this->data = $dr;
    }

    public function front_call()
    {
        parent::front_call();

        echo <<<EOT1
        function form_alerta(id_alerta) {
            alert(id_alerta); 
        }

        function openEditForm(codAlert) {
        //    // Obtener el modal
        // var modal = document.getElementById("myModal");

        // // Abrir el modal
        // $('#myModal').modal('show');

        // // Agregar el código del alerta al formulario de edición
        // $('#cod_alerta').val(codAlert);
            

                // Obtiene la ventana modal y el botón de cerrar
        var modal = document.getElementById("myModal");
        var closeBtn = document.getElementsByClassName("close")[0];

        // Abre la ventana modal cuando se hace clic en el botón
        function openModal() {
            modal.style.display = "block";
        }

        // Cierra la ventana modal cuando se hace clic en el botón de cerrar
        closeBtn.onclick = function () {
            modal.style.display = "none";
        }

        // Cierra la ventana modal cuando se hace clic fuera de ella
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Envía el formulario al servidor
        var form = document.getElementById("editForm");
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Evita que se recargue la página al enviar el formulario

            // Aquí puedes agregar el código para enviar los datos del formulario al servidor utilizando AJAX
            // Por ejemplo, puedes usar fetch() o XMLHttpRequest
        });
         }
        EOT1;
    }

    public function back_call()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        $this->get_data();

    echo <<<EOT

         <div class='xcard $dark' style='width:90%'>
            <div >
            <header class=r'card-header'>
                <font color=black>Alertas</font><br>
            </header>
            <div class='card-content'>
                <table width=100%>
                    <tr>
                        <td><b></b></td>
                        <td><b>Prioridade</b></td>
                        <td><b>Cod.Alerta</b></td>
                        <td><b>Quando</b></td>
                        <td><b>Módulo</b></td>
                        <td><b>Item</b></td>
                        <td><b>Valor</b></td>
                        <td><b>Descrição</b></td>
                        <td><b>Analista</b></td>
                    </tr>
        EOT;

        while ($o = $this->data->GetObject()) {
            print "<tr>";
            print "<td><span onclick=form_alerta('$o->id_alerta')>...</span></td>";
            print "<td>$o->prioridade</td>";
            print "<td>$o->cod_alerta</td>";
            print "<td>$o->quando</td>";
            print "<td>$o->modulo</td>";
            print "<td>$o->item</td>";
            print "<td>$o->valor</td>";
            print "<td>$o->descricao</td>";
            print "<td>$o->nome</td>";
            echo "<td onclick=\"openEditForm('$o->cod_alerta')\"><img src='/images/icon_edit.png' alt='edit'></td>";
            print "</tr>";
        }
    }
}


$show = new ShowAlerta();

if (isset($_GET['back']))
    $show->back_call();
