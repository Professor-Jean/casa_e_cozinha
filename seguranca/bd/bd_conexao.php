<?php
include "bd_configuracao.php";
try {
	$conexaobd = new PDO("mysql:host=" . $servidor . ";dbname=" . $banco . ";charset=utf8", "" . $usuario . "", "" . $senha . ""); /*Variavel para se conectar ao banco de dados*/
} catch (PDOException $e) /*Excessão*/ {
	/*morre, tudo a partir desta linha morre*/die("Erro ao se conectar com o banco de dados: " . $e->getMessage());
}
?>
