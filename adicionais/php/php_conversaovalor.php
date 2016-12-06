<?php
/******

Este arquivo contém o código utilizado para converter as vírgulas digitadas pelo usuário
em pontos para o banco de dados, e converter em vírgulas os pontos do valor buscado no
banco de dados

Autores: Gustavo Habitzreiter, Gustavo de Camargo, Guilherme Foster
Data de Criação: 30/11/2016
Data de Modificação: 30/11/2016

 ****/

function valorPonto($valor) {
	if($valor==""){
		$valor_resultado = "";
	}else{
		//Removendo qualuqer vírgula digitada pelo usuário
		$valor_alterado = explode(",", $valor);

		//Adicionando ponto a string para que ela seja aceita pelo banco de dados
		$valor_resultado = $valor_alterado[0] . "." . $valor_alterado[1];

	}


	//Retornando o valor para a página de validação
	return $valor_resultado;
}

function valorVirgula($valor) {
	if($valor==""){
		$valor_resultado = "";
	}else{
		//Removendo qualquer ponto da variável
		$valor_alterado = explode(".", $valor);

		//Adicionando vírgula a string para que ela seja visualizada
		$valor_resultado = "R$ ".$valor_alterado[0] . "," . $valor_alterado[1];
	}

	//Retornando o valor para a página
	return $valor_resultado;
}
?>
