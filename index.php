<?php 

session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/FuncionariosModel.php");
include_once($PATH."pai.php");

$email = trim($_POST['email']);
$senha = trim(md5($_POST['senha']));

if($email && $senha)
{
	$usuario = new FuncionariosController();
	$obj = new FuncionariosModel();

	$usuario->setEmail($email);
	$usuario->setSenha($senha);

	$dado = $obj->loginAdm($usuario);

	if($dado)
	{
		//ADMINISTRADOR
		$_SESSION['codigo'] = $dado->getId();
		$_SESSION['tipo'] = $dado->getTipo();
		$_SESSION['nome'] = $dado->getNome();

		//funcionario
		if(($_SESSION['tipo'] == "USE542"))
		{
			header ("Location: principal.php");
		}
		else
		{
			//adm
			header ("Location: principal.php");
		}
		
		exit();
	}
	else 
	{
		$sk['MSG'] = "<font color='red'>Email e/ou senha não encontrados.</font>";
		include_once("sk_index.html");
	}
}
else 
{
	include_once("sk_index.html");
}

?>