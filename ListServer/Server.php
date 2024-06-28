<?php


if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER["DOCUMENT_ROOT"] . "/ListServer/Disk.php";

class Server
{


    public $hostname;
    public $file;
    public $disks;
    public $atz;
    public $memory_percent;
    public $status;
    public $file_date;
    public $diff;
    public function __construct($file)
    {

        $this->file = $file;
    }


    public function get_data()
    {
        date_default_timezone_set("America/Sao_Paulo");

        $file = $this->file;
        $len = filesize($file);
        $arq = fopen($file, "r");
        if ($arq == null) {
            print "Erro: arquivo xml  $file não encontrado<br>;";
            exit(0);
        }
        $xmlstr = fread($arq, $len);
        fclose($arq);

        $this->file_date = date("d/m/Y H:i:s.", filemtime($this->file));
        $this->diff = (time() - filemtime($this->file)) / 3600;
        $xmlc = new SimpleXMLElement($xmlstr);

        $this->hostname = $xmlc->hostname;

        $this->atz = $xmlc->atualizacao;


        $this->memory_percent = intval($xmlc->memoriausada);
        $this->status = "OK";

        $this->disks = array();

        $al = new alerta();
        if ($this->diff > 1.8) {
            $this->status = "NOK";
            $al->registra("ListServer", $this->hostname, $this->file_date, "Falta de atualização: $this->diff .", 1, 1);

        }

        foreach ($xmlc->capacidade->item as $item) {


            $indice = str_replace("/", "_", $item->pasta);

            $this->disks[$indice] = new Disk($item->pasta, $item->percentual);

            if ($item->percentual >= 80) {
                $this->status = "NOK";
                $al->registra("ListServer", $this->hostname, $item->percentual, "Espaço em disco", 1, 1);
            }

        }

        foreach ($xmlc->inodes->item as $item) {
            $indice = str_replace("/", "_", $item->pasta);

            $this->disks[$indice]->SetInodes($item->percentual);

            if ($item->percentual >= 86) {
                $this->status = "NOK";
                $al->registra("servidor", $this->hostname, $item->percentual, "Esgotando inodes", 1, 1);

            }

        }


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
        if ($this->status == "NOK")
            print "<font color=red><b>$this->hostname</b><br></font>";
        else
            print "<b>$this->hostname</b><br>";
        print "$this->atz xml<br>$this->file_date file";

        if ($this->memory_percent < 99) {
            print "<br> Memória Usada:<font color=green>$this->memory_percent% OK</font>";
        } else {
            print "<br> Memória Usada:<font color=red>$this->memory_percent% NOK</font>";
        }

        print "</header>";
        print "<div class='card-content'>";

        print "<table width=100%>";
        print "<tr>";
        print "<td><b>Disco</b></td>";
        print "<td colspan=2><b>Espaço</b></td>";
        print "<td colspan=2><b>Inodes</b></td>";
        print "</tr>";


        foreach ($this->disks as $di) {
            print "<tr>";
            print "<td><b>" . $di->name . "</b></td>";
            print "<td><b>" . $di->percentual . "</b></td>";
            if (intval($di->percentual) < 80) {
                print "<td><font color=green>OK</font></td>";
            } else {
                print "<td><font color=red>NOK</font></td>";
            }
            print "<td><b>" . $di->inodes . "</b></td>";
            if (intval($di->inodes) < 86) {
                print "<td><font color=green>OK</font></td>";
            } else {
                print "<td><font color=red>NOK</font></td>";
            }
            print "</tr>";
        }
        print "</table>";
        print "</div>";
        print "</div>";

    }

}


