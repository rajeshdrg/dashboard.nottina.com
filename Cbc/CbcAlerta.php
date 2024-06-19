<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Cbc/cbc.php";

class CbcAlerta extends modulo
{
    public $CbcFile; // Define $CbcFile property

    public function __construct()
    {
        parent::__construct();

        $this->name = "Cbc";
        $this->sigla = "CBC Alerta";
        $this->icone = "fa fa-signal";

        // trocar a ruta do arquivo de test
        $this->CbcFile = new Cbc($_SERVER["DOCUMENT_ROOT"] . "/Cbc/test.xml");
    }

    public function get_data()
    {
        $this->CbcFile->get_data();  //  obtener os dados do arquivo XML
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
        $this->CbcFile->ShowMe();  // Mostrar os dados diretamente
    }
}

$cbcAlerta = new CbcAlerta();

if (isset($_GET['back'])) {
    $cbcAlerta->back_call();
    $cbcAlerta->ShowMe();
}



// require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "/Cbc/cbc.php";

// class CbcAlerta extends modulo
// {
//     public $CbcFile; // Define $CbcFile property

//     public function __construct()
//     {
//         parent::__construct();

//         $this->name = "Cbc";
//         $this->sigla = "CBC Alerta";
//         $this->icone = "fa fa-signal";

//         $this->CbcFile = new Cbc("/dados/cap/status/wspre_cbc.xml");
//     }

//     public function get_data()
//     {
//         foreach ($this->CbcFile as $cbcFile) {
//             $cbcFile->get_data();
//         }

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

//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         if ($hora > 19 || $hora < 6)
//             $dark = "dark";
//         else
//             $dark = "";


//         foreach ($this->CbcFile as $cbc) {
//             $cbc->ShowMe();
//         }
//     }
// }

// $cbcAlerta = new CbcAlerta();

// if (isset($_GET['back'])) {
//     $cbcAlerta->back_call();
//     $cbcAlerta->ShowMe();
// }





