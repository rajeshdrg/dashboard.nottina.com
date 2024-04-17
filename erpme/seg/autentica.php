<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/conecta.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";

$login      = $_POST["login"];
$senha      = $_POST["secret"];

/*
$codigo     = $_POST["codigo"];
$login      = strtoupper($_POST["login"]);
$senha      = $_POST["secret"];
 */

//$ldap = ldap_connect("172.31.198.204");
/*
session_start();

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

if($senha==NULL) {
      session_start();
      $_SESSION['mensagem'] = 'Usuário/senha inválidos';
      header('Location: /login.php');   
      exit(0);
}
if( empty($senha)) {
     session_start();
     $_SESSION['mensagem'] = 'Usuário/senha inválidos';
     header('Location: /login.php');  
      exit(0);
}


/*
 *  $Sql ->query = 'select * from usuario where  email  = $1 and senha = md5( $2)';
 * if ($bind = ldap_bind($ldap, $email, $senha)) {
    $Sql->query  = 'select cod_usuario,nome,prestadora from usuario '
             . ' inner join prestadora on usuario.cod_prestadora = prestadora.cod_prestadora '
             . ' where usuario.email = $1 ';
    $Sql->params = array($email);
} 
else {
  */

$Sql->query  = 'select cod_usuario,nome,prestadora,dir,login from usuario '
             . ' inner join prestadora on usuario.cod_prestadora = prestadora.cod_prestadora '
             . ' where email  = $1 and senha = md5( $2) and usuario.excluido is null';
            
    $Sql->params = array($login,$senha);
    
/*
  }
 */
  

$dr = $Sql->ExecuteReader();


$row = $dr->GetObject();


  
  if($dr->HasRows) {
	 session_start();
  
	 $now = time();
          
           
          $cod_usuario = $row->cod_usuario;
	  $_SESSION['cod_usuario']  	= $cod_usuario;
	  $_SESSION['usuario']      	= $row->nome;
	  $_SESSION['login']      	= $row->login;
	  $_SESSION['prestadora']   	= $row->prestadora;
	  $_SESSION['dir']          	= $row->dir;
	  $_SESSION['codigo']          	= $codigo;
	  $_SESSION['discard_after'] 	= $now + 3600;		
	  $Sql->query  = 'insert into log (usuario,prestadora) values ( $1,$2) ';
	  $Sql->params   = array ($row->login,$row->prestadora);
	  $Sql->Execute();
          
          
       echo '--executou--'; 
	  
	$Sql->query  = 'select sigla from perfil inner join usuario ';
	$Sql->query .= 'on perfil.cod_perfil = usuario.cod_perfil and usuario.cod_usuario = $1 ';
        $Sql->params = array($cod_usuario);
        $dr = $Sql->ExecuteReader();
        while( $row = $dr->GetObject()) {
            $_SESSION[$row->sigla] = true;
        }
	  
          
          
	
	header('Location: /index.php');
        
  }
  else {
	  session_start();
	  $_SESSION['mensagem'] = 'Usuário/senha inválidos';
	  header('Location: /login.php');
  }
  exit(0);
?>
