<?php

// if ($_SERVER['DOCUMENT_ROOT'] == null)
//     $_SERVER['DOCUMENT_ROOT'] = "..";

// require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/Cbc/cbc.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
// class CbcAlerta extends modulo
// {
//     public $CbcFile; // Define $CbcFile property
//     public $CbcAlerta;

//     public function __construct()
//     {
//         parent::__construct();

//         $this->name = "Cbc";
//         $this->sigla = "CBC";
//         $this->icone = "fa fa-signal";

//         // trocar a ruta do arquivo do test
//         //$this->CbcFile = new Cbc("/dados/cap/status/wspre_cbc.xml"); 
//         $this->CbcFile = new Cbc($_SERVER["DOCUMENT_ROOT"] . "/Cbc/test.xml");

//         $this->CbcAlerta = new Alerta();


//     }

//     public function get_data()
//     {
//         $this->CbcFile->get_data();  //  obtener os dados do arquivo XML
//     }

//     public function front_call()
//     {
//         parent::front_call();
//     }

//     public function back_call()
//     {
//         $this->get_data();
//     }

//     public function ShowMe()
//     {

//         $this->CbcFile->ShowMe();  // Mostrar os dados diretamente
//     }
// }

// $cbcAlerta = new CbcAlerta();

// if (isset($_GET['back'])) {
//     $cbcAlerta->back_call();
//     $cbcAlerta->ShowMe();
// }




if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";



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
        $this->sigla = "CBC";
        $this->icone = "fa fa-signal";

        try {
            $this->CbcFile = new Cbc("/home/rajesh/dashboard.nottina.com/Cbc/test.xml");
            echo "<script>console.log('Cbc object created successfully');</script>";
        } catch (Exception $e) {
            echo "<script>console.error('Erro: " . $e->getMessage() . "');</script>";
        }
    }

    public function get_data()
    {
        $hora = date('G');
        echo "<script>console.log('Getting data...');</script>";
        foreach ($this->CbcAlerta as $sf) {
            echo "<script>console.log('Showing alert...');</script>";
            $this->CbcFile->ShowMe();
        }
    }

    public function front_call()
    {
        parent::front_call();
    }

    public function back_call()
    {
        echo "<script>console.log('Back call initiated');</script>";
        $this->get_data();
    }

    public function ShowMe()
    {
        echo "<script>console.log('Calling ShowMe method');</script>";
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        foreach ($this->CbcAlerta as $sf) {
            $this->CbcFile->ShowMe();
        }
    }
}

$cbcAlerta = new CbcAlerta();
echo "<script>console.log('Back parameter detected');</script>";
if (isset($_GET['back'])) {
    $cbcAlerta->back_call();
    $cbcAlerta->ShowMe();
}




