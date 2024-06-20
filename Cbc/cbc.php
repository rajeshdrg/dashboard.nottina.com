<?php

class Cbc
{
    public $file;
    public $xml;
    public $file_date;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception("Erro: arquivo xml não encontrado");
        }
        $this->file = $file;
        $this->get_data();
    }

    public function get_data()
    {
        echo "<script>console.log('Loading XML data from file: {$this->file}');</script>";

        $this->file_date = date("d/m/Y H:i:s", filemtime($this->file));
        $xmlstr = file_get_contents($this->file);

        if ($xmlstr === false) {
            throw new Exception("Erro: não foi possível ler o arquivo xml");
        }

        try {
            $this->xml = new SimpleXMLElement($xmlstr);
            echo "<script>console.log('XML data loaded successfully');</script>";
        } catch (Exception $e) {
            throw new Exception("Erro: conteúdo xml inválido");
        }
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        $dark = ($hora > 19 || $hora < 6) ? "dark" : "";

        echo "<script>console.log('Showing XML data');</script>";
        echo "<div class='$dark' style='width:50%; margin: 20px auto;'>";
        echo "<header class='card-header'>";
        echo "<b>CBC - Alerta</b><br>";
        echo "<span>Atualização " . htmlspecialchars($this->file_date) . "</span>";
        echo "</header>";
        echo "<div class='card-content'>";

        foreach ($this->xml->cbcAlerta as $alerta) {
            $cbcAlerta_id = (string) $alerta->cbcAlerta_id;
            $status = (string) $alerta->status;
            $color = ($status === "ok") ? "green" : (($status === "fora") ? "red" : "black");

            echo "<p>";
            echo "<span style='display:inline-block; width:300px;'>";
            echo "<b>ID: " . htmlspecialchars($cbcAlerta_id) . "</b></span>";
            echo "<span style='display:inline-block; width:100px; color:$color;'>";
            echo "<b>Status: " . htmlspecialchars($status) . "</b></span>";
            echo "<span style='display:inline-block; width:100px;'>";
            echo "<b>Teste: " . htmlspecialchars((string) $alerta->test_done) . "</b></span>";
            echo "<span style='display:inline-block; width:100px;'>";
            echo "<b>Roteamento: " . htmlspecialchars((string) $alerta->routing) . "</b></span>";
            echo "</p>";
        }

        echo "</div>";
        echo "</div>";
    }
}
?>