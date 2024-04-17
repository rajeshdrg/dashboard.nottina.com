

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
               	        <td class="rootVoice {menu: '001'}" menu="001" style="white-space: nowrap;">Mensagem</td>
                        <?php } ?>
               	        <td class="rootVoice {menu: '002'}" menu="002" style="white-space: nowrap;">Relatório</td>
                        <td class="rootVoice {menu: '011'}" menu="011" style="white-space: nowrap;">Ajuda</td>

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
<div id="001" class="mbmenu" style="display: none;">
   <a href="/mensagens">Cadastro de Mensagens</a>
   <a href="/prestadoras">Prestadoras</a>
</div>
<?php } ?>
<div id="002" class="mbmenu" style="display: none;">
   <a href="/rel_arquivos">Arquivos</a>
   <a href="/rel_enviados">Mensagens Enviadas</a>
   <a href="/rel_mensagens/">Mensagens Associadas por Arquivo</a>
</div>


<div id="011" class="mbmenu" style="display: none;">
	<a href="/manual/DOST_GST_Manual-SINAI.pdf" target="_blank">Manual Online</a>
	<a href="/trocar_senha">Trocar senha</a>
 

</div>


<div id="030" class="mbmenu" style="display: none;">
	<a href="/perfil">Meu Perfil</a>
</div>
