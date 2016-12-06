jQuery(function($){
  //transformando os campos com id do telefone em uma forma padronizada
  $("#telefone").mask("999999999999");
  //  //transformando os campos com id do rg em uma forma padronizada
  $("#rg").mask("9999999");
  //transformando os campos com id do cpf em uma forma padronizada
  $("#cpf").mask("99999999999");
  //transformando os campos com id do horario em forma padronizada
  $("#horario").mask("99:99");
});
