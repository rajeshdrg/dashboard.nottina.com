<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Cbc/cbc.php";

class CbcAlerta extends modulo
{
    public $CbcFile; // Define $CbcFile property
    public $CbcAlerta = []; // Initialize $CbcAlerta as an array

    public function __construct()
    {
        parent::__construct();

        $this->name = "Cbc";
        $this->sigla = "CBC Alerta";
        $this->icone = "fa fa-signal";

        // $this->CbcFile = new Cbc("/dados/cap/status/wspre_cbc.xml");
        $this->CbcFile = new Cbc("/Cbc/test.xml"); // Cambia "test.xml" por la ruta real de tu archivo XML

    }


    public function get_data()
    {
        $hora = date('G');
        foreach ($this->CbcAlerta as $sf) {
            $this->CbcFile->ShowMe();
            ;
        }
    }

    public function front_call()
    {
        parent::front_call();
    }

    public function back_call()
    {
        $this->get_data();
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        foreach ($this->CbcAlerta as $sf) {
            $this->CbcFile->ShowMe();
        }
    }
}

$cbcAlerta = new CbcAlerta();

if (isset($_GET['back'])) {
    $cbcAlerta->back_call();
    $cbcAlerta->ShowMe();
}
