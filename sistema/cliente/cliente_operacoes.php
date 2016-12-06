<?php
/****

Este arquivo contém as duas operações necessárias na área de clientes,
que são registro e edição/atualização

Autores: Gustavo Habitzreiter, Gustavo de Camargo, Guilherme Foster
Data de Criação: 13/10
Data de Modificação: 19/11

 *****/

/*
Operações de Registro
 */
if ($_POST['op'] == "registro") {
	//Se o valor enviado por post no campo hidden for registro
	$p_nome = $_POST['txtnome'];
	$p_email = $_POST['txtemail'];
	$p_telefone = $_POST['txtfone'];
	$p_rg = $_POST['txtrg'];
	$p_cpf = $_POST['txtcpf'];
	$p_cidade = $_POST['txtcidade'];
	$p_bairro = $_POST['txtbairro'];
	$p_logradouro = $_POST['txtlogradouro'];
	$p_complemento = $_POST['txtcomplemento'];
	$p_numero = $_POST['txtnumero'];
	$id = "erro";

	if ($p_nome == "") {
		$mensagem = mensagem("vazio", "nome", "");
		header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
	} else if ($p_telefone == "") {
		$mensagem = mensagem("vazio", "telefone", "");
		header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
	} else {

		if ((!validar_email($p_email)) && ($p_email != NULL)) {
			$mensagem = mensagem("padrao", "e-mail", "");
			header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
		} else if (!validar_telefone($p_telefone)) {
			$mensagem = mensagem("padrao", "telefone", "");
			header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
		} else if ((!is_numeric($p_rg)) && ($p_rg != NULL)) {
			$mensagem = mensagem("padrao", "RG", "");
			header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
		} else if ((!is_numeric($p_cpf)) && ($p_cpf != NULL)) {
			$mensagem = mensagem("padrao", "CPF", "");
			header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
		} else if ((!is_numeric($p_numero)) && ($p_numero != NULL)) {
			$mensagem = mensagem("padrao", "número da residência", "");
			header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
		} else {

			$sql_sel_clientes = "SELECT * FROM clientes WHERE telefone='" . $p_telefone . "' OR email='" . $p_email . "' ";
			$sql_sel_clientes_preparado = $conexaobd->prepare($sql_sel_clientes);
			$sql_sel_clientes_preparado->execute();

			if ($sql_sel_clientes_preparado->rowCount() == 0) {

				$ins_dados = array(
					'nome' => $p_nome,
					'telefone' => $p_telefone,
					'cpf' => $p_cpf,
					'rg' => $p_rg,
					'email' => $p_email,
					'cidade' => $p_cidade,
					'bairro' => $p_bairro,
					'logradouro' => $p_logradouro,
					'complemento' => $p_complemento,
					'numero' => $p_numero,
				);

				$ins_tabela = "clientes";

				$sql_ins_clientes_resultado = inserir($ins_tabela, $ins_dados);
				if ($sql_ins_clientes_resultado) {
					$mensagem = mensagem("sucesso", "cliente", "registrado");
					$id_projeto = selecionar("SELECT clientes.id FROM clientes WHERE clientes.telefone='{$p_telefone}' AND clientes.nome='{$p_nome}'");
					$dado_projeto = $id_projeto->fetchAll(PDO::FETCH_ASSOC);
					$id = "sucesso";
					header("location: ?pas=cliente&arq=consultadetalhada&id={$dado_projeto[0]['id']}&mensagem=$mensagem&id_mensagem=$id");
				} else {
					$mensagem = mensagem("bd", "cliente", "registrar");
					header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
				}

			} else {
				$mensagem = mensagem("existencia", "telefone ou e-mail");
				header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id_mensagem=$id");
			}
		}
	}
/*
Fim Operações de Registro
 */

/*
Operações de Atualização
 */
} else if ($_POST['op'] == "atualizacao") {
	//Se o valor enviado por post no campo hidden for atualização
	$g_id = $_GET['id_cliente'];
	$p_nome = $_POST['txtnome'];
	$p_email = $_POST['txtemail'];
	$p_telefone = $_POST['txtfone'];
	$p_cpf = $_POST['txtcpf'];
	$p_rg = $_POST['txtrg'];
	$p_cidade = $_POST['txtcidade'];
	$p_bairro = $_POST['txtbairro'];
	$p_logradouro = $_POST['txtlogradouro'];
	$p_numero = $_POST['txtnumero'];
	$p_complemento = $_POST['txtcomplemento'];

	if ($p_nome == "") {
		$mensagem = mensagem("vazio", "nome", "");
		header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
	} else if ($p_telefone == "") {
		$mensagem = mensagem("vazio", "telefone", "");
		header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
	} else {

		if ((!validar_email($p_email)) && ($p_email != NULL)) {
			$mensagem = mensagem("padrao", "e-mail", "");
			header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
		} else if (!validar_telefone($p_telefone)) {
			$mensagem = mensagem("padrao", "telefone", "");
			header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
		} else if ((!is_numeric($p_rg)) && ($p_rg != NULL)) {
			$mensagem = mensagem("padrao", "RG", "");
			header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
		} else if ((!is_numeric($p_cpf)) && ($p_cpf != NULL)) {
			$mensagem = mensagem("padrao", "CPF", "");
			header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
		} else if ((!is_numeric($p_numero)) && ($p_numero != NULL)) {
			$mensagem = mensagem("padrao", "número de residência", "");
			header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");

		} else {
			$sql_sel_cliente = "SELECT * FROM clientes WHERE id<>'" . $g_id . "' AND telefone='" . $p_telefone . "' ";
			$sql_sel_cliente_preparado = $conexaobd->prepare($sql_sel_cliente);
			$sql_sel_cliente_preparado->execute();

			if ($sql_sel_cliente_preparado->rowCount() > 0) {
				$mensagem = mensagem("existencia", "telefone", "");
				header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
			} else {

				$alt_tabela = "clientes";

				$alt_dados = array(
					'nome' => $p_nome,
					'telefone' => $p_telefone,
					'cpf' => $p_cpf,
					'rg' => $p_rg,
					'email' => $p_email,
					'cidade' => $p_cidade,
					'bairro' => $p_bairro,
					'logradouro' => $p_logradouro,
					'complemento' => $p_complemento,
					'numero' => $p_numero,
				);

				$alt_condicao = "id='" . $g_id . "'";

				$resultado = alterar($alt_tabela, $alt_dados, $alt_condicao);

				if ($resultado) {
					$mensagem = mensagem("sucesso", "Informações do cliente", "atualizadas");
					$id = "sucesso";
					header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
				} else {
					$mensagem = mensagem("bd", "cliente", "atualizar as informações do");
					header("location: ?pas=cliente&arq=consultadetalhada&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
				}

			}

		}

	}
} else {
	//Se o valor enviado por post no campo hidden for apagado ou não definido
	$mensagem = mensagem("op", "", "");
	header("location: ?pas=cliente&arq=registro&mensagem=$mensagem&id=$g_id&id_mensagem=$id");
}
/*
Fim Operações de Atualização
 */
?>
