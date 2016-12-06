<?php
session_start();
include "../../seguranca\bd\bd_conexao.php";
include "../../adicionais\php\php_operacoesbd.php";

$json = array();
$sel = selecionar("SELECT projetos.id, projetos.titulo AS 'title', agendamentos.data_marcada AS 'time',agendamentos.data_marcada AS 'start' FROM agendamentos INNER JOIN projetos ON agendamentos.projetos_id=projetos.id INNER JOIN funcionarios ON projetos.funcionarios_id=funcionarios.id WHERE funcionarios.id='{$_SESSION['idFuncionario']}'");
echo json_encode($sel->fetchAll(PDO::FETCH_ASSOC));
exit();
?>
