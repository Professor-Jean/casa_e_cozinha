<script src="adicionais\js\js_maskauxiliar.js"></script>
<script src="adicionais\plugins\mask\jquery.maskedinput.js"></script>
<script src="adicionais/plugins/js/js_validarAgendamento.js"></script>
<script>
$(function(){
  $('#dp1').fdatepicker({
  format: 'dd/mm/yyyy',
  disableDblClickSelection: true,
  leftArrow:'<<',
  rightArrow:'>>',
  closeIcon:'',
  closeButton: true,
  language: 'pt-br'
  });
});

function validarAgendamento(){
  var novoAgendamento = confirm("Existe necessidade de agendar uma nova reunião?\n\nOK - Sim \nCancelar - Não");
    if(novoAgendamento==true){
        document.getElementById('status').innerHTML='<input type="hidden" name="hidstatus" value="Incompleto">';
        return true;
      }else{
          return true;
        }
}

function match(){
  var hora = document.getElementById("horario").value;
  var regex = /([01]\d|2[0-3]):([0-5]\d)/;
  if(regex.test(hora)==false){
      alert("Data preenchida incorretamente");
      document.getElementById("horario").focus();
      return false;
    }else{
        return true;
      }
}

</script>
<style type="text/css">
    .day:hover{
      background-color: #0bb3e5;
    }
  </style>
<?php
include "../../../seguranca\bd\bd_conexao.php";
include "../../../seguranca/seguranca_configuracao.php";
include "../../../adicionais/php/php_conversaodata.php";
include "../../../adicionais/php/php_conversaostatus.php";
include "../../../adicionais/php/php_operacoesbd.php";
	$tipo_agendamento = $_GET['tipo'];
  switch($tipo_agendamento){
    case 1:
      $titulo = "Recolhimento de Informações";
      break;
    case 2:
      $titulo = "Homologação de Projeto";
      break;
    case 3:
      $titulo = "Entrega de Produto";
      break;
  }

if (!$id_agendamento = $_GET['id_agendamento']) {

} elseif ($id_agendamento == "novo") {

	?>
	<h1><?php echo $titulo?></h1>
	<form name="frmrecolhimento" method="POST" action="?pas=projeto&arq=operacoes" onsubmit="return match()">
    <div class="espaco-recolhimento-formulario">
      <div>
        <label>Data: </label>
        <input type="text" name="txtdata" maxlength="10" placeholder="DD/MM/AAAA" id="dp1" readonly></input>
      </div>
      <div>
        <label>Horário Agendado: </label>
        <input type="text" name="txthorario" maxlength="5" placeholder="HH:MM" id="horario"></input>
      </div>
    </div>
    <input type="hidden" name="operacao" value="6"></input>
    <input type="hidden" name="hidid" value="<?php echo $_GET['id_projeto'] ?>"></input>
    <input type="hidden" name="hidtipo" value="<?php echo $_GET['tipo'] ?>"></input>
      <div class="alinhar-btns-formulario">
        <a href="#" rel="modal:close"><button class="btn-canc" name="btncanc">Fechar</button></a>
        <button type="submit" class="btn-ocorreu" name="btnenviar" >Salvar</button>
      </div>
  </form>
	<?php
} else {
	$agendamento = selecionar("SELECT agendamentos.tipo, agendamentos.status, agendamentos.data_marcada, agendamentos.horario, agendamentos.data_criada FROM agendamentos WHERE id='{$id_agendamento}'");
	if (!$agendamento) {

	} else {
		$dado_agendamento = $agendamento->fetch(PDO::FETCH_ASSOC);
    $horario = substr($dado_agendamento['horario'], 0, -3);
		if ($dado_agendamento['status'] == 0) {
			?>
      <h1><?php echo $titulo?></h1>
			<form name="frmrecolhimento" method="POST" action="?pas=projeto&arq=operacoes" >
          <div class="espaco-recolhimento">
            <div>
              <label>Data Agendada: </label>
              <?php echo data_local($dado_agendamento['data_marcada']); ?>
            </div>
            <div>
              <label>Horário Agendado: </label>
              <?php echo $horario; ?>
            </div>
            <div>
              <label>Data de Registro: </label>
              <?php echo data_local($dado_agendamento['data_criada']); ?>
            </div>
            <div>
              <label>Status: </label>
              <?php echo agendamento($dado_agendamento['status']); ?>
            </div>
            <input type="hidden" name="operacao" value="7">
            <input type="hidden" name="hidid" value="<?php echo $_GET['id_projeto'] ?>">
            <input type="hidden" name="hididag" value="<?php echo $id_agendamento ?>">
            <div id="status">
            </div>
            <div class="alinhar-btns-formulario">
              <input type="submit" class="btn-canc" name="btn" value="Cancelar">
              <input type="submit" class="btn-ocorreu" name="btn" value="Ocorreu" onClick="return validarAgendamento()">
            </div>
          </div>
        </form>
			<?php
} else {
			?>
      <h1><?php echo $titulo?></h1>
		<div class="espaco-recolhimento">
            <div>
              <label>Data Agendada: </label>
              <?php echo data_local($dado_agendamento['data_marcada']); ?>
            </div>
            <div>
              <label>Horário Agendado: </label>
              <?php echo $horario; ?>
            </div>
            <div>
              <label>Data de Registro: </label>
              <?php echo data_local($dado_agendamento['data_criada']); ?>
            </div>
            <div>
              <label>Status: </label>
              <?php echo agendamento($dado_agendamento['status']); ?>
            </div>
          </div>
		<?php
}
	}
}

?>
