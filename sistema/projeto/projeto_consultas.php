<h1 class="titulo-pagina">Consulta de Projetos</h1>

<!-- Área filtro -->

<h2 class="subtitulo">Filtro</h2>
  <form name="frmfiltroprojetos" action="?pas=projeto&arq=consultas" method="POST">
    <div class="area-filtro-projetos">
      <div class="div-e-filtro"><!-- Início div-e-filtro -->
        <div>
          <label>Nome do Cliente: </label>
          <input type="text" name="txtnome" placeholder="João" maxlength="20"></input>
        </div>
        <div>
          <label>Ambiente: </label>
          <select name="selambiente">
            <option value="">...</option>
            <?php

$sql_sel_ambientes = "SELECT nome, id FROM ambientes";
$sql_sel_ambientes_preparado = $conexaobd->prepare($sql_sel_ambientes);
$sql_sel_ambientes_preparado->execute();

while ($sql_sel_ambientes_dados = $sql_sel_ambientes_preparado->fetch()) {
	?>
            <option value="<?php echo $sql_sel_ambientes_dados['id'] ?>"><?php echo $sql_sel_ambientes_dados['nome'] ?></option>
            <?php
}
?>
          </select>
        </div>
      </div><!-- Fim div-e-filtro -->

      <div class="div-d-filtro"><!-- Início div-d-filtro -->
        <div>
          <label>Funcionário: </label>
          <select name="selfuncionario">
            <option value="">...</option>
            <?php
$sql_sel_funcionarios = "SELECT nome, id FROM funcionarios";
$sql_sel_funcionarios_preparado = $conexaobd->prepare($sql_sel_funcionarios);
$sql_sel_funcionarios_preparado->execute();
while ($sql_sel_funcionarios_dados = $sql_sel_funcionarios_preparado->fetch()) {
	?>
            <option value="<?php echo $sql_sel_funcionarios_dados['id'] ?>"><?php echo $sql_sel_funcionarios_dados['nome'] ?></option>
            <?php
}
?>
          </select>
        </div>
        <div>
          <label>Status do Projeto: </label>
          <select name="selstatus">
            <option value="">...</option>
            <option value="1">Aguardando recolhimento de informações</option>
            <option value="2">Desenvolvimento de pré-molde</option>
            <option value="3">Em produção</option>
            <option value="4">Projeto finalizado</option>
            <option value="5">Projeto concluído</option>
            <option value="6">Projeto cancelado</option>
          </select>
        </div>
      </div><!-- Fim div-d-filtro -->
      <div class="filtro-projetos">
        <label>Título: </label>
        <input type="text" name="txttitulo" placeholder="titulo"></input><button type="submit" name="btnenviar" class="btn-filtro-projeto" >Pesquisar</button>
      </div>
    </div>
  </form>

    <?php
