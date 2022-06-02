<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."model/AlunosModel.php");
include_once($PATH."pai.php");

$idAluno = trim(addslashes((($_GET['aluno']))));

if($_SESSION['codigo'] && $idAluno)
{
	$dado = new PagamentosModel();
	$objA = new AlunosModel();

	$dados = $dado->listAllByAluno($idAluno);
	$aluno = $objA->listById($idAluno);

	require_once 'sk_pagamentos_aluno.html';

}
else
{
	echo ("<script>alert('Você precisa estar logado.'); window.location=\"index.php\"</script>");
}

?>