<?php
session_start();

if(isset($_SESSION["mensagem2"])) 
	$mensagem = $_SESSION["mensagem2"];
else 
	$mensagem = "";
?><!DOCTYPE html>

<html lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Conselho - Recuperar Senha</title>
        <link rel="stylesheet"  type="text/css" href="/css/basico2.css">
             <script type="text/javascript" src="/js/jquery.min.js"></script>
      <script>
          function valida() {
              if(!$('#usuario').val()) {
                  $("#mensagem").html("E-mail é obrigatório.");
                  return false;
              }              
    return true;
          }
      </script>     
    </head>
    <body class="FormLoginCenter"  >
        <form id="formulario"  method="post"   action="/erpme/seg/reset.php" onsubmit="return valida();">
        <div id="WRAPPERLOGIN" class="wrapperLogin" style="">
            <div>
                <div id="CELL" class="cellLogin">
                    <table  data-cellpadding="0" data-cellspacing="0" style="margin-left:auto; margin-right: auto;" cellpadding="0" cellspacing="0">
                        
                            <tr></tr>
                            <tr><td  class="abr_logo" style="vertical-align:bottom">
                                </td>
                            </tr>
                            <tr><td class="titulo">Portal <span id="Titulo" name="Titulo">Conselho</span> > Recuperar senha </td></tr>
                            <tr>
                                <td   class="formLogin" >
                                    <table cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align: right; padding-right: 5px; font-size: 9pt;"><span id="digite" class="TextBlank">E-mail: </span></td>
							<td style="padding-right: 5px">
							<input name="usuario" type="text" id="usuario" class="login" />
							</td>
							<td><input type="submit" name="botao" value="" id="botao" Class="botao" style="border-width:0; background:url('images/btnRSenha.png') no-repeat; width:106px; height:21px;" /></td>
						</tr>
						<tr>
							<td colspan="3"><img src="imagens/spacer.gif" height="5" width="1" /></td>
						</tr>
						<tr>
							<td style="text-align: right; padding-right: 5px">&nbsp;</td>
							<td style="padding-right: 5px; width: 278px;"><div id='mensagem' style='color:red;'><?php print $mensagem; ?></div></td>                                                        
                                                        <td><a  href="login.php"><img border="0" src="images/btnVoltar.png"/></a></td>  
						</tr>
                                              
					</table>
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>
