<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/erpme/seg/valida.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/modulo/modulo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Gtloc/Gtloc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Esms/Esms.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/EsmsChart/EsmsChart.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Seac/Seac.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/BrokerGlobal/BrokerGlobal.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Servico/Servico.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Bigdata/Bigdata.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/NMP/NMP.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Sites/Sites.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Mpls/Mpls.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Sinai/Sinai.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Processo/Processo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Positivo/Positivo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ListServer/ListServer.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ShowAlerta/ShowAlerta.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/ShowAlerta/editForm.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Procon/Procon.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/SmsPortabilidade/SmsPortabilidade.php";

$hora = date('G');
if ($hora > 21 || $hora < 6)
  $dark = "dark";
else
  $dark = "";

$painel = json_decode(file_get_contents('/dados/cap/status/painel.json'), true);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link rel="manifest" href="/manifest.json">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="Painel" content="#254C75" />
  <meta name="description" content="Painel de monitoramento">

  <!--  iOS meta tags and icons -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Painel">
  <link rel="apple-touch-icon" href="/icone/icon.png">

  <title>Painel PWA</title>

  <link rel="stylesheet" type="text/css" href="css/principal.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/v4-shims.css">
  <link rel="stylesheet" type="text/css" href="css/dbox.css" />

  <!-- 
	<link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css"/> 
-->
  <link rel="manifest" href="manifest.json" />


  <style>
    .discussion {
      list-style: none;
      background: #e5e5e5;
      box-sizing: border-box;
      width: 42%;
      padding: 0 0 50px 0;
      float: left;

    }

    .discussion li {
      padding: 0.5rem;
      overflow: hidden;
      display: flex;
    }

    .discussion .avatar {
      width: 40px;
      position: relative;
    }

    .discussion .ufs {
      padding-top: 5px;
      width: 40px;
      height: 40px;
      position: relative;
      background-color: #069;
      text-align: center;
      color: white;
    }

    .discussion_tv {
      list-style: none;
      background: #e5e5e5;
      box-sizing: border-box;
      width: 42%;
      padding: 0 0 50px 0;
      float: left;

    }

    .discussion_tv li {
      padding: 0.5rem;
      overflow: hidden;
      display: flex;
    }

    .discussion_tv .cobrade {
      padding-top: 5px;
      width: 80px;
      height: 40px;
      position: relative;
      background-color: navy;
      text-align: center;
      color: white;
    }


    .avatar:after {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      width: 0;
      height: 0;
      border: 5px solid white;
      border-left-color: transparent;
      border-bottom-color: transparent;
    }

    @media (min-width:150px) and (max-width:1060px) {

      .discussion {
        list-style: none;
        background: #e5e5e5;
        margin: 0;
        padding: 0 0 50px 0;
        width: 100%;
        height: auto;
      }

      .discussion_tv {
        list-style: none;
        background: #e5e5e5;
        margin: 0;
        padding: 0 0 50px 0;
        width: 100%;
        height: auto;
      }



    }
  </style>


  <!-- ==== PWA === -->
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="application-name" content="Painel" />
  <meta name="apple-mobile-web-app-title" content="Painel" />
  <meta name="theme-color" content="#254C75" />
  <meta name="msapplication-navbutton-color" content="#254C75" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="msapplication-starturl" content="https://painel.abrtelecom.com.br/" />

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    <?php


    $gtloc->front_call();
    $esms->front_call();
    $esmschart->front_call();
    $seac->front_call();
    $glob->front_call();
    $sin->front_call();
    $mpl->front_call();
    $site->front_call();
    $ser->front_call();
    $big->front_call();
    $pos->front_call();
    $nmp->front_call();
    $srv->front_call();
    $show->front_call();
    $procon->front_call();
    $smsPor->front_call();
    $processo->front_call();

    ?>

    var funcao = 'Painel';
    var PainelInterval = null;

    function PainelRefresh() {
      switch (funcao) {
        case 'Painel':
          painel();
          break;
      }
    }

    function voltar() {
      conteudo = document.getElementById("conteudo");
      conteudo.style.display = 'none';
      menu = document.getElementById("menu");
      menu.style.display = 'block';
    }


    function pre() {}

    function tv() {
      window.location = "tv.php";
    }

    function painel() {
      post = new XMLHttpRequest();
      post.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);

          var contador = document.getElementById("Esms_count");
          var titulo = document.getElementById("Esms_title");
          contador.innerHTML = data.sms;
          titulo.innerHTML = 'Alertas';
        }
      };
      post.open("POST", "painel.php", true);
      post.setRequestHeader("Content-type", "application/json");
      post.send();

    }

    function drawDashboardGlobal() {

      post = new XMLHttpRequest();
      post.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          data.forEach(plota_grafico);
        }
      };

      post.open("POST", "/dashboard/dados_global.php", true);
      post.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      post.send("item[]=s0341-1&item[]=s0341-2");
    }




    // Load the Visualization API and the controls package.
    google.charts.load('current', {
      'packages': ['corechart', 'controls']
    });
    google.charts.load('current', {
      'packages': ['line']
    });
    window.onload = function() {
      PainelRefresh();
      PainelInterval = setInterval(PainelRefresh, 300000);
    }
  </script>



