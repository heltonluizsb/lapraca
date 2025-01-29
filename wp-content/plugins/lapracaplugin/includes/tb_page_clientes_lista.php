<?php
	include('config.php');
	global $wpdb;
	$upload_dir = wp_upload_dir();

	if(isset($_GET['cliente_excluir'])){
		$cliente_id = $_GET['cliente_excluir'];

		$cliente = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `id` = $cliente_id");

		if(count($cliente) < 1){
			echo '<h2>Este cliente não existe em nosso banco de dados</h2>';
			wp_die();
		}else{
			$wpdb->delete('tb_clientes', array(
				'id' => $cliente_id));
		}
	}
?>
<tbbase
	wp-admin="<?php echo admin_url(); ?>"
	get-site-url="<?php echo get_site_url(); ?>"
	base-dir="<?php echo $upload_dir['basedir'] ?>"
	base-url="<?php echo $upload_dir['baseurl'] ?>"
></tbbase>
<div class="wrap">
	<h2>Clientes</h2>

	<h2>Clientes Anunciantes</h2>

	<?php $tb_clientes_anunciantes = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `plano` != '' "); ?>

	<table class="table-list">
		<tr>
			<th>Empresa</th>
			<th>E-mail</th>
			<th>Plano</th>
			<th>Alterar</th>
		</tr>
		<?php foreach ($tb_clientes_anunciantes as $key => $value) {?>
		<tr>
			<td><?php echo $value->empresa; ?></td>
			<td><?php echo $value->email; ?></td>
			<td><?php echo $value->plano; ?></td>
			<td>
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_clientes_alterar&cliente_alterar='.$value->id; ?>" class="cliente-alterar" cliente-id="<?php echo $value->id ?>">Acessar</a> | 
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_clientes_lista&cliente_excluir='.$value->id; ?>" class="cliente-excluir" cliente-id="<?php echo $value->id ?>">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</table>

	<br><br>
	<h2>Clientes Não Anunciantes</h2>

	<?php $tb_clientes = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `plano` = '' "); ?>

	<table class="table-list">
		<tr>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Alterar</th>
		</tr>
		<?php foreach ($tb_clientes as $key => $value) {?>
		<tr>
			<td><?php echo $value->nome; ?></td>
			<td><?php echo $value->email; ?></td>
			<td>
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_clientes_alterar&cliente_alterar='.$value->id; ?>" class="cliente-alterar" cliente-id="<?php echo $value->id ?>">Acessar</a> | 
				<a href="<?php echo get_site_url().'/wp-admin/admin.php?page=lapraca_plugin_clientes_lista&cliente_excluir='.$value->id; ?>" class="cliente-excluir" cliente-id="<?php echo $value->id ?>">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>