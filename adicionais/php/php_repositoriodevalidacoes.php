<?php
function validar($id, $mensagem) {
	if ($id == "erro") {
		?>
      <div id="fechar" class="msg-erro">
          <button type="button" class="fechar-aviso" onClick="return removerAviso()"></button>
          <h1>Erro</h1>
          <h2><?php echo $mensagem ?></h2>
      </div>
      <?php
} else if ($id == "sucesso") {
		?>
        <div id="fechar" class="msg-sucesso">
            <button type="button" class="fechar-aviso" onClick="return removerAviso()"></button>
            <h1>Sucesso</h1>
            <h2><?php echo $mensagem ?></h2>
        </div>
        <?php
}
}
?>
