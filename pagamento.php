<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."pai.php");

date_default_timezone_set('America/Los_Angeles');

$cod = trim(addslashes((($_GET['cod']))));
$acao = trim(addslashes((($_GET['acao']))));
$idAluno = trim(addslashes((($_GET['aluno']))));

if($_SESSION['codigo'] && $idAluno)
{	
	$objA = new AlunosModel();
	//$alunos = $objA->listaTodosSemLimite();
	$info_aluno = $objA->listById($idAluno);

	if($acao)
	{
		if($acao == "cad") 
		{
			$dado = new PagamentosController();
			$dado->setID(null);
			$dado->setDataVencimento(null);
			$dado->setDataPagamento(null);
			$dado->setStatus(null);
			$dado->setIdAluno($idAluno);

			if($info_aluno->getPlano() == 1)
			{
				$dado->setValor("90,00");
			}
			else
			{
				$dado->setValor("500,00");
			}

			include_once("sk_pagamento.html");
		}
		elseif($acao == "add") {
			$pagamentos = new PagamentosController();
			$objP = new PagamentosModel();

			$pagamentos->setDataVencimento(trim(addslashes((($_POST['data_vencimento'])))));
			$pagamentos->setValor(trim(addslashes((($_POST['valor'])))));
			$pagamentos->setDataPagamento(trim(addslashes((($_POST['data_pagamento'])))));
			$pagamentos->setIdAluno(trim(addslashes((($_POST['id_aluno'])))));
			$pagamentos->setStatus(trim(addslashes((($_POST['status'])))));

			if($cod)
			{
				$pagamentos->setID($cod);
				$retorno = $objP->update($pagamentos);
				if($retorno)
		            echo ("<script>alert('Registro alterado com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não foi possível alterar, tente novamente.'); window.location=\"alunos.php\"</script>");
			}
			else
			{
				$retorno = $objP->save($pagamentos);

		        if($retorno)
		            echo ("<script>alert('Registro incluido com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não é possível incluir itens iguais, tente novamente.'); window.location=\"alunos.php\"</script>");
	    	}
		}
		elseif($acao == "edit") {
			if($cod)
			{
				$obj = new PagamentosModel();
				$dado = $obj->listById($cod);

				include_once("sk_pagamento.html");
			}
		}
		else
		{
			echo ("<script>alert('Opção inválida.'); window.location=\"pagamentos.php\"</script>");
		}
	}
}
else
{
	echo ("<script>alert('Você precisa estar logado.'); window.location=\"index.php\"</script>");
}

?>