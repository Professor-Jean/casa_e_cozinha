<?php
  session_start();
    if(!isset($_SESSION['idSessao'])){
        header('location: '.BASE_URL.'seguranca/autenticacao/autenticacao_logout.php');
        exit;
      }else if($_SESSION['idSessao']!=session_id()){
          header('location; '.BASE_URL.'seguranca/autenticacao/autenticacao_logout.php');
          exit;
        }
?>
