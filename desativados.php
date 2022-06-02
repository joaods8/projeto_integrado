<?php 
session_start();

$PATH = "/home/u315715135/domains/acadetech.com.br/public_html/";
include_once($PATH."model/AlunosModel.php");
include_once($PATH."model/AlunosDataModel.php");
include_once($PATH."pai.php");

$objA = new AlunosModel();
$objAD = new AlunosDataModel();

$alunos = $objA->listAllDesativados();

include_once("sk_desativados.html");

?>