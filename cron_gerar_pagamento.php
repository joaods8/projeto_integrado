<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/AlunosDataModel.php");
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."common/common.php");
include_once($PATH."pai.php");

//seleciona todos os alunos ativos
$objA = new AlunosModel();
$objP = new PagamentosModel();

//alunos ativos
$alunos = $objA->listaTodosSemLimite();

$objAD = new AlunosDataModel();

//verifica o plano (mensal ou semestral)
foreach ($alunos as $aluno)
{
	$plano = $aluno->getPlano();

	//verifico se o aluno já tem pagamentos
	//se não tiver emito o 1 pagamento com a data de entrada dela

	$quanti_pagamentos = $objP->contadorByAluno($aluno->getId());

	if($quanti_pagamentos == 0)
	{
		//verifica ultima data de entrada
		$datas = $objAD->listLastByAluno($aluno->getId());

		$dataInicio = $datas->getDataInicio();

		//verifico a validade do código
	    $data1 = date('Y-m-d');

		$date = DateTime::createFromFormat('d/m/Y', $dataInicio);
		$data2 = $date->format('Y-m-d');

		$especifica = new DateTime($data2);

		if($plano == 2)
		{
			$proximaAlteracao = $especifica->modify('+6 month');
			$valor = "500,00";
		}
	    else
	    {
	    	$proximaAlteracao = $especifica->modify('+1 month');
	    	$valor = "90,00";
	    } 

	    // Comparando as Datas
	    if(strtotime($data1) == strtotime($proximaAlteracao))
	    {
	        //gero pagamento
	        $pagamentos = new PagamentosController();

			$pagamentos->setDataVencimento(date('d-m-Y'));
			$pagamentos->setValor($valor);
			$pagamentos->setDataPagamento();
			$pagamentos->setIdAluno($aluno->getId());
			$pagamentos->setStatus(1);
			$retorno = $objP->save($pagamentos);
	    }
	}
	else
	{
		//gera o boleto com base na data de vencimento do ultimo gerado
		//verifica ultima data de entrada
		$datas = $objP->listLastByAluno($aluno->getId());

		$dataInicio = $datas->getDataInicio();

		//verifico a validade do código
	    $data1 = date('Y-m-d');

		$date = DateTime::createFromFormat('d/m/Y', $dataInicio);
		$data2 = $date->format('Y-m-d');

		$especifica = new DateTime($data2);

		if($plano == 2)
		{
			$proximaAlteracao = $especifica->modify('+6 month');
			$valor = "500,00";
		}
	    else
	    {
	    	$proximaAlteracao = $especifica->modify('+1 month');
	    	$valor = "90,00";
	    } 

	    // Comparando as Datas
	    if(strtotime($data1) == strtotime($proximaAlteracao))
	    {
	        //gero pagamento
	        $pagamentos = new PagamentosController();

			$pagamentos->setDataVencimento(date('d-m-Y'));
			$pagamentos->setValor($valor);
			$pagamentos->setDataPagamento();
			$pagamentos->setIdAluno($aluno->getId());
			$pagamentos->setStatus(1);
			$retorno = $objP->save($pagamentos);
	    }
	}
}

?>