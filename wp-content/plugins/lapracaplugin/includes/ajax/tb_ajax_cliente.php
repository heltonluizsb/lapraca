<?php	

include(plugin_dir_path(__DIR__).'config.php');
	
add_action('wp_ajax_altera_cliente','altera_cliente');
add_action('wp_ajax_nopriv_altera_cliente','altera_cliente');

function altera_cliente(){

	global $wpdb;

	$data['sucesso'] = true;
	$data['mensagem'] = [];

	if(isset($_POST['acao']) && $_POST['acao'] == 'cliente_atualizar'){

		if($_POST['cliente_id'] == 'new'){

		    $query =  "CREATE TABLE IF NOT EXISTS tb_clientes (
		        id INT AUTO_INCREMENT PRIMARY KEY,
		        nome VARCHAR(255) NOT NULL,
		        email VARCHAR(255) NOT NULL,
		        senha VARCHAR(255) NOT NULL,
		        plano VARCHAR(255) NOT NULL,
		        telefone VARCHAR(255) NOT NULL,
		        endereco VARCHAR(255) NOT NULL,
		        cidade VARCHAR(255) NOT NULL,
		        cep VARCHAR(255) NOT NULL,
		        pais VARCHAR(255) NOT NULL,
		        empresa VARCHAR(255) NOT NULL,
		        cargo VARCHAR(255) NOT NULL,
		        logo VARCHAR(255) NOT NULL,
		        descricao TEXT NOT NULL,
		        instagram VARCHAR(255) NOT NULL,
		        facebook VARCHAR(255) NOT NULL,
		        site VARCHAR(255) NOT NULL,
		        confirmacao VARCHAR(255) NOT NULL,
		        termos BOOLEAN NOT NULL,
		        newsletters BOOLEAN NOT NULL
		    )";

		    if (!function_exists('maybe_create_table')) {
		        require_once ABSPATH . 'wp-admin/install-helper.php';
		    }

		    maybe_create_table('tb_clientes',$query);

		    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = 'tb_clientes' AND column_name = 'cidade'"  );
			if(empty($row)){
			   $wpdb->query("ALTER TABLE `tb_clientes` ADD `cidade` VARCHAR(255) NOT NULL AFTER `endereco`");
			}

		    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = 'tb_clientes' AND column_name = 'cep'"  );
			if(empty($row)){
			   $wpdb->query("ALTER TABLE `tb_clientes` ADD `cep` VARCHAR(255) NOT NULL AFTER `cidade`");
			}

			if($_POST['nome'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo NOME está em branco.';
			}

		    $tb_clientes = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",array($_POST['email']));
		    $tb_clientes = $wpdb->get_results($tb_clientes);

			if($_POST['email'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo E-MAIL está em branco.';
			}else if(count($tb_clientes) > 0 && $_POST['email'] == $tb_clientes[0]->email){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'E-MAIL já existente em nosso banco de dados.';
			}

			if($_POST['telefone'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo TELEFONE / WHATSAPP está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['endereco'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo ENDEREÇO está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cidade'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CIDADE está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cep'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CEP está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['empresa'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo EMPRESA está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cargo'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CARGO está em branco.';
			}

			$logo = $_FILES['logo'];

			if($_POST['plano'] != '' && isset($logo['name']) && $logo['name'] != ''){
				if(padrao::imagemValida($logo) == false){
					$data['sucesso'] = false;
					$data['mensagem'][] = 'Imagem do LOGO com formato incorreto ou arquivo maior que 3MB.';
				}
			}else if($_POST['plano'] != '' && !isset($logo['name'])){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'É necessário ter um logo.';
			}

			if($_POST['plano'] != '' && $_POST['descricao'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO está em branco.';
			}else if($_POST['plano'] != '' && strlen($_POST['descricao']) > 500){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO tem mais de 500 caracteres.';
			}

			if($data['sucesso']){

				$logo = padrao::uploadFile($logo);

				$wpdb->insert('tb_clientes', array(
					'nome' => $_POST['nome'],
					'email' => $_POST['email'],
					'senha' => 'Lapraca@2022',
					'plano' => $_POST['plano'],
					'telefone' => $_POST['telefone'],
					'endereco' => $_POST['endereco'],
					'cidade' => $_POST['cidade'],
					'cep' => $_POST['cep'],
					'pais' => $_POST['pais'],
					'empresa' => $_POST['empresa'],
					'cargo' => $_POST['cargo'],
					'logo' => $logo,
					'descricao' => $_POST['descricao'],
					'instagram' => $_POST['instagram'],
					'facebook' => $_POST['facebook'],
					'site' => $_POST['site'],
					'confirmacao' => 'confirmado',
					'termos' => false,
					'newsletters' => false,
				));

			    $cliente_id = $wpdb->insert_id;

			    $query =  "CREATE TABLE IF NOT EXISTS tb_clientes_categorias (
			        id INT AUTO_INCREMENT PRIMARY KEY,
			        cliente_id INT NOT NULL,
			        categoria_id INT NOT NULL
			    )";

			    if (!function_exists('maybe_create_table')) {
			        require_once ABSPATH . 'wp-admin/install-helper.php';
			    }

			    maybe_create_table('tb_clientes_categorias',$query);

				$wpdb->insert('tb_clientes_categorias', array(
					'cliente_id' => $cliente_id,
					'categoria_id' => $_POST['categoria']));

				$wpdb->show_errors();
				if($wpdb->last_error !== '')
				    $wpdb->print_error();

				$data['mensagem'][] = 'Cadastro do cliente realizado com sucesso!';

			}

		}else{

		    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = 'tb_clientes' AND column_name = 'cidade'"  );
			if(empty($row)){
			   $wpdb->query("ALTER TABLE `tb_clientes` ADD `cidade` VARCHAR(255) NOT NULL AFTER `endereco`");
			}

			if($_POST['nome'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo NOME está em branco.';
			}

		    $tb_clientes = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",array($_POST['email']));
		    $tb_clientes = $wpdb->get_results($tb_clientes);

			if($_POST['email'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo E-MAIL está em branco.';
			}else if(count($tb_clientes) > 0 && $_POST['email'] != $_POST['email-antigo'] && $_POST['email'] == $tb_clientes[0]->email){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'E-MAIL já existente em nosso banco de dados.';
			}

			if($_POST['telefone'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo TELEFONE / WHATSAPP está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['endereco'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo ENDEREÇO está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cidade'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CIDADE está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cep'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CEP está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['empresa'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo EMPRESA está em branco.';
			}

			if($_POST['plano'] != '' && $_POST['cargo'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo CARGO está em branco.';
			}

			$logo = $_FILES['logo'];

			if($_POST['plano'] != '' && isset($logo['name']) && $logo['name'] != ''){
				if(padrao::imagemValida($logo) == false){
					$data['sucesso'] = false;
					$data['mensagem'][] = 'Imagem do LOGO com formato incorreto ou arquivo maior que 3MB.';
				}
			}

			if($_POST['plano'] != '' && $_POST['descricao'] == ''){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO está em branco.';
			}else if($_POST['plano'] != '' && strlen($_POST['descricao']) > 500){
				$data['sucesso'] = false;
				$data['mensagem'][] = 'O campo DESCRIÇÃO tem mais de 500 caracteres.';
			}

			if($data['sucesso']){

				if(isset($logo['name']) && $logo['name'] == ''){
					$logo = stripslashes($_POST['logo-antigo']);
				}else if(isset($logo['name']) && $logo['name'] != ''){
					padrao::deleteFile($_POST['logo-antigo']);
					$logo = padrao::uploadFile($logo);
				}else if(!isset($logo['name'])){
					$logo = stripslashes($_POST['logo-antigo']);
				}

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
					'logo' => $logo,
					'descricao' => $_POST['descricao'],
					'instagram' => $_POST['instagram'],
					'facebook' => $_POST['facebook'],
					'site' => $_POST['site']
				),array(
					'id' => $_POST['cliente_id']
				));

			    $query =  "CREATE TABLE IF NOT EXISTS tb_clientes_categorias (
			        id INT AUTO_INCREMENT PRIMARY KEY,
			        cliente_id INT NOT NULL,
			        categoria_id INT NOT NULL
			    )";

			    if (!function_exists('maybe_create_table')) {
			        require_once ABSPATH . 'wp-admin/install-helper.php';
			    }

			    maybe_create_table('tb_clientes_categorias',$query);

				$data['tb_clientes_categorias'] = $wpdb->prepare("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = %s",array($_POST['cliente_id']));
			    $data['tb_clientes_categorias'] = $wpdb->get_results($data['tb_clientes_categorias']);

			    if(count($data['tb_clientes_categorias']) < 1){
					$wpdb->insert('tb_clientes_categorias', array(
						'cliente_id' => $_POST['cliente_id'],
						'categoria_id' => $_POST['categoria']));
			    }else{
					$wpdb->update('tb_clientes_categorias', array(
						'categoria_id' => $_POST['categoria']
					),array(
						'cliente_id' => $_POST['cliente_id']));
			    }

				$wpdb->show_errors();
				if($wpdb->last_error !== '')
				    $wpdb->print_error();

				$data['mensagem'][] = 'Cadastro do cliente realizado com sucesso!';

			}

		}

	}else if(isset($_POST['acao']) && $_POST['acao'] == 'foto_excluir'){

    	padrao::deleteFile($_POST['foto']);

    	$wpdb->delete('tb_clientes_fotos',array(
    		'cliente_id' => $_POST['cliente_id'],
    		'id' => $_POST['foto_id']
    	));

    	$data['post'] = $_POST;

    }

	wp_die(json_encode($data));
}

 ?>