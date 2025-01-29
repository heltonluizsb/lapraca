<?php 
	// Template Name: Login
?>

<?php 

    ob_start();

    include('config.php');

    global $wpdb;
    $upload_dir = wp_upload_dir();

    if(isset($_SESSION['cliente_login']) && $_SESSION['cliente_login']){

        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
            array(
               $_SESSION['cliente_email'],
               $_SESSION['cliente_password']
            ));
        $tb_cliente = $wpdb->get_results($tb_cliente);
        if(count($tb_cliente) == 1){
            
            $_SESSION['cliente_login'] = true;

            if(isset($_GET['plano'])){
                header('Location: '.get_home_url().'/painel?plano='.$_GET['plano']);
            }else{
                header('Location: '.get_home_url().'/painel');
            }
            die();
        }
    }

    if(isset($_COOKIE['cliente_email']) && isset($_COOKIE['cliente_password'])){

        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
            array(
               $_COOKIE['cliente_email'],
               $_COOKIE['cliente_password']
            ));
        $tb_cliente = $wpdb->get_results($tb_cliente);
        if(count($tb_cliente) == 1){
            
            $_SESSION['cliente_login'] = true;

            $_SESSION['cliente_email'] = $_COOKIE['cliente_email'];
             $_SESSION['cliente_password'] = $_COOKIE['cliente_password'];

            header('Location: '.get_home_url().'/painel');
            die();
        }
    }

 ?>

<?php get_header(); ?>

<section class="login-box01">
    <div class="container">
        <div class="login-box01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span>Login</span><?php if(isset($_GET['plano'])){ echo ' / Você escolheu o plano <span>'.$_GET['plano'].'</span>';} ?></p>
        </div>

        <div class="box-login-wrapper">

            <div class="box-login">

                <?php
                    if(isset($_POST['entrar'])){

                        $tb_cliente = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `email` = %s AND `senha` = %s",
                            array(
                               $_POST['email'],
                               $_POST['password']
                            ));
                        $tb_cliente = $wpdb->get_results($tb_cliente);

                        if(count($tb_cliente) == 1){
                            $_SESSION['cliente_login'] = true;
                            $_SESSION['cliente_email'] = $_POST['email'];
                            $_SESSION['cliente_password'] = $_POST['password'];
                            $_SESSION['cliente_id'] = $tb_cliente->id;
                            setcookie('cliente_email',$_POST['email'],time()+(60*60*24*7),'/');
                            setcookie('cliente_password',$_POST['password'],time()+(60*60*24*7),'/');
                            header('Location: '.get_home_url().'/painel');
                            die();
                        }else{
                            echo '<h2 class="box-login-erro" style="margin-top:0;margin-bottom:40px;">Usuário ou senha incorretos</h2>';
                        }
                    }
                ?>

                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/login_img01.png" class="box-login-img">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/entre_em_sua_conta.png" class="box-login-titulo">
                <form method="post">
                    <label>Endereço de Email</label>
                    <input type="email" name="email">
                    <label>Senha</label>
                    <input type="password" name="password" autocomplete="on">
                    <div class="box-login-btns">
                        <a href="" class="left">Ainda não tenho cadastro</a>
                        <input type="submit" name="entrar" value="Entrar" class="right">
                        <div class="clear"></div>
                    </div>
                </form>
                <a href="" class="link-esqueceu-senha">Esqueceu a senha</a>
                <div class="box-login-esqueceu-senha">
                    <form method="post" class="box-login-esqueceu-senha-form">
                        <label>Escreva seu e-mail, para enviarmos um link de reset de senha.</label>
                        <input type="text" name="email">
                        <div>
                            <input type="submit" name="enviar">
                        </div>
                    </form>
                </div>
            </div><!-- box-login -->


            <div class="box-login">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cadastro_img01.svg" class="box-login-img">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/faca_seu_cadastro.png" class="box-login-titulo">
                <form method="post" class="box-login-form-cadastro">
                    <label>Nome Completo</label>
                    <input type="text" name="nome">
                    <label>Endereço de Email</label>
                    <input type="email" name="email">
                    <label>Senha</label>
                    <input type="password" name="password" autocomplete="on">
                    <label>Confirma Senha</label>
                    <input type="password" name="confirmpassword" autocomplete="on">
                    <input type="hidden" name="plano-tipo" value="<?php echo @$_GET['plano'] ?>">
                    <div class="box-login-btns">
                        <a href="" class="left">⇐ Voltar para tela de Login</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="right">
                        <div class="clear"></div>
                    </div>
                </form>
                <a href="">Esqueceu a senha</a>
            </div><!-- box-login 2 -->

        </div><!-- box-loing-wrapper -->

    </div><!-- container -->
</section><!-- login-box01 -->

<section class="login-processando">
    <div class="container">
        <div class="login-processando-box">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/processando01.gif">
            <h2>Estamos Processando sua solicitação</h2>
        </div>
    </div>
</section>

<?php get_footer(); ?>
<?php ob_end_flush(); ?>