<?php	
	
	add_action('wp_ajax_altera_categoria','altera_categoria');
	add_action('wp_ajax_nopriv_altera_categoria','altera_categoria');

	function altera_categoria(){

		$data['sucesso'] = true;
		$data['mensagem'] = '';
		$data['wpdb'] = [];

		if(isset($_POST['acao']) && $_POST['acao'] == 'categoria_alterar'){
			$categoria_id = $_POST['categoria_id'];

			global $wpdb;

			$resultado = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");

			$data['wpdb'] = $resultado;
		}else if(isset($_POST['acao']) && $_POST['acao'] == 'categoria_excluir'){
			$categoria_id = $_POST['categoria_id'];

			global $wpdb;

			$wpdb->delete('tb_categorias', array(
				'id' => $categoria_id));

		}

		wp_die(json_encode($data));
	}

 ?>