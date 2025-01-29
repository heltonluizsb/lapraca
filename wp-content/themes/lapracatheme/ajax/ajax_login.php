<?php  

include(get_stylesheet_directory().'/config.php');

add_action('wp_ajax_nopriv_cliente_cadastro','cliente_cadastro');
add_action('wp_ajax_cliente_cadastro','cliente_cadastro');

function cliente_cadastro(){

	error_reporting(E_ALL); 
	ini_set("display_errors", 1);

	$data['sucesso'] = true;
	$data['mensagem'] = [];

	global $wpdb;

	if(isset($_POST['acao']) && $_POST['acao'] == 'cliente_cadastrar'){

	    $plano_tipo = $_POST['plano-tipo'];

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


	    $tb_clientes = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",
			array(
				$_POST['email']
			));

	    $tb_clientes = $wpdb->get_results($tb_clientes);

	    $data['tb_clientes'] = $tb_clientes;

	    if(count($tb_clientes) > 0){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Já existe este e-mail cadastrado.';

	    }

	    if($_POST['password'] != $_POST['confirmpassword']){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'As senhas não conferem.';
	    }

	    if(strlen($_POST['password']) < 8){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Senha menor do que 8 caracteres.';
	    }

		if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['password'])){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Sua senha não tem caracteres especiais';
		}

		if (!preg_match('~[0-9]+~', $_POST['password'])){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Sua senha deve conter pelo menos um número';
		}

		if(!preg_match("/[a-z]/i",$_POST['password'])){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Sua senha deve conter pelo menos uma letra';
		}

	    if($_POST['nome'] == ''){
	        $data['sucesso'] = false;

	        $data['mensagem'][] = 'Campo Nome está em BRANCO.';
	    }


	    if($data['sucesso']){

	        $codigo_confirma = uniqid();

	        $wpdb->insert('tb_clientes',array(
	            'nome' => $_POST['nome'],
	            'email' => $_POST['email'],
	            'senha' => $_POST['password'],
	            'plano' => $plano_tipo,
	            'confirmacao' => $codigo_confirma
	        ));

	        $body = '
	<!DOCTYPE html>
	<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Template de E-mail</title>
	</head>
	<style type="text/css">
	        

	    @font-face{
	        src:url('."'".get_stylesheet_directory_uri()."/fonts/OpenSans/OpenSans/OpenSans-Regular.ttf'".');
	        font-family: "OpenSans Regular";
	    }

	    *{
	        margin:  0;
	        padding:  0;
	        box-sizing: border-box;
	        font-family: "OpenSans Regular";
	    }

	    body{
	        background-color: #f1f1f1;
	    }
	    
	    .box{
	        width: 100%;
	        max-width: 560px;
	        margin: 40px auto;
	        background-color: white;
	        border:  1px solid #ccc;
	        border-radius: 10px;
	        text-align: center;
	        padding: 50px;
	        position: relative;
	    }

	    .box a{
	    	font-size:16px;
	    }

	</style>
	<body>
	    <div class="box">
	        <img src="'.get_stylesheet_directory_uri().'/img/logo2x.png">
	        <h2>Favor confirmar seu e-mail no link abaixo:</h2>
	        <a href="'.get_home_url().'/confirmaemail?codigo='.$codigo_confirma.'">'.get_home_url().'/confirmaemail?codigo='.$codigo_confirma.'</a>        
	    </div>
	</body>
	</html>';

            $mail = new Mail($_POST,$_POST['nome'].' confirme seu cadastro!',$body);

            $mail->addAddress($_POST['email'],$_POST['nome']);

            $mail->sendMail();

        }

    } else if(isset($_POST['acao']) && $_POST['acao'] == 'cliente_esqueceu_senha'){

    	$tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s",
			array(
				$_POST['email']
			));

	    $tb_cliente = $wpdb->get_results($tb_cliente);

	    if(count($tb_cliente) > 0){

        	$codigo_confirma = uniqid();

			$wpdb->update('tb_clientes', array(
				'confirmacao' => $codigo_confirma
			),array(
				'id' => $tb_cliente[0]->id));

	    	$body = '
	<!DOCTYPE html>
	<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Template de E-mail</title>
	</head>
	<style type="text/css">
	        

	    @font-face{
	        src:url('."'".get_stylesheet_directory_uri()."/fonts/OpenSans/OpenSans/OpenSans-Regular.ttf'".');
	        font-family: "OpenSans Regular";
	    }

	    *{
	        margin:  0;
	        padding:  0;
	        box-sizing: border-box;
	        font-family: "OpenSans Regular";
	    }

	    body{
	        background-color: #f1f1f1;
	    }
	    
	    .box{
	        width: 100%;
	        max-width: 560px;
	        margin: 40px auto;
	        background-color: white;
	        border:  1px solid #ccc;
	        border-radius: 10px;
	        text-align: center;
	        padding: 50px;
	        position: relative;
	    }

	    .box a{
	    	font-size:16px;
	    }

	</style>
	<body>
	    <div class="box">
	        <img src="'.get_stylesheet_directory_uri().'/img/logo2x.png">
	        <h2>Para continuar com o procedimento de alteração de senha, favor clicar no link abaixo:</h2>
	        <a href="'.get_home_url().'/resetsenha?codigo='.$codigo_confirma.'">'.get_home_url().'/resetsenha?codigo='.$codigo_confirma.'</a>        
	    </div>
	</body>
	</html>';

	        $mail = new Mail($_POST,$tb_cliente[0]->nome.' altere sua senha',$body);

	        $mail->addAddress($_POST['email'],$_POST['nome']);

	        $mail->sendMail();
	    }else{

	    	$data['sucesso'] = false;

	    	$data['mensagem'][] = 'Não encontramos seu este e-mail em nosso banco de dados. Tente novamente ou envie um e-mail para <a href="mailto:contato@lapraca.com" class="esqueceu-senha-suporte">contato@lapraca.com</a> e iremos te atender.';

	    }

    }

	wp_die(json_encode($data));

}
?>