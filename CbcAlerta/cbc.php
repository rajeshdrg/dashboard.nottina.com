<?php
class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Erro: arquivo não encontrado.");
        }

        $this->file = $file;
        $this->get_data();
    }

    private function get_data()
    {
        // Lê a data de modificação do arquivo
        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

        // Lê o conteúdo do arquivo XML
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro: não foi possível ler o arquivo XML");
        }

        // Tentar carregar o XML
        libxml_use_internal_errors(true); // Habilitar erros libxml
        $this->xml = simplexml_load_string($xmlstr);

        if ($this->xml === false) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
            throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
        }
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        echo "<div class='$dark' style='width:80%; margin: 20px auto;'>";
        echo "<header class='card-header'>";
        echo "<b>CBC</b><br>";
        echo "<span>Última atualização: " . htmlspecialchars($this->file_date) . "</span>";
        echo "</header>";
        echo "<div class='card-content'>";

        // Mostrar dados do MME
        $this->showMMETable();

        // Mostrar dados de tecnologia 5G
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
        echo "<th>Ação</th>"; // Columna para el ícono de edición
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($this->xml->cbcAlerta as $alerta) {
            $estado = (string) $alerta->estado;
            $operadora = (string) $alerta->cbcAlerta_operadora;
            $mme = isset($alerta->mme) ? (string) $alerta->mme : '';
            $status = (string) $alerta->status;
            $test_done = (string) $alerta->test_done;
            $routing = (string) $alerta->routing;

            if (empty($mme) && empty($status) && empty($test_done) && empty($routing)) {
                continue;
            }

            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            echo "<tr>";
            echo "<td>" . htmlspecialchars($estado) . "</td>";
            echo "<td>" . htmlspecialchars($operadora) . "</td>";
            echo "<td>" . htmlspecialchars($mme) . "</td>";
            echo "<td style='color:$color; font-weight:bold;'>" . htmlspecialchars($status) . "</td>";
            echo "<td>" . htmlspecialchars($test_done) . "</td>";
            echo "<td>" . htmlspecialchars($routing) . "</td>";

            // Agregar ícono de edición si el status es "fora"
            if ($status === "fora") {
                echo "<td><a href=\"/CbcAlerta/cbcEditForm.php?id={$alerta['id']}\" class='btn'><img src='/images/icon_edit.png' alt='edit'></a></td>";
            } else {
                echo "<td></td>";
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
        echo "<th>Operadora (5G)</th>";
        echo "<th>AMF</th>";
        echo "<th>Status</th>";
        echo "<th>Teste</th>";
        echo "<th>Roteamento</th>";
        echo "<th>Ação</th>"; // Columna para el ícono de edición
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($this->xml->cbcAlerta as $alerta) {
            if (isset($alerta->tecnologia)) {
                $estado = (string) $alerta->estado;
                $operadora = (string) $alerta->cbcAlerta_operadora;
                $tipo = (string) $alerta->tecnologia->tipo;
                $amf = (string) $alerta->tecnologia->amf;
                $status_tecnologia = (string) $alerta->tecnologia->status;
                $test_done_tecnologia = (string) $alerta->tecnologia->test_done;
                $routing_tecnologia = (string) $alerta->tecnologia->routing;

                if (empty($status_tecnologia) && empty($test_done_tecnologia) && empty($routing_tecnologia)) {
                    continue;
                }

                $color_tecnologia = ($status_tecnologia === "ok") ? "green" : (($status_tecnologia === "fora") ? "red" : "black");

                echo "<tr>";
                echo "<td>" . htmlspecialchars($estado) . "</td>";
                echo "<td>" . htmlspecialchars($operadora) . " ($tipo)</td>";
                echo "<td>" . htmlspecialchars($amf) . "</td>";
                echo "<td style='color:$color_tecnologia; font-weight:bold;'>" . htmlspecialchars($status_tecnologia) . "</td>";
                echo "<td>" . htmlspecialchars($test_done_tecnologia) . "</td>";
                echo "<td>" . htmlspecialchars($routing_tecnologia) . "</td>";

                // Agregar ícono de edición si el status de la tecnología es "fora"
                if ($status_tecnologia === "fora") {
                    echo "<td><a href=\"/CbcAlerta/cbcEditForm.php?id={$alerta['id']}\" class='btn'><img src='/images/icon_edit.png' alt='edit'></a></td>";
                } else {
                    echo "<td></td>";
                }

                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
    }
}

