<?php

include "../../../seguranca\bd\bd_conexao.php";
include "../../../adicionais/php/php_operacoesbd.php";
include "../../../seguranca/seguranca_configuracao.php";
include "../../../adicionais/php/php_validacoes.php";

//Recebendo a id que foi enviada pelo link da modal
$id_cliente = $_GET['id_cliente'];

$sql_sel_detalhado = "SELECT * FROM clientes WHERE id='" . $id_cliente . "'";
$sql_sel_detalhado_preparado = $conexaobd->prepare($sql_sel_detalhado);
$sql_sel_detalhado_preparado->execute();
$sql_sel_detalhado_dados = $sql_sel_detalhado_preparado->fetch();

?>
<!-- Área geral da modal da edição de cliente -->
<div class="modal-edicao-cliente">
  <div class="titulo-modal">
      <h1>Edição de Cliente</h1>
  </div>
          <form name="frmattcliente" method="POST" action="?pas=cliente&arq=operacoes&id_cliente=<?php echo $id_cliente ?>">
            <div class="modal-div-e"><!-- Início div-e -->
              <div>
                <label>Nome:</label>
                <input type="text" name="txtnome" value="<?php echo $sql_sel_detalhado_dados['nome'] ?>" maxlength="45">
              </div>
              <div>
                <label>E-mail:</label>
                <input type="text" name="txtemail" value="<?php echo $sql_sel_detalhado_dados['email'] ?>" maxlength="100">
              </div>
              <div>
                <label>Telefone:</label>
                <input type="text" name="txtfone" value="<?php echo $sql_sel_detalhado_dados['telefone'] ?>" maxlength="12" id="telefone">
              </div>
              <div>
                <label>CPF:</label>
                <input type="text" name="txtcpf" value="<?php echo $sql_sel_detalhado_dados['cpf'] ?>" maxlength="11" id="cpf">
              </div>
              <div>
                <label>RG:</label>
                <input type="text" name="txtrg" value="<?php echo $sql_sel_detalhado_dados['rg'] ?>" maxlength="10" id="rg">
              </div>
            </div><!-- Fim div-e -->
            <div class="modal-div-d"><!-- Início div-d -->
              <div>
                <label>Cidade: </label>
                <input type="text" name="txtcidade" value="<?php echo $sql_sel_detalhado_dados['cidade'] ?>" maxlength="30">
              </div>
              <div>
                <label>Bairro:</label>
                <input type="text" name="txtbairro" value="<?php echo $sql_sel_detalhado_dados['bairro'] ?>" maxlength="20">
              </div>
              <div>
                <label>Logradouro:</label>
                <input type="text" name="txtlogradouro" value="<?php echo $sql_sel_detalhado_dados['logradouro'] ?>" maxlength="45">
              </div>
              <div>
                <label>Número:</label>
                <input type="text" name="txtnumero" value="<?php echo $sql_sel_detalhado_dados['numero'] ?>" maxlength="5">
              </div>
              <div>
                <label>Complemento:</label>
                <input type="text" name="txtcomplemento" value="<?php echo $sql_sel_detalhado_dados['complemento'] ?>" maxlength="20">
              </div>
            </div><!-- Fim div-e -->
            <input type="hidden" name="op" value="atualizacao"></input>
            <div class="btns-modal-cliente">
              <label><a href="#close-modal" rel="modal:close"><button name="btnfechar" class="modal-btn-fechar">Fechar</button></a></label>
              <button type="submit" name="btnenviar" class="modal-btn-salvar">Salvar</button>
            </div>
          </form>
</div>

<script src="..\adicionais\plugins\mask\jquery.maskedinput.js"></script>
<script src="..\adicionais\js\js_maskauxiliar.js"></script>
