<?php


include "ui/textbox.php";
include "ui/sqldatareader.php";
include "ui/sqlcommand.php";
include "ui/dropdownlist.php";

include "conexao/conecta.php";

$SqlUf = new SqlCommand("SqlUf");
$SqlUf->connection= $conexao;
$SqlUf->query="select uf,uf as text from uf";


$SqlCidade = new SqlCommand("SqlCidade");
$SqlCidade->connection= $conexao;
$SqlCidade->query="select cod_cidade,cidade  from cidade";


$nome = new textbox("nome");
$cpf = new textbox("cpf");
$email = new textbox("email");
$twitter = new textbox("twitter");
$fone = new textbox("fone");
$endereco = new textbox("endereco");
$endereco_numero= new textbox("endereco_numero");
$bairro= new textbox("bairro");
$cidade= new DropDownList("cidade");
$uf= new DropDownList("uf");
$cep= new textbox("cep");

$nome->size="100%";
$cpf->size="100%";
$email->size="100%";
$twitter->size="100%";
$fone->size="100%";
$endereco->size="100%";
$bairro->size="100%";


$uf->size="1";
$uf->SqlCommand = $SqlUf;
$uf->bind();
$uf->Value = "uf";
$uf->Text = "uf";


$cidade->size="1";
$cidade->SqlCommand = $SqlCidade;
$cidade->bind();
$cidade->Value = "cod_cidade";
$cidade->Text = "cidade";

$endereco_numero->size="10";

?>

O Formulário <br>
<table border="0">
<tr><td>Nome</td><td><?php $nome();?></td></tr>
<tr><td>E-mail</td><td><?php $email();?></td></tr>
<tr><td>Twitter</td><td><?php $twitter();?></td></tr>
<tr><td>Fone</td><td><?php $fone();?></td></tr>
<tr><td>CPF</td><td><?php $cpf();?></td></tr>
<tr><td>Endereco</td><td><?php $endereco();?> Número <?php $endereco_numero();?></td></tr>
<tr><td>Bairro</td><td><?php $bairro();?></td></tr>
<tr><td>Cidade</td><td><?php $cidade();?></td></tr>
<tr><td>UF</td><td><?php $uf();?></td></tr>
<tr><td>CEP</td><td><?php $cep();?></td></tr>

</table>
