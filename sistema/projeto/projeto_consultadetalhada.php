<?php
if (!$projeto_id = $_GET['id']) {
	echo "<h1 class='titulo-pagina'>Projeto não identificado</h1>";
} else {
// Buscando informações do projeto no banco de dados
	$sel_projeto = selecionar("SELECT funcionarios.nome as 'funcionarios_nome', funcionarios.id AS 'funcionarios_id',clientes.nome AS 'clientes_nome', clientes.telefone AS 'clientes_telefone', clientes.email AS 'clientes_email', clientes.id AS 'clientes_id', projetos.status AS 'projetos_status', projetos.titulo AS 'projetos_titulo', projetos.bairro AS 'projetos_bairro', projetos.logradouro AS 'projetos_logradouro', projetos.numero AS 'projetos_numero', projetos.complemento AS 'projetos_complemento', projetos.cidade AS 'projetos_cidade', projetos.valor AS 'projetos_valor', projetos.descricao AS ' projetos_descricao' FROM projetos INNER JOIN funcionarios ON funcionarios.id=funcionarios_id INNER JOIN clientes ON clientes_id=clientes.id WHERE projetos.id='{$projeto_id}'");
	if ((!$sel_projeto) || ($sel_projeto->rowCount() == 0)) {
		echo "<h1 class='titulo-pagina'>Projeto não identificado</h1>";
	} else {

		// Buscando informações dos agendamentos no bando de dados
		$sel_agendamento = selecionar("SELECT agendamentos.id, data_marcada, agendamentos.tipo, agendamentos.status FROM agendamentos INNER JOIN projetos ON projetos.id=agendamentos.projetos_id WHERE projetos.id='{$projeto_id}' ORDER BY agendamentos.tipo ASC, agendamentos.id ASC");

		// Buscando agendamentos no banco
		$sel_ambientes = selecionar("SELECT ambientes.id AS 'ambientes_id', ambientes.nome AS 'ambientes_nome' FROM ambientes INNER JOIN projetos_tem_ambientes ON ambientes.id=projetos_tem_ambientes.ambientes_id WHERE projetos_id='{$projeto_id}'");

		// Buscando arquivos promob
		$sel_arquivos = selecionar("SELECT arquivos.id, arquivos.nome, arquivos.caminho, arquivos.data FROM arquivos WHERE arquivos.projetos_id='{$projeto_id}' ORDER BY arquivos.data DESC");

		$dado_projeto = $sel_projeto->fetch(PDO::FETCH_ASSOC);
		$dado_agendamento = $sel_agendamento->fetchAll(PDO::FETCH_ASSOC);
		$dado_ambientes = $sel_ambientes->fetchAll(PDO::FETCH_ASSOC);
		$dado_arquivos = $sel_arquivos->fetchAll(PDO::FETCH_ASSOC);

		// Separando os agendamentos de tipos diferentes em variaveis diferentes
		if (count($dado_agendamento) > 0) {
			foreach ($dado_agendamento as $agendamento) {
				switch ($agendamento['tipo']) {
				case 1:
					$agendamento_recolhimento[] = array('id' => $agendamento['id'], 'data_marcada' => data_local($agendamento['data_marcada']), 'status' => $agendamento['status']);
					break;

				case 2:
					$agendamento_homologacao[] = array('id' => $agendamento['id'], 'data_marcada' => data_local($agendamento['data_marcada']), 'status' => $agendamento['status']);
					break;

				case 3:
					$agendamento_entrega[] = array('id' => $agendamento['id'], 'data_marcada' => data_local($agendamento['data_marcada']), 'status' => $agendamento['status']);
					break;
				}
			}
		}

/* Verficando os agendamentos para os casos de novos agendamentos */
		if (isset($agendamento_recolhimento)) {
			$agendamento_aux = count($agendamento_recolhimento) - 1;
			if (($agendamento_recolhimento[$agendamento_aux]['status'] == 2) || ($agendamento_recolhimento[$agendamento_aux]['status'] == 3)) {
				$agendamento_recolhimento[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
			}
		} else {
			$agendamento_recolhimento[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
		}

		if (isset($agendamento_homologacao)) {
			$agendamento_aux = count($agendamento_homologacao) - 1;
			if (($agendamento_homologacao[$agendamento_aux]['status'] == 2) || ($agendamento_homologacao[$agendamento_aux]['status'] == 3)) {
				$agendamento_homologacao[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
			}
		} else {
			if (isset($agendamento_recolhimento)) {
				$agendamento_aux = 0;
				foreach ($agendamento_recolhimento as $agendamento) {
					if ($agendamento['status'] == 1) {
						$agendamento_homologacao[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
						$agendamento_aux = 1;
					}
				}
				if ($agendamento_aux == 0) {
					$agendamento_homologacao[] = array('id' => 'Inexistente', 'data_marcada' => 'Aguardando Recolhimento', 'status' => 4);

				}
			} else {
				$agendamento_homologacao[] = array('id' => 'Inexistente', 'data_marcada' => 'Aguardando Recolhimento', 'status' => 4);
			}
		}

		if (isset($agendamento_entrega)) {
			$agendamento_aux = count($agendamento_entrega) - 1;
			if (($agendamento_entrega[$agendamento_aux]['status'] == 2) || ($agendamento_entrega[$agendamento_aux]['status'] == 3)) {
				$agendamento_entrega[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
			}
		} elseif (isset($agendamento_homologacao)) {
			$agendamento_aux = 0;
			foreach ($agendamento_homologacao as $agendamento) {
				if ($agendamento['status'] == 1) {
					$agendamento_entrega[] = array('id' => 'novo', 'data_marcada' => 'Marque', 'status' => 0);
					$agendamento_aux = 1;
				}
			}
			if ($agendamento_aux == 0) {
				$agendamento_entrega[] = array('id' => 'Inexistente', 'data_marcada' => 'Aguardando Homologação', 'status' => 4);
			}
		} else {
			$agendamento_entrega[] = array('id' => 'Inexistente', 'data_marcada' => 'Aguardando Homologação', 'status' => 4);
		}

/*
Temino do agendamento
 */

		?>
<h1 class="cpd-titulo">Consulta de Projeto detalhado</h1>
<div class="cpd-esquerda">
  <div class="cpd cpd-esquerda-cliente">
    <div class="cpd-esquerda-cliente-botao">
      <a href="?pas=cliente&arq=consultadetalhada&id=<?php echo $dado_projeto['clientes_id']; ?>">
        <button type="button" name="button"></button>
      </a>
    </div><!-- Fim cpd-esquerda-cliente-botao -->
    <div class="cpd-esquerda-cliente-nome">
      <span>Cliente:<?php echo $dado_projeto['clientes_nome']; ?></span>
    </div><!-- Fim cpd-esquerda-cliente-nome -->
    <div class="cpd-esquerda-cliente-telefone">
      <span>Telefone: <?php echo $dado_projeto['clientes_telefone']; ?></span>
    </div><!-- Fim cpd-esquerda-cliente-telefone -->
    <div class="cpd-esquerda-cliente-email">
      <span>Email: <?php echo $dado_projeto['clientes_email']; ?></span>
    </div><!-- Fim cpd-esquerda-cliente-email -->
  </div><!-- Fim cpd cpd-esquerda-cliente -->
  <div class="cpd cpd-esquerda-arquivos">
    <div class="cpd-esquerda-arquivos-titulo">
      <span>Arquivos:</span>
    </div><!-- Fim cpd-esquerda-arquivos-titulo -->
    <div class="cpd-esquerda-arquivos-tabela">
      <table>
        <thead>
          <tr>
            <th class="cpd-esquerda-arquivos-tabela-nome">
                Nome
            </th>
            <th class="cpd-esquerda-arquivos-tabela-data">
                Data de upload
            </th>
            <th class="cpd-esquerda-arquivos-tabela-baixar">
              Baixar
            </th>
            <th class="cpd-esquerda-arquivos-tabela-excluir">
              Excluir
            </th>
          </tr>
        </thead>
        <tbody>
					<?php
if (count($dado_arquivos) == 0) {
			?>
						<tr>
							<td colspan="4" style="background:#FFFFF3;">
								Nenhum arquivo disponivel
							</td>
						</tr>
						<?php
} else {
			foreach ($dado_arquivos as $dado_arquivos) {?>
          <tr>
            <td>
									<?php echo $dado_arquivos['nome']; ?>
            </td>
            <td>
              <?php echo data_local($dado_arquivos['data']); ?>
            </td>
            <td>
							<a href="<?php echo "sistema/despejo/" . $dado_arquivos['caminho'] ?>" download="<?php echo $dado_arquivos['nome'] . ".promob"; ?>" >
              	<button onclick="MudarNome()" type="button" class="cpd-esquerda-arquivos-tabela-baixar-botao" name="baixar arquivo"></button>
							</a>
            </td>
            <td>
							<form action="?pas=projeto&arq=operacoes" method="post">
								<input type="hidden" name="operacao" value="8">
								<input type="hidden" name="arq_id" value="<?php echo $dado_arquivos['id']; ?>">
								<input type="hidden" name="id" value="<?php echo $projeto_id; ?>">
								<button type="submit" class="cpd-esquerda-arquivos-tabela-excluir-botao" name="excluir arquivo"></button>
							</form>
            </td>
          </tr>
					<?php }
		}?>
        </tbody>
      </table>
    </div><!-- Fim cpd-esquerda-arquivos-tabela -->
    <div class="cpd-esquerda-arquivos-upload">
			<form id="upload" enctype="multipart/form-data" action="?pas=projeto&arq=operacoes" method="post">
				<input  type="hidden" name="operacao" value="4">
				<input  type="hidden" name="id" value="<?php echo $projeto_id; ?>">
        <label for="upload-input">
          <img src="layout/imagens/upload.svg">
        </label>
				<?php if (($dado_projeto['projetos_status'] > 1)&&($dado_projeto['projetos_status']!=6)) {?>
       <input id="upload-input" type="file" name="arquivo" />
			 <?php }?>
			</form>
    </div><!-- Fim cpd-esquerda-arquivos-upload -->
  </div><!-- Fim cpd-esquerda-arquivos -->
  <div class="cpd cpd-esquerda-projeto">
    <div class="cpd-esquerda-projeto-informacao">
      <div class="cpd-esquerda-projeto-informacao-editar-botao">
        <a href="sistema/projeto/modal/edicao_projeto.php?id=<?php echo $projeto_id; ?>" rel="modal:open"><button type="button" name="editar projeto"></button></a>
      </div><!-- Fim cpd-esquerda-projeto-informacao-editar-botao -->
      <div class="cpd-esquerda-projeto-informacao-status">
        <span>
          Status: <?php echo projeto($dado_projeto['projetos_status']); ?>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-status -->
      <div class="cpd-esquerda-projeto-informacao-titulo">
        <span>
          Titulo: <?php echo $dado_projeto['projetos_titulo']; ?>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-titulo -->
      <div class="cpd-esquerda-projeto-informacao-funcionario">
        <span>
          Funcionário: <a href="?pas=funcionario&arq=consultadetalhada&id=<?php echo $dado_projeto['funcionarios_id']; ?>"><?php echo $dado_projeto['funcionarios_nome']; ?></a>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-funcionario -->
      <div class="cpd-esquerda-projeto-informacao-local">
        <span>
          Local: <?php echo "{$dado_projeto['projetos_logradouro']}, {$dado_projeto['projetos_numero']}, {$dado_projeto['projetos_cidade']}"; ?>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-local -->
      <div class="cpd-esquerda-projeto-informacao-complemento">
        <span>
          Complemento: <?php echo $dado_projeto['projetos_complemento']; ?>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-complemento -->
      <div class="cpd-esquerda-projeto-informacao-cancelar-botao">
        <form action="?pas=projeto&arq=operacoes" method="post">
          <input type="hidden" name="operacao" value="5">
          <input type="hidden" name="id" value="<?php echo $projeto_id; ?>">
          <button type="submit" name="cancelar projeto">Cancelar Projeto</button>
        </form>
      </div><!-- Fim cpd-esquerda-projeto-informacao-cancelar-botao -->
      <div class="cpd-esquerda-projeto-informacao-valor">
        <span>
          Valor do projeto: <?php echo valorVirgula($dado_projeto['projetos_valor']); ?>
        </span>
      </div><!-- Fim cpd-esquerda-projeto-informacao-valor -->
    </div><!-- Fim cpd-esquerda-projeto-informacao -->
    <div class="cpd-esquerda-projeto-descricao">
      <span>Descrição:</span>
      <textarea name="descrição" rows="16" cols="88" readonly><?php echo $dado_projeto['projetos_descricao']; ?></textarea>
    </div><!-- Fim cpd-esquerda-projeto-descricao -->
  </div><!-- Fim cpd-esquerda-projeto -->
</div><!-- Fim cpd-esquerda -->
<div class="cpd-direita">
  <div class="cpd cpd-direita-agendamentos">
    <div class="cpd-direita-agendamentos-apresentacao">
      <span>Agendamentos:</span>
    </div><!-- Fim cpd-direita-agendamentos-apresentacao -->
    <div class="cpd-direita-agendamentos-corpo">
      <?php
foreach ($agendamento_recolhimento as $dado_agendamento) {
			?>
      <div status="<?php echo $dado_agendamento['status']; ?>" class="cpd-direita-agendamentos-corpo-agendamento">
        <div class="cpd-direita-agendamentos-corpo-agendamento-botao">
          <a href="sistema/projeto/modal/modal_agendamentos.php?id_agendamento=<?php echo $dado_agendamento['id']; ?>&status=<?php echo $dado_agendamento['status']; ?>&id_projeto=<?php echo $projeto_id; ?>&tipo=1" rel="modal:open">
						<button type="button" status-agendamento="<?php echo $dado_agendamento['status']; ?>" name="<?php echo "Selecionar agendamento"; ?>"></button>
					</a>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-botao -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-titulo">
          <span>
            Recolhimento de Informações
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-titulo -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-data">
          <span>
          <?php echo $dado_agendamento['data_marcada']; ?>
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-data -->
      </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento -->
      <?php }?>
      <?php
foreach ($agendamento_homologacao as $dado_agendamento) {
			?>
      <div status="<?php echo $dado_agendamento['status']; ?>" class="cpd-direita-agendamentos-corpo-agendamento">
        <div class="cpd-direita-agendamentos-corpo-agendamento-botao">
          <a href="sistema/projeto/modal/modal_agendamentos.php?id_agendamento=<?php echo $dado_agendamento['id']; ?>&status=<?php echo $dado_agendamento['status']; ?>&id_projeto=<?php echo $projeto_id; ?>&tipo=2" rel="modal:open">
						<button type="button" status-agendamento="<?php echo $dado_agendamento['status']; ?>" name="<?php echo "Selecionar agendamento"; ?>"></button>
					</a>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-botao -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-titulo">
          <span>
            Homologação de projeto
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-titulo -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-data">
          <span>
          <?php echo $dado_agendamento['data_marcada']; ?>
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-data -->
      </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento -->
      <?php }?>
      <?php
foreach ($agendamento_entrega as $dado_agendamento) {
			?>
      <div status="<?php echo $dado_agendamento['status']; ?>" class="cpd-direita-agendamentos-corpo-agendamento">
        <div class="cpd-direita-agendamentos-corpo-agendamento-botao">
          <a href="sistema/projeto/modal/modal_agendamentos.php?id_agendamento=<?php echo $dado_agendamento['id']; ?>&status=<?php echo $dado_agendamento['status']; ?>&id_projeto=<?php echo $projeto_id; ?>&tipo=3" rel="modal:open">
						<button type="button" status-agendamento="<?php echo $dado_agendamento['status']; ?>" name="<?php echo "Selecionar agendamento"; ?>"></button>
					</a>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-botao -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-titulo">
          <span>
            Entrega de produto
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-titulo -->
        <div class="cpd-direita-agendamentos-corpo-agendamento-data">
          <span>
          <?php echo $dado_agendamento['data_marcada']; ?>
          </span>
        </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento-data -->
      </div><!-- Fim cpd-direita-agendamentos-corpo-agendamento -->
      <?php }?>
    </div><!-- Fim cpd-direita-agendamentos-corpo -->
  </div><!-- Fim cpd-direita-agendamentos -->
  <div class="cpd cpd-direita-ambientes">
    <div class="cpd-direita-ambientes-criar">
      <a href="?pas=ambiente&arq=registro"><button type="button" name="criar ambiente"></button></a>
    </div><!-- Fim cpd-direita-ambientes-criar -->
    <div class="cpd-direita-ambientes-apresentacao">
      <span>Ambientes:</span>
    </div><!-- Fim cpd-direita-ambientes-apresentacao -->
    <div class="cpd-direita-ambientes-corpo">
        <?php
foreach ($dado_ambientes as $dado_ambientes) {
			?>
      <div class="cpd-direita-ambientes-corpo-ambiente">
        <div class="cpd-direita-ambientes-corpo-ambiente-editar">
          <a href="sistema/projeto/modal/modal_ambientes.php?ambiente_id=<?php echo $dado_ambientes['ambientes_id']; ?>&projetos_id=<?php echo $projeto_id; ?>" rel="modal:open"><button type="button" name="editar ambiente"></button></a>
        </div><!-- Fim cpd-direita-ambientes-ambiente-editar -->
        <span>
          <?php echo $dado_ambientes['ambientes_nome']; ?>
        </span>
      </div><!-- Fim cpd-direita-ambientes-ambiente -->
      <?php }?>
      <div class="cpd-direita-corpo-ambientes-adicionar">
        <div class="cpd-direita-corpo-ambientes-adicionar-botao">
          <a href="sistema/projeto/modal/modal_ambientes.php?projetos_id=<?php echo $projeto_id; ?>" rel="modal:open"><button type="button" name="adicionar ambiente"></button></a>
        </div>
        <div>
          <span>
            Adicionar Ambiente ao Projeto
          </span>
        </div>
      </div><!-- Fim cpd-direita-ambientes-adicionar -->
    </div>
  </div><!-- Fim cpd-direita-ambientes -->
</div><!-- Fim cpd-direita -->
<?php }
}?>
