<?php
session_start();
  if(isset($_SESSION['idSessao'])){
    include "sistema/inicial/inicial_pagina-inicial.php";
  }else{
    include "sistema/inicial/inicial_autenticacao.php";
  }
  exit();
 ?>
