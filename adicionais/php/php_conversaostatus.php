<?php
/****

  Este arquivo tem o objetivo de trocar os status de agendamento e projeto em caracteres,
  para facilitar a visualização do usuário

  Autores: Gustavo Habitzreiter, Gustavo de Camargo, Guilherme Foster
  Data de Criação: 29/10/2016
  Data de Modificação: 29/10/2016

****/

  //Caso o status seja de agendamentos
  function agendamento($status){
    switch ($status){
      case '0':
        return "Pendente";
        break;

      case '1':
        return "Completo";
        break;

      case '2':
        return "Incompleto";
        break;

      case '3':
        return "Cancelado";
        break;

      default:
        return "Erro";
        break;
    }
  }

  //Caso o status seja de projeto
  function projeto($status){
    switch($status){
      case '1':
        return "Aguardando recolhimento de informações";
        break;

      case '2':
        return "Desenvolvimento de pré-molde";
        break;

      case '3':
        return "Em produção";
        break;

      case '4':
        return "Projeto finalizado";
        break;

      case '5':
        return "Projeto concluído";
        break;

      case '6':
        return "Projeto Cancelado";
        break;

      default:
        return "Erro";
        break;
    }
}

?>
