<div class="fundo-ambiente">
  <div>
    <h1 class="h1custom">Registro de Ambiente</h1>
  </div>
  <div class="ambiente-registro">
    <form name="registro_ambiente" action="?pas=ambiente&arq=operacoes" method="post" onsubmit="return validarRegistroA()">
      <div>
        <label for="ambiente">Ambiente</label>
        <input id="ambiente" type="text" name="ambiente" placeholder="Ambiente" maxlength="20">
      </div>
      <div class="btn-ambiente">
        <button type="reset" name="limpar">Cancelar</button>
        <button type="submit" name="salvar">Salvar</button>
      </div>
    </form>
  </div>
  <h2 class="h2custom">Ambientes Registrados</h2>
  <table class="tabela-consultas">
    <tbody>
      <?php
        $sql_sel_ambientes = selecionar("SELECT * FROM ambientes");
        $sql_sel_ambientes->execute();
        if($sql_sel_ambientes->rowCount()>0){
          while($sql_sel_ambientes_dados = $sql_sel_ambientes->fetch()){
            ?>
            <tr>
              <td class="text-align">
                <?php echo $sql_sel_ambientes_dados['nome']?>
              </td>
            </tr>
            <?php
          }
        }else{
          ?>
          <tr>
            <td>
              Não há nenhum ambiente registrado
            </td>
          </tr>
          <?php
        }
      ?>
    </tbody>
  </table>
</div>
