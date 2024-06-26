<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBC</title>
    <!-- <link rel="stylesheet" href="path/to/your/css/styles.css"> Ruta a tu archivo CSS -->
    <script src="/home/rajesh/dashboard.nottina.com/CbcAlerta/cbc.js" defer></script>
    <!-- Ruta a tu archivo JavaScript -->
</head>

<body>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/CbcAlerta/cbc.php";

    try {
        $cbc = new Cbc($_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/cbcRelatorio.xml"); // Ruta a tu archivo XML
        $cbc->showMe();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
    ?>
</body>

</html>



<?php
// Se o DOCUMENT_ROOT não estiver definido, atribui um valor padrão
if (!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT'] == null) {
    $_SERVER['DOCUMENT_ROOT'] = "..";
}

// Inclui os arquivos necessários
require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/CbcAlerta/cbc.php";

class CbcAlerta extends modulo
{
    public $CbcFile; // Propriedade para armazenar o objeto Cbc

    public function __construct()
    {
        parent::__construct();

        $this->name = "CbcAlerta";
        $this->sigla = "CBC";
        $this->icone = "fa fa-signal";

        try {

            // trocar a ruta do arquivo do test
            //$this->CbcFile = new Cbc("/dados/cap/status/wspre_cbc.xml"); 

            // Cria uma instância de Cbc e atribui a $CbcFile
            // Substitui a rota do arquivo pelo uso de $_SERVER['DOCUMENT_ROOT']

            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/CbcAlerta/cbcRelatorio.xml";
            $this->CbcFile = new Cbc($filePath);

            // echo "<script>console.log('Objeto Cbc criado com sucesso');</script>";
        } catch (Exception $e) {
            echo "<script>console.error('Erro: " . $e->getMessage() . "');</script>";
        }
    }

    // Método para obter dados do objeto Cbc
    public function get_data()
    {
        // echo "<script>console.log('Obtendo dados...');</script>";
        try {
            // Chama o método get_data de Cbc (ajustar conforme a implementação de Cbc)
            // $this->CbcFile->get_data();
        } catch (Exception $e) {
            echo "<script>console.error('Erro ao obter dados: " . $e->getMessage() . "');</script>";
        }
    }

    // Método de chamada frontal (front-end)
    public function front_call()
    {
        parent::front_call(); // Chama o método front_call da classe pai
    }

    // Método de chamada de retorno (back-end)
    public function back_call()
    {
        // echo "<script>console.log('Chamada de retorno iniciada');</script>";
        $this->get_data(); // Chama o método get_data para obter os dados do Cbc
    }

    // Método para mostrar os dados do objeto Cbc
    public function ShowMe()
    {
        // echo "<script>console.log('Chamando método ShowMe');</script>";
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        // Chama o método ShowMe de Cbc (ajustar conforme a implementação de Cbc)
        $this->CbcFile->ShowMe();
    }
}

// Cria uma instância de CbcAlerta
$cbcAlerta = new CbcAlerta();

// Se o parâmetro 'back' estiver presente na URL, chama os métodos back_call e ShowMe
if (isset($_GET['back'])) {
    // echo "<script>console.log('Parâmetro back detectado');</script>";
    $cbcAlerta->back_call();
    $cbcAlerta->ShowMe();
}

