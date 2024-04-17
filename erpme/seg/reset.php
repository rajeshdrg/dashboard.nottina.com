<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/conecta.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/dados/classes/PHPMailer5.2/class.phpmailer.php';
//require_once('/dados/classes/PHPMailer_v5.1/class.phpmailer.php');

session_start();
session_destroy();

//Definir timezone para Phpmailer
date_default_timezone_set("America/Sao_Paulo");
$timezone = date_default_timezone_get();

//$codigo  = $_POST["codigo"];
$login     =  $_POST["usuario"];
echo $login;

//$ldap = ldap_connect("172.31.198.204");
/*

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
*/

$Sql = new SqlCommand("Sql");
$Sql->connection= $conexao;

//print_r($Sql);

/*if ($bind = ldap_bind($ldap, $email, $senha)) {
    $Sql->query  = 'select cod_usuario,nome,prestadora from usuario '
             . ' inner join prestadora on usuario.cod_prestadora = prestadora.cod_prestadora '
             . ' where usuario.email = $1 ';
    $Sql->params = array($email);
} 
else {
  */

$Sql->query  = 'select * '
        . 'from usuario '
        . 'left outer join prestadora on usuario.cod_prestadora = prestadora.cod_prestadora where email = $1 ';
    $Sql->params = array($login);
   
    
$dr = $Sql->ExecuteReader();
$row = $dr->GetObject();


//echo "<br/>Data Reader: ". print_r($dr,1);

