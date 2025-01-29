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
	<h2>Categorias</h2>
	<form method="post" enctype="multipart/form-data" class="form-planos-vc">

		<?php 
			if(isset($_POST['categoria_alterar'])){

				$sucesso = true;

				$query =  "CREATE TABLE IF NOT EXISTS tb_categorias (
					id INT AUTO_INCREMENT PRIMARY KEY,
					nome VARCHAR(255) NOT NULL,
					imagem VARCHAR(255) NOT NULL
				)";

				if (!function_exists('maybe_create_table')) {
         			require_once ABSPATH . 'wp-admin/install-helper.php';
     			}

				maybe_create_table('tb_categorias',$query);

				$imagem = @$_FILES['imagem'];

				if(isset($imagem['name']) && $imagem['name'] != ''){
					if(padrao::imagemValida($imagem) == false){
						$sucesso = false;
						echo '<div class="msg-box erro">Imagem com formato incorreto ou arquivo maior que 10MB.</div>';
					}
				}

				if($_POST['categoria_id'] == 'new'){

					if(isset($imagem['name']) && $imagem['name'] == ''){					
						$sucesso = false;
						echo '<div class="msg-box erro">Precisa escolher uma imagem.</div>';
					}

					if($sucesso){

						$imagem = padrao::uploadFile($imagem);

						$wpdb->insert('tb_categorias', array(
							'nome' => $_POST['nome'],
							'imagem' => $imagem
						));

						$wpdb->show_errors();
						if($wpdb->last_error !== '')
						    $wpdb->print_error();

						echo '<div class="msg-box sucesso">Categorias inserida com sucesso!</div>';
					}

				}else{

					if($sucesso){

						if(isset($imagem['name']) && $imagem['name'] == ''){
							$imagem = stripslashes($_POST['imagem_antiga']);
						}else{

							padrao::deleteFile($_POST['imagem_antiga']);
							$imagem = padrao::uploadFile($imagem);

						}

						$wpdb->update('tb_categorias', array(
							'nome' => $_POST['nome'],
							'imagem' => $imagem
						),array(
							'id' => $_POST['categoria_id']));

						$wpdb->show_errors();
						if($wpdb->last_error !== '')
						    $wpdb->print_error();

						echo '<div class="msg-box sucesso">Categoria alterada com sucesso!</div>';

					}
				}

			}
		 ?>

		<table class="table-form table-form-planos-vc">
			<tr>
				<td class="table-form-label"><label>Nome da Categoria: </label></td>
				<td class="table-form-input"><input type="text" name="nome"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Imagem da Categoria: </label></td>
				<td class="table-form-input">
					<img src="<?php echo plugins_url('',__FILE__) ?>/img/no_image.jpg" id="editar-img"><br>
					<input type="file" name="imagem" onchange="document.getElementById('editar-img').src = window.URL.createObjectURL(this.files[0])">
				</td>
			</tr>
		</table>

		<input type="hidden" name="imagem_antiga" value="">
		<input type="hidden" name="categoria_id" value="new">

		<input type="submit" name="categoria_alterar" value="Criar Categoria" class="button button-primary">
		
	</form>

	<?php $tb_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias`"); ?>

	<table class="table-list">
		<tr>
			<th>Título</th>
			<th>Imagem</th>
			<th>Alterar</th>
		</tr>
		<?php foreach ($tb_categorias as $key => $value) {?>
		<tr>
			<td><?php echo $value->nome; ?></td>
			<td><img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>"></td>
			<td>
				<a href="" class="categoria-alterar" categoria-id="<?php echo $value->id ?>">Alterar</a> | 
				<a href="" class="categoria-excluir" categoria-id="<?php echo $value->id ?>">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>