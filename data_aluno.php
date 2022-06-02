<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/AlunosDataModel.php");
include_once($PATH."pai.php");

date_default_timezone_set('America/Los_Angeles');

$cod = trim(addslashes((($_GET['cod']))));
$acao = trim(addslashes((($_GET['acao']))));
$idAluno = trim(addslashes((($_GET['aluno']))));

if($_SESSION['codigo'])
{	
	$objA = new AlunosModel();
	$aluno = $objA->listById($idAluno);

	if($acao)
	{
		if($acao == "cad") 
		{
			$dado = new AlunosDataController();
			$dado->setID(null);
			$dado->setDataInicio(null);
			$dado->setDataDesligamento(null);
			$dado->setIdAluno(null);

			include_once("sk_data_aluno.html");
		}
		elseif($acao == "add") {
			$alunos = new AlunosDataController();
			$obj = new AlunosDataModel();

			$alunos->setDataInicio(trim(addslashes((($_POST['data_inicio'])))));
			$alunos->setDataDesligamento(trim(addslashes((($_POST['data_desligamento'])))));
			$alunos->setIdAluno($idAluno);

			if($cod)
			{
				$alunos->setID($cod);
				$retorno = $obj->update($alunos);

				//se tiver data de desligamento inativa o aluno
				$objA = new AlunosModel();
				$status = new AlunosController();

				if(trim(addslashes((($_POST['data_desligamento'])))))
				{
					$status->setStatus(1);
					$status->setId($idAluno);
					$objA->inativaAluno($status);
				}
				else
				{
					$status->setStatus(2);
					$status->setId($idAluno);
					$objA->inativaAluno($status);
				}

				if($retorno)
		            echo ("<script>alert('Registro alterado com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não foi possível alterar, tente novamente.'); window.location=\"alunos.php\"</script>");
			}
			else
			{
				$retorno = $obj->save($alunos);

				//se tiver data de desligamento inativa o aluno
				$objA = new AlunosModel();
				$status = new AlunosController();

				if(trim(addslashes((($_POST['data_desligamento'])))))
				{
					$status->setStatus(1);
					$status->setId($idAluno);
					$objA->inativaAluno($status);
				}
				else
				{
					$status->setStatus(2);
					$status->setId($idAluno);
					$objA->inativaAluno($status);
				}

		        if($retorno)
		            echo ("<script>alert('Registro incluido com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não é possível incluir itens iguais, tente novamente.'); window.location=\"alunos.php\"</script>");
	    	}
		}
		elseif($acao == "edit") {
			if($cod)
			{
				$obj = new AlunosDataModel();
				$dado = $obj->listById($cod);

				include_once("sk_data_aluno.html");
			}
		}
		else
		{
			echo ("<script>alert('Opção inválida.'); window.location=\"alunos.php\"</script>");
		}
	}
}
else
{
	echo ("<script>alert('Você precisa estar logado.'); window.location=\"index.php\"</script>");
}

?>