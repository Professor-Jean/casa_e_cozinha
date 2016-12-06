<?php
  /***********************
    Autores: Gustavo Habitzreiter, Gustavo Michels de Camargo, Guilhereme Foster

    Descrição: Validações numéricas

    Data: 11/10/2016

  ************************/

  //Validar número de telefone
    function validar_telefone($num_usuario){
      $resultado = preg_match('/^([0-9]{1,})$/', $num_usuario);


      return $resultado;
    }

  //Validar data
  function validar_data($num_usuario){
    $resultado = preg_match('/^((([0-1]{1}+[0-9]{1})||([2]{1}+[0-3]{1}))+[:]{1}+[0-5]{1}+[0-9]{1})$/', $num_usuario);

    return $resultado;
  }

  //Função utilizada para validar o e-mail
  function validar_email($num_usuario){

    $resultado = filter_var($num_usuario, FILTER_VALIDATE_EMAIL);

    return $resultado;

  }


?>
