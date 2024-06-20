<?php

class Cbc
{
    private $file;
    private $xml;
    private $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Erro: arquivo XML não encontrado");
        }

        $this->file = $file;
        $this->get_data();
    }

    private function get_data()
    {
        echo "<script>console.log('Loading XML data from file: {$this->file}');</script>";

        // Leer la fecha de modificación del archivo
        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));

        // Leer el contenido del archivo XML
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro: não foi possível ler o arquivo XML");
        }

        // Intentar cargar el XML
        libxml_use_internal_errors(true); // Habilitar errores libxml
        $this->xml = simplexml_load_string($xmlstr);

        if ($this->xml === false) {
            $errors = libxml_get_errors();
            throw new Exception("Erro: conteúdo XML inválido. Detalhes: " . implode(", ", $errors));
        }

        echo "<script>console.log('XML data loaded successfully');</script>";
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        print "<script>console.log('Showing XML data');</script>";
        print "<div class='$dark' style='width:50%; margin: 20px auto;'>";
        print "<header class='card-header'>";
        print "<b>CBC - Alerta</b><br>";
        print "<span>Atualização " . htmlspecialchars($this->file_date) . "</span>";
        print "</header>";
        print "<div class='card-content'>";

        // Mostrar los datos del XML
        foreach ($this->xml->cbcAlerta as $alerta) {
            $cbcAlerta_id = (string) $alerta->cbcAlerta_id;
            $status = (string) $alerta->status;
            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            print "<p>";
            print "<span style='display:inline-block; width:300px;'>";
            print "<b>ID: " . htmlspecialchars($cbcAlerta_id) . "</b></span>";
            print "<span style='display:inline-block; width:100px; color:$color;'>";
            print "<b>Status: " . htmlspecialchars($status) . "</b></span>";
            print "<span style='display:inline-block; width:100px;'>";
            print "<b>Teste: " . htmlspecialchars((string) $alerta->test_done) . "</b></span>";
            print "<span style='display:inline-block; width:100px;'>";
            print "<b>Roteamento: " . htmlspecialchars((string) $alerta->routing) . "</b></span>";
            print "</p>";
        }

        print "</div>";
        print "</div>";
    }
}


