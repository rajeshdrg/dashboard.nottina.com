<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/xcon/conecta.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqlcommand.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";

$email = $_POST["usuario"];
$senha = $_POST["senha"];

$Sql = new SqlCommand("Sql");
$Sql->connection= $conexao;
  $Sql->query  = 'select cod_usuario,nome,corretora from usuario ';
  $Sql->query .= 'cross join corretora where usuario.email = $1 and senha =md5( $2)';
  $Sql->params = array($email,$senha);
  $dr = $Sql->ExecuteReader();
  $row = $dr->GetObject();
  
  if($dr->HasRows) {
	  session_start();
          
          //if($row->cod_usuario==16) $cod_usuario = 28;
          //else 
            $cod_usuario = $row->cod_usuario;
	  $_SESSION['cod_usuario'] = $cod_usuario;
	  $_SESSION['usuario'] = $row->nome;
	  $_SESSION['corretora'] = $row->corretora;
	  
	  $Sql->query  = 'select sigla from perfil inner join usuario_perfil ';
	  $Sql->query .= 'on perfil.cod_perfil = usuario_perfil.cod_perfil and usuario_perfil.cod_usuario = $1 ';
      $Sql->params = array($cod_usuario);
      $dr = $Sql->ExecuteReader();
      while( $row = $dr->GetObject()) {
      	 $_SESSION[$row->sigla] = true;
      }
	  
	  header('Location: /index.php');
  }
  else {
	  header('Location: /login.php');
  }
  
  exit(0);
?>