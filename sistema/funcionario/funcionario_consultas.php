<div>
  <h1 class="h1custom">Consulta de funcionários</h1>
</div>
<div class="funcionario-consulta">
  <?php
    $sql_sel_funcionario = "SELECT nome, id FROM funcionarios";
    if(isset($_POST['fnome'])){
      $sql_sel_funcionario.= " WHERE nome LIKE '%".$_POST['fnome']."%'";
    }
    $sql_sel_funcionario_preparado = $conexaobd->prepare($sql_sel_funcionario);
    $sql_sel_funcionario_preparado->execute();
  ?>
  <div class = "div-legenda-filtro">
    <p>Filtro:</p>
  </div>
  <div class="centralizado">
    <form action="?pas=funcionario&arq=consultas" method="POST">
      <input type="text" maxlength="" name="fnome" placeholder="Nome"></input>
      <button class="btn-pesquisa" type="submit">Pesquisar</button>
    </form>
  </div>
  <table id="tr-link" class="tabela-consultas-2 tabela-funcionario">
    <thead>
      <tr>
        <th>Nome</th>
      </tr>
    </thead>
    <tbody>
      <?php
        if($sql_sel_funcionario_preparado->rowCount()>0){
          while($sql_sel_funcionario_dados = $sql_sel_funcionario_preparado->fetch()){
            ?>
              <tr href="?pas=funcionario&arq=consultadetalhada&id=<?php echo $sql_sel_funcionario_dados['id']; ?>">
                <td><?php echo $sql_sel_funcionario_dados['nome']; ?></td>
              </tr>
            <?php
          }
        }else{
          ?>
            <tr href="#">
              <td>Nenhum funcionário registrado</td>
            </tr>
          <?php
        }
      ?>
    </tbody>
  </table>
</div>
