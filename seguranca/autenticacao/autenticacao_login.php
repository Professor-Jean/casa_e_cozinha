<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link rel="stylesheet" href="../../layout/css/css_estilo.css">
<meta charset="utf8">
<?php
include "../bd/bd_conexao.php";
$p_nome = $_POST['txtusuario'];
$p_senha = $_POST['pwdsenha'];
  if($p_nome==""){
      $mensagem = "Usuário não preenchido";
    }else if($p_senha==""){
        $mensagem = "Senha não preenchida";
      }else{
          $sql_sel_autenticacao = "SELECT funcionarios.id AS
          funcionarioid, funcionarios.nome FROM usuarios INNER JOIN funcionarios ON funcionarios.usuarios_id = usuarios.id WHERE
          usuario='".$p_nome."' AND senha='".md5($salt.$p_senha)."'";
          

          $sql_sel_autenticacao_preparado = $conexaobd->prepare($sql_sel_autenticacao);
          $sql_sel_autenticacao_preparado->execute();
          $sql_sel_autenticacao_dados = $sql_sel_autenticacao_preparado->fetch();

          if($sql_sel_autenticacao_preparado->rowCount()==0){
              $mensagem = "Usuário ou senha incorretos";
            }else{

              $funcionario_nome = explode(" ", $sql_sel_autenticacao_dados['nome']);
              $funcionario_nome = $funcionario_nome[0];

              session_start();

              $_SESSION['idFuncionario'] = $sql_sel_autenticacao_dados['funcionarioid'];

              $_SESSION['funcionario'] = $funcionario_nome;

              $_SESSION['idSessao'] = session_id();

              header('Location: ../../index.php');
              exit();
          }
        }

?>
<html class="pag-validacao-logi ">
  <div class="validacao-login define-fontes-login">
    <h2><?php echo $mensagem?></h2>
      <a class="retornar-validacao-login" href="../../index.php?">
        Retornar
      </a>
  </div>
</html>
