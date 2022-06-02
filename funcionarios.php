<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/FuncionariosModel.php");
include_once($PATH."pai.php");

$filtro = trim(addslashes(($_GET['filtro'])));

if($_SESSION['codigo'] && (($_SESSION['tipo'] == "ADM0564") ))
{
	//paginação
	$limite = 20;
	$pagina = trim(addslashes(($_GET['pag'])));
	if(!isset($pagina) || $pagina == ''){
		$pagina = 1;
	}
	$inicio = ($pagina * $limite) - $limite;

	$dado = new FuncionariosModel();

	$total_registros = $dado->contador($filtro);
	$total_paginas = ceil($total_registros / $limite);

	$dados = $dado->listAll($inicio, $limite, $filtro);

	$primeira =  "<a href='funcionarios.php?pag=1' style='color:#9b9b9b'>Primeira página</a>";

	// Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
	if ( $pagina > 1) { 
		$anterior =  "<a href=funcionarios.php?pag=".($pagina-1)." style='color:#111111'>Página anterior</a>";
		$pag_ant = '<a href="funcionarios.php?pag='.($pagina-1).'" style="color:#111111"> '.($pagina-1).'</a>'; // Escreve o número e o link da página
	} else { 
		$anterior = "<font color=#9b9b9b>Página anterior</font>";
	}

	$pag_atual = "<font color=#000000>".$pagina."</font>"; // Escreve somente o número da página sem ação alguma

	// Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
	if (($pagina) < $total_paginas) { 
		$proximo = "<a href=funcionarios.php?pag=".($pagina+1)." style='color:#111111'>Próxima Página</a>";
		$pag_prox = '<a href="funcionarios.php?pag='.($pagina+1).'" style="color:#111111"> '.($pagina+1).'</a>'; // Escreve o número e o link da página
	} else { 
		$proximo = "<font color=#9b9b9b>Próxima Página</font>";
	}

	$ultima =  "<a href='funcionarios.php?pag=".$total_paginas."'><font color=#9b9b9b>Última página</font></a>";

	require_once 'sk_funcionarios.html';
}
else
{
	echo ("<script>alert('Você precisa estar logado.'); window.location=\"index.php\"</script>");
}

?>