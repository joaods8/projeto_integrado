<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/AlunosDataModel.php");
include_once($PATH."common/common.php");
include_once($PATH."pai.php");

date_default_timezone_set('America/Los_Angeles');

$cod = trim(addslashes((($_GET['cod']))));
$acao = trim(addslashes((($_GET['acao']))));

if($_SESSION['codigo'])
{	
	if($acao)
	{
		if($acao == "cad") 
		{
			$dado = new AlunosController();
			$dado->setID(null);
			$dado->setNome(null);
			$dado->setEmail(null);
			$dado->setTelefone(null);
			$dado->setStatus(null);
			$dado->setNascimento(null);
			$dado->setProfissao(null);
			$dado->setPlano(null);

			include_once("sk_aluno.html");
		}
		elseif($acao == "add") {
			$alunos = new AlunosController();
			$obj = new AlunosModel();

			$alunos->setNome(trim(addslashes((($_POST['nome'])))));
			$alunos->setTelefone(trim(addslashes((($_POST['telefone'])))));
			$alunos->setEmail(trim(addslashes((($_POST['email'])))));
			$alunos->setStatus(trim(addslashes((($_POST['status'])))));
			$alunos->setNascimento(trim(addslashes((($_POST['nascimento'])))));
			$alunos->setProfissao(trim(addslashes((($_POST['profissao'])))));
			$alunos->setPlano(trim(addslashes((($_POST['plano'])))));
			$alunos->setDataCadastro(date("d-m-Y H:i:s"));

			if($cod)
			{
				$alunos->setID($cod);
				$retorno = $obj->update($alunos);
				if($retorno)
		            echo ("<script>alert('Registro alterado com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não foi possível alterar, tente novamente.'); window.location=\"alunos.php\"</script>");
			}
			else
			{
				$retorno = $obj->save($alunos);

				//registro o inicio do aluno
				$objAD = new AlunosDataModel();
				$datas = new AlunosDataController();
				$datas->setDataInicio(date("d/m/Y"));
				$datas->setIdAluno($retorno);
				$objAD->save($datas);

		        if($retorno)
		            echo ("<script>alert('Registro incluido com sucesso!'); window.location=\"alunos.php\"</script>");
		        else
		        	echo ("<script>alert('Não é possível incluir itens iguais, tente novamente.'); window.location=\"alunos.php\"</script>");
	    	}
		}
		elseif($acao == "edit") {
			if($cod)
			{
				$obj = new AlunosModel();
				$dado = $obj->listById($cod);

				include_once("sk_aluno.html");
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