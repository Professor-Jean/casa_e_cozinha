<?php
/****************
Autores: Gustavo Habitzreiter, Gustavo Michels de Camargo e Guilherme Foster

Descrição: Criptografia de arquivo

Data: 31/10/2016
 *****************/
 function encriptarNome($arquivo){

    $pathinfo = pathinfo($arquivo);

    $nome_arquivo = MD5($pathinfo['filename'].time());

    $nome = $nome_arquivo.'.'.$pathinfo['extension'];

    return $nome;

}
 ?>