if ((isset($_POST['txtnome'])) || (isset($_POST['selambiente'])) || (isset($_POST['selfuncionario'])) || (isset($_POST['txttitulo'])) || (isset($_POST['selstatus']))) {
	$p_nome = $_POST['txtnome'];
	$p_ambiente = $_POST['selambiente'];
	$p_funcionario = $_POST['selfuncionario'];
	$p_titulo = $_POST['txttitulo'];
	$p_status = $_POST['selstatus'];

	?>

          <h2 class="subtitulo">Projetos Registrados</h2>
            <section>
              <div class="tabela-consultas-2">
                <table id="tr-link">
                 <thead>
                   <tr>
                     <th width="16%">Nome do Cliente</th>
                     <th width="16%">Título</th>
                     <th width="16%">Status</th>
                     <th width="16%">Data de Criação</th>
                     <th width="16%">Data de Entrega</th>
                     <th width="16%">Funcionário</th>
                   </tr>
                 </thead>
                 <tbody>
          <?php
$sql_sel_pesquisa = "SELECT clientes.nome as nome_cliente, projetos.titulo, projetos.status, funcionarios.nome as
          nome_funcionario, projetos.id as projetos_id FROM clientes INNER JOIN projetos on clientes.id=projetos.clientes_id
          INNER JOIN funcionarios on projetos.funcionarios_id=funcionarios.id WHERE clientes.nome LIKE '%" . $p_nome . "%' AND
          funcionarios.id LIKE '%" . $p_funcionario . "%' AND projetos.status LIKE '%" . $p_status . "%'
          AND projetos.titulo LIKE '%" . $p_titulo . "%'";

	$sql_sel_pesquisa_preparado = $conexaobd->prepare($sql_sel_pesquisa);
	$sql_sel_pesquisa_preparado->execute();

	//Se a pesquisa encontrar valores
	if ($sql_sel_pesquisa_preparado->rowCount() > 0) {

		while ($sql_sel_pesquisa_dados = $sql_sel_pesquisa_preparado->fetch()) {

			$status = projeto($sql_sel_pesquisa_dados['status']);

			$sql_sel_agendamentos = "SELECT data_criada FROM agendamentos WHERE projetos_id = '" . $sql_sel_pesquisa_dados['projetos_id'] . "'
                  AND id LIKE '%" . $p_ambiente . "%'";
			$sql_sel_agendamentos_preparado = $conexaobd->prepare($sql_sel_agendamentos);
			$sql_sel_agendamentos_preparado->execute();
			$sql_sel_agendamentos_dados = $sql_sel_agendamentos_preparado->fetch();

			$sql_sel_entrega = "SELECT data_marcada FROM agendamentos WHERE tipo='3' AND projetos_id = '" . $sql_sel_pesquisa_dados['projetos_id'] . "' AND id LIKE '%" . $p_ambiente . "%' ";
			$sql_sel_entrega_preparado = $conexaobd->prepare($sql_sel_entrega);
			$sql_sel_entrega_preparado->execute();
			$sql_sel_entrega_dados = $sql_sel_entrega_preparado->fetch();

      if ($sql_sel_agendamentos_preparado->rowCount() == 0) {
        $data_marcada = "Sem data marcada";
        $data_criada = "Sem data criada";
      } else {
        if ($sql_sel_entrega_preparado->rowCount() > 0) {
          $data_marcada = data_local($sql_sel_entrega_dados['data_marcada']);
        } else {
          $data_marcada = "Sem data marcada";
        }
        $data_criada = data_local($sql_sel_agendamentos_dados['data_criada']);
      }

			?>

                    <tr href="?pas=projeto&arq=consultadetalhada&id=<?php echo $sql_sel_pesquisa_dados['projetos_id']; ?>">
                      <td><?php echo $sql_sel_pesquisa_dados['nome_cliente']; ?></td>
                      <td><?php echo $sql_sel_pesquisa_dados['titulo']; ?></td>
                      <td><?php echo $status; ?></td>
                      <td><?php echo $data_criada; ?></td>
                      <td><?php echo $data_marcada; ?></td>
                      <td><?php echo $sql_sel_pesquisa_dados['nome_funcionario']; ?></td>
                    </tr>

                  <?php
}
	} else {
		?>
                <tr>
                  <td colspan="6">Não foram encontrados projetos</td>
                </tr>
              <?php
}

	?>
          </tbody>
        </table>
      </div>
    </section>
          <?php

	//Se a pesquisa não for feita
} else {
	?>

<!-- Fim área filtro -->

<!-- Área da tabela geral -->
    <h2 class="subtitulo">Projetos Registrados</h2>
    <section>
      <div class="tabela-consultas-2">
        <table id="tr-link">
          <?php
$sql_sel_projetos = "SELECT clientes.nome as nome_cliente, projetos.titulo, projetos.status, funcionarios.nome as nome_funcionario, projetos.id as projetos_id
             FROM clientes INNER JOIN projetos on clientes.id=projetos.clientes_id INNER JOIN funcionarios on projetos.funcionarios_id=funcionarios.id";
	$sql_sel_projetos_preparado = $conexaobd->prepare($sql_sel_projetos);
	$sql_sel_projetos_preparado->execute();

	?>
            <thead>
              <tr>
                <th width="16%">Nome do Cliente</th>
                <th width="16%">Título</th>
                <th width="16%">Status</th>
                <th width="16%">Data de Criação</th>
                <th width="16%">Data de Entrega</th>
                <th width="16%">Funcionário</th>
              </tr>
            </thead>
            <tbody>
              <?php
if ($sql_sel_projetos_preparado->rowCount() > 0) {
		while ($sql_sel_projetos_dados = $sql_sel_projetos_preparado->fetch()) {

			$status = projeto($sql_sel_projetos_dados['status']);

			$sql_sel_agendamentos = "SELECT data_criada, data_marcada FROM agendamentos WHERE projetos_id = '" . $sql_sel_projetos_dados['projetos_id'] . "'";
			$sql_sel_agendamentos_preparado = $conexaobd->prepare($sql_sel_agendamentos);
			$sql_sel_agendamentos_preparado->execute();
			$sql_sel_agendamentos_dados = $sql_sel_agendamentos_preparado->fetch();

			$sql_sel_entrega = "SELECT data_marcada FROM agendamentos WHERE tipo='3' AND projetos_id = '" . $sql_sel_projetos_dados['projetos_id'] . "' ";
			$sql_sel_entrega_preparado = $conexaobd->prepare($sql_sel_entrega);
			$sql_sel_entrega_preparado->execute();
			$sql_sel_entrega_dados = $sql_sel_entrega_preparado->fetch();

			if ($sql_sel_agendamentos_preparado->rowCount() == 0) {
				$data_marcada = "Sem data marcada";
				$data_criada = "Sem data criada";
			} else {
				if ($sql_sel_entrega_preparado->rowCount() > 0) {
					$data_marcada = data_local($sql_sel_entrega_dados['data_marcada']);
				} else {
					$data_marcada = "Sem data marcada";
				}
				$data_criada = data_local($sql_sel_agendamentos_dados['data_criada']);
			}

			?>

              <tr href="?pas=projeto&arq=consultadetalhada&id=<?php echo $sql_sel_projetos_dados['projetos_id'] ?>">
                <td><?php echo $sql_sel_projetos_dados['nome_cliente']; ?></td>
                <td><?php echo $sql_sel_projetos_dados['titulo']; ?></td>
                <td><?php echo $status; ?></td>
                <td><?php echo $data_criada; ?></td>
                <td><?php echo $data_marcada; ?></td>
                <td><?php echo $sql_sel_projetos_dados['nome_funcionario']; ?></td>
              </tr>
              <?php
}
	} else {
		?>
                  <tr href="#">
                    <td colspan="6">Não existem projetos registrados</td>
                  </tr>
                  <?php
}
}
?>
            </tbody>
        </table>
      </div>
    </section>
<!-- Fim da área da tabela geral -->
