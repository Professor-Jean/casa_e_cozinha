<?php
  include "../../../seguranca\bd\bd_conexao.php";
  include "../../../adicionais\php\php_operacoesbd.php";

  // id do funcionario pego via get da tabela anterior
  $g_id = $_GET['id'];
  // select para mostrar as informações do funcionário/usuario
  $sql_sel_funcionario = "SELECT usuarios.usuario,usuarios.id, funcionarios.nome, funcionarios.email, funcionarios.telefone FROM usuarios INNER JOIN funcionarios ON usuarios.id = funcionarios.usuarios_id WHERE funcionarios.id = '".$g_id."'";
  $sql_sel_funcionario_preparado = $conexaobd->prepare($sql_sel_funcionario);
  $sql_sel_funcionario_preparado->execute();
  $sql_sel_funcionario_dados = $sql_sel_funcionario_preparado->fetch();
?>
<link rel="stylesheet" href="../layout\css\css_modalpersonalizado.css">
<h1 class="h1custom">Edição de Funcionário</h1>
<form name="modal-edicaofuncionario" action="?pas=funcionario&arq=operacoes" method="POST">
  <div class="modal-div-e">
    <div>
      <input type="hidden" name="hidid" value="<?php echo $sql_sel_funcionario_dados['id'] ?>";>
      <input type="hidden" name="operacao" value="2">
      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" id="usuario" value="<?php echo $sql_sel_funcionario_dados['usuario']; ?>" maxlength="20">
    </div>
    <div>
      <label for="senha">Senha:</label>
      <input type="password" name="senha" id="senha" maxlength="32">
    </div>
  </div>
  <div class="modal-div-d">
    <div>
      <label for="nome">Nome:</label>
      <input type="text" name="nome" id="nome" value="<?php echo $sql_sel_funcionario_dados['nome']; ?>" maxlength="45">
    </div>
    <div>
      <label for="email">E-Mail:</label>
      <input type="text" name="email" id="email" value="<?php echo $sql_sel_funcionario_dados['email']; ?>" maxlength="100">
    </div>
    <div>
      <label for="telefone">Telefone:</label>
      <input type="text" name="telefone" id="telefone" value="<?php echo $sql_sel_funcionario_dados['telefone']; ?>" maxlength="14">
    </div>
  </div>
  <div class="modal-btn">
    <a href="#close-modal" rel="modal:close"><button class="modal-btn-fechar" type="button" name="fechar">Fechar</button></a>
    <button class="modal-btn-salvar" type="submit" name="registrar">Salvar</button>
  </div>
</form>
