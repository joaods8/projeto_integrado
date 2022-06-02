<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/PagamentosModel.php");
include_once($PATH."pai.php");

$objA = new AlunosModel();
$objP = new PagamentosModel();

$pagamentos = $objP->listAllAbertos();

include_once("sk_aberto.html");

?>