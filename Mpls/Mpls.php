<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/alerta/alerta.php";

class Mpls extends modulo {

    public $xmlc;

    public function __construct() {
        parent::__construct();
        $this->name  = "Mpls";
        $this->sigla = "MPLS";
        $this->icone = "fab fa-mixcloud";
    }
   public function ShowMe() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 )
            $dark = "dark";
        else
                $dark = "";
	require_once $_SERVER["DOCUMENT_ROOT"]."/Mpls/page.php"; 
    }
    public function back_call() {
        date_default_timezone_set ("America/Sao_Paulo");
        $hora = date('G');
        if($hora > 19 || $hora < 6 )
            $dark = "dark";
        else
                $dark = "";
        $this->ShowMe();
    }
}
$mpl = new Mpls();

if(isset($_GET['back']))
    $mpl->back_call();

?>
