<?php
$conexao= pg_connect("hostaddr=127.0.0.1 dbname=painel  user=conselho password=painel@1500");
if(!$conexao) {
        die("Não pode conectar ao banco de dados.");
}
$sqlset = "set DATESTYLE to European,European;";
pg_query($conexao,$sqlset);

?>
