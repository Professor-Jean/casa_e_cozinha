<?php
/***

  Este arquivo tem como função, padronizar as mensagens que são utilizadas nas
  validações do software

  Autores: Gustavo Habitzreiter, Gustavo de Camargo, Guilherme Foster
  Data de Criação: 21/10
  Data de Modificação: 21/10

***/

  //Recebendo os parâmetros da função
  function mensagem($tipo, $assunto, $acao=NULL){
    //Processando qual é o tipo de mensagem deve ser exibida
    switch($tipo){
      //Caso o campo esteja vazio
      case "vazio":
        return "O campo ".$assunto." não está preenchido!";
      break;

      //Caso o valor esteja fora do padrão
      case "padrao":
        return "O campo ".$assunto." está fora do padrão";
      break;

      //Caso ocorra um erro no banco de dados
      case "bd":
        return "Erro ao ".$acao." ".$assunto;
      break;

      //Caso já exista um registro, que não pode ser duplo, no banco de dados
      case "existencia":
        return "Já existe um registro com o mesmo ".$assunto;
      break;

      //Caso a operação em um arquivo de operações não seja definida
      case "op":
        return "Operção não definida!";
      break;

      //Caso não ocorra nenhum erro
      case "sucesso":
        return $assunto." ".$acao." com sucesso!";
      break;

      //Caso o tipo não seja especificado
      default:
        return "Tipo não identificado";
      break;
    }
  }
?>
