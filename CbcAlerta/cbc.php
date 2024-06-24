<?php

// class Cbc
// {
//     private $file;
//     private $xml;
//     private $file_date;

//     public function __construct($file)
//     {
//         if (!file_exists($file)) {
//             throw new Exception("Erro: arquivo não encontrado.");
//         }

//         $this->file = $file;
//         $this->get_data();
//     }

//     private function get_data()
//     {
//         // echo "<script>console.log('Carregando dados XML do arquivo: {$this->file}');</script>";

//         // Lê a data de modificação do arquivo
//         $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

//         // Lê o conteúdo do arquivo XML
//         $xmlstr = file_get_contents($this->file);

//         if ($xmlstr === false) {
//             throw new Exception("Erro: não foi possível ler o arquivo XML");
//         }

//         // Tentar carregar o XML
//         libxml_use_internal_errors(true); // Habilitar erros libxml
//         $this->xml = simplexml_load_string($xmlstr);

//         if ($this->xml === false) {
//             $errors = libxml_get_errors();
//             libxml_clear_errors();
//             throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
//         }

//         // echo "<script>console.log('Dados XML carregados com sucesso');</script>";
//     }

//     public function ShowMe()
//     {
//         date_default_timezone_set("America/Sao_Paulo");
//         $hora = date('G');
//         $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

//         echo "<script>console.log('Mostrando dados XML');</script>";
//         echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
//         echo "<header class='card-header'>";
//         echo "<b>CBC</b><br>";
//         echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
//         echo "</header>";
//         echo "<div class='card-content'>";

//         // Mostrar dados de MME
//         $this->showMMETable();

//         // Mostrar dados de tecnologia 5G
//         $this->show5GTable();

//         echo "</div>";
//         echo "</div>";
//     }

//     private function showMMETable()
//     {
//         echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
//         echo "<caption>MME</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora</th>";
//         echo "<th>MME</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         // Agrupar dados por estado e operadora para MME
//         foreach ($this->xml->cbcAlerta as $alerta) {
//             $estado = (string) $alerta->estado;
//             $operadora = (string) $alerta->cbcAlerta_operadora;

//             $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
//             $status = (string) $alerta->status;
//             $test_done = (string) $alerta->test_done;
//             $routing = (string) $alerta->routing;

//             // Verifique se há dados em todos os campos
//             if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
//                 //los campos test_done y routing no seran verficado
//                 continue;
//             }

//             $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($estado) . "</td>";
//             echo "<td>" . htmlspecialchars($operadora) . "</td>";
//             echo "<td>" . htmlspecialchars($mme) . "</td>";
//             echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($status) . "</td>";
//             echo "<td>" . htmlspecialchars($test_done) . "</td>";
//             echo "<td>" . htmlspecialchars($routing) . "</td>";
//             echo "</tr>";
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }

//     private function show5GTable()
//     {
//         echo "<table class='table table-striped'>";
//         echo "<caption>Tecnologia 5G</caption>";
//         echo "<thead>";
//         echo "<tr>";
//         echo "<th>Estado/Região</th>";
//         echo "<th>Operadora (5G)</th>";
//         echo "<th>AMF</th>";
//         echo "<th>Status</th>";
//         echo "<th>Teste</th>";
//         echo "<th>Roteamento</th>";
//         echo "</tr>";
//         echo "</thead>";
//         echo "<tbody>";

//         // Agrupar dados por estado e operadora para tecnologia 5G
//         foreach ($this->xml->cbcAlerta as $alerta) {
//             if (isset($alerta->tecnologia)) {
//                 $estado = (string) $alerta->estado;
//                 $operadora = (string) $alerta->cbcAlerta_operadora;
//                 $tipo = (string) $alerta->tecnologia->tipo;
//                 $amf = (string) $alerta->tecnologia->amf;
//                 $status_tecnologia = (string) $alerta->tecnologia->status;
//                 $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
//                 $routing_tecnologia = (string) $alerta->tecnologia->routing;

//                 // Verifique se há dados em todas as áreas da tecnologia
//                 if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
//                     continue;
//                 }

//                 $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

//                 echo "<tr>";
//                 echo "<td>" . htmlspecialchars($estado) . "</td>";
//                 echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
//                 echo "<td>" . htmlspecialchars($amf) . "</td>";
//                 echo "<td style='color:$color_tecnologia; font-weight:bold;'>" . htmlspecialchars($status_tecnologia) . "</td>";
//                 echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
//                 echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
//                 echo "</tr>";
//             }
//         }

