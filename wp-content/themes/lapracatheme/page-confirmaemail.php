<?php 
	// Template Name: Confirmação de E-mail
?>

<?php get_header(); ?>

<?php 

	global $wpdb;

 ?>

<section class="confirmacao-box01">
    <div class="container">
        <div class="login-box01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span>Confirmação de E-mail</span><?php if(isset($_GET['plano'])){ echo ' / Você escolheu o plano <span>'.$_GET['plano'].'</span>';} ?></p>
        </div>

        <div class="box-login-wrapper">

        	<?php if(isset($_GET['codigo'])){
        		$check_codigo = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `confirmacao` = %s",
        			array(
        				$_GET['codigo']
        			));
        		$check_codigo = $wpdb->get_results($check_codigo);
        		if(count($check_codigo) < 1){?>
		            <div class="box-login">
		            	<h2 class="box-login-erro">Este código não existe em nosso banco de dados</h2>
		            </div>
        		<?php }else{
        			$wpdb->update('tb_clientes',array(
        				'confirmacao' => 'confirmado'
        			),array(
        				'confirmacao' => $_GET['codigo']
        			));
        		 ?>
		            <div class="box-login">
		            	<h2 class="box-login-sucesso">Confirmação Realizada com Sucesso!<br> Entre <a href="<?php echo get_home_url().'/login'; ?>">Neste Link</a> para continuar seu cadastro.</h2>
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