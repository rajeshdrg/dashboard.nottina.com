<?php
$nome = "Teste Silva";
$email = "teste@abstract.com.br";

require_once $_SERVER["DOCUMENT_ROOT"]."/erpme/seg/valida.php";
require_once '/dados/classes/jwt-master/JWT.php';

$url = "https://login.abrtelecom.com.br/f0345.php";

$ch = curl_init();
$headers = [];

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&nome=$nome");

curl_setopt($ch, CURLOPT_HEADERFUNCTION,
  function($curl, $header) use (&$headers)
  {
    $len = strlen($header);
    $header = explode(':', $header, 2);
    if (count($header) < 2) // ignore invalid headers
      return $len;

    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

    return $len;
  }
);
$data = curl_exec($ch);

if(isset($headers['authorization'])) {
	$jwt = $headers['authorization'][0];
	$jwt =  substr($jwt,8);
	$secretKey  = 'master_king_monkey';
	$token = JWT::decode($jwt, $secretKey, array('HS512'));

	print_r($token);
}
