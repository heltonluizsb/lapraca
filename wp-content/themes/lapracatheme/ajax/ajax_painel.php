<?php  

include(get_stylesheet_directory().'/config.php');

add_action('wp_ajax_nopriv_cliente_atualizar','cliente_atualizar');
add_action('wp_ajax_cliente_atualizar','cliente_atualizar');

function cliente_atualizar(){

	error_reporting(E_ALL); 
	ini_set("display_errors", 1);

	global $wpdb;

	$data['sucesso'] = true;
	$data['mensagem'] = [];

	if(isset($_POST['acao']) && $_POST['acao'] == 'cliente_atualizar'){

		$data['acao_hidden'] = $_POST['acao_hidden'];
		$cliente_id = $_POST['cliente_id'];

		$data['tb_clientes'] = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `id` = %s",
			array(
				$cliente_id
			));

	    $data['tb_clientes'] = $wpdb->get_results($data['tb_clientes']);

		if($data['acao_hidden'] == 'atualizar-logo'){
			
			padrao::deleteFile($data['tb_clientes'][0]->logo);

			$logo = padrao::uploadFile($_FILES['logo']);

			$wpdb->update('tb_clientes', array(
				'logo' => $logo
			),array(
				'id' => $cliente_id));

			$data['tb_clientes'] = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `id` = %s",
				array(
					$cliente_id
				));

		    $data['tb_clientes'] = $wpdb->get_results($data['tb_clientes']);

		}else if($data['acao_hidden'] == 'atualizar-fotos'){

		    $query =  "CREATE TABLE IF NOT EXISTS tb_clientes_fotos (
		        id INT AUTO_INCREMENT PRIMARY KEY,
		        cliente_id INT NOT NULL,
		        foto VARCHAR(255) NOT NULL
		    )";

		    if (!function_exists('maybe_create_table')) {
		        require_once ABSPATH . 'wp-admin/install-helper.php';
		    }

		    maybe_create_table('tb_clientes_fotos',$query);

			$data['tb_clientes_fotos'] = $wpdb->prepare("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = %s",
				array(
					$_POST['cliente_id']
				));		    

		    $data['tb_clientes_fotos'] = $wpdb->get_results($data['tb_clientes_fotos']);

		    $foto_limite = 10;

		    if(count($data['tb_clientes_fotos']) >= $foto_limite){
		    	$data['sucesso'] = false;

		    	$data['mensagem'][] = 'Você chegou no limite máximo de '.$foto_limite.' fotos.';
		    }

		    if($data['sucesso']){

				$foto = padrao::uploadFile($_FILES['foto-empresa']);

				$wpdb->insert('tb_clientes_fotos', array(
					'cliente_id' => $cliente_id,
					'foto' => $foto));

				$data['tb_clientes_fotos'] = $wpdb->prepare("SELECT * FROM `tb_clientes_fotos` WHERE `id` = %s",
					array(
						$wpdb->insert_id
					));

			    $data['tb_clientes_fotos'] = $wpdb->get_results($data['tb_clientes_fotos']);

		    }

		}else if($data['acao_hidden'] == 'atualizar-tudo'){

		    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = 'tb_clientes' AND column_name = 'cidade'"  );
			if(empty($row)){
			   $wpdb->query("ALTER TABLE `tb_clientes` ADD `cidade` VARCHAR(255) NOT NULL AFTER `endereco`");
			}


			$data['post'] = $_POST;

			if($_POST['empresa'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo EMPRESA está em branco.';
			}

			if($_POST['nome'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo NOME PARA CONTATO está em branco.';
			}

			$confirmado = 'confirmado';

			if($_POST['email'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo E-MAIL está em branco.';
			}else if($_POST['email'] != $data['tb_clientes'][0]->email){
				$tb_clientes_all = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",array($_POST['email']));
				$tb_clientes_all = $wpdb->get_results($tb_clientes_all);

				if(count($tb_clientes_all) > 0){
					$data['sucesso'] = false;
					$data['mensagem'][] = 'E-MAIL já existente em nosso banco de dados.';
				}else{
					$confirmado = uniqid();
				}
			}

			if($_POST['telefone'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo TELEFONE / WHATSAPP está em branco.';
			}

			if($_POST['cargo'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CARGO está em branco.';
			}

			if($_POST['endereco'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo ENDEREÇO está em branco.';
			}

			if($_POST['cidade'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CIDADE está em branco.';
			}

			if($_POST['cep'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CEP está em branco.';
			}

		    $query =  "CREATE TABLE IF NOT EXISTS tb_clientes_categorias (
		        id INT AUTO_INCREMENT PRIMARY KEY,
		        cliente_id INT NOT NULL,
		        categoria_id INT NOT NULL
		    )";

		    if (!function_exists('maybe_create_table')) {
		        require_once ABSPATH . 'wp-admin/install-helper.php';
		    }

		    maybe_create_table('tb_clientes_categorias',$query);

			$data['tb_clientes_categorias'] = $wpdb->prepare("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = %s",
				array(
					$cliente_id
				));		    

		    $data['tb_clientes_categorias'] = $wpdb->get_results($data['tb_clientes_categorias']);

		    if(count($data['tb_clientes_categorias']) < 1){

				$wpdb->insert('tb_clientes_categorias', array(
					'cliente_id' => $cliente_id,
					'categoria_id' => $_POST['categoria']));

		    }else{

				$wpdb->update('tb_clientes_categorias', array(
					'categoria_id' => $_POST['categoria']
				),array(
					'cliente_id' => $cliente_id));

		    }

			if($_POST['descricao'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO está em branco.';
			}else if(strlen($_POST['descricao']) > 500){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO tem mais de 500 caracteres.';
			}

			if(!isset($_POST['termos'])){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'Você precisa aceitar os TERMOS DE USO do Lá Pra Cá.';
			}

			$newsletters = false;

			if(isset($_POST['newsletters'])){
				$newsletters = true;
			}

			if($data['sucesso']){

				$wpdb->update('tb_clientes', array(
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'plano' => $_POST['plano'],
					'telefone' => $_POST['telefone'],
					'endereco' => $_POST['endereco'],
					'cidade' => $_POST['cidade'],
					'cep' => $_POST['cep'],
					'pais' => $_POST['pais'],
					'empresa' => $_POST['empresa'],
					'cargo' => $_POST['cargo'],
					'descricao' => $_POST['descricao'],
					'instagram' => $_POST['instagram'],
					'facebook' => $_POST['facebook'],
					'site' => $_POST['site'],
					'confirmacao' => $confirmado,
					'termos' => true,
					'newsletters' => $newsletters,
				),array(
					'id' => $cliente_id));

				if($confirmado == 'confirmado'){
					$data['mensagem'][] = 'Seu cadastro foi atualizado com sucesso.';
				}else{
					$data['mensagem'][] = 'Um e-mail foi enviado para você. Click no link enviado no seu e-mail para continuar seu cadastro.';
				}

			}

		}else if($data['acao_hidden'] == 'atualizar-nao-anunciante'){

			if($_POST['nome'] == ''){

				$data['sucesso'] = false;

				$data['mensagem'][] = 'O campo NOME PARA CONTATO está em branco.';

			}

			$confirmado = 'confirmado';

			if($_POST['email'] == ''){

				$data['sucesso'] = false;

				$data['mensagem'][] = 'O campo E-MAIL está em branco.';

			}else if($_POST['email'] != $data['tb_clientes'][0]->email){

				$tb_clientes_all = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",array($_POST['email']));
				$tb_clientes_all = $wpdb->get_results($tb_clientes_all);

				if(count($tb_clientes_all) > 0){

					$data['sucesso'] = false;

					$data['mensagem'][] = 'E-MAIL já existente em nosso banco de dados.';

				}else{
					$confirmado = uniqid();
				}
			}

			if($_POST['telefone'] == ''){

				$data['sucesso'] = false;

				$data['mensagem'][] = 'O campo TELEFONE / WHATSAPP está em branco.';

			}

			if(!isset($_POST['termos'])){

				$data['sucesso'] = false;

				$data['mensagem'][] = 'Você precisa aceitar os TERMOS DE USO do Lá Pra Cá.';

			}

			$newsletters = false;

			if(isset($_POST['newsletters'])){

				$newsletters = true;

			}

			if($data['sucesso']){

				$wpdb->update('tb_clientes', array(
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'telefone' => $_POST['telefone'],
					'endereco' => $_POST['endereco'],
					'pais' => $_POST['pais'],
					'confirmacao' => $confirmado,
					'termos' => true,
					'newsletters' => $newsletters,
				),array(
					'id' => $cliente_id));

				if($confirmado == 'confirmado'){
					$data['mensagem'][] = 'Seu cadastro foi atualizado com sucesso.';
				}else{
					$data['mensagem'][] = 'Um e-mail foi enviado para você. Click no link enviado no seu e-mail para continuar seu cadastro.';
				}

			}

		}

    }else if(isset($_POST['acao']) && $_POST['acao'] == 'foto_excluir'){

    	padrao::deleteFile($_POST['foto']);

    	$wpdb->delete('tb_clientes_fotos',array(
    		'cliente_id' => $_POST['cliente_id'],
    		'id' => $_POST['foto_id']
    	));

    }

	wp_die(json_encode($data));

}
?>