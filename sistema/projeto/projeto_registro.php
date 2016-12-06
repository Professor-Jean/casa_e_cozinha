<?php

$sql_sel_clientes = "SELECT nome, id FROM clientes";
$sql_sel_clientes_preparado = selecionar($sql_sel_clientes);
$sql_sel_clientes_preparado->execute();

$sql_sel_funcionarios = "SELECT nome, id FROM funcionarios";
$sql_sel_funcionarios_preparado = selecionar($sql_sel_funcionarios);
$sql_sel_funcionarios_preparado->execute();

?>
<div class="registro-projeto">
  <div>
    <h1 class="h1custom">Registro de Projeto</h1>
  </div>
  <form name="registro_projeto" action="?pas=projeto&arq=operacoes" method="POST" onsubmit="return validarRegistroP()">
    <input type="hidden" name="operacao" value="1">
  <div>
    <select class="select-projeto" name="cliente">
      <option value="">Cliente</option>
      <?php
if ($sql_sel_clientes_preparado->rowCount() > 0) {
	while ($sql_sel_clientes_dados = $sql_sel_clientes_preparado->fetch()) {
		echo "<option value = " . $sql_sel_clientes_dados['id'] . ">" . $sql_sel_clientes_dados['nome'] . "</option>";
	}
}
?>
    </select>
    <select class="select-projeto" name="funcionario">
      <option value="">Funcionário</option>
      <?php
if ($sql_sel_funcionarios_preparado->rowCount() > 0) {
	while ($sql_sel_funcionarios_dados = $sql_sel_funcionarios_preparado->fetch()) {
		echo "<option value=" . $sql_sel_funcionarios_dados['id'] . "> " . $sql_sel_funcionarios_dados['nome'] . "</option>";
	}
}
?>
    </select>
  </div>
    <div>
      <label for="titulo" >Titulo</label>
      <input id="titulo" type="text" name="titulo" placeholder="Titulo" maxlength="45">
    </div>
    <div>
      <label for="cidade" >Cidade</label>
      <input id="cidade" type="text" name="cidade" placeholder="Cidade" maxlength="30">
    </div>
    <div>
      <label for="bairro" >Bairro</label>
      <input id="bairro" type="text" name="bairro" placeholder="Bairro" maxlength="20">
    </div>
    <div>
      <label for="rua" >Logradouro</label>
      <input id="rua" type="text" name="rua" placeholder="Logradouro" maxlength="45">
    </div>
    <div>
      <label for="numero" >Número de Residência</label>
      <input id="numero" type="text" name="numero" placeholder="Número de Residência" maxlength="5">
    </div>
    <div>
      <label for="complemento" >Complemento</label>
      <input id="complemento" type="text" name="complemento" placeholder="Complemento" maxlength="40">
    </div>
    <div>
      <label for="valor">Valor</label>
      <input id="valor" type="text" name="valor" placeholder="R$" maxlength="11">
    </div>
    <div>
      <textarea name="descricao" rows="5" cols="117" placeholder="Descrição"></textarea>
    </div>
    <div class="btn-projeto">
      <button class="btn-limpar" type="reset" name="limpar">Limpar</button>
      <button class="btn-registro" type="submit" name="registrar">Registrar</button>
    </div>
  </form>
</div>
