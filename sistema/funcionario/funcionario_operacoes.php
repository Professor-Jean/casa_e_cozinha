<?php
$p_nome			= strip_tags($_POST['nome']);
$p_email		= strip_tags($_POST['email']);
$p_telefone	= strip_tags($_POST['telefone']);
$p_usuario	= strip_tags($_POST['usuario']);
$p_senha		= strip_tags($_POST['senha']);
$p_operacao	= strip_tags($_POST['operacao']);

if ($p_operacao == "1") {
	if ($p_nome == "") {
		$msg = "Nome não preenchido!";
		header("location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
	} else if (($p_email != "") && (!validar_email($p_email))) {
		$msg = "Email não preenchido!";
		header("location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
	} else if (!validar_telefone($p_telefone)){
		$msg = "Telefone não preenchido!";
		header("Location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
	} else if ($p_usuario == "") {
		$msg = "Usuario não preenchido!";
		header("location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
	} else {
		$sql_sel_funcionarios = "SELECT * FROM funcionarios INNER JOIN usuarios ON usuarios.id = funcionarios.usuarios_id WHERE funcionarios.email = '" . $p_email . "' OR usuarios.usuario = '" . $p_usuario . "'";
		$sql_sel_funcionarios_preparado = $conexaobd->prepare($sql_sel_funcionarios);
		$sql_sel_funcionarios_preparado->execute();
		if ($sql_sel_funcionarios_preparado->rowCount() == 0) {
			$md5senha = md5($salt . $p_senha);
			$ins_dados = array(
				'usuario' => $p_usuario,
				'senha' => $md5senha
			);
			$ins_tabela = "usuarios";
			$sql_sel_usuarios_resultado = inserir($ins_tabela, $ins_dados);
			if ($sql_sel_usuarios_resultado) {
				$usuario_id = $conexaobd->lastInsertId();
				$ins_dados = array(
					'usuarios_id' => $usuario_id,
					'nome' => $p_nome,
					'email' => $p_email,
					'telefone' => $p_telefone
				);
				$ins_tabela = "funcionarios";
				$sql_sel_funcionarios_resultado = inserir($ins_tabela, $ins_dados);
				if ($sql_sel_funcionarios_resultado) {
					$ultimo_registro = selecionar("SELECT funcionarios.id FROM funcionarios ORDER BY ID DESC LIMIT 1");
					$id_registrado = $ultimo_registro->fetch(PDO::FETCH_ASSOC);
					$msg = "Sucesso ao cadastrar o usuario";
					header("location: ?pas=funcionario&arq=consultadetalhada&id={$id_registrado['id']}&mensagem=$msg&id_mensagem=sucesso");
				} else {
					$del_tabela = "usuarios";
					$del_condicao = "usuarios.usuario = '" . $p_usuario . "'";
					excluir($del_tabela, $del_condicao);
					$msg = "Erro ao cadastrar o funcionário";
					header("location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
				}
			}
		} else {
			$msg = "Já há um registro com esse email ou usuario";
			header("location: ?pas=funcionario&arq=registro&mensagem=$msg&id_mensagem=erro");
		}
	}
} else if ($p_operacao == "2") {
	if ($p_nome == "") {
		$msg = "Nome não preenchido!";
		header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
	} else if (($p_email != "") && (!validar_email($p_email))) {
		$msg = "Email não preenchido!";
		header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
	} else if (!validar_telefone($p_telefone)){
		$msg = "Telefone não preenchido!";
		header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
	} else if ($p_usuario == "") {
		$msg = "Usuario não preenchido!";
		header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
	} else {
		$sql_sel_funcionarios = "SELECT funcionarios.id, usuarios.senha FROM funcionarios INNER JOIN usuarios ON usuarios.id = funcionarios.usuarios_id WHERE email = '" . $p_email . "' OR usuario = '" . $p_usuario . "' and id<>'" . $_POST['hidid']. "'";
		$sql_sel_funcionarios_preparado = $conexaobd->prepare($sql_sel_funcionarios);
		$sql_sel_funcionarios_preparado->execute();
		if ($sql_sel_funcionarios_preparado->rowCount() == 0) {
			$alt_dados = array(
				'nome' => $p_nome,
				'email' => $p_email,
				'telefone' => $p_telefone
			);

			$alt_tabela = "funcionarios";
			$alt_condicao = "usuarios_id = '".$_POST['hidid']."'";
			$sql_alt_funcionarios = alterar($alt_tabela, $alt_dados, $alt_condicao);
			if($sql_alt_funcionarios){
				$md5senha = md5($salt.$p_senha);
				if($p_senha==""){
					$alt_dados = array(
						'usuario' => $p_usuario,
					);
				}else{
					$alt_dados = array(
						'usuario' => $p_usuario,
						'senha' => $md5senha
					);
				}

				$alt_tabela = "usuarios";
				$alt_condicao = "id = '".$_POST['hidid']."'";
				$sql_alt_usuario_resultado = alterar($alt_tabela, $alt_dados, $alt_condicao);
				if ($sql_alt_usuario_resultado) {
					$msg = "Sucesso ao mudar as informações do usuario";
					header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=sucesso");
				} else {
					$msg = "Erro ao cadastrar o usuario";
					header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
				}
			}else{
				$msg = "Erro ao cadastrar o usuario";
				header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
			}

		} else {
			$msg = "Erro ao cadastrar o usuario";
			header("location: ?pas=funcionario&arq=consultadetalhada&id={$_POST['hidid']}&mensagem=$msg&id_mensagem=erro");
		}
	}
}
?>
