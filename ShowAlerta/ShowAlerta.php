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
            $('#cod_alerta').val(' + codAlert + ');
            $('#myModal').modal('show');
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
            <div>
                <header class='card-header'>
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
            echo "<tr>";
            echo "<td><span onclick='form_alerta(\"$o->id_alerta\")'>...</span></td>";
            echo "<td>$o->prioridade</td>";
            echo "<td>$o->cod_alerta</td>";
            echo "<td>$o->quando</td>";
            echo "<td>$o->modulo</td>";
            echo "<td>$o->item</td>";
            echo "<td>$o->valor</td>";
            echo "<td>$o->descricao</td>";
            echo "<td>$o->nome</td>";
            echo "<td><button onclick='openEditForm(\"$o->cod_alerta\")' class='btn'><img src='/images/icon_edit.png' alt='edit'></button></td>";
            echo "</tr>";
        }

        echo <<<EOT
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class='modal fade' id='myModal' role='dialog'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <h4 class='modal-title'>Editar Alerta</h4>
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
                            <button type='submit' class='btn btn-primary'>Guardar Cambios</button>
                        </form>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        EOT;
    }
}

$show = new ShowAlerta();

if (isset($_GET['back']))
    $show->back_call();
