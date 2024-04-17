<?php
?>
<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="Painel" content="#254C75"/>
  
  <title>Painel - SMS</title>

  <link rel="stylesheet" type="text/css" href="css/inline.css"/> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <link rel="manifest" href="manifest.json"/>
  
  <!-- ==== PWA === -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Painel">
    <meta name="apple-mobile-web-app-title" content="Painel">
    <meta name="theme-color" content="#254C75">
    <meta name="msapplication-navbutton-color" content="#254C75">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="https://painel.abrtelecom.com.br/">



</head>
<body>
  <header class="header">
    <h1 class="header__title">Painel - SMS</h1>
    <!--<button id="butRefresh" class="headerButton"></button> -->
    <button id="butMenu" class="headerButton" role="presentation">&nbsp;<i class="fa fa-bars" aria-hidden="true"></i></button>
  </header>
 
  <main class="main">
   
    <div class="top_main">
        <h3>Bem-vindo, Usuário Teste</h3>
    </div>    
      
  <div class="card-div">
     
        <button id="butAddSMS" class="butCard"> 
            <div class="card-icon"><i class="fa fa-mobile" style="font-size:50px;"></i></div>  
             SMS
        </button>

          <button id="butAddGTLOC" class="butCard">
            <div class="card-icon"><i class="fa fa-map-marker" aria-hidden="true" style="font-size:40px;"></i></div>  
            GTLOC
        </button>
   
  </div>    
      
    <div class="card-div">  
        <button id="butAddMPLS" class="butCard">
          <div class="card-icon"><i class="fa fa-mixcloud" style="font-size:40px;"></i></div>  
           MPLS
      </button>

        <button id="butAddEAQ" class="butCard">
          <div class="card-icon"><i class="fa fa-signal" style="font-size:40px;"></i></div>  
           EAQ
      </button>
    </div>
      
     <!-- <div class="card-div">
          <img src="images/logo_smal.png"/>
      </div> -->
        
  </main>

  <!--Insert link to app.js here -->
    <script src="serviceWorker-register.js"></script>
    <script src="serviceWorker.js"></script>
</body>
</html>

