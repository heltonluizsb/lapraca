<?php
	include('config.php');
	global $wpdb;
	$upload_dir = wp_upload_dir();

	if(isset($_GET['cliente_alterar'])){
		$cliente_id = $_GET['cliente_alterar'];

		$cliente = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `id` = $cliente_id");

		if(count($cliente) < 1){
			echo '<h2>Este cliente não existe em nosso banco de dados</h2>';
			wp_die();
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
	<p>Obs: No caso de um novo cadastro de cliente, a senha padrão será <i>"Lapraca@2022"</i></p>
	<form method="post" enctype="multipart/form-data" class="form-planos-vc form-cliente">

		<table class="table-form table-form-planos-vc">
			<tr>
				<td class="table-form-label"><label>Nome: </label></td>
				<td class="table-form-input"><input type="text" name="nome" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->nome;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>E-mail: </label></td>
				<td class="table-form-input"><input type="email" name="email" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->email;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Plano: </label></td>
				<td class="table-form-input">
					<select name="plano">
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->plano == ''){echo 'selected';} ?> value="">Nenhum plano (não anunciante)</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->plano == 'Descobrimento'){echo 'selected';} ?> value="Descobrimento">Descobrimento (grátis)</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->plano == 'Exploração'){echo 'selected';} ?> value="Exploração" disabled>Exploração (ainda não disponível)</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->plano == 'Exploração'){echo 'selected';} ?> value="Expansão" disabled>Expansão (ainda não disponível)</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->plano == 'Liderança'){echo 'selected';} ?> value="Liderança" disabled>Liderança (ainda não disponível)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Telefone: </label></td>
				<td class="table-form-input"><input type="text" name="telefone" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->telefone;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Endereço: </label></td>
				<td class="table-form-input"><input type="text" name="endereco" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->endereco;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Pais: </label></td>
				<td class="table-form-input">
					<select name="pais">
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->pais == 'Alemanha'){echo 'selected';} ?>>Alemanha</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->pais == 'Brasil'){echo 'selected';} ?>>Brasil</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->pais == 'Portugal'){echo 'selected';} ?>>Portugal</option>
						<option <?php if(isset($_GET['cliente_alterar']) && $cliente[0]->pais == 'Outros'){echo 'selected';} ?>>Outros</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Cidade: </label></td>
				<td class="table-form-input"><input type="text" name="cidade" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->cidade;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>CEP: </label></td>
				<td class="table-form-input"><input type="text" name="cep" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->cep;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Empresa: </label></td>
				<td class="table-form-input"><input type="text" name="empresa" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->empresa;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Cargo: </label></td>
				<td class="table-form-input"><input type="text" name="cargo" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->cargo;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Logo: </label></td>
				<td class="table-form-input">
					<?php if(isset($_GET['cliente_alterar'])){ ?>
						 <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente[0]->logo); ?>" id="editar-img"><br>
					<?php }else{ ?>
						<img src="<?php echo plugins_url('',__FILE__) ?>/img/no_image.jpg" id="editar-img"><br>
					<?php } ?>
					<input type="file" name="logo" onchange="document.getElementById('editar-img').src = window.URL.createObjectURL(this.files[0])">
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Categoria: </label></td>
				<td class="table-form-input">
					<?php $tb_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias`");
					if(isset($_GET['cliente_alterar'])){
						$tb_clientes_categorias = $wpdb->prepare("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = %s",array($cliente[0]->id));
						$tb_clientes_categorias = $wpdb->get_results($tb_clientes_categorias);
					} ?>
					<select name="categoria">
					<?php foreach ($tb_categorias as $key => $value) {?>
						<option value="<?php echo $value->id ?>" <?php if(isset($_GET['cliente_alterar']) && $tb_clientes_categorias[0]->categoria_id == $value->id){echo 'selected';} ?>><?php echo $value->nome?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Descrição da Empresa: </label></td>
				<td class="table-form-input">
					<textarea name="descricao"><?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->descricao;} ?></textarea>
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Fotos da empresa: </label></td>
				<td class="table-form-input">
    				<?php $tb_cliente_fotos = $wpdb->prepare("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = %s",array($cliente[0]->id));
				        $tb_cliente_fotos = $wpdb->get_results($tb_cliente_fotos);
				        foreach ($tb_cliente_fotos as $key => $value) { ?>
				        	<div class="foto-empresa">
				        		<img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->foto); ?>">
				        		<div cliente-id="<?php echo $cliente[0]->id; ?>" foto-id="<?php echo $value->id; ?>" foto="<?php echo $value->foto; ?>">
				        			<span></span><span></span>
				        		</div>
				        	</div>
				        <?php } ?>
				</td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Instagram: </label></td>
				<td class="table-form-input"><input type="text" name="instagram" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->instagram;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Facebook: </label></td>
				<td class="table-form-input"><input type="text" name="facebook" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->facebook;} ?>"></td>
			</tr>
			<tr>
				<td class="table-form-label"><label>Site: </label></td>
				<td class="table-form-input"><input type="text" name="site" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->site;} ?>"></td>
			</tr>
		</table>

		<input type="hidden" name="email-antigo" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->email;} ?>">
		<input type="hidden" name="logo-antigo" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->logo;} ?>">
		<input type="hidden" name="cliente_id" value="<?php if(isset($_GET['cliente_alterar'])){echo $cliente[0]->id;}else{echo 'new';} ?>">

		<input type="submit" name="cliente_alterar" value="<?php if(isset($_GET['cliente_alterar'])){echo 'Alterar Cliente';}else{echo 'Criar Cliente';} ?>" class="button button-primary">
		
	</form>

	<section class="login-processando">
	    <div class="container">
	        <div class="login-processando-box">
	            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/processando01.gif">
	            <h2>Estamos Processando sua solicitação</h2>
	        </div>
	    </div>
	</section>

</div>