  <?php
if (!$id_cliente = $_GET['id']) {
	echo "<h1 class='titulo-pagina'>Cliente não identificado</h1>";
} else {
	$g_id = $_GET['id'];
	$sql_sel_detalhado = "SELECT * FROM clientes WHERE id='" . $id_cliente . "'";
	$sql_sel_detalhado_preparado = $conexaobd->prepare($sql_sel_detalhado);
	$sql_sel_detalhado_preparado->execute();
	if (!$sql_sel_detalhado_preparado->rowCount() > 0) {
		echo "<h1 class='titulo-pagina'>Cliente não identificado</h1>";
	} else {
		$sql_sel_detalhado_dados = $sql_sel_detalhado_preparado->fetch();

		/*Se a variável via GET não existir, este código abaixo será ignorado, já que a validação não ocorreu*/
		?>
   <a href="sistema/cliente/modal/cliente.php?id_cliente=<?php echo $id_cliente ?>" rel="modal:open"><button type="button" class="btn-editar-consultas"><img src="layout/imagens/editar.png" width="20%" height="10%">Editar</button></a>
  <h1 class="titulo-pagina">Consulta Detalhada de Cliente</h1>

  <!-- Área da tabela em geral -->
  <div class="conteudo-detalhada">
    <!-- Área de cada valor da tabela -->
    <div>
      <label class="espacamento-entre-frases-detalhada">Nome Completo: <?php echo $sql_sel_detalhado_dados['nome'] ?></label>
    </div>
    <div>
      <label>Telefone: <?php echo $sql_sel_detalhado_dados['telefone'] ?></label>
    </div>
    <div>
      <label>E-mail: <?php echo $sql_sel_detalhado_dados['email'] ?></label>
    </div>
    <div>
      <label>CPF: <?php echo $sql_sel_detalhado_dados['cpf'] ?></label>
    </div>
    <div>
      <label>RG: <?php echo $sql_sel_detalhado_dados['rg'] ?></label>
    </div>
    <div>
      <label>Cidade: <?php echo $sql_sel_detalhado_dados['cidade'] ?></label>
    </div>
    <div>
      <label>Bairro: <?php echo $sql_sel_detalhado_dados['bairro'] ?></label>
    </div>
    <div>
      <label>Logradouro: <?php echo $sql_sel_detalhado_dados['logradouro'] ?></label>
    </div>
    <div>
      <label>Complemento: <?php echo $sql_sel_detalhado_dados['complemento'] ?></label>
    </div>
    <div>
      <label>Número de residência: <?php echo $sql_sel_detalhado_dados['numero'] ?></label>
    </div>
  </div>

  <!-- Área da tabela de histórico de projetos -->
  <h1 class="titulo-pagina-2">Histórico de Projetos do Cliente</h1>
  <div class="tabela-historico-projetos">
    <table id="tr-link">
      <thead>
        <tr>
          <th width="20%">Título</th>
          <th width="20%">Funcionário</th>
          <th width="20%">Status</th>
          <th width="20%">Data de Início</th>
          <th width="20%">Data de Conclusão</th>
        </tr>
      </thead>
      <tbody>
					<?php
            $sql_sel_projetos = "SELECT projetos.titulo, clientes.nome, projetos.status, projetos.id FROM clientes INNER JOIN projetos ON clientes.id = projetos.clientes_id WHERE projetos.clientes_id='".$g_id."'";
            $sql_sel_projetos_preparado = $conexaobd->prepare($sql_sel_projetos);
            $sql_sel_projetos_preparado->execute();


            if($sql_sel_projetos_preparado->rowCount()>0){
              while($sql_sel_projetos_dados = $sql_sel_projetos_preparado->fetch()){
                $sql_sel_agendamentos = "SELECT agendamentos.data_criada AS '1', agendamentos.data_marcada AS '2' FROM agendamentos WHERE agendamentos.projetos_id = '".$sql_sel_projetos_dados['id']."' AND tipo = '1' OR tipo = '3' AND agendamentos.projetos_id = '".$sql_sel_projetos_dados['id']."'";
                $sql_sel_agendamentos_preparado = $conexaobd->prepare($sql_sel_agendamentos);
                $sql_sel_agendamentos_preparado->execute();
              ?>
                <tr href="?pas=projeto&arq=consultadetalhada&id=<?php echo $sql_sel_projetos_dados['id']; ?>">
                  <td><?php echo $sql_sel_projetos_dados['titulo']; ?></td>
                  <td><?php echo $sql_sel_projetos_dados['nome']; ?></td>
                  <td><?php echo projeto($sql_sel_projetos_dados['status']); ?></td>
                  <?php
                    $i = 1;
                    while ($i <= 2 ) {
											$sql_sel_agendamentos_dados = $sql_sel_agendamentos_preparado->fetch();
											if(isset($sql_sel_agendamentos_dados[$i])){
                      ?>
                      <td><?php echo data_local($sql_sel_agendamentos_dados[$i]); ?></td>
                      <?php
											$i++;
										}else{
											?>
											<td>Sem Agendamento</td>
											<?php
											$i++;
										}
                    }
                  ?>
                </tr>
          <?php
              }
            }else{
          ?>
              <tr href="#">
                <td colspan="5">Este cliente não possui nenhum registro de projeto</td>
              </tr>
              <?php
            }
					}
          ?>
        </tbody>
    </table>
  </div>
<?php
	}
?>
