<?php
session_start();
require_once '/dados/classes/jwt-master/JWT.php';

$jwt = $_GET['j'];

$secretKey  = 'master_king_monkey';
                
$token = JWT::decode($jwt, $secretKey, array('HS512'));



require_once $_SERVER['DOCUMENT_ROOT'] . "/xcon/conecta.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/erpme/banco/sqldatareader.php";

$query  = 'select cod_usuario,nome  from usuario where usuario.email = $1 ';

$params = array($token->data->userName);

$Result = pg_query_params($conexao,$query, $params);

$dr = new SqlDataReader();
$dr->SetResult($Result);

$row = $dr->GetObject();

if($dr->HasRows) {
      
        $cod_usuario = $row->cod_usuario;
	$_SESSION['login_userId']	 	= $token->data->userId;
	$_SESSION['login_email'] 		= $token->data->userName;
	$_SESSION['login_celular'] 		= $token->data->celular;
	$_SESSION['cod_usuario'] = $cod_usuario;
	$_SESSION['usuario'] = $row->nome;
	header('Location: /index.php');
	exit(0);
}
else {
	header('Location: /no_permission.php');
	exit(0);
}
  
