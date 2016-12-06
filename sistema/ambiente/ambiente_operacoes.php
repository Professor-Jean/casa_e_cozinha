<?php
  $p_ambiente = strip_tags($_POST['ambiente']);

  if($p_ambiente == ""){
    $msg = "Preencha o campo ambiente para concluir o registro";
    header("Location: ?pas=ambiente&arq=registro&mensagem=$msg&id_mensagem=erro");
  }else{
    $sel_ambientes = selecionar("SELECT nome FROM ambientes WHERE nome = '".$p_ambiente."'");
    $sel_ambientes_exec = $sel_ambientes->execute();
    if($sel_ambientes->rowCount()==0){
      $ins_dados = array(
        'nome' => $p_ambiente
      );
      $ins_tabela = "ambientes";
      $ins_ambientes = inserir($ins_tabela, $ins_dados);
      if($ins_ambientes){
        $msg = "Sucesso ao cadastrar o ambiente";
        header("Location: ?pas=ambiente&arq=registro&mensagem=$msg&id_mensagem=sucesso");
      }
    }else{
      $msg = "Ambiente já esta cadastrado";
      header("Location: ?pas=ambiente&arq=registro&mensagem=$msg&id_mensagem=erro");
    }
  }
?>