//         echo "</tbody>";
//         echo "</table>";
//     }
// }






class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Arquivo não encontrado.");
        }

        $this->file = $file;
        $this->get_data();
    }

    private function get_data()
    {
        //Lê a data de modificação do arquivo
        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

        // Lẽ o conteudo do arquivo XML
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro ao ler o arquivo XML.");
        }

        // Tentar carregar o XML
        libxml_use_internal_errors(true); // Habilitar erros libxml
        $this->xml = simplexml_load_string($xmlstr);

        if ($this->xml === false) {
            $errors = libxml_get_errors();
            throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
        }

        echo "<script>console.log('Dados XML carregados com sucesso.');</script>";
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        echo "<script>console.log('Mostrando dados XML.');</script>";
        echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
        echo "<header class='card-header'>";
        echo "<b>CBC</b><br>";
        echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
        echo "</header>";
        echo "<div class='card-content'>";

        // Mostrar tabela de MME
        $this->showMMETable();

        // Mostrar tabela de tecnologia 5G
        $this->show5GTable();

        echo "</div>";
        echo "</div>";
    }

    private function showMMETable()
    {
        echo "<table class='table table-striped' style='margin-bottom: 20px;'>";
        echo "<caption>MME</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Estado/Região</th>";
        echo "<th>Operadora</th>";
        echo "<th>MME</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Agrupar dados por estado e operadora para MME
        foreach ($this->xml->cbcAlerta as $alerta) {
            $estado = (string) $alerta->estado;
            $operadora = (string) $alerta->cbcAlerta_operadora;
            $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
            $status = (string) $alerta->status;
            $test_done = (string) $alerta->test_done;
            $routing = (string) $alerta->routing;

            // Verificar se há dados em todos os campos
            if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
                continue;
            }

            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            echo "<tr>";
            echo "<td>" . htmlspecialchars($estado) . "</td>";
            echo "<td>" . htmlspecialchars($operadora) . "</td>";
            echo "<td>" . htmlspecialchars($mme) . "</td>";
            echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($status) . "</td>";

            // Mostrar "Teste" y "Roteamento" en modo editable solo cuando el Status sea "fora"
            if ($status === "fora") {
                echo "<td contenteditable='true'>" . htmlspecialchars($test_done) . "</td>";
                echo "<td contenteditable='true'>" . htmlspecialchars($routing) . "</td>";
            } else {
                echo "<td>" . htmlspecialchars($test_done) . "</td>";
                echo "<td>" . htmlspecialchars($routing) . "</td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    private function show5GTable()
    {
        echo "<table class='table table-striped'>";
        echo "<caption>Tecnologia 5G</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Estado/Região</th>";
        echo "<th>Operadora (Tecnologia 5G)</th>";
        echo "<th>AMF</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Agrupar dados por estado e operadora para tecnologia 5G
        foreach ($this->xml->cbcAlerta as $alerta) {
            if (isset($alerta->tecnologia)) {
                $estado = (string) $alerta->estado;
                $operadora = (string) $alerta->cbcAlerta_operadora;
                $tipo = (string) $alerta->tecnologia->tipo;
                $amf = (string) $alerta->tecnologia->amf;
                $status_tecnologia = (string) $alerta->tecnologia->status;
                $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
                $routing_tecnologia = (string) $alerta->tecnologia->routing;

                // Verificar se há dados em todas as áreas da tecnologia
                if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
                    continue;
                }

                $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

                echo "<tr>";
                echo "<td>" . htmlspecialchars($estado) . "</td>";
                echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
                echo "<td>" . htmlspecialchars($amf) . "</td>";
                echo "<td style='color:$color_tecnologia; font-weight:bold;'>" . htmlspecialchars($status_tecnologia) . "</td>";

                // Mostrar "Teste" y "Roteamento" en modo editable solo cuando el Status sea "fora"
                if ($status_tecnologia === "fora") {
                    echo "<td contenteditable='true'>" . htmlspecialchars($test_done_tecnologia) . "</td>";
                    echo "<td contenteditable='true'>" . htmlspecialchars($routing_tecnologia) . "</td>";
                } else {
                    echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
                    echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
                }

                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
    }
}
