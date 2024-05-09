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
    
                // URL del formulario de edición
                var editFormUrl = "/ShowAlerta/editForm.php?cod_alerta=" + codAlert;
    
    
                
                 // Abrir la ventana emergente con el formulario de edición
                var popup = window.open(editFormUrl, "Editar Alerta", "width=500,height=400");
                
                 // Verificar si la ventana emergente fue bloqueada por el navegador
                 if (!popup || popup.closed || typeof popup.closed == 'undefined') {
                     alert("La ventana emergente fue bloqueada por el navegador. Asegúrate de habilitar las ventanas emergentes para este sitio.");
                }
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
            echo "<td><button onclick='openEditForm(\"$o->cod_alerta\")' class='btn'><img src='/images/icon_edit.png' alt='edit'></button></td>";
            echo "</tr>";
        }
    }
}
print "
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
    
";

$show = new ShowAlerta();

if (isset($_GET['back']))
    $show->back_call();
