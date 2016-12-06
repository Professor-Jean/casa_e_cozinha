<?php
include "../../../seguranca\bd\bd_conexao.php";
include "../../../adicionais\php\php_operacoesbd.php";

global $conexaobd;
$sql_sel_ambientes = "SELECT nome, id FROM ambientes";
$sql_sel_ambientes_preparado = $conexaobd->prepare($sql_sel_ambientes);
$sql_sel_ambientes_resultado = $sql_sel_ambientes_preparado->execute();

if (isset($_GET['ambiente_id'])) {
	$dado_ambiente = selecionar("SELECT ambientes.id, ambientes.nome, projetos_tem_ambientes.descricao  FROM ambientes INNER JOIN projetos_tem_ambientes ON ambientes.id=projetos_tem_ambientes.ambientes_id WHERE ambientes.id='{$_GET['ambiente_id']}' AND projetos_tem_ambientes.projetos_id='{$_GET['projetos_id']}'")->fetch(PDO::FETCH_ASSOC);
	$fazer = "editar";
} else {
	$fazer = "registrar";
}

?>
    <div class="modal-ambientes">
      <div>
        <h1 clas="h1custom">Registro de Ambiente no software</h1>
      </div>
      <form action="?pas=projeto&arq=operacoes" name="edit-ambientes" method="post">
        <?php if ($fazer == "editar") {
	?>
          <input type="hidden" name="operacao" value="9">
          <?php
} elseif ($fazer == "registrar") {
	?>
          <input type="hidden" name="operacao" value="3">
          <?php
}?>
        <input type="hidden" name="projetosid" value="<?php echo $_GET['projetos_id'] ?>">
        <select class="modal-ambientes-select" name="msa-ambiente-id">
          <option value="">Selecione um ambiente</option>
          <?php
while ($sql_sel_ambientes_dados = $sql_sel_ambientes_preparado->fetch()) {
	if (isset($dado_ambiente)) {
		if ($sql_sel_ambientes_dados['id'] == $dado_ambiente['id']) {
			echo "<option value=" . $sql_sel_ambientes_dados['id'] . " selected>" . $sql_sel_ambientes_dados['nome'] . "</option>";
			$ambientesid = $dado_ambiente['id'];
		}
	} else {
		echo "<option value=" . $sql_sel_ambientes_dados['id'] . ">" . $sql_sel_ambientes_dados['nome'] . "</option>";
	}
}
?>
        </select>
        <textarea name="descricao-ambientes" rows="8" cols="60"><?php if (isset($dado_ambiente)) {echo $dado_ambiente['descricao'];}?></textarea>
        <div class="btn-modal-ambientes">
          <?php if ($fazer === 'registrar') {
	?>
            <a href="#close-modal" rel="modal:close"><button type="reset" class="modal-btn modal-btn-fechar" name="fechar-registro">Fechar</button></a>
            <button type="submit" class="modal-btn modal-btn-salvar" name="registrar-ambiente-projeto">Salvar</button>
            <?php
} else {?>
          <button type="submit" class="modal-btn modal-btn-salvar modal-btn-salvar-2" name="registrar-ambiente-projeto">Salvar</button>
        <?php }?>
        </div>
      </form>
      <?php
if ($fazer == "editar") {
	?>
      <form action="?pas=projeto&arq=operacoes" name="del-ambientes" method="post">
        <input type="hidden" name="projetosid" value="<?php echo $_GET['projetos_id']; ?>">
        <input type="hidden" name="msa-ambiente-id" value="<?php echo $ambientesid; ?>">
        <input type="hidden" name="operacao" value="10">
        <button class="modal-btn modal-btn-excluir" type="submit" name="btn-del-ambientes">Excluir</button>
      </form>
      <?php
}
?>
    </div>