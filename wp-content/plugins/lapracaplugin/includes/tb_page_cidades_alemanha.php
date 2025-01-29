<?php
	include('config.php');
	global $wpdb;
	$upload_dir = wp_upload_dir();
?>
<tbbase
	wp-admin="<?php echo admin_url(); ?>"
	get-site-url="<?php echo get_site_url(); ?>"
	base-dir="<?php echo $upload_dir['basedir'] ?>"
	base-url="<?php echo $upload_dir['baseurl'] ?>"
></tbbase>
<div class="wrap">
	<h2>Cidades da Alemanha</h2>
	<form method="post" enctype="multipart/form-data" class="form-planos-vc">

		<?php 
			if(isset($_POST['cidade_alterar'])){

				$sucesso = true;

				$query =  "CREATE TABLE IF NOT EXISTS tb_cidades_alemanha (
					id INT AUTO_INCREMENT PRIMARY KEY,
					cidade VARCHAR(255) NOT NULL
				)";

				if (!function_exists('maybe_create_table')) {
         			require_once ABSPATH . 'wp-admin/install-helper.php';
     			}

				maybe_create_table('tb_cidades_alemanha',$query);

					if(isset($imagem['name']) && $imagem['name'] == ''){					
						$sucesso = false;
						echo '<div class="msg-box erro">Precisa escolher uma imagem.</div>';
					}

					if($sucesso){

						$wpdb->insert('tb_cidades_alemanha', array(
							'cidade' => $_POST['cidade']
						));

						$wpdb->show_errors();
						if($wpdb->last_error !== '')
						    $wpdb->print_error();

						echo '<div class="msg-box sucesso">Cidade inserida com sucesso!</div>';
					}

			}

			if(isset($_GET['cidade_excluir'])){

				$cidade_id = $_GET['cidade_excluir'];

		    	$wpdb->delete('tb_cidades_alemanha',array(
		    		'id' => $cidade_id
		    	));
			}
		 ?>

		<table class="table-form table-form-planos-vc">
			<tr>
				<td class="table-form-label"><label>Cidade: </label></td>
				<td class="table-form-input"><input type="text" name="cidade"></td>
			</tr>
		</table>

		<input type="submit" name="cidade_alterar" value="Cadastrar Cidade" class="button button-primary">
		
	</form>

	<?php $tb_cidades = $wpdb->get_results("SELECT * FROM `tb_cidades_alemanha` ORDER BY `cidade`"); ?>

	<table class="table-list">
		<tr>
			<th>Cidade</th>
			<th>Alterar</th>
		</tr>
		<?php foreach ($tb_cidades as $key => $value) {?>
		<tr>
			<td><?php echo $value->cidade; ?></td>
			<td>
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_cidades_alemanha&cidade_excluir='.$value->id; ?>" class="cidade-excluir" banner-id="<?php echo $value->id ?>">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>