<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/banco/sqlcommand.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/banco/sqldatareader.php";

class ShowAlerta extends modulo {
    
    
    public $data;
    
    public function __construct() {
        
        parent::__construct();
        
        
        $this->name  = "ShowAlerta";
        $this->sigla = "Alerta";
        $this->icone = "fas fa-exclamation-circle";
        
    }
    
    public function get_data() {
        require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/banco/conecta.php";
        
        $hora = date('G');
        
        $Sql = new SqlCommand("Sql");
        $Sql->connection = $conexao;
        $Sql->query = "select md5('hgtk'||cod_alerta::varchar) id_alerta,* from alerta left outer join modulo on alerta.cod_modulo = modulo.cod_modulo "
                . "left outer join usuario on alerta.cod_usuario = usuario.cod_usuario "
                . "where fechamento is null ";
        $dr = $Sql->ExecuteReader();
        
        $this->data = $dr;
        
        
    }
    

    
    public function front_call() {
        parent::front_call();
    
        echo <<<EOT1
        function form_alerta(id_alerta) {
            alert(id_alerta); 
        }
        function openEditForm(codAlert) {
            // Aquí puedes generar el contenido del formulario
            var formulario = "<form>";
            formulario += "Código de alerta: <input type='text' value='" + codAlert + "'><br>";
            formulario += '<div class="row">';
            formulario += '   <div class="col"><label for="exampleInputEmail1">Data da Alerta</label>';
            formulario += '       <input type="date" name="data_da_alerta" id="data_da_alerta" required>';
            formulario += '   </div>';
            formulario += '   <div class="col">';
            formulario += '       <label for="exampleInputPassword1">Hora da Alerta (24h)</label>';
            formulario += '       <input type="time" name="hora_da_alerta" id="hora_da_alerta" required>';
            formulario += "   </div>";
            formulario += "</div>";
    
            // Agrega más campos al formulario según tus necesidades
            formulario += "</form>";
    
            // Muestra el formulario en un modal
            $('#modalEdita .modal-body').html(formulario);
            $('#modalEdita').modal('show');
        }
        EOT1;
    }
    
    public function back_call() {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        if ($hora > 19 || $hora < 6) 
            $dark = "dark";
        else 
            $dark = "";
    
        $this->get_data();
    
        echo <<<EOT
    
        <div class='xcard $dark' style='width:90%'>
            <div >
                <header class=r'card-header'>
                    <font color=black>Alertas</font><br>
                </header>
                <div class='card-content'>
                    <table class="table-alertas" width=100%>
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
            echo "<td><img src='/images/icon_edit.png' alt='edit' data-id='$o->cod_alerta'></td>";
            echo "</tr>";
        }
    
        echo "</table></div></div></div>";
    }
    
    
//     public function back_call() {
//         date_default_timezone_set ("America/Sao_Paulo");
//         $hora = date('G');
//         if($hora > 19 || $hora < 6 ) 
//             $dark = "dark";
//         else 
//         	$dark = "";
        

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

//        while($o=$this->data->GetObject()) {
//            print "<tr>";
//            print "<td><span onclick=form_alerta('$o->id_alerta')>...</span></td>";
//            print "<td>$o->prioridade</td>";
//            print "<td>$o->cod_alerta</td>";
//            print "<td>$o->quando</td>";
//            print "<td>$o->modulo</td>";
//            print "<td>$o->item</td>";
//            print "<td>$o->valor</td>";
//            print "<td>$o->descricao</td>";
//            print "<td>$o->nome</td>";
//            echo "<td onclick=\"openEditForm('$o->cod_alerta')\"><img src='/images/icon_edit.png' alt='edit'></td>";
//            print "</tr>";
            
//        }


//     }
}

$show = new ShowAlerta();

if(isset($_GET['back']))
    $show->back_call();