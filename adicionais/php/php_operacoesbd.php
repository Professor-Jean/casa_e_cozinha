<?php
/****************
Autores: Gustavo Habitzreiter, Gustavo Michels de Camargo e Guilherme Foster

Descrição: Operações de inserção, alteração e exclusão do banco de dados são realizadas aqui por meio de envio de parâmetros pela página que deseja realizar alguma dessas funções.

Data: 11/10/2016
 *****************/
//Função de inserção

function inserir($ins_tabela, $ins_dados){
    //Pegando valores da página
    $ins_campos = array_keys($ins_dados);
    //Contando o número de campos
    $ins_n_campos = count($ins_dados);
    //Iniciando a sintaxe de inserção
    $ins_sintaxe = "INSERT INTO ".$ins_tabela." (";
    //Realizando a estrutura de repetição for para adicionar os campos à sintaxe
    for($ins_aux = 0; $ins_aux < $ins_n_campos; $ins_aux++){
      $ins_sintaxe .= $ins_campos[$ins_aux].", ";
    }
    //Removendo o espaço e a vírgula extra que ficam na sintaxe
    $ins_sintaxe = substr($ins_sintaxe, 0, -2);
    //Adicionando values à sintaxe
    $ins_sintaxe .= ") VALUES (";
    //Realizando a estrutura de repetição for para adicionar os campos à sintaxe
    for($ins_aux=0; $ins_aux < $ins_n_campos; $ins_aux++){
      if($ins_dados[$ins_campos[$ins_aux]]!==""){
        $ins_sintaxe .= "'".($ins_dados[$ins_campos[$ins_aux]]."', ");
      }else{
        $ins_sintaxe.="NULL, ";
      }
    }
    //Removendo o espaço e a vírgula extra que ficam ao final da estrutura de repetição
    $ins_sintaxe = substr($ins_sintaxe, 0, -2);
    //Fechando a sintaxe
    $ins_sintaxe .= ")";
    //Estabelecendo conexão com o banco de dados
    global $conexaobd;

    $ins_resultado = $conexaobd->prepare($ins_sintaxe);
		$ins_resultado->execute();
    return $ins_resultado;
  }

//Função de alteração
function alterar($alt_tabela, $alt_dados, $alt_condicao) {

	$alt_campos = array_keys($alt_dados);

	$alt_n_campos = count($alt_dados);

	$alt_sintaxe = "UPDATE " . $alt_tabela . " SET ";

	for ($alt_aux = 0; $alt_aux < $alt_n_campos; $alt_aux++) {
		if ($alt_dados[$alt_campos[$alt_aux]] != "") {
			$alt_sintaxe .= $alt_campos[$alt_aux] . "='" . addslashes($alt_dados[$alt_campos[$alt_aux]]) . "', ";
		} else {
			$alt_sintaxe .= $alt_campos[$alt_aux] . "=NULL, ";
		}
	}
	//Removendo o espaço e a vírgula extra que ficam ao final da estrutura de repetição
	$alt_sintaxe = substr($alt_sintaxe, 0, -2);

	$alt_sintaxe .= " WHERE " . $alt_condicao;

	global $conexaobd;
	$alt_preparado = $conexaobd->prepare($alt_sintaxe);
	$alt_resultado = $alt_preparado->execute();

	return $alt_resultado;
}

//Função de excçusão
function excluir($exc_tabela, $exc_condicao) {

	$exc_sintaxe = "DELETE FROM " . $exc_tabela . " WHERE " . $exc_condicao;
//	die($exc_sintaxe);
	global $conexaobd;

	$exc_preparado = $conexaobd->prepare($exc_sintaxe);

	$exc_resultado = $exc_preparado->execute();

	return $exc_resultado;

}

function selecionar($sel_codigo) {
	global $conexaobd;
	$sel_preparado = $conexaobd->prepare($sel_codigo);
	$sel_preparado->execute();
	return $sel_preparado;
}

?>
