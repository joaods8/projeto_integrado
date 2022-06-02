<?php
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/FuncionariosModel.php");
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."pai.php");

if($_SESSION['codigo'] && (($_SESSION['tipo'] == "KNT347") || ($_SESSION['tipo'] == "ADM0564") ))
{
	if($_SESSION['tipo'] == "ADM0564") 
	{
		$objF = new FuncionariosModel();
		//$funcionarios = $objF->quantidadeFunc();
	}
	
	$objA = new AlunosModel();
	$desligados = $objA->contadorByStatus(1);
	$ativos = $objA->contadorByStatus(2);

	$objP = new PagamentosModel();
	$em_aberto = $objP->contadorByStatus(1);

	include_once("sk_principal.html");
}
else
{
	echo ("<script>alert('Você precisa estar logado.'); window.location=\"index.php\"</script>");
}

?>