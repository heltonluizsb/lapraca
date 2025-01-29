<?php

	add_action('admin_menu','tb_add_menus');
	
	function tb_add_menus(){

		$img = file_get_contents(__DIR__.'/img/logo01.svg');

		add_menu_page(
			'Lá Pra Cá Plugin',
			'Lá Pra Cá Plugin',
			'manage_options',
			'lapraca_plugin',
			'tb_call_page_main',
			'data:image/svg+xml;base64,' . base64_encode($img)
		);

		add_submenu_page(
			'lapraca_plugin',
			'Configurações Adicionais',
			'Configurações Adicionais',
			'manage_options',
			'lapraca_plugin',
			'tb_call_page_main'
		);

		add_submenu_page(
			'lapraca_plugin',
			'Categorias',
			'Categorias',
			'manage_options',
			'lapraca_plugin_categorias',
			'tb_call_page_categorias'
		);

		add_submenu_page(
			'lapraca_plugin',
			'Cadastro / Alteração de Clientes',
			'Cadastro / Alteração de Clientes',
			'manage_options',
			'lapraca_plugin_clientes_alterar',
			'tb_call_page_clientes_alterar'
		);

		add_submenu_page(
			'lapraca_plugin',
			'Lista de Clientes',
			'Lista de Clientes',
			'manage_options',
			'lapraca_plugin_clientes_lista',
			'tb_call_page_clientes_lista'
		);

		add_submenu_page(
			'lapraca_plugin',
			'Cadastro de Banners',
			'Cadastro de Banners',
			'manage_options',
			'lapraca_plugin_banners',
			'tb_call_page_banners'
		);

		add_submenu_page(
			'lapraca_plugin',
			'Cidades da Alemanha',
			'Cidades da Alemanha',
			'manage_options',
			'lapraca_plugin_cidades_alemanha',
			'tb_call_page_cidades_alemanha'
		);
	}

	function tb_call_page_main(){
		include('tb_page_main.php');
	}

	function tb_call_page_categorias(){
		include('tb_page_categorias.php');
	}

	function tb_call_page_clientes_alterar(){
		include('tb_page_clientes_alterar.php');
	}

	function tb_call_page_clientes_lista(){
		include('tb_page_clientes_lista.php');
	}

	function tb_call_page_banners(){
		include('tb_page_banners.php');
	}

	function tb_call_page_cidades_alemanha(){
		include('tb_page_cidades_alemanha.php');
	}

	
	function tb_wp_styles(){
		wp_enqueue_style('tb_style_css',plugins_url('css/style.css',__FILE__));

		wp_enqueue_script('tb_jquery_js',plugins_url('js/jquery.js',__FILE__),'',true);
		wp_enqueue_script('tb_jquery_ajaxform_js',plugins_url('js/jquery.ajaxform.js',__FILE__),'',true);
		wp_enqueue_script('tb_jquery_mask_js',plugins_url('js/jquery.mask.js',__FILE__),'',true);
		wp_enqueue_script('tb_functions_js',plugins_url('js/functions.js',__FILE__),'',true);
	}

	add_action('init','tb_wp_styles');


	include('ajax/tb_ajax_categoria.php');
	include('ajax/tb_ajax_cliente.php');

 ?>