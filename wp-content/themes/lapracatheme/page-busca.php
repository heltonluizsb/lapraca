<?php 
	// Template Name: Busca
?>

<?php get_header(); ?>

<?php 
    global $wpdb;
    $upload_dir = wp_upload_dir();
    $clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias`");
?>

<section class="busca01">
    <div class="container">
        <div class="busca01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span><?php echo get_the_title(); ?></span></p>
        </div>
        <?php if(isset($_GET['segmento'])){ ?>
            <div class="busca01-titulo">
                <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/segmentos.png"> -->
                <?php $tb_cliente_categoria_single = $wpdb->prepare("SELECT * FROM `tb_categorias` WHERE `id` = %s",array($_GET['segmento']));
                $tb_cliente_categoria_single = $wpdb->get_results($tb_cliente_categoria_single);?>
                <h2><?php echo $tb_cliente_categoria_single[0]->nome; ?></h2>
            </div>
        <?php }else if(isset($_GET['cidade'])){ ?>
            <div class="busca01-titulo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cidades.png">
            </div>
        <?php }else{ ?>
            <div class="busca01-titulo">
                <h2>Resultado da Busca</h2>
            </div>
        <?php } ?>
    </div>
</section>

<section class="busca02">
    <div class="container">
        <div class="busca02-lista-segmentos">
            <?php foreach ($clientes_categorias as $key => $value) {?>
                <a href="<?php echo get_site_url().'/busca?segmento='.$value->id; ?>" class="busca02-lista-segmentos-single">
                    <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>">
                    <p><?php echo $value->nome; ?></p>
                </a>
            <?php } ?>
        </div>
        <div class="busca02-empresas">
            
            <?php if(isset($_GET['segmento'])){
                $clientes_categorias = $wpdb->prepare("
                    SELECT 
                        `tb_clientes`.* ,
                        `tb_clientes_categorias`.`id` AS `tb_clientes_categorias_id`,
                        `tb_clientes_categorias`.`cliente_id`,
                        `tb_clientes_categorias`.`categoria_id`
                    FROM `tb_clientes`
                    INNER JOIN `tb_clientes_categorias`
                    ON `tb_clientes`.`id` = `tb_clientes_categorias`.`cliente_id`
                    WHERE `tb_clientes_categorias`.`categoria_id` = %s",
                    array(
                        $_GET['segmento']
                    )
                );
                $clientes_categorias = $wpdb->get_results($clientes_categorias);
                if(count($clientes_categorias) > 0){
                    foreach ($clientes_categorias as $key => $value) {
                        $cliente_id = $value->id;
                        $cliente_fotos =  $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id");?>

                        <a href="<?php echo get_site_url().'/anunciante?id='.$value->id; ?>" class="busca02-empresas-single">
                            <div class="busca02-empresas-single-img">
                                <?php if($cliente_fotos[0]->foto != ''){ ?>
                                    <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente_fotos[0]->foto); ?>">
                                <?php }else{ ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png">
                                <?php } ?>
                                <?php if($value->pais == 'Alemanha'){ ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                                <?php }else if($value->pais == 'Brasil'){ ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_brazil.png" class="flag">
                                <?php }else if($value->pais == 'Portugal'){ ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_portugal.png" class="flag">
                                <?php } ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/like.png" class="coracao">
                            </div>
                            <div class="busca02-empresas-single-valores">
                                <div class="busca02-empresas-single-valores-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/oferta.svg">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/photo.svg">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/location.svg">
                                </div>
                                <!-- <div class="busca02-empresas-single-valores-text">
                                    <span>$49-89</span>
                                </div> -->
                            </div>
                            <div class="busca02-empresas-single-text">
                                <h2><?php echo $value->empresa; ?></h2>
                                <?php $tb_clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = $cliente_id");
                                $categoria_id = $tb_clientes_categorias[0]->categoria_id;
                                $tb_cliente_categoria_single = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");?>
                                <p style="font-weight: bold;"><?php echo $tb_cliente_categoria_single[0]->nome; ?></p>
                                <p><?php if(strlen($value->descricao) > 39){echo substr($value->descricao,0,40).'[...]';}else{echo $value->descricao;} ?></p>
                            </div>
                        </a><!-- busca02-empresas-single -->

                    <?php }
                }else{
                    echo '<p class="busca02-empresas-vazio">Não foi encontrada nenhuma empresa com essa categoria.</p>';
                }
            }else if(isset($_GET['resultado'])){
                $tb_categorias = $wpdb->prepare("SELECT * FROM `tb_categorias` WHERE `nome` LIKE %s",array('%'.$_GET['resultado'].'%'));
                $tb_categorias = $wpdb->get_results($tb_categorias);

                if(count($tb_categorias) > 0){?>
                    <h3>Buscando resultados com "<?php echo $_GET['resultado']; ?>" nos Segmentos:</h3>
                    <div class="busca02-categorias">
                        <?php foreach ($tb_categorias as $key => $value) {?>
                        
                            <a href="<?php echo get_site_url().'/busca?segmento='.$value->id; ?>" class="busca02-categorias-single"><div>
                                <div><img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>"></div>
                                <div><span>
                                    <?php $nome_ucwords = str_replace(strtolower($_GET['resultado']), '<span class="busca02-categorias-single-destaque">'.strtolower($_GET['resultado']).'</span>', mb_strtolower($value->nome));
                                    echo $nome_ucwords; ?>
                                </span></div>
                            </div></a>

                        <?php } ?>
                    </div>
                <?php }

                if(strlen($_GET['resultado']) == 5 AND $_GET['resultado'] >= 0 AND $_GET['resultado'] <= 99999){
                    $tb_clientes_cep = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `cep` = %s AND `plano` != ''",array($_GET['resultado']));
                    $tb_clientes_cep = $wpdb->get_results($tb_clientes_cep);

                    if(count($tb_clientes_cep) > 0){
                        echo '<h3>Exibindo empresas com o CEP '.$_GET['resultado'].'.</h3><br>';
                        foreach ($tb_clientes_cep as $key => $value) {
                            $cliente_id = $value->id;
                            $cliente_fotos =  $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id");?>

                            <a href="<?php echo get_site_url().'/anunciante?id='.$value->id; ?>" class="busca02-empresas-single">
                                <div class="busca02-empresas-single-img">
                                    <?php if($cliente_fotos[0]->foto != ''){ ?>
                                        <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente_fotos[0]->foto); ?>">
                                    <?php }else{ ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png">
                                    <?php } ?>
                                    <?php if($value->pais == 'Alemanha'){ ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                                    <?php }else if($value->pais == 'Brasil'){ ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_brazil.png" class="flag">
                                    <?php }else if($value->pais == 'Portugal'){ ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_portugal.png" class="flag">
                                    <?php } ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/like.png" class="coracao">
                                </div>
                                <div class="busca02-empresas-single-valores">
                                    <div class="busca02-empresas-single-valores-img">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/oferta.svg">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/photo.svg">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/location.svg">
                                    </div>
                                    <!-- <div class="busca02-empresas-single-valores-text">
                                        <span>$49-89</span>
                                    </div> -->
                                </div>
                                <div class="busca02-empresas-single-text">
                                    <h2><?php echo $value->empresa; ?></h2>
                                    <?php $tb_clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = $cliente_id");
                                    $categoria_id = $tb_clientes_categorias[0]->categoria_id;
                                    $tb_cliente_categoria_single = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");?>
                                    <p style="font-weight: bold;"><?php echo $tb_cliente_categoria_single[0]->nome; ?></p>
                                    <p><?php if(strlen($value->descricao) > 39){echo substr($value->descricao,0,40).'[...]';}else{echo $value->descricao;} ?></p>
                                </div>
                            </a><!-- busca02-empresas-single -->

                        <?php }
                    }else{
                        $tb_clientes_cep = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE `cep` LIKE %s AND `plano` != ''",array(substr($_GET['resultado'],0,2).'%'));
                        $tb_clientes_cep = $wpdb->get_results($tb_clientes_cep);

                        if(count($tb_clientes_cep) > 0){
                            echo '<h3>Exibindo empresas na mesma região do CEP selecionado '.$_GET['resultado'].'.</h3><br>';
                            foreach ($tb_clientes_cep as $key => $value) {
                                $cliente_id = $value->id;
                                $cliente_fotos =  $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id");?>

                                <a href="<?php echo get_site_url().'/anunciante?id='.$value->id; ?>" class="busca02-empresas-single">
                                    <div class="busca02-empresas-single-img">
                                        <?php if($cliente_fotos[0]->foto != ''){ ?>
                                            <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente_fotos[0]->foto); ?>">
                                        <?php }else{ ?>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png">
                                        <?php } ?>
                                        <?php if($value->pais == 'Alemanha'){ ?>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                                        <?php }else if($value->pais == 'Brasil'){ ?>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_brazil.png" class="flag">
                                        <?php }else if($value->pais == 'Portugal'){ ?>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_portugal.png" class="flag">
                                        <?php } ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/like.png" class="coracao">
                                    </div>
                                    <div class="busca02-empresas-single-valores">
                                        <div class="busca02-empresas-single-valores-img">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/oferta.svg">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/photo.svg">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/location.svg">
                                        </div>
                                        <!-- <div class="busca02-empresas-single-valores-text">
                                            <span>$49-89</span>
                                        </div> -->
                                    </div>
                                    <div class="busca02-empresas-single-text">
                                        <h2><?php echo $value->empresa; ?></h2>
                                        <?php $tb_clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = $cliente_id");
                                        $categoria_id = $tb_clientes_categorias[0]->categoria_id;
                                        $tb_cliente_categoria_single = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");?>
                                        <p style="font-weight: bold;"><?php echo $tb_cliente_categoria_single[0]->nome; ?></p>
                                        <p><?php if(strlen($value->descricao) > 39){echo substr($value->descricao,0,40).'[...]';}else{echo $value->descricao;} ?></p>
                                    </div>
                                </a><!-- busca02-empresas-single -->

                            <?php }
                        }
                    }
                }

                $tb_clientes = $wpdb->prepare("SELECT * FROM `tb_clientes` WHERE
                    (`nome` LIKE %s OR
                    `email` LIKE %s OR
                    `telefone` LIKE %s OR
                    `endereco` LIKE %s OR
                    `cidade` LIKE %s OR
                    `pais` LIKE %s OR
                    `empresa` LIKE %s OR
                    `descricao` LIKE %s OR
                    `instagram` LIKE %s OR
                    `facebook` LIKE %s OR
                    `site` LIKE %s)
                    AND `plano` != ''"
                    ,array(
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%',
                        '%'.$_GET['resultado'].'%'
                    ));
                $tb_clientes = $wpdb->get_results($tb_clientes);

                if(count($tb_clientes) > 0){
                    echo '<br><h3>Exibindo resultados de busca com "'.$_GET['resultado'].'":</h3><br>';
                }

                foreach ($tb_clientes as $key => $value) {
                    $cliente_id = $value->id;
                    $cliente_fotos =  $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id");?>

                    <a href="<?php echo get_site_url().'/anunciante?id='.$value->id; ?>" class="busca02-empresas-single">
                        <div class="busca02-empresas-single-img">
                            <?php if($cliente_fotos[0]->foto != ''){ ?>
                                <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$cliente_fotos[0]->foto); ?>">
                            <?php }else{ ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png">
                            <?php } ?>
                            <?php if($value->pais == 'Alemanha'){ ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                            <?php }else if($value->pais == 'Brasil'){ ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_brazil.png" class="flag">
                            <?php }else if($value->pais == 'Portugal'){ ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_portugal.png" class="flag">
                            <?php } ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/like.png" class="coracao">
                        </div>
                        <div class="busca02-empresas-single-valores">
                            <div class="busca02-empresas-single-valores-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/oferta.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/photo.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/location.svg">
                            </div>
                            <!-- <div class="busca02-empresas-single-valores-text">
                                <span>$49-89</span>
                            </div> -->
                        </div>
                        <div class="busca02-empresas-single-text">
                            <h2><?php echo $value->empresa; ?></h2>
                            <?php $tb_clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = $cliente_id");
                            $categoria_id = $tb_clientes_categorias[0]->categoria_id;
                            $tb_cliente_categoria_single = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");?>
                            <p style="font-weight: bold;"><?php echo $tb_cliente_categoria_single[0]->nome; ?></p>
                            <p><?php if(strlen($value->descricao) > 39){echo substr($value->descricao,0,40).'[...]';}else{echo $value->descricao;} ?></p>
                        </div>
                    </a><!-- busca02-empresas-single -->

                <?php }
            }
             ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>