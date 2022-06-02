<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."common/class.phpmailer.php");
include_once($PATH."common/class.smtp.php");
include_once($PATH."pai.php");

$objA = new AlunosModel();
$objP = new PagamentosModel();

$pagamentos = $objP->listAllAbertos();

//seleciona todos os alunos ativos
foreach($pagamentos as $pagamento)
{
	//verifica email do aluno
	$aluno = $objA->listById($pagamento->getIdAluno());

	//envia email
	$mensagemHTML = '
					Olá '.$aluno->getNome().',<br>
					Verificamos que sua mensalidade com vencimento em '$pagamento->getDataVencimento().' e no valor de R$ '.$pagamento->getValor().' ainda está pendente. Pedimos que entre em contato com a academia para regularizar sua situação.
							<br><br>
							Atenciosamente<br> Acadetech.';

					if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
					else $quebra_linha = "\n"; //Se "não for Windows"

					$headers = "MIME-Version: 1.1" .$quebra_linha;
					$headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra_linha;

					$emailsender = "naoresponder@acadetech.com.br";
					$emaildestinatario = $aluno->getEmail();
					$assunto = "Acadetech - Pagamento pendente ";

					if(!mail($emaildestinatario, $assunto, $mensagemHTML, $headers ,"-r".$emailsender)){ // Se for Postfix
						$headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"

						mail($emaildestinatario, $assunto, $mensagemHTML, $headers );
					}
}

?>