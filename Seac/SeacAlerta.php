<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";

class SeacAlerta
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

        $al = new alerta();
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

        /*	if($this->xml->quantidade > 2780 ) {
                $quantidade = intval($this->xml->quantidade);
                        $al->registra("seac", 'Seac', $this->file_date, "Novo Alerta: $quantidade", 1, 1);
            }
         */
    }

    public function ShowMe()
    {
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        if ($hora > 19 || $hora < 6)
            $dark = "dark";
        else
            $dark = "";

        print "<div class='card $dark'>";
        print "<header class=r'card-header'>";
        print "<b>SEaC - Alertas</b><br>";
        print "<span> Atualização $this->file_date</span>";
        print "</header>";
        print "<div class='card-content'>";

        foreach ($this->xml->alerta as $al) {

            print '<div class="avatar"><div style="background-color:gray;color:white">' . (string) $al->cobrade . '</div></div>';
            print "<div class='messages_tv $dark'>";
            print "<p>" . (string) $al->evento . "</p>";
            print "<p>Id: $al->id </p>";
            print "<p>";
            if ($al->claro == 0)
                print "<font color=red>Claro</font> ";
            else
                print "<font color=green>Claro</font> ";

            if ($al->vivo == 0)
                print "<font color=red>Vivo</font> ";
            else
                print "<font color=green>Vivo</font> ";

            if ($al->oi == 0)
                print "<font color=red>Oi</font> ";
            else
                print "<font color=green>Oi</font> ";

            // if ($al->sky == 0)
            //     print "<font color=red>Sky</font> ";
            // else
            //     print "<font color=green>Sky</font> ";

            if ($al->nossa == 0)
                print "<font color=red>Nossa</font> ";
            else
                print "<font color=green>Nossa</font> ";
            print "</p>";

            print "<time datetime=" . $al->time . " style='color=black;'>" . substr($al->time, 8, 2) . '/' . substr($al->time, 5, 2) . '/' . substr($al->time, 0, 4) . " " . substr($al->time, 11, 5) . "</time>";

            print "</div>";

        }


        print "</div>";
        print "</div>";

    }

}