</head>

<body>

  <!--=================================
           HEADER DESKTOP
   ===================================-->
  <div class="topo">
    <div style="width: 2%;height: 100%; float: left;">
      <button class="header_back" onclick="voltar();" style="margin:36px auto auto 8px; font-size: 15pt;">
        <i class="fa fa-arrow-left" style="color:#003366"></i>
      </button>
    </div>
    <div style="width: 30%;height: 100%; float: left;">
      <img src="images/nottina.png" style="margin:auto auto auto 12px; width: 250px; height: 85px;" />
    </div>
    <div style="width: 68%;height: 100%; float: left;">
      <a id="btnSair" href="sair.php" class="headerUser" style="width: 35px; height: 35px;margin-top: 50px;"><img src="images/logout_small.png"></a>
      <h4 class="headerUser"><?php print $nome; ?></h4>
    </div>
  </div>

  <!--=================================
           HEADER MOBILE
   ===================================-->
  <header class="header">
    <button class="header_back" onclick="voltar();"><i class="fa fa-arrow-left"></i></button>
    <h1 class="header__title">&nbsp;&nbsp;Painel ABR Telecom</h1>
    <a id="btnSair" href="sair.php" class="headerButton"></a>
  </header>

  <!--=================================
              CONTEUDO
   ===================================-->

  <main class="main <?php print $dark; ?>">


    <div class="header_mobile">
      <h3 style="background: #808080;"><?php print $nome; ?></h3>
    </div>

    <div id=menu>
      <div class="card-div">
        <?php $show->Button(); ?>
        <?php $gtloc->button(); ?>

      </div>


      <div class="card-div">
        <?php $ser->button(); ?>
        <?php $esms->button(); ?>
      </div>
      <div class="card-div">
        <?php $esmschart->button(); ?>
        <?php $seac->button(); ?>

      </div>

      <div class="card-div">
        <?php $glob->button(); ?>
        <?php $pos->button(); ?>
      </div>
      <div class="card-div">
        <?php $processo->button(); ?>
        <?php $smsPor->button(); ?>
      </div>
      <div class="card-div">
        <?php $sin->button(); ?>
        <?php $mpl->button(); ?>
      </div>

      <div class="card-div">
        <?php $site->button(); ?>
        <?php $srv->button(); ?>
      </div>

      <div class="card-div">
        <?php $procon->button(); ?>
        <?php $nmp->button(); ?>
      </div>

    </div>
    <div id='conteudo' style='display:none;' class="<?php print $dark; ?>"></div>
  </main>


</body>

</html>