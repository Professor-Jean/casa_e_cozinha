<?php
include "seguranca\bd\bd_conexao.php";
include "adicionais/php/php_operacoesbd.php";
include "adicionais/php/php_conversaodata.php";
include "adicionais\php\php_conversaostatus.php";
include "adicionais\php\php_repositoriodemensagens.php";
include "adicionais\php\php_repositoriodevalidacoes.php";
include "adicionais/php/php_validacoes.php";
include "adicionais/php/php_conversaovalor.php";

?>
<!doctype html>
<html>
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="description" content="Software desenvolvimento para Casa e Cozinha ambientes">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="authors" content="Guilherme Henrique Foster, Gustavo de Camargo e Gustavo Habitzreiter">
        <!-- Título -->
        <title>Casa e Cozinha Ambientes</title>
        <!-- CSS -->
        <link rel="stylesheet" href="layout/css/css_reset.min.css">
        <link rel="stylesheet" href="adicionais/plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="adicionais\plugins\modal\modal.min.css">
        <link rel="stylesheet" href="layout/css/css_estilo.min.css">
        <link rel="stylesheet" href="layout/css/datepicker.min.css">
    </head>
    <!-- Conteúdo -->
    <body>
        <div class="corpo">
          <!-- Corpo do menu -->
        	<div class="menu">
                <!-- Logo da empresa -->
                <div class="logo">
                </div>
                <!-- Nome do funcionário que está autenticado -->
                <div class="funcionario-autenticado">
                    <a href="?pas=funcionario&arq=consultadetalhada&id=<?php echo $_SESSION['idFuncionario']; ?>">
                      <span>
                        <?php echo $_SESSION['funcionario']; ?>
                      </span>
                    </a>
                </div>
                <!-- Botões de início e sair -->
                <div class="inicio-sair">
                  <a href="index.php">
                    <div class="inicio">
                        Inicio
                    </div>
                  </a>
                  <a href="seguranca/autenticacao/autenticacao_logout.php">
                    <div class="sair">
                        Sair
                    </div>
                  </a>
                </div>
                <!-- Barra de navegação do menu -->
                <div class="navegacao">
                    <!-- Opção de cliente -->
                    <div class="dropdown cliente">
                       <button class="dropbtn">Cliente<label></label></button>
          					   <div class="dropdown-conteudo">
            						<a href="?pas=cliente&arq=registro">Registro de Cliente</a>
            						<a href="?pas=cliente&arq=consultas">Consulta de Clientes</a>
          					  </div>
                    </div>
                    <!-- Opção de projeto -->
                    <div class="dropdown projeto">
                       <button class="dropbtn">Projeto<label></label></button>
          					   <div class="dropdown-conteudo">
            						<a href="?pas=projeto&arq=registro">Registro de Projeto</a>
            						<a href="?pas=projeto&arq=consultas">Consulta de Projetos</a>
          					   </div>
                    </div>
                    <!-- Opção de funcionário -->
                    <div class="dropdown funcionario">
                       <button class="dropbtn">Funcionário<label></label></button>
            						<div class="dropdown-conteudo">
            							<a href="?pas=funcionario&arq=registro">Registro de Funcionário</a>
            							<a href="?pas=funcionario&arq=consultas">Consulta de Funcionários</a>
            						</div>
                    </div>
              </div>
              <!-- Copyright dos desenvolvedores -->
              <div class="desenvolvedor">
                <h2>&copy GGG</h2>
              </div>
        	</div> <!-- Fim .menu -->
          <div class="calendario">
              <a href="sistema\calendario\modal\calendario.php" rel="modal:open"><button class="calendario-img"></button></a>
          </div>
          <!-- Conteúdo principal -->
          <?php
if (isset($_GET['mensagem']) == true) {
	validar($_GET['id_mensagem'], $_GET['mensagem']);
}
?>
          <div class="conteudo">
            <?php
if (isset($_GET['pas']) && isset($_GET['arq'])) {
	if (!include "sistema/" . $_GET['pas'] . "/" . $_GET['pas'] . "_" . $_GET['arq'] . ".php") {
		echo "<h1>Pagina não encontrada</h1>";
	}
} else {
	$funcionario = selecionar("SELECT funcionarios.nome FROM funcionarios WHERE funcionarios.id='{$_SESSION['idFuncionario']}'")->fetch(PDO::FETCH_ASSOC);
	?>
  <h2 class="texto-bem-vindo">Seja muito bem vindo<br> <?php echo $funcionario['nome']; ?></h2>
  <?php
}
?>
          </div>
    </body>
    <!-- Scripts -->
    <script src="adicionais\plugins\jquery\jquery-min.js"></script>
    <script src="adicionais\plugins\modal\highlight.pack.js"></script>
    <script src="adicionais\js\js_upload-submit.js"></script>
    <script src="adicionais\plugins\fullcalendar\moment.min.js"></script>
    <script src="adicionais\plugins\modal\modal.min.js"></script>
    <script src="adicionais\plugins\mask\jquery.maskedinput.js"></script>
    <script src="adicionais/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="adicionais/plugins/fullcalendar/fullcalenda-pt-br.js"></script>
    <script src="adicionais\js\js_calendariopersonalizado.js"></script>
    <script src="adicionais\js\js_trlink.js"></script>
    <script src="adicionais\js\js_removeraviso.js"></script>
    <script src="adicionais\js\js_maskauxiliar.js"></script>
    <script src="adicionais/pluginsjs/datepickerpersonalizado.js"></script>
    <script src="adicionais/plugins/datepicker/datepicker.min.js"></script>
    <script src="adicionais/plugins/datepicker/datepicker.pt-br.js"></script>
</html>
