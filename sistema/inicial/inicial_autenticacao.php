<?php
include "adicionais\php\php_repositoriodemensagens.php";
include "adicionais\php\php_repositoriodevalidacoes.php";
?>
<!DOCTYPE html>
  <html class="pag-login">
    <head>
      <script src="adicionais/js/js_validacoes.js"></script>
      <!-- Título -->
      <title>Casa e Cozinha Ambientes</title>
      <!-- Metas -->
      <meta charset="utf8">
      <meta name="author" content="Guilherme Foster, Gustavo Habitzreiter, Gustavo Michels de Camargo">
      <meta name="description" content="WebSoftware da empresa Casa e Cozinha Ambientes">

    <!-- Links -->
      <link rel="stylesheet" href="layout/css/css_estilo.css" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    </head>
    <body class="pag-login">
    <?php
if (isset($_GET['mensagem']) == true) {
	validar($_GET['id_mensagem'], $_GET['mensagem']);
}
?>
      <form class="login" onsubmit="return validarLogin()" name="frmautent" method="POST" action="seguranca/autenticacao/autenticacao_login.php">
        <div class="formulario define-fontes-login">
          <div>
            <label><img class="logo-empresa-login" src="layout/imagens/logo.jpg"></label>
          </div>
          <div>
            <label class="alinhar-inputs">Usuário: </label>
            <input class="formulario-login define-fontes-login" type="text" name="txtusuario" placeholder="usuario" maxlength="20">
          </div>
          <div>
            <label class="alinhar-inputs">Senha: </label>
            <input class="formulario-login define-fontes-login" type="password" name="pwdsenha" placeholder="******" maxlength="20">
          </div>
          <div>
            <label colspan="2"><button class="entrar define-fontes-login" type="submit"><img class="imagem-dentro-btn" src="layout/imagens/login.png" width="7%" height="7%">ENTRAR</button></label>
          </div>
        </div>
      </form>
    </body>
    <footer class="login-rodape">
      <h3 class="texto-login-rodape define-fontes-login">© GGG</h3>
    </footer>
  </html>
