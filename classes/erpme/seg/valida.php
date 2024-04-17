<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/xcon/conecta.php";
session_start();
if (!isset($_SESSION['cod_usuario'])) {
	header('Location: login.php');
	exit(0);
}
?>