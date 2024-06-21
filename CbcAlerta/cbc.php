<?php

class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception();
        }

        $this->file = $file;
        $this->get_data();
    }

    private function get_data()
    {
        // echo "<script>console.log('Carregando dados XML do arquivo: {$this->file}');</script>";

        //Lê a data de modificação do arquivo
        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

        // Lẽ o conteudo do arquivo XML
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro: não foi possível ler o arquivo XML");
        }

        // Intentar carregar o XML
        libxml_use_internal_errors(true); // Habilitar errores libxml
        $this->xml = simplexml_load_string($xmlstr);

        if ($this->xml === false) {
            $errors = libxml_get_errors();
            throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
        }

        echo "<script>console.log('Dados XML carregados com sucesso');</script>";
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        echo "<script>console.log('Mostrando dados XML');</script>";
        echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
        echo "<header class='card-header'>";
        echo "<b>CBC</b><br>";
        echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
        echo "</header>";
        echo "<div class='card-content'>";
        echo "<table class='table table-striped'>"; // Utilizando uma tabela para organizar os dados

        echo "<thead>";
        echo "<tr>";
        echo "<th>Operadora</th>";
        echo "<th>Estado/Região</th>";
        echo "<th>MME/AMF</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        // Mostrar os dados do XML
        foreach ($this->xml->cbcAlerta as $alerta) {
            $cbcAlerta_operadora = (string) $alerta->cbcAlerta_operadora;
            $estado = (string) $alerta->estado;
            $status = (string) $alerta->status;
            $test_done = (string) $alerta->test_done;
            $routing = (string) $alerta->routing;
            $mme_amf = isset($alerta->mme) ? (string) $alerta->mme : (string) $alerta->tecnologia->amf;
            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            echo "<tr>";
            echo "<td>" . htmlspecialchars($cbcAlerta_operadora) . "</td>";
            echo "<td>" . htmlspecialchars($estado) . "</td>";
            echo "<td>" . htmlspecialchars($mme_amf) . "</td>";
            echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($status) . "</td>";
            echo "<td>" . htmlspecialchars($test_done) . "</td>";
            echo "<td>" . htmlspecialchars($routing) . "</td>";
            echo "</tr>";

            // Verificar si hay subgrupo de tecnologia
            if (isset($alerta->tecnologia)) {
                $tipo = (string) $alerta->tecnologia->tipo;
                $amf = (string) $alerta->tecnologia->amf;
                $status_tecnologia = (string) $alerta->tecnologia->status;
                $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
                $routing_tecnologia = (string) $alerta->tecnologia->routing;
                $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

                echo "<tr>";
                echo "<td>" . htmlspecialchars($cbcAlerta_operadora) . " (Tecnologia $tipo)</td>";
                echo "<td>" . htmlspecialchars($estado) . "</td>";
                echo "<td>" . htmlspecialchars($amf) . "</td>";
                echo "<td style='color:$color_tecnologia; font-weight:bold;'>" . htmlspecialchars($status_tecnologia) . "</td>";
                echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
                echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";

        echo "</table>"; // Fechando a tabela

        echo "</div>";
        echo "</div>";
    }


}

