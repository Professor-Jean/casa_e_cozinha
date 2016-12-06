<?php
// id do funcionario pego via get da tabela anterior
if (!$g_id = $_GET['id']) {

} else {
// select para mostrar as informações do funcionário/usuario

	$sql_sel_funcionario = "SELECT usuarios.usuario,funcionarios.id, funcionarios.nome, funcionarios.email, funcionarios.telefone FROM usuarios INNER JOIN funcionarios ON usuarios.id = funcionarios.usuarios_id WHERE funcionarios.id = '" . $g_id . "'";

	$sql_sel_funcionario_preparado = $conexaobd->prepare($sql_sel_funcionario);
	$sql_sel_funcionario_preparado->execute();
	$sql_sel_funcionario_dados = $sql_sel_funcionario_preparado->fetch();

	$sql_sel_projetos = selecionar("SELECT projetos.titulo, projetos.status, clientes.nome FROM  projetos INNER JOIN clientes ON clientes.id = projetos.clientes_id WHERE projetos.funcionarios_id = " . $_SESSION['idFuncionario']);
	$sql_sel_projetos->execute();

	?>
  <div>
    <h1 class="h1custom">Consulta detalhada de funcionário</h1>
  </div>
  <div>
    <fieldset class="fundo-div">
      <legend>Informações do funcionario</legend>
      <div class="padding">
        <span>Nome: <?php echo $sql_sel_funcionario_dados['nome']; ?></span>
        <a href="sistema\funcionario\modal\modal_funcionarioedicao.php?id=<?php echo $sql_sel_funcionario_dados['id'] ?>" rel="modal:open"><button class="btn-edit" type="submit">Editar</button></a>
      </div>
      <div class="padding">
        <span>Usuario: <?php echo $sql_sel_funcionario_dados['usuario']; ?></span>
      </div>
      <div class="padding">
        <span>E-mail: <?php echo $sql_sel_funcionario_dados['email']; ?></span>
      </div>
      <div class="padding">
        <span>Telefone: <?php echo $sql_sel_funcionario_dados['telefone']; ?></span>
      </div>
    </fieldset>
    <div>
      <h2 class="h2custom">Historico de projetos do funcionário</h2>
    </div>
    <div class="div-tabela">
      <table id="tr-link" class="tabela-consultas-2">
        <thead>
          <tr>
            <th width="20%">Titulo</th>
            <th width="20%">Cliente</th>
            <th width="20%">Status</th>
            <th width="20%">Data de Inicio</th>
            <th width="20%">Data de conclusão</th>
          </tr>
        </thead>
        <tbody>
					<?php
            $sql_sel_projetos = "SELECT projetos.titulo, funcionarios.nome, projetos.status, projetos.id FROM funcionarios INNER JOIN projetos ON funcionarios.id = projetos.funcionarios_id WHERE projetos.funcionarios_id='".$g_id."'";
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
                <td colspan="5">Este funcionário não possui nenhum registro de projeto</td>
              </tr>
              <?php
            }
					}
          ?>
        </tbody>
      </table>
    </div>
  </div>
