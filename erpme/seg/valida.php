<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . "/xcon/conecta.php";
session_start();
if (!isset($_SESSION['login_userId']) ) {
	header('Location: /login.php');
	exit(0);
}

$now = time();


if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
	session_unset();
	session_destroy();
	session_start();
	header('Location: /login.php');
	exit(0);
}



$_SESSION['discard_after'] = $now + 3600;


$cod_usuario    = 	  $_SESSION['cod_usuario'];
$nome           = 	  $_SESSION['usuario'];
