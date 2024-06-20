<?php


if ($_SERVER['DOCUMENT_ROOT'] == null)
    $_SERVER['DOCUMENT_ROOT'] = "..";

require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/alerta/alerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ListServer/Server.php";

class ListServer extends modulo
{


    public $server;
    public $telefones;
    public $contatos;
    public $conexoes;

    public $usuariosF;
    public $telefonesF;
    public $contatosF;
    public $conexoesF;
    public $data_cloudF;
    public $hora_cloudF;
    public $data_eqF;
    public $hora_eqF;

    public function __construct()
    {

        parent::__construct();

        $this->name = "ListServer";
        $this->sigla = "SERVIDOR";
        $this->icone = "fas fa-server";




        $this->server = array();
        $this->server[] = new Server('/dados/cap/status/disco_pr10.xml');
        $this->server[] = new Server('/dados/cap/status/disco_pr20.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sp1.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sp2.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sv_site.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sv_banco.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sv_mail.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sv-sql.xml');
        $this->server[] = new Server('/dados/cap/status/disco_apache-100.xml');
        $this->server[] = new Server('/dados/cap/status/disco_apache-101.xml');
        $this->server[] = new Server('/dados/cap/status/disco_kannel51.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sp27.abstract.com.br.xml');
        $this->server[] = new Server('/dados/cap/status/disco_sp29.hugtak.com.xml');
        $this->server[] = new Server('/dados/cap/status/disco_bup.hugtak.com.xml');
        $this->server[] = new Server('/dados/cap/status/disco_n246.xml');
        // $this->server[]= new Server('/dados/cap/status/disco_bup-sp.xml');
        // $this->server[]= new Server('/dados/cap/status/disco_rup-sp.xml');
        $this->server[] = new Server('/dados/cap/status/disco_cbv32-cdc-dc.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv16-cbc-algar-lab.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv10-cbc-vivo-lab.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv12-cbc-claro-lab.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv14-tim-lab.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv27.xml');
        $this->server[] = new Server('/dados/cap/status/disco_spv28.xml');

    }

    public function get_data()
    {

        $hora = date('G');

        foreach ($this->server as $s) {
            $s->get_data();
        }

        //  $al = new alerta();

        //    if($cloud->cadastros <= 10  && $hora > 1 ) {
        //      $al->registra("nmp", "Usuarios", date('Y-m-d H:i'), "Volume baixo de usuarios", 1, 1);
        //}


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
        date_default_timezone_set("America/Sao_Paulo");
        $hora = date('G');
        if ($hora > 19 || $hora < 6)
            $dark = "dark";
        else
            $dark = "";

        print "<div class='card $dark'>";
        print "<header class=r'card-header'>SERVIDORES<br></header>";
        print "<div class='card-content'>";
        print "<table width=100%>";
        print "<tr>";
        print "<td><b>Hostname</b></td>";
        print "<td><b>Status</b></td>";
        print "</tr>";


        foreach ($this->server as $s) {
            print "<tr>";
            print "<td><b>" . $s->hostname . "</b></td>";
            if ($s->status == "OK") {
                print "<td><font color=green>OK</font></td>";
            } else {
                print "<td><font color=red>NOK</font></td>";
            }
            print "</tr>";
        }
        print "</table>";
        print "</div>";
        print "</div>";

        foreach ($this->server as $s) {
            $s->ShowMe();
        }




    }


}

$srv = new ListServer();

if (isset($_GET['back'])) {
    $srv->back_call();
    $srv->ShowMe();
}



