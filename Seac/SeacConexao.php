<?php

class SeacConexao
{

    public $file;
    public $xml;
    public $file_date;

    public function __construct($file)
    {

        $this->file = $file;

    }

    public function get_data()
    {
        $len = filesize($this->file);

        date_default_timezone_set("America/Sao_Paulo");
        $this->file_date = date("d/m/Y H:i:s.", filemtime($this->file));
        $arq = fopen($this->file, "r");
        if ($arq == null) {
            print "Erro: arquivo xml não encontrado<br>;";
            exit(0);
        }
        $xmlstr = fread($arq, $len);
        fclose($arq);

        $this->xml = new SimpleXMLElement($xmlstr);

    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        if ($hora > 19 || $hora < 6) {
            $dark = "dark";
        } else {
            $dark = "";
        }

        print "<div class='card $dark'>";
        print "<header class=r'card-header'>";
        print "<b>SEaC - Conexão</b><br>";
        print "<span> Atualização $this->file_date</span>";
        print "</header>";
        print "<div class='card-content'>";

        foreach ($this->xml->heartbeat as $hb) {

            if ($hb->operadora == "Sky") {
                continue;
            }

            print "<p>";

            if ($hb->status == "OK") {
                print "<span style='display:inline-block; width:90px;'><font color=green>";
            } else {
                print "<span style='display:inline-block; width:90px;'><font color=red>";
            }

            print "<b>" . $hb->operadora . "</b></span>";
            print "</font>";

            print "</p>";
        }

        print "</div>";

        print "</div>";

    }

}
