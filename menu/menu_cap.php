

<table border="0" cellpadding="0" cellspacing="0" style="height: 35px;width: 100%;BACKGROUND-IMAGE: url(/images/loopMenu.png)">
   <tr>
      <td valign="bottom">
         <table border="0" cellpadding="0" cellspacing="0" class="container">
            <tr>
               <td class="myMenu" id="menu_171">
                  <table class="rootVoices" border="0">
		     <tr>
                         <?php if(isset($_SESSION['ADM'])) { ?>
               	        <td class="rootVoice {menu: '000'}" menu="000" style="white-space: nowrap;">Administração</td>
                        <?php } ?>
               	        <td class="rootVoice {menu: '010'}" menu="010" style="white-space: nowrap;">Alerta</td>

                     </tr>
		  </table>
               </td>
            </tr>
         </table>
      </td>
      <td valign="bottom"></td>
      <td></td>
      <td></td>
   </tr>
</table>
<?php if(isset($_SESSION['ADM'])) { ?>
<div id="000" class="mbmenu" style="display: none;">
        <a href="/usuario">Usuários</a>
</div>
<?php } ?>

<div id="010" class="mbmenu" style="display: none;">
	<a href="/upload">Upload de Arquivo CGI</a>
        <a href="/download">Download Arquivo CGI Full</a>
        <a href="/con_cgi">Consultar CGI</a>
</div>
<div id="020" class="mbmenu" style="display: none;">
	<a href="/rel_processados">Arquivos Processados</a>
	<a href="/rel_alerta">Alerta Gerado</a>
	<a href="/rel_evolucao">Evolução da Base de CGI</a>
	<a href="/rel_enviados">Arquivos Enviados</a>
        <a href="/rel_volumetria/">Volumetria</a>
        <a href="/rel_volumetria_central/">Volumetria Central</a>
</div>

<div id="030" class="mbmenu" style="display: none;">
	<a href="/perfil">Meu Perfil</a>
</div>
