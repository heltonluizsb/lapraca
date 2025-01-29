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
	<h2>Banners</h2>
	<form method="post" enctype="multipart/form-data" class="form-planos-vc">

		<?php 
			if(isset($_POST['banner_alterar'])){

				$sucesso = true;

				$query =  "CREATE TABLE IF NOT EXISTS tb_banners (
					id INT AUTO_INCREMENT PRIMARY KEY,
					cliente_id INT NOT NULL,
					link VARCHAR(255) NOT NULL,
					imagem VARCHAR(255) NOT NULL
				)";

				if (!function_exists('maybe_create_table')) {
         			require_once ABSPATH . 'wp-admin/install-helper.php';
     			}

				maybe_create_table('tb_banners',$query);

				$imagem = @$_FILES['imagem'];

				if(isset($imagem['name']) && $imagem['name'] != ''){
					if(padrao::imagemValida($imagem) == false){
						$sucesso = false;
						echo '<div class="msg-box erro">Imagem com formato incorreto ou arquivo maior que 10MB.</div>';
					}
				}else if((isset($imagem['name']) && $imagem['name'] == '') || !isset($imagem['name'])){
					$sucesso = false;
					echo '<div class="msg-box erro">Precisa escolher uma imagem.</div>';
				}

				if($sucesso){

					$imagem = padrao::uploadFile($imagem);

					$wpdb->insert('tb_banners', array(
						'link' => $_POST['link'],
						'imagem' => $imagem
					));

					$wpdb->show_errors();
					if($wpdb->last_error !== '')
					    $wpdb->print_error();

					echo '<div class="msg-box sucesso">Banner inserido com sucesso!</div>';
				}

			}

			if(isset($_GET['banner_excluir'])){

				$banner_id = $_GET['banner_excluir'];
				$banner = $wpdb->get_results("SELECT * FROM `tb_banners` WHERE `id` = $banner_id");
		    	padrao::deleteFile($banner[0]->imagem);

		    	$wpdb->delete('tb_banners',array(
		    		'id' => $banner_id
		    	));
			}
		 ?>

		<table class="table-form table-form-planos-vc">
			<tr>
				<td class="table-form-label"><label>Link da Imagem: </label></td>
				<td class="table-form-input"><input type="text" name="link"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Imagem (Tamanho Preferencial: 976x398): </label></td>
				<td class="table-form-input">
					<img src="<?php echo plugins_url('',__FILE__) ?>/img/no_image.jpg" id="editar-img"><br>
					<input type="file" name="imagem" onchange="document.getElementById('editar-img').src = window.URL.createObjectURL(this.files[0])">
				</td>
			</tr>
		</table>

		<input type="submit" name="banner_alterar" value="Cadastrar Banner" class="button button-primary">
		
	</form>

	<?php $tb_banners = $wpdb->get_results("SELECT * FROM `tb_banners`"); ?>

	<table class="table-list">
		<tr>
			<th>Empresa</th>
			<th>Nome do Cliente</th>
			<th>Link</th>
			<th>Imagem</th>
			<th>Alterar</th>
		</tr>
		<?php foreach ($tb_banners as $key => $value) {?>
		<tr>
			<td>
				<?php $cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `id` = %s",array($value->cliente_id));
				$cliente = $wpdb->get_results($cliente);
				if(count($cliente) < 1){echo 'Lá Pra Cá';}else{echo $cliente[0]->empresa;} ?>
			</td>
			<td>
				<?php if(count($cliente) < 1){echo 'Lá Pra Cá';}else{echo $cliente[0]->nome;} ?>
			</td>
			<td>
				<?php echo $value->link; ?>
			</td>
			<td><img class="banner-img" src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>"></td>
			<td>
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_banners&banner_excluir='.$value->id; ?>" class="banner-excluir" banner-id="<?php echo $value->id ?>">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>