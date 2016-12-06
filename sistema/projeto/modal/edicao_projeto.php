<?php
include "../../../seguranca/bd/bd_conexao.php";
include "../../../adicionais/php/php_operacoesbd.php";
include "../../../adicionais/php/php_conversaostatus.php";
include "../../../adicionais/php/php_conversaovalor.php";
$projeto_id = $_GET['id'];
$sel_projeto = "SELECT projetos.funcionarios_id AS 'funcionarios_id', projetos.status, projetos.titulo, projetos.bairro, projetos.logradouro, projetos.numero, projetos.complemento, projetos.cidade, projetos.descricao, projetos.valor FROM projetos WHERE projetos.id='{$projeto_id}'";
$sel_projeto = $conexaobd->prepare($sel_projeto);
$sel_projeto->execute();
$dado_projeto = $sel_projeto->fetch(PDO::FETCH_ASSOC);

$sel_funcionario = "SELECT funcionarios.id, funcionarios.nome FROM funcionarios ORDER BY funcionarios.nome ASC";
$sel_funcionario = $conexaobd->prepare($sel_funcionario);
$sel_funcionario->execute();
$dado_funcionario = $sel_funcionario->fetchAll(PDO::FETCH_ASSOC);

switch ($dado_projeto['status']) {
case 1:
	$dado_projeto['status'] = "Aguardando recolhimento de informações";
	break;
case 2:
	$dado_projeto['status'] = "Desenvolvimento pré-molde";
	break;
case 3:
	$dado_projeto['status'] = "Em produção";
	break;
case 4:
	$dado_projeto['status'] = "Projeto finalizado";
	break;
case 5:
	$dado_projeto['status'] = "Projeto concluido";
	break;
case 6:
	$dado_projeto['status'] = "Projeto cancelado";
	break;
}

?>
<link rel="stylesheet" href="layout\css\css_modalpersonalizado.min.css">

<div class="projeto-modal">
  <div class="projeto-modal-titulo">
    <h1>Edição de Projeto</h1>
  </div>
  <form class="projeto-modal-tabela" action="?pas=projeto&arq=operacoes" method="post">
    <input type="hidden" name="operacao" value="2">
    <input type="hidden" name="id" value="<?php echo $projeto_id; ?>">
    <div class="projeto-modal-tabela-esquerda">
      <div class="projeto-modal-tabela-esquerda-cidade">
        <label for="cidade">Cidade:</label>
        <input id="cidade" type="text" name="cidade" maxlength="30" value="<?php echo $dado_projeto['cidade'] ?>">
      </div>
      <div class="projeto-modal-tabela-esquerda-bairro">
        <label for="bairro">Bairro:</label>
        <input id="cidade" type="text" name="bairro" maxlength="20" value="<?php echo $dado_projeto['bairro'] ?>">
      </div>
      <div class="projeto-modal-tabela-esquerda-logradouro">
        <label for="logradouro">Logradouro:</label>
        <input id="logradouro" type="text" name="logradouro" maxlength="45" value="<?php echo $dado_projeto['logradouro'] ?>">
      </div>
      <div class="projeto-modal-tabela-esquerda-complemento">
        <label for="complemento">Complemento:</label>
        <input id="complemento" type="text" name="complemento" maxlength="40" value="<?php echo $dado_projeto['complemento'] ?>">
      </div>
      <div class="projeto-modal-tabela-esquerda-numero">
        <label for="numero">Número de Residencia:</label>
        <input id="numero" type="text" name="numero" maxlength="5" value="<?php echo $dado_projeto['numero'] ?>">
      </div>
    </div><!-- Fim projeto-modal-tabela-esquerda -->
    <div class="projeto-modal-tabela-direta">
      <div class="projeto-modal-tabela-direta-titulo">
        <label for="titulo">Titulo:</label>
        <input id="titulo" type="text" name="titulo" maxlength="45" value="<?php echo $dado_projeto['titulo'] ?>">
      </div>
      <div class="projeto-modal-tabela-direta-funcionario">
        <label for="funcionario">Funcionário:</label>
        <select id="funcionario" name="funcionario">
          <?php
foreach ($dado_funcionario as $dado_funcionario) {
	if ($dado_funcionario['id'] == $dado_projeto['funcionarios_id']) {
		?>
              <option value="<?php echo $dado_funcionario['id']; ?>" selected><?php echo $dado_funcionario['nome']; ?></option>
              <?php
} else {
		?>
          <option value="<?php echo $dado_funcionario['id']; ?>"><?php echo $dado_funcionario['nome']; ?></option>
          <?php
}
}
?>
        </select>
      </div>
      <div class="projeto-modal-tabela-direta-valor">
        <label for="valor">Valor do projeto:</label>
        <input id="valor" type="text" name="valor" value="<?php echo valorVirgula($dado_projeto['valor']); ?>">
      </div>
      <div class="projeto-modal-tabela-direta-status">
        <span>
          Status: <?php echo projeto($dado_projeto['status']); ?>
        </span>
      </div>
    </div><!-- Fim projeto-modal-tabela-direta -->
    <div class="projeto-modal-tabela-descricao">
      <textarea name="descricao" rows="10" cols="100"><?php echo $dado_projeto['descricao']; ?></textarea>
    </div>
    <div class="projeto-modal-tabela-botoes">
      <div class="projeto-modal-tabela-botoes-fechar">
				<a href="#close-modal" rel="modal:close">
					<button type="button" name="button">Fechar</button>
				</a>
      </div>
      <div class="projeto-modal-tabela-botoes-salvar">
        <button type="submit" name="button">Salvar</button>
      </div>
    </div><!-- Fim projeto-modal-tabela-botoes -->
  </form><!-- Fim projeto-modal-tabela -->
</div><!-- Fim projeto-modal -->
