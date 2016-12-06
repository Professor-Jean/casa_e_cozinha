<?php
/*Se a variável via GET não existir, este código abaixo será ignorado, já que a validação não ocorreu*/
if (isset($_GET['mensagem']) == true) {
	validar($_GET['id_mensagem'], $_GET['mensagem']);
}
?>
<h1 class="titulo-pagina" >Consulta de Clientes</h1>
<section>
  <!-- Filtro do nome do cliente -->
  <form class="filtro" name="frmfiltrarcliente" method="POST" action="?pas=cliente&arq=consultas">
      <h3 class="subtitulo">Filtro</h3>
      <div class="alinhar-filtro">
        <input class="input-filtro" type="text" name="txtfiltro" placeholder="Ex: João/João da Silva" >
        <button class="btn-filtro" type="submit"><img class="imagem-dentro-btn-filtro" src="layout/imagens/pesquisar.png">Pesquisar</button>
      </div>
  </form>

  <?php
/*******

ÁREA DO FILTRO

 *******/

/*Se o usuário não realizar a pesquisa, a variável de pesquisa não existirá, portanto,
toda a área da pesquisa será ignorada, porém, se o usuário realizar a pesquisa, a variável passará a existir e
 */
if (isset($_POST['txtfiltro'])) {
	$nome = $_POST['txtfiltro'];

	//Procurando clientes cujos nomes tenham algo em comum com o que foi pesquisado
	$sql_sel_pesquisa = "SELECT nome, id FROM clientes WHERE nome LIKE '%" . $nome . "%'";
	$sql_sel_pesquisa_preparado = $conexaobd->prepare($sql_sel_pesquisa);
	$sql_sel_pesquisa_preparado->execute();

	?>
      <h3 class="subtitulo">Clientes Registrados</h3>
      <div class="tabela-consultas-2">
      <table id="tr-link">
        <thead>
          <tr>
            <th>Nome</th>
          </tr>
        </thead>
        <tbody>
          <?php
if ($sql_sel_pesquisa_preparado->rowCount() > 0) {
		while ($sql_sel_pesquisa_dados = $sql_sel_pesquisa_preparado->fetch()) {
			?>
                <tr href="?pas=cliente&arq=consultadetalhada&id=<?php echo $sql_sel_pesquisa_dados['id'] ?>">
                    <td><?php echo $sql_sel_pesquisa_dados['nome'] ?></td>
                </tr>
              <?php
}
		?>
        </table>
        </div>
            <?php
} else {
		?>
            <tr href="#">
              <!-- Caso a pesquisa não ache nada relacionado ao que foi pesquisado pelo usuário -->
              <td>Não foram encontrados resultados.</td>
            </tr>

          <?php
}
	?>
      </table>
    </div>
        <?php
} else {
	?>
  <h3 class="subtitulo">Clientes Registrados</h3>
  <div class="tabela-consultas-2">
  <table id="tr-link">
    <thead>
      <tr>
        <th>Nome</th>
      </tr>
    </thead>
    <tbody>
      <?php
$sql_sel_clientes = "SELECT nome, id FROM clientes";
	$sql_sel_clientes_preparado = $conexaobd->prepare($sql_sel_clientes);
	$sql_sel_clientes_preparado->execute();

	if ($sql_sel_clientes_preparado->rowCount() > 0) {
		while ($sql_sel_clientes_dados = $sql_sel_clientes_preparado->fetch()) {
			?>
     <tr href="?pas=cliente&arq=consultadetalhada&id=<?php echo $sql_sel_clientes_dados['id'] ?>">
       <!-- Nome do cliente -->
       <td><?php echo $sql_sel_clientes_dados['nome'] ?></td>
     </tr>
   <?php
}
	} else {
		?>
   <tr href="#">
     <!-- Caso não hajam clientes registrados no BD -->
     <td>Não há clientes registrados</td>
   </tr>
   <?php
}
}
?>
    </tbody>
  </table>
</div>
</section>