$cod_usuario = $row->cod_usuario;


  if($dr->HasRows) {
	  session_start();
          
          
$bytes = openssl_random_pseudo_bytes(3);

$nova_senha = bin2hex($bytes); 

$Sql->query  = 'update usuario set senha=md5($2) where cod_usuario = $1 ';
$Sql->params = array($cod_usuario,$nova_senha);
$Sql->Execute();
          
$mensagem  = "<div align='center'><table border='0' cellspacing='0' cellpadding='0' style='border-collapse:collapse'>"
    ."<tr style='height:64.75pt'>"
        . "<td width='453' colspan='2' style='width:339.8pt;border:solid #17365d 1.0pt;border-bottom:none;background:#17365d;padding:0cm 9.9pt 0cm 9.9pt;height:64.75pt'>"
        ."<p class='MsoNormal'><b><span style='font-size:16.0pt;font-family:&quot;Calibri&quot;,sans-serif;color:white'>"
        . "Comunicado</span></b></p>"
        . "<p class='MsoNormal'><b><span style='font-size:16.0pt;font-family:&quot;Calibri&quot;,sans-serif;color:white'>"
        . "SINAI - Reset de Senha</span></b>"
        . "<span style='font-size:16.0pt;font-family:Calibri,sans-serif;color:white'>"
        . "</span>"
        . "</p></td>"
        . "<td width='156' style='width:117.35pt;border-top:solid #17365d 1.0pt;border-left:none;border-bottom:none;border-right:solid #17365d 1.0pt;background:#17365d;padding:0cm 9.9pt 0cm 0cm;height:64.75pt'>"
        . "<p class='MsoNormal' align='right' style='text-align:right'>"
        . "<span style='font-family:Calibri,sans-serif;color:#1f497d'>"
        
        . "<img width='76' height='76' src='http://conselho.abstract.com.br/images/envelope.png' alt='envelope' class='CToWUd'>"
        . "</span></p></td>"
        . "<td width='24' ><p class='MsoNormal'></p></td></tr>"
        . "<tr style='height:88.8pt'>"
        . "<td width='610' colspan='3' valign='top' "
        . "style='width:457.15pt;border-left:solid #17365d 1.0pt;border-right:solid #17365d 1.0pt;"
        . "background:#f2f2f2;padding:9.9pt 9.9pt 0cm 9.9pt;height:88.8pt'>"
        . "<p class='MsoNormal' align='right' style='margin-right:7.0pt;text-align:right;line-height:115%'>"
        . "<span></span></p>"
        . "<p class='MsoNormal' style='margin-right:7.0pt;line-height:115%'>"
        . "<span style='font-size:10.0pt;line-height:115%;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Prezado(a) Sr(a) $row->nome, </span></p><br>"
            

        . "<p class='MsoNormal' style='text-align:justify;'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Você está recebendo uma mensagem automática do SINAI – https://sinai.abrtelecom.com.br</span></p><br>"


        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Foi solicitado o envio de sua senha por e-mail. Se você não solicitou, comunique o administrador imediatamente.</span></p><br>"


        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Instituição:$row->prestadora</span></p>"


        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Usuario:$row->login</span></p>"


        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "Senha:$nova_senha</span></p>"

        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;</span></p>"

        
        
	. "</td>"
        . "<td width='24' style='width:18.0pt;padding:0cm 0cm 0cm 0cm;height:88.8pt'>"
        . "<p class='MsoNormal'><span style='font-family:Calibri,sans-serif;color:black'>"
        . "&nbsp;</span></p></td></tr>"
        . "<tr style='height:3.7pt'>"
        . "<td width='430' valign='top' style='width:322.5pt;border-top:none;border-left:solid #17365d 1.0pt;border-bottom:solid #17365d 1.0pt;border-right:none;background:#f2f2f2;padding:9.9pt 0cm 9.9pt 9.9pt;height:3.7pt'>"
        . "<p class='MsoNormal' style='text-align:justify'></p>"
        . "<p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'>Atenciosamente,"
        . "<span style='color:#404040'><u></u><u></u></span></span></p><p class='MsoNormal' style='text-align:justify'>"
        . "<span style='font-size:11.0pt;font-family:Calibri,sans-serif;color:#1f497d'><u></u>&nbsp;<u></u></span>"
        . "</p><p class='MsoNormal' style='text-align:justify'><b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'>Gerência de Operações</span></b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'></span></p>"
        . "<p class='MsoNormal' style='text-align:justify'><b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'>"
        . "Diretoria de Operações e Soluções em Telecom</span></b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'>"
        . "</span></p><p class='MsoNormal' style='text-align:justify'><b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif'>"
        . "ABR Telecom – Associação Brasileira de Recursos em Telecomunicações</span></b>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:#404040'>"
        . "</span></p></td>"
        . "<td width='180' colspan='2' valign='bottom' style='width:134.65pt;border-left:none;border-bottom:solid #17365d 1.0pt;border-right:solid #17365d 1.0pt;background:#f2f2f2;padding:9.9pt 9.9pt 0cm 0cm;height:3.7pt'>"
        . "<p class='MsoNormal' align='right' style='text-align:right'>"
        . "<span style='font-family:Calibri,sans-serif'>"
        
        . "<img width='108' height='42' src='http://conselho.abstract.com.br/images/logo_smal.png' alt='logo'  class='CToWUd'>"
        . "</span>"
        . "<span style='font-size:10.0pt;font-family:Calibri,sans-serif;color:#404040'>"
        . "</span></p></td><td width='24' style='width:18.0pt;padding:0cm 0cm 0cm 0cm;height:3.7pt'>"
        . "<p class='MsoNormal'><span style='font-family:Calibri,sans-serif'>&nbsp;</span>"
        . "<span style='font-size:11.0pt;font-family:Calibri,sans-serif'>"
        . "</span>"
        . "</p></td></tr><tr><td width='430' style='width:322.5pt;padding:0cm 0cm 0cm 0cm'></td>"
        . "<td width='23' style='width:17.25pt;padding:0cm 0cm 0cm 0cm'>"
        . "</td><td width='156' style='width:117.0pt;padding:0cm 0cm 0cm 0cm'>"
        . "</td><td width='24' style='width:18.0pt;padding:0cm 0cm 0cm 0cm'>"
         ."</td></tr></tbody></table></div>";

//print $mensagem;
//exit(0);
      
$mail             = new PHPMailer();
        
$mail->CharSet = "UTF-8";

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "gw-mail01.abrtelecom.com.br"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = false;                  // enable SMTP authentication
$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
//$mail->AddEmbeddedImage('http://conselho.abstract.com.br/images/logo_smal.png', 'logo', 'logo.png');
//$mail->AddEmbeddedImage('http://conselho.abstract.com.br/images/envelope.png', 'envelope', 'envelope.png');

$mail->SetFrom('security@abrtelecom.com.br', 'security ABR Telecom');
//$mail->AddReplyTo('', '');

$mail->Subject    = "Recuperação de senha";
$mail->MsgHTML($mensagem);
$mail->AddAddress($row->email,$row->nome);
//$mail->AddEmbeddedImage('', 'logo', 'logo.png');
//$mail->AddEmbeddedImage('', 'envelope', 'envelope.png');

if(!$mail->Send()) {
            
            error_log("ERRO_MAIL:$mail->ErrorInfo");
} 



 
 
$_SESSION["mensagem"] = "Uma nova senha foi enviada por e-mail";
          
	  header('Location: /login.php');
  exit(0);
  }
else {
    session_start();
$_SESSION["mensagem2"] = "Usuario não encontrado";
	  header('Location: /esqueceu.php');
}



?>
