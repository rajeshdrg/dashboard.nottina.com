<?php

if($_SERVER['DOCUMENT_ROOT']==null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";

class GuardarEdicion {
    
    public $conexao;

    function __construct() {
        require $_SERVER['DOCUMENT_ROOT'].'/erpme/banco/conecta.php';
        $this->conexao = $conexao;
    }
    
    function guardarEdicion($codAlerta, $prioridade, $quando, $modulo, $item, $valor, $descricao, $analista) {
        // Actualizar la entrada correspondiente en la base de datos de alertas
        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $this->conexao;
        
        // Aquí debes escribir las consultas SQL necesarias para insertar los datos del formulario en la base de datos.
        // Asumiendo que estás insertando nuevos registros en lugar de actualizar, el SQL sería algo como esto:
        $Sql->query = "INSERT INTO alerta (cod_alerta, prioridade, quando, modulo, item, valor, descricao, analista) 
                       VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $Sql->params = array($codAlerta, $prioridade, $quando, $modulo, $item, $valor, $descricao, $analista);
        $Sql->Execute();
        
        
        
        // Redireccionar a la página de visualización de alertas
        header("Location: /ShowAlerta.php");
        exit();
    }
}

// Instanciar la clase y llamar a la función guardarEdicion con los datos del formulario
$guardarEdicion = new GuardarEdicion();
if(isset($_POST['cod_alerta'])) {
    $guardarEdicion->guardarEdicion(
        $_POST['cod_alerta'],
        $_POST['prioridade'],
        $_POST['quando'],
        $_POST['modulo'],
        $_POST['item'],
        $_POST['valor'],
        $_POST['descricao'],
        $_POST['analista']
    );
}






//     public function front_call()
//     {
//         parent::front_call();

//         echo <<<EOT1
//         function form_alerta(id_alerta) {
//             alert(id_alerta); 
//         }

//          function openEditForm(codAlert) {

//             // URL del formulario de edición
//             var editFormUrl = "/ShowAlerta/editForm.php?cod_alerta=" + codAlert;


            
//              // Abrir la ventana emergente con el formulario de edición
//             // var popup = window.open(editFormUrl, "Editar Alerta", "width=500,height=400");
            
//              // Verificar si la ventana emergente fue bloqueada por el navegador
//              if (!popup || popup.closed || typeof popup.closed == 'undefined') {
//                  alert("La ventana emergente fue bloqueada por el navegador. Asegúrate de habilitar las ventanas emergentes para este sitio.");
//             }
//         }
//         EOT1;
//     }

//     public function back_call()
//     {
//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         if ($hora > 19 || $hora < 6)
//             $dark = "dark";
//         else
//             $dark = "";


//         $this->get_data();


//         echo <<<EOT

//         <div class='xcard $dark' style='width:90%'>
//             <div >
//                 <header class=r'card-header'>
//                     <font color=black>Alertas</font><br>
//                 </header>
//                 <div class='card-content'>
//                     <table width=100%>
//                         <tr>
//                             <td><b></b></td>
//                             <td><b>Prioridade</b></td>
//                             <td><b>Cod.Alerta</b></td>
//                             <td><b>Quando</b></td>
//                             <td><b>Módulo</b></td>
//                             <td><b>Item</b></td>
//                             <td><b>Valor</b></td>
//                             <td><b>Descrição</b></td>
//                             <td><b>Analista</b></td>
//                         </tr>
// EOT;

//         while ($o = $this->data->GetObject()) {
//             print "<tr>";
//             print "<td><span onclick=form_alerta('$o->id_alerta')>...</span></td>";
//             print "<td>$o->prioridade</td>";
//             print "<td>$o->cod_alerta</td>";
//             print "<td>$o->quando</td>";
//             print "<td>$o->modulo</td>";
//             print "<td>$o->item</td>";
//             print "<td>$o->valor</td>";
//             print "<td>$o->descricao</td>";
//             print "<td>$o->nome</td>";
//             echo "<td onclick=\"openEditForm('$o->cod_alerta')\"><img src='/images/icon_edit.png' alt='edit'></td>";
//             print "</tr>";
//         }
        
//     }