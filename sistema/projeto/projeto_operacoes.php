<?php
if ($p_metodo = $_POST['operacao']) {
	switch ($p_metodo) {
	// Registro de projeto
	case 1:
		$p_titulo = $_POST['titulo'];
		$p_cidade = $_POST['cidade'];
		$p_bairro = $_POST['bairro'];
		$p_rua = $_POST['rua'];
		$p_numero = $_POST['numero'];
		$p_complemento = $_POST['complemento'];
		$p_descricao = $_POST['descricao'];
		$p_cliente = $_POST['cliente'];
		$p_funcionario = $_POST['funcionario'];
		$p_valor = valorPonto($_POST['valor']);

		if ($p_titulo == "") {
			$msg = "campo titulo está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if ($p_bairro == "") {
			$msg = "Campo bairro está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if ($p_rua == "") {
			$msg = "Campo rua está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if (($p_numero == "") || (is_nan($p_numero))) {
			$msg = "Campo numero está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if ($p_complemento == "") {
			$msg = "Campo complemento está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if ($p_cliente == "") {
			$msg = "Campo dasdsadasds está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else if ($p_funcionario == "") {
			$msg = "Campo funcionários está vazio";
			header("Location: ?pas=projeto&arq=registro&mensagem=$msg&id_mensagem=erro");
		} else {
			$ins_dados = array(
				'funcionarios_id' => $p_funcionario,
				'clientes_id' => $p_cliente,
				'status' => "1",
				'titulo' => $p_titulo,
				'bairro' => $p_bairro,
				'logradouro' => $p_rua,
				'numero' => $p_numero,
				'complemento' => $p_complemento,
				'cidade' => $p_cidade,
				'descricao' => $p_descricao,
				'valor' => $p_valor,
			);
			$ins_tabela = "projetos";
			$sql_sel_resultado = inserir($ins_tabela, $ins_dados);
			if ($sql_sel_resultado) {
				$ultimo_registro = selecionar("SELECT projetos.id FROM projetos ORDER BY ID DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$ultimo_registro['id']}&mensagem=Projeto registrado com sucesso!&id_mensagem=sucesso");
			} else {
				$msg = "Erro ao cadastrar o projeto";
				header("Location: ?pas=projeto=&arq=registro&mensagem=$msg&id_mensagem=erro");
			}
		}
		break;

	// Edição de projeto
	case 2:

		$dados_atualizados = array(
			'descricao' => $_POST['descricao'],
			'cidade' => $_POST['cidade'],
			'bairro' => $_POST['bairro'],
			'logradouro' => $_POST['logradouro'],
			'complemento' => $_POST['complemento'],
			'numero' => $_POST['numero'],
			'titulo' => $_POST['titulo'],
			'funcionarios_id' => $_POST['funcionario'],
			'valor' => valorPonto($_POST['valor']),
		);

		if ($dados_atualizados['bairro'] == "") {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Campo Bairro está indevidamente preechido&id_mensagem=erro");
		} elseif ($dados_atualizados['logradouro'] == "") {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Campo Logradouro está indevidamente preechido&id_mensagem=erro");
		} elseif ($dados_atualizados['complemento'] == "") {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Campo Complemento está indevidamente preechido&id_mensagem=erro");
		} elseif ($dados_atualizados['numero'] == "") {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Campo Numero de residencia está indevidamente preechido&id_mensagem=erro");
		} elseif ($dados_atualizados['titulo'] == "") {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Campo Titulo está indevidamente preechido&id_mensagem=erro");
		} else {
			$resultado = alterar("projetos", $dados_atualizados, "id='{$_POST['id']}'");
			if ($resultado) {
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Projeto atualizado com sucesso&id_mensagem=sucesso");
			} else {
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}&mensagem=Erro inesperado ao atualizar Projeto&id_mensagem=erro");
			}
		}
		break;

	//Registro de ambiente no projeto
	case 3:
		$ins_tabela = "projetos_tem_ambientes";
		$ins_dados = array(
			"projetos_id" => $_POST['projetosid'],
			"ambientes_id" => $_POST['msa-ambiente-id'],
			"descricao" => $_POST['descricao-ambientes'],
		);
		$verficiar = selecionar("select ambientes_id, projetos_id from projetos_tem_ambientes where ambientes_id='{$ins_dados['ambientes_id']}' and projetos_id='{$ins_dados['projetos_id']}'")->rowCount();
		if ($verficiar > 0) {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&mensagem=Ambiente já registrado&id_mensagem=erro");
		} else {
			inserir($ins_tabela, $ins_dados);
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&mensagem=Ambiente registrado com sucesso&id_mensagem=sucesso");
		}

		break;

	//Upload do arquivo
	case 4:
		include "adicionais/php/php_upload.php";

		if ($arquivo = $_FILES['arquivo']) {
			$arq_nome = explode(".", $arquivo['name']);
			if ($arq_nome[1] == "promob") {
				if ($upload = array('diretorio' => 'sistema/despejo/', 'nome' => encriptarNome($arquivo['name']))) {
					$arq_caminho = $upload['diretorio'] . $upload['nome'];
					if ($arquivo['type'] == "application/octet-stream") {
						if (move_uploaded_file($arquivo['tmp_name'], $arq_caminho)) {
							$arq_resultado = inserir("arquivos", array('projetos_id' => $_POST['id'], 'nome' => $arq_nome[0], 'caminho' => $upload['nome'], 'data' => date("Y-m-d")));
							if ($arq_resultado) {
								header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
							}
						}
					} else {
						header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
					}
				} else {
					header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
				}

			} else {
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
			}

		} else {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
		}

		break;

	// Cancelamento do projeto
	case 5:
		$resultado = alterar("projetos", array('status' => 6), "id='{$_POST['id']}'");
		if ($resultado) {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
		}
		break;

	// Registro de agendamento
	case 6:
		$p_tipo = $_POST['hidtipo'];
		$p_id = $_POST['hidid'];
		$p_data = $_POST['txtdata'];
		$p_horario = $_POST['txthorario'];
		$data_criada = date("o-m-j");
		$id = "erro";

		if ($p_data == "") {
			$mensagem = mensagem("vazio", "data", "");
			header("location: ?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
		} else if ($p_horario == "") {
			$mensagem = mensagem("vazio", "horário", "");
			header("location: ?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
		} else {
			$data = data_iso($p_data);

			$ins_agendamento_dados = array(
				'projetos_id' => $p_id,
				'tipo' => $p_tipo,
				'status' => '0',
				'data_marcada' => $data,
				'horario' => $p_horario,
				'data_criada' => $data_criada,
			);

			$ins_agendamento_tabela = "agendamentos";
			$ins_agendamento_resultado = inserir($ins_agendamento_tabela, $ins_agendamento_dados);

			if ($ins_agendamento_resultado) {
				if($p_tipo==3){
					$resultado_status = alterar("projetos", array('status'=>4), "id='{$p_id}'");
					if ($resultado_status) {
						$mensagem = mensagem("sucesso", "agendamento", "registrado");
						$id = "sucesso";
						header("location: ?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
					}
				}else{
					$mensagem = mensagem("sucesso", "agendamento", "registrado");
					$id = "sucesso";
					header("location: ?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
				}
			} else {
				$mensagem = mensagem("bd", "agendamento", "registrar");
				header("location: ?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
			}

		}
		break;

	// Mudança de status de agendamento
	case 7:
		if (isset($_POST['hidstatus'])) {
			$status = 2;
		} else {
			if ($_POST['btn'] == "Ocorreu") {
				$status = 1;
			} else if ($_POST['btn'] == "Cancelar") {
				$status = 3;
			}
		}

		$p_idag = $_POST['hididag'];
		$p_id = $_POST['hidid'];

		$id = "erro";

		$upd_dados = array(
			'status' => $status,
		);

		$upd_tabela = "agendamentos";

		$upd_condicao = "id='" . $p_idag . "'";

		$upd_resultado = alterar($upd_tabela, $upd_dados, $upd_condicao);

		if ((($upd_resultado))&&($status==2)) {
			$projeto_status = selecionar("select projetos.status from projetos where projetos.id='{$p_id}'")->fetch(PDO::FETCH_ASSOC);
			switch ($projeto_status['status']) {
				case 1:
					$resultado_status = alterar("projetos", array('status'=>2), "id='{$p_id}'");
					break;
				case 2:
					$resultado_status = alterar("projetos", array('status'=>3), "id='{$p_id}'");
					break;
				case 4:
					$resultado_status = alterar("projetos", array('status'=>5), "id='{$p_id}'");
					break;
				default:
					$resultado_status = false;
				break;
			}
			if(isset($resultado_status)){
				if($resultado_status){
					$mensagem = mensagem("sucesso", "status", "alterado");
					$id = "sucesso";
					header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
				}else{
					$mensagem = mensagem("bd", "status do agendamento", "alterar");
					header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
					}
			}else{
				if($upd_resultado){
					$mensagem = mensagem("sucesso", "status", "alterado");
					$id = "sucesso";
					header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
				}else{
					$mensagem = mensagem("bd", "status do agendamento", "alterar");
					header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
					}
			}


		} else if($upd_resultado){
				$mensagem = mensagem("sucesso", "status do agendamento", "alterado");
				$id = "sucesso";
				header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
			}else{
					$mensagem = mensagem("bd", "status do agendamento", "alterar");
					header("location:?pas=projeto&arq=consultadetalhada&mensagem=$mensagem&id_mensagem=$id&id=$p_id");
				}
		break;

	// Exclusão de arquivo
	case 8:

		if ($_POST['arq_id']) {
			if (excluir("arquivos", "id='{$_POST['arq_id']}'")) {
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
			} else {
				header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
			}
		} else {
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['id']}");
		}

		break;

	case 9:
		$ins_tabela = "projetos_tem_ambientes";
		$ins_dados = array(
			"projetos_id" => $_POST['projetosid'],
			"ambientes_id" => $_POST['msa-ambiente-id'],
			"descricao" => strip_tags($_POST['descricao-ambientes']),
		);
		$ins_condicao = " projetos_id = {$_POST['projetosid']} AND ambientes_id = {$_POST['msa-ambiente-id']}";
		$resultado = alterar($ins_tabela, $ins_dados, $ins_condicao);
		if ($resultado) {
			$mensagem = "Sucesso ao alterar o registro de ambiente";
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&id_mensagem=sucesso&mensagem=$mensagem");
		} else {
			$mensagem = "Erro ao alterar o registro de ambiente";
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&id_mensagem=erro&mensagem=$mensagem");
		}

		break;

	case 10:
		$tabela = "projetos_tem_ambientes";
		$condicao = " projetos_id = {$_POST['projetosid']} AND ambientes_id = {$_POST['msa-ambiente-id']}";
		$resultado = excluir($tabela, $condicao);
		if ($resultado) {
			$mensagem = "Sucesso ao alterar o registro de ambiente";
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&id_mensagem=sucesso&mensagem=$mensagem");
		} else {
			$mensagem = "Erro ao alterar o registro de ambiente";
			header("Location: ?pas=projeto&arq=consultadetalhada&id={$_POST['projetosid']}&id_mensagem=erro&mensagem=$mensagem");
		}
		break;
	}
}
?>
