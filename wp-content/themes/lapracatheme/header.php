<?php include('classes/padrao.php'); ?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<title>
		<?php if(is_front_page()){
			bloginfo('name');
		}else if(get_the_title() == ''){
			bloginfo('name');
		}else if(get_the_title() == 'Anunciante'){
		    if(isset($_GET['id'])){
		        $cliente_id = $_GET['id'];
		        $cliente = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `id` = $cliente_id AND `plano` != ''");
		        if(count($cliente) > 0){
		            echo $cliente[0]->nome;
		        }
		    }
		}else if(is_home() || is_category() || is_archive() || is_tag()){
			echo 'Blog';
		}else{
			the_title();
		} ?>
	</title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
	<?php if(is_front_page() || get_the_title() == 'Home'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/home.css">
	<?php }else if(get_the_title() == 'Planos'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/planos.css">
	<?php }else if(get_the_title() == 'Login'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/login.css">
	<?php }else if(get_the_title() == 'Confirmação de Email'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/confirmacao.css">
	<?php }else if(get_the_title() == 'Alteração de Senha'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/confirmacao.css">
	<?php }else if(get_the_title() == 'Painel'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/painel.css">
	<?php }else if(get_the_title() == 'Anunciante'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/anunciante.css">
	<?php }else if(get_the_title() == 'Política de Privacidade' || get_the_title() == 'Política de privacidade' || get_the_title() == 'Termos e Serviços' || get_the_title() == 'Diretrizes de conteúdo' || get_the_title() == 'Impressum' || get_the_title() == 'Política de Cookies' || get_the_title() == 'TERMOS ADICIONAIS PARA CONTAS EMPRESARIAIS'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/politicas.css">
	<?php }else if(get_the_title() == 'Busca'){?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/busca.css">
	<?php }else if(is_single()){  ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/blog.css">
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/single.css">
	<?php }else{  ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/blog.css">
	<?php } ?>
</head>
<body>

	<?php 

		if(isset($_GET['sair'])){
			if(padrao::logado()){
				padrao::logout();
			}
		}

		$upload_dir = wp_upload_dir();

	 ?>

<header>

	<div class="header-main">
		<div class="container">

			<div class="header-main-img">
				<a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo2x.png"></a>
			</div><!-- header-main-img -->

			<div class="header-main-menu-desktop">
				<ul>
					<li class="selected"><a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/home.svg">Início</a></li>
					<li class="header-main-menu-como-funciona">
						<a href="">Como Funciona<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow01.svg"></a>
						<div class="header-main-menu-como-funciona-menu">
							<p>Para quem procura</p>
							<p>Para anunciantes</p>
						</div>
					</li>
					<li><a href="<?php echo get_home_url(); ?>/novidades">Novidades</a></li>
				</ul>
			</div><!-- header-main-menu-desktop -->

			<div class="header-main-btns">
				<a href="<?php echo get_home_url(); ?>/planos" class="anuncie">Anuncie</a>
				<?php if (padrao::logado()){ 
			        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
			            array(
			               $_SESSION['cliente_email'],
			               $_SESSION['cliente_password']
			            ));
			        $tb_cliente = $wpdb->get_results($tb_cliente);
					?>
					<span class="logado">Olá <?php echo $tb_cliente[0]->nome; ?> &#x25BC;</span>
					<div class="logado-menu">
						<a href="<?php echo get_home_url(); ?>/painel" class="logado-menu-painel">Painel</a>
						<a href="<?php echo get_home_url(); ?>?sair" class="logado-menu-sair">Sair</a>
					</div>
				<?php }else{ ?>
					<a href="<?php echo get_home_url(); ?>/login" class="criar-conta">Entrar ou Criar Conta</a>
				<?php } ?>
			</div><!-- header-main-btns -->

			<div class="header-main-mobile">
				<?php if (padrao::logado()){ 
			        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
			            array(
			               $_SESSION['cliente_email'],
			               $_SESSION['cliente_password']
			            ));
			        $tb_cliente = $wpdb->get_results($tb_cliente);
					?>
					<span class="logado">Olá <?php echo $tb_cliente[0]->nome; ?> &#x25BC;</span>
					<div class="logado-menu">
						<a href="<?php echo get_home_url(); ?>/painel" class="logado-menu-painel">Painel</a>
						<a href="<?php echo get_home_url(); ?>?sair" class="logado-menu-sair">Sair</a>
					</div>
				<?php }else{ ?>
					<a href="<?php echo get_home_url(); ?>/login" class="header-main-mobile-login"><span>Entrar</span> <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/login01.svg"></a>
				<?php } ?>
				<a href="" class="header-main-mobile-menu-btn"><span></span><span></span><span></span></a>
			</div>

		</div><!-- container -->
	</div><!-- header-main -->

	<div class="header-busca">
		<div class="container">
			<?php if(isset($_POST['busca-text'])){
				header('Location:'.get_site_url().'/busca?resultado='.$_POST['busca-text']);
			} ?>
			<form method="post">
				<div class="header-busca-div">
					<div class="header-busca-input">
						<input type="text" name="busca-text" placeholder="Busque o que você precisa">
					</div>
					<div class="header-busca-submit">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/busca01.svg">					
					</div>
				</div>
			</form>
		</div>
	</div>

</header>

<div class="header-main-mobile-menu">
	<div class="header-main-mobile-menu-btn-wrapper">
		<a href="" class="header-main-mobile-menu-btn"><span></span><span></span><span></span></a>	
	</div>

	<a href="<?php echo get_site_url(); ?>/planos">Anuncie</a>
	
	<a href="" class="header-main-mobile-menu-como-funciona">Como Funciona</a>
		<div class="header-main-mobile-menu-como-funciona-menu">
			<a href="">Para quem procura</a>
			<a href="">Para anunciantes</a>
		</div>
	<a href="<?php echo get_site_url(); ?>/novidades">Novidades</a>
</div>

<lapraca
	page-title="<?php echo get_the_title(); ?>"
	get-site-url="<?php echo get_site_url(); ?>"
	wp-admin="<?php echo admin_url(); ?>"
	basedir = "<?php echo $upload_dir['basedir'] ?>"
	baseurl = "<?php echo $upload_dir['baseurl'] ?>"
></lapraca>