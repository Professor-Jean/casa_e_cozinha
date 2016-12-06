<?php
/******

Este arquivo tem como objetivo converter as datas para mostragem de dados ao usuário
e conversão de datas para o banco de dados interpretar

Autores: Gustavo Habitzreiter, Gustavo de Camargo, Guilherme Foster
Data de Criação: 29/10/2016
Data de Modificação: 29/10/2016

 ****/

//Converter data que o banco de dados aceita para a data utilizada no Brasil
function data_local($data) {
	//Removendo traços
	$conversao = explode("-", $data);
	//Reorganizando por DD/MM/AAAA
	$convertida = $conversao[2] . "/" . $conversao[1] . "/" . $conversao[0];
	//Retornando o valor da variável a página que chamou a função
	return $convertida;
}

//Converter data que é mostrada ao usuário para data no formato iso 8601 aceito pelo banco de dados
function data_iso($data) {
	//Removendo barras
	$conversao = explode("/", $data);
	//Reorganizando por AAAA-MM-DD
	$convertida = $conversao[2] . "-" . $conversao[1] . "-" . $conversao[0];
	//Retornando o valor da variável a página que chamou a função
	return $convertida;
}

?>
