<?php
session_start();
?>
<html lang="pt-br">
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="Painel" content="#254C75"/>
  
  <title>Painel</title>
  <link rel="stylesheet" href="css/principal.css"/>
  <link rel="stylesheet" type="text/css" href="css/principal.css"/> 
  <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css"/> 
  <link rel="manifest" href="manifest.json"/> 
</head>

<body>

  
<main>
    <div id="no_permission" class="center" style="margin-top: 15%;" >
            <img src="images/abr.png">
    </div>    
    
    <span class="center" style="font-size: 26pt; color: #3D5A8A">
             <i class="fas fa-lock"></i>
    </span>
    
    <div class="center" style="padding-left: 20px; padding-right: 20px;">
            <p>
                Seu usuário (<?php print $_SESSION['login_email']; ?>) não possui permissão para o acessar esse conteúdo.<br><br>
                Por favor entre em contato com a ABR Telecom.
            </p>   
    </div>
</main>

</body>
</html>
