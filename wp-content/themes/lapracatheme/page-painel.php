<?php 
	// Template Name: Painel
?>

<?php get_header(); ?>

<section class="painel-box01">
	<div class="container">
		<?php 

			$upload_dir = wp_upload_dir();

			if(isset($_SESSION['cliente_email']) && isset($_SESSION['cliente_password'])){

		        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
		            array(
		               $_SESSION['cliente_email'],
		               $_SESSION['cliente_password']
		            ));
		        $tb_cliente = $wpdb->get_results($tb_cliente);
		        if(count($tb_cliente) < 1){

		            header('Location: '.get_home_url().'/login');
		            die();
		        }else if($tb_cliente[0]->confirmacao != 'confirmado'){

		            echo '<h2>Seu código não foi confirmado. Favor entrar  em seu e-mail e confirmar</h2>';
		            die();
		        }

			}
		 ?>

        <div class="painel-box01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span>Painel</span></p>
        </div>

        <div class="box-login-wrapper">

            <div class="box-login">

            	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/painel_img01.png" class="box-login-img">
            	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/atualize_seu_cadastro.png" class="box-login-titulo">

            	<?php if($tb_cliente[0]->plano == '' && !isset($_GET['plano'])){ ?>
            		<form method="post" enctype="multipart/form-data">
            			<div class="input-box">
            				<label>Nome</label>
            				<input type="text" name="nome" value="<?php echo $tb_cliente[0]->nome; ?>">
            			</div>
            			<div class="input-box">
            				<label>E-mail</label>
            				<input type="email" name="email" value="<?php echo $tb_cliente[0]->email; ?>">
            			</div>
            			<div class="input-box">
            				<label>Telefone / WhatsApp</label>
            				<input type="text" name="telefone" value="<?php echo $tb_cliente[0]->telefone; ?>">
            			</div>
            			<div class="input-box">
            				<label>Endereço</label>
            				<input type="text" name="endereco" value="<?php echo $tb_cliente[0]->endereco; ?>">
            			</div>
            			<div class="input-box">
            				<label>País</label>
            				<select name="pais">
            					<option <?php if($tb_cliente[0]->pais == 'Alemanha'){echo 'selected';} ?>>Alemanha</option>
            					<option <?php if($tb_cliente[0]->pais == 'Brasil'){echo 'selected';} ?>>Brasil</option>
            					<option <?php if($tb_cliente[0]->pais == 'Portugal'){echo 'selected';} ?>>Portugal</option>
            				</select>
            			</div>
            			<input type="hidden" name="acao_hidden" value="atualizar-nao-anunciante">
            			<input type="hidden" name="cliente_id" value="<?php echo $tb_cliente[0]->id; ?>">
            			<input type="submit" name="atualizar" value="Atualizar">
            			<div class="checkbox-box">
            				<input type="checkbox" name="termos" <?php if($tb_cliente[0]->termos){echo 'checked';} ?>>
            				<label>Concordo com os <a href="<?php echo get_site_url(); ?>/termos-e-servicos/">Termos de Uso</a> do Lá Pra Cá</label>
            			</div>
            			<div class="checkbox-box">
            				<input type="checkbox" name="newsletters">
            				<label>Aceito receber e-mails de newsletters e notificações sobre minha conta.</label>
            			</div>
            		</form>
            	<?php }else{ ?>
            		<form method="post" enctype="multipart/form-data">
            			<div class="input-box">
            				<label>Nome da Empresa</label>
            				<input type="text" name="empresa" value="<?php echo $tb_cliente[0]->empresa; ?>">
            			</div>
            			<div class="input-box">
            				<label>Nome para contato</label>
            				<input type="text" name="nome" value="<?php echo $tb_cliente[0]->nome; ?>">
            			</div>
            			<div class="input-box">
            				<label>E-mail</label>
            				<input type="text" name="email" value="<?php echo $tb_cliente[0]->email; ?>">
            			</div>
            			<div class="input-box">
            				<label>Telefone / WhatsApp</label>
            				<input type="text" name="telefone" value="<?php echo $tb_cliente[0]->telefone; ?>">
            			</div>
            			<div class="input-box">
            				<label>Posição / Cargo</label>
            				<input type="text" name="cargo" value="<?php echo $tb_cliente[0]->cargo; ?>">
            			</div>
            			<div class="input-box">
            				<label>Endereço (Obs: se possível colocar o endereço com logradouro e bairro para melhor localização do Google Maps)</label>
            				<input type="text" name="endereco" value="<?php echo $tb_cliente[0]->endereco; ?>">
            			</div>
            			<div class="input-box">
            				<label>CEP:</label>
            				<input type="text" name="cep" value="<?php echo $tb_cliente[0]->cep; ?>">
            			</div>
            			<div class="input-box">
            				<label>País</label>
            				<select name="pais">
            					<option <?php if($tb_cliente[0]->pais == 'Alemanha'){echo 'selected';} ?>>Alemanha</option>
            					<option <?php if($tb_cliente[0]->pais == 'Brasil'){echo 'selected';} ?>>Brasil</option>
            					<option <?php if($tb_cliente[0]->pais == 'Portugal'){echo 'selected';} ?>>Portugal</option>
            					<option <?php if($tb_cliente[0]->pais == 'Portugal'){echo 'selected';} ?>>Outros</option>
            				</select>
            			</div>
            			<div class="input-box">
            				<label>Cidade</label>
            				<input type="text" name="cidade" value="<?php echo $tb_cliente[0]->cidade; ?>">
            			</div>
            			<div>
	        				<label>Imagem do Logo</label>
	            			<div class="painel-form-logo-img">
	            				<?php if( $tb_cliente[0]->logo != ''){ ?>
	            					<div><img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$tb_cliente[0]->logo); ?>"></div>
	            				<?php } ?>
	            			</div>
            			</div>
            			<div class="input-box">
            				<label>Logo</label>
            				<input id="logo-file" type="file" name="logo" cliente-id="<?php echo $tb_cliente[0]->id ?>">
            				<div class="file-stylized">
            					<div><label for="logo-file">Arquivos suportados: JPG, PNG ou SVG (tamanho máx: 3mb)</label></div>
            					<div><label for="logo-file"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/download_btn01.svg"></label></div>
            				</div>
            			</div>
            			<div class="input-box">
            				<label>Categoria</label>
            				<select name="categoria">
            					<?php $tb_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias`");
            						$tb_clientes_categorias = $wpdb->prepare("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = %s",array($tb_cliente[0]->id));
            						$tb_clientes_categorias = $wpdb->get_results($tb_clientes_categorias);
            						foreach ($tb_categorias as $key => $value) {?>
            							<option value="<?php echo $value->id ?>" <?php if($tb_clientes_categorias[0]->categoria_id == $value->id){echo 'selected';} ?>><?php echo $value->nome?></option>
            						<?php } ?>
            				</select>
            			</div>
            			<div class="input-box">
            				<label>Descrição da Empresa</label>
            				<textarea name="descricao"><?php echo $tb_cliente[0]->descricao; ?></textarea>
            				<h6>*Maximo de 500 caracteres</h6>
            			</div>
            			<div>
	        				<label>Imagem da Foto da Empresa</label>
	            			<div class="painel-form-foto-empresa-img">
	            				<?php $tb_cliente_fotos = $wpdb->prepare("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = %s",
							            array(
							            	$tb_cliente[0]->id
							            ));
							        $tb_cliente_fotos = $wpdb->get_results($tb_cliente_fotos);

							        foreach ($tb_cliente_fotos as $key => $value) { ?>
							        	<div>
							        		<img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->foto); ?>">
							        		<div cliente-id="<?php echo $tb_cliente[0]->id; ?>" foto-id="<?php echo $value->id; ?>" foto="<?php echo $value->foto; ?>">
							        			<span></span><span></span>
							        		</div>
							        	</div>
							        <?php } ?>
	            			</div>
            			</div>
            			<div class="input-box">
            				<label>Foto da Empresa</label>
            				<input id="foto-empresa-file" type="file" name="foto-empresa" cliente-id="<?php echo $tb_cliente[0]->id; ?>">
            				<div class="file-stylized">
            					<div><label for="foto-empresa-file">Arquivos suportados: JPG, PNG ou SVG (tamanho máx: 3mb)</label></div>
            					<div><label for="foto-empresa-file"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/download_btn01.svg"></label></div>
            				</div>
            			</div>
            			<div class="input-box">
            				<label>Instagram da Empresa</label>
            				<input type="text" name="instagram" value="<?php echo $tb_cliente[0]->instagram; ?>">
            			</div>
            			<div class="input-box">
            				<label>Link da Página do Facebook</label>
            				<input type="text" name="facebook" value="<?php echo $tb_cliente[0]->facebook; ?>">
            			</div>
            			<div class="input-box">
            				<label>Site da Empresa</label>
            				<input type="text" name="site" value="<?php echo $tb_cliente[0]->site; ?>">
            			</div>
            			<input type="hidden" name="acao_hidden" value="atualizar-tudo">
            			<input type="hidden" name="cliente_id" value="<?php echo $tb_cliente[0]->id; ?>">
            			<input type="hidden" name="plano" value="<?php if(isset($_GET['plano'])){echo $_GET['plano'];}else{ echo $tb_cliente[0]->plano;} ?>">
            			<input type="submit" name="atualizar" value="Atualizar">
            			<div class="checkbox-box">
            				<input type="checkbox" name="termos" <?php if($tb_cliente[0]->termos){echo 'checked';} ?>>
            				<label>Concordo com os <a href="">Termos de Uso</a> do Lá Pra Cá</label>
            			</div>
            			<div class="checkbox-box">
            				<input type="checkbox" name="newsletters" <?php if($tb_cliente[0]->newsletters){echo 'checked';} ?>>
            				<label>Aceito receber e-mails de newsletters e notificações sobre minha conta.</label>
            			</div>
            		</form>
            	<?php } ?>

            </div><!-- box-login -->

        </div><!-- box-login-wrapper -->
	</div><!-- container -->
</section>

<section class="login-processando">
    <div class="container">
        <div class="login-processando-box">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/processando01.gif">
            <h2>Estamos Processando sua solicitação</h2>
        </div>
    </div>
</section>

<?php get_footer(); ?>