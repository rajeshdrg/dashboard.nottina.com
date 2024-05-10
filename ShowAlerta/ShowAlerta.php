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


        $this->name  = "ShowAlerta";
        $this->sigla = "Alerta";
        $this->icone = "fas fa-exclamation-circle";
    }

    public function get_data()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/banco/conecta.php";

        $hora = date('G');

        $Sql = new SqlCommand("Sql");
        $Sql->connection = $conexao;
        $Sql->query = "select md5('hgtk'||cod_alerta::varchar) id_alerta,* from alerta left outer join modulo on alerta.cod_modulo = modulo.cod_modulo "
            . "left outer join usuario on alerta.cod_usuario = usuario.cod_usuario "
            . "where fechamento is null ";
        $dr = $Sql->ExecuteReader();

        $this->data = $dr;
    }

    public function front_call()
    {
        parent::front_call();

        echo <<<EOT1
        function openEditForm(codAlert) {
            // URL del formulario de edición
            var editFormUrl = "/ShowAlerta/editForm.php?cod_alerta=" + codAlert;
            console.log('$this->name')
            // Hacer una petición AJAX para obtener el contenido del formulario de edición
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () =>  {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var editFormContent = xhr.responseText;
                    // Agregar el contenido del formulario de edición al cuerpo del modal
                    document.getElementById("myModal").innerHTML = editFormContent;
                    console.log(editFormContent);
                    // Mostrar el modal
                    document.getElementById("myModal").style.display = "block";
                } else if (xhr.readyState === 4 && xhr.status !== 200) {
                    // Manejar errores en caso de que la petición AJAX falle
                    alert("Error al cargar el formulario de edición.");
                }
            };
            xhr.open("GET", editFormUrl, true);
            xhr.send();
        }
        
        
       
        EOT1;
    }

    public function back_call()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        if ($hora > 19 || $hora < 6)
            $dark = "dark";
        else
            $dark = "";

        $this->get_data();

        echo <<<EOT
        <div class='xcard $dark' style='width:90%'>
            <div>
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
            echo "<td><button onclick=\"openEditForm('$o->cod_alerta')\" class='btn'><img src='/images/icon_edit.png' alt='edit'></button></td>";
            print "</tr>";
        }
    }
}

$show = new ShowAlerta();

if (isset($_GET['back']))
    $show->back_call();





    