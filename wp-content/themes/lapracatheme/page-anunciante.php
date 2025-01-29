<?php 
	// Template Name: Anunciante
?>

<?php 
    global $wpdb;
    $upload_dir = wp_upload_dir();

    if(isset($_GET['id'])){

        $cliente_id = $_GET['id'];
        $cliente = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `id` = $cliente_id AND `plano` != ''");

        if(count($cliente) < 1){
            echo '<h2>Código do anunciante não existe.';
            wp_die();
        }

    }else{
        echo '<h2>Não tem o código do anunciante.';
        wp_die();
    }
?>

<?php get_header(); ?>

<section class="anunciante-box01">
    <div class="container">
        <div class="anunciante-box01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span><?php echo get_the_title(); ?></span></p>
        </div>
    </div>
</section>

<?php $cliente_fotos = $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id"); ?>

<section class="anunciante-box02" style="background-image: url(<?php echo "'".str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente_fotos[0]->foto)."')"; ?>;">
    <div class="anunciante-box02-wrapper"></div><!-- anunciante-box02-wrapper -->
    <div class="container">
        <div class="anunciante-box02-text">
            <h2><?php echo $cliente[0]->nome; ?></h2>
        </div>
    </div><!-- container -->
</section><!-- anunciante-box02 -->

<section class="anunciante-box03">
    <div class="container">
        <div class="anunciante-box03-text">
            <div class="anunciante-box03-text-wrapper">
                <?php echo $cliente[0]->descricao; ?>
            </div>
        </div> 
        <div class="anunciante-box03-address">
            <div class="anunciante-box03-address-wrapper">
                <div class="anunciante-box03-address-map">
                    <div class="anunciante-box03-address-map-wrapper" id="map-canvas"></div>
                    <div class="anunciante-box03-address-map-location">
                        <?php echo $cliente[0]->endereco; ?>
                    </div>
                </div>
                <div class="anunciante-box03-address-text">
                    <table>
                        <tr><td><div class="anunciante-box03-address-text-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp01.svg">
                            </div></td>
                            <td class="anunciante-box03-address-text-paragraph">
                                <a href="https://api.whatsapp.com/send?phone=55<?php echo preg_replace('/\D/', '', $cliente[0]->telefone); ?>" target="_blank"><?php echo $cliente[0]->telefone ?></a>
                            </td>
                            <td><div class="anunciante-box03-address-text-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/instagram-logo.svg">
                            </div></td>
                            <td class="anunciante-box03-address-text-paragraph">
                                <a href="<?php echo $cliente[0]->instagram ?>" target="_blank"><?php echo $cliente[0]->instagram ?></a>
                            </td>
                        </tr>
                        <tr><td><div class="anunciante-box03-address-text-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email01.svg">
                            </div></td>
                            <td class="anunciante-box03-address-text-paragraph">
                                <a href="mailto:<?php echo $cliente[0]->email ?>" target="_blank"><?php echo $cliente[0]->email ?></a>
                            </td>
                            <td><div class="anunciante-box03-address-text-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/world01.svg">
                            </div></td>
                            <td class="anunciante-box03-address-text-paragraph" target="_blank">
                                <a href="<?php echo $cliente[0]->site ?>"><?php echo $cliente[0]->site ?></a>
                            </td>
                        </tr>
                        </tr>
                        <tr>
                    </table>
                    <form method="post">
                        <input type="hidden" name="address" id="address" value="<?php echo $cliente[0]->endereco.' - '.$cliente[0]->cidade; ?>">
                        <input type="hidden" name="nome" id="nome" value="<?php echo $cliente[0]->nome; ?>">
                    </form>
                </div>
            </div>
        </div>       
    </div><!-- container -->
</section><!-- anunciante-box03 -->

<section class="anunciante-box04">
    <div class="anunciante-box04-wrapper" id="pano">
        
    </div>
</section>

<?php get_footer(); ?>