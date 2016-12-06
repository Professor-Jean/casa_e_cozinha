<?php
  $nome_server = $_SERVER['SERVER_NAME'];
  $nome_projeto = "cca";
  define("URL_BASE", "https://".$nome_server.DIRECTORY_SEPARATOR.$nome_projeto.DIRECTORY_SEPARATOR);

  include "autenticacao/autenticacao_sessao.php";
?>
