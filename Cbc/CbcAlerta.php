<?php

if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Cbc/cbc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
class CbcAlerta extends modulo
{
    public $CbcFile; // Define $CbcFile property
    public $CbcAlerta;

    public function __construct()
    {
        parent::__construct();

        $this->name = "Cbc";
        $this->sigla = "CBC";
        $this->icone = "fa fa-signal";

        // trocar a ruta do arquivo do test
        //$this->CbcFile = new Cbc("/dados/cap/status/wspre_cbc.xml"); 
        $this->CbcFile = new Cbc($_SERVER["DOCUMENT_ROOT"] . "/Cbc/test.xml");
        $this->CbcAlerta = new Alerta();


    }

    public function get_data()
    {
        $hora = date('G');
        foreach ($this->CbcAlerta as $sf) {
            $sf->get_data();
        }

        // $this->CbcFile->get_data();  //  obtener os dados do arquivo XML
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
            $sf->ShowMe();
            echo $sf;
        }

        // $this->CbcFile->ShowMe();  // Mostrar os dados diretamente
    }
}

$cbcAlerta = new CbcAlerta();

if (isset($_GET['back'])) {
    $cbcAlerta->back_call();
    $cbcAlerta->ShowMe();
}








