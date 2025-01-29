<?php 
	// Template Name: Reset de Senha
?>

<?php get_header(); ?>

<?php 

	global $wpdb;

 ?>

<section class="confirmacao-box01">
    <div class="container">
        <div class="login-box01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span>Alteração de Senha</span><?php if(isset($_GET['plano'])){ echo ' / Você escolheu o plano <span>'.$_GET['plano'].'</span>';} ?></p>
        </div>

        <div class="box-login-wrapper">

        	<?php if(isset($_GET['codigo'])){
        		$tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `confirmacao` = %s",
        			array(
        				$_GET['codigo']
        			));
        		$tb_cliente = $wpdb->get_results($tb_cliente);
        		if(count($tb_cliente) < 1){?>
		            <div class="box-login">
		            	<h2 class="box-login-erro">Este código não existe em nosso banco de dados</h2>
		            </div>
        		<?php }else{?>
		            <div class="box-login">
		            	<h2>Alteração de Senha</h2>
		            	<form method="post">
		            		<label>Digite a nova senha</label>
		            		<input type="password" name="password">
		            		<label>Confirme a sua nova senha</label>
		            		<input type="password" name="confirmpassword">
		            		<?php 
		            			if($_POST['alterar-senha']){

		            				$sucesso = true;

								    if($_POST['password'] != $_POST['confirmpassword']){
								        $sucesso = false;

								        echo '<p style="color:red; margin-bottom:20px;"> As senhas não conferem.';
								    }

								    if(strlen($_POST['password']) < 8){
								        $sucesso = false;

								        echo '<p style="color:red; margin-bottom:20px;"> Senha menor do que 8 caracteres.';
								    }

									if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['password'])){
								        $sucesso = false;

								        echo '<p style="color:red; margin-bottom:20px;"> Sua senha não tem caracteres especiais.';
									}

									if (!preg_match('~[0-9]+~', $_POST['password'])){
								        $sucesso = false;

								        echo '<p style="color:red; margin-bottom:20px;"> Sua senha deve conter pelo menos um número.';
									}

									if(!preg_match("/[a-z]/i",$_POST['password'])){
								        $sucesso = false;

								        echo '<p style="color:red; margin-bottom:20px;"> Sua senha deve conter pelo menos uma letra.';
									}

									if($sucesso){

										$wpdb->update('tb_clientes', array(
											'senha' => $_POST['password'],
											'confirmacao' =>'confirmado'
										),array(
											'id' => $tb_cliente[0]->id));

								        echo '<p style="color:green; margin-bottom:20px; font-weight:bold;"> Senha alterada com sucesso. Clique em <a href="'.get_home_url().'/login" style="color:#040;">Entrar ou Criar conta</a>.';

									}

		            			}
		            		 ?>
		            		<input type="submit" name="alterar-senha" value="Alterar Senha">
		            	</form>
		            </div>
        		<?php } ?>
        	<?php }else{ ?>
            <div class="box-login">
            	<h2 class="box-login-erro">Não existe o código para confirmação.</h2>
            </div>
        	<?php } ?>

        </div>
		
	</div>
</section>

<?php get_footer(); ?>