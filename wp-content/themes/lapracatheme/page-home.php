<?php 
	// Template Name: Home
?>

<?php get_header(); ?>

<?php 
    global $wpdb;
    $upload_dir = wp_upload_dir();    
?>

<section class="home-box01">
    <div class="container">
        <div class="home-box01-01">
            <div class="home-box01-text">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/titulo.png">
                <p>Procure aqui o melhor lugar, profissional ou serviço em português para matar as saudades de tua terra.</p>
            </div>
            <div class="home-box01-img">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vetor_brasilportugal.png">
            </div>
        </div>
    </div>
    <div class="home-box01-02">
        <div class="container">
            <div>
                <h2>138555</h2>
                <p><span>Portugueses</span> na Alemanha</p>
            </div>
            <div>
                <h2>144120</h2>
                <p><span>Brasileiros</span> na Alemanha</p>
            </div>
        </div>
    </div>
</section>

<section class="home-box02">
    <div class="container">
        <div class="home-box02-galeria">
            <?php $banners = $wpdb->get_results("SELECT * FROM `tb_banners` ORDER BY RAND()");
            foreach ($banners as $key => $value) {?>
                <div><a href="<?php echo $value->link; ?>" target="_blank">
                    <img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>">
                </a></div>
            <?php } ?>
        </div>
        <div class="home-box02-dots">
            <?php $banner_first = false;
            foreach ($banners as $key => $value) {
                if(!$banner_first){?>
                    <span class="selected"></span>
                    <?php $banner_first = true;
                }else{ ?>
                    <span></span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<section class="home-box03" id="comofunciona">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/comofunciona.png">
        <p>O Lapraca é uma plataforma completa de serviços e produtos para a comunidade de língua portuguesa na Alemanha. É bem simples de usar, tanto para quem está procurando um serviço ou produto, como para quem está anunciando.</p>
        <div class="home-box03-tipos">
            <span class="selected">Para quem procura</span>
            <span>Para anunciantes</span>
        </div>
        <div class="home-box03-conteudo">

            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/conexao.png">

            <div class="home-box03-para-quem-procura">

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_1.svg">
                    <h2>Há 2 modos de fazer sua busca:</h2>
                    <p>1 - através da busca rápida na barra do menu, na parte superior do site.</p>
                    <p>2 - procure por produtos e serviços por Segmentos.</p>
                </div>

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_2.svg">
                    <h2>Explore e compare o que você procura</h2>
                    <p>Explore e compare os produtos e serviços, leia as recomendações e conecte-se com as empresas.</p>
                </div>

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_3.svg">
                    <h2>Compartilhe sua experiência</h2>
                    <p>Compartilhe sua experiência, faça uma avaliação da empresa que teve contato para ajudar os próximos usuários.</p>
                </div>

            </div><!-- home-box03-para-quem-procura -->

            <div class="home-box03-para-anunciantes">

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_4.svg">
                    <h2>Você cadastra o seu negócio:</h2>
                    <p>Verifique se seu negócio já foi adicionado no nosso site. Se for, assuma sua listagem. Caso contrário, crie uma conta e registre sua empresa.</p>
                </div>

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_5.svg">
                    <h2>Escolha um dos nossos planos:</h2>
                    <p>Oferecemos 4 pacotes, cada um com estratégias de marketing especiais para atender aos seus objetivos e orçamentos.</p>
                </div>

                <div class="home-box03-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/card_6.svg">
                    <h2>Conecte-se com mais clientes:</h2>
                    <p>Alcance milhares de brasileiros e portugueses que vivem na Alemanha e procuram produtos e serviços como o seu.</p>
                </div>

            </div><!-- home-box03-para-anunciantes -->

        </div><!-- home-box03-conteudo -->

        <div class="home-box03-saiba-mais">
            <a href="<?php echo get_home_url(); ?>/planos">Saiba mais</a>
        </div>
    </div><!-- container -->
</section><!-- home-box03 -->

<section class="home-box04">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/empresasemdestaque.png">
        <div class="home-box04-wrapper">

            <div class="home-box04-arrow-left">
                <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow02.svg"></div>
            </div><!-- home-box04-arrow-left -->

            <div class="home-box04-conteudo">
                <?php $tb_clientes_anunciantes = $wpdb->get_results("SELECT * FROM `tb_clientes` WHERE `plano` != '' ORDER BY RAND()");
                foreach ($tb_clientes_anunciantes as $key => $value) {
                    $cliente_id = $value->id;
                    $cliente_fotos =  $wpdb->get_results("SELECT * FROM `tb_clientes_fotos` WHERE `cliente_id` = $cliente_id");?>

                    <a href="<?php echo get_site_url().'/anunciante?id='.$value->id; ?>" class="home-box04-conteudo-single">
                        <div class="home-box04-conteudo-single-img">
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
                        <div class="home-box04-conteudo-single-valores">
                            <div class="home-box04-conteudo-single-valores-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/oferta.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/photo.svg">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/location.svg">
                            </div>
                            <!-- <div class="home-box04-conteudo-single-valores-text">
                                <span>$49-89</span>
                            </div> -->
                        </div>
                        <div class="home-box04-conteudo-single-text">
                            <h2><?php echo $value->empresa; ?></h2>
                            <?php $tb_clientes_categorias = $wpdb->get_results("SELECT * FROM `tb_clientes_categorias` WHERE `cliente_id` = $cliente_id");
                            $categoria_id = $tb_clientes_categorias[0]->categoria_id;
                            $tb_cliente_categoria_single = $wpdb->get_results("SELECT * FROM `tb_categorias` WHERE `id` = $categoria_id");?>
                            <p style="font-weight: bold;"><?php echo $tb_cliente_categoria_single[0]->nome; ?></p>
                            <p><?php if(strlen($value->descricao) > 39){echo substr($value->descricao,0,40).'[...]';}else{echo $value->descricao;} ?></p>
                        </div>
                    </a><!-- home-box04-conteudo-single -->

                <?php } ?>
                
            </div><!-- home-box04-conteudo -->

            <div class="home-box04-arrow-right">
                <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow02.svg"></div>
            </div><!-- home-box04-arrow-right -->

        </div><!-- home-box04-wrapper -->

        <div class="home-box04-link">
            <a href="">Mais empresas</a>
        </div>

    </div><!-- container -->
</section><!-- home-box04 -->

<section class="home-box05">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/encontreporsegmentos.png">
        <p>Lá pra cá é a melhor maneira de comprar produtos e contratar serviços brasileiros que estão disponíveis na Alemanha. Você pode procurar praticamente qualquer coisa de lá pra cá, de roupas de bebê, comidas, eletrônicos e até suplementos nutricionais.</p>

        <div class="home-box05-segmentos">

            <?php $tb_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias` LIMIT 0,8"); ?>
            <?php foreach ($tb_categorias as $key => $value) {?>
            
                <a href="<?php echo get_site_url().'/busca?segmento='.$value->id; ?>" class="home-box05-segmentos-single"><div>
                    <div><img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>"></div>
                    <div><span><?php echo $value->nome; ?></span></div>
                </div></a>

            <?php } ?>

        </div><!-- home-box05-segmentos -->

        <?php $tb_categorias = $wpdb->get_results("SELECT * FROM `tb_categorias` LIMIT 8,8"); ?>
        <?php if(count($tb_categorias) > 0){ ?>

            <div class="home-box05-segmentos-02">

            <?php foreach ($tb_categorias as $key => $value) {?>
            
                <a href="<?php echo get_site_url().'/busca?segmento='.$value->id; ?>" class="home-box05-segmentos-single"><div>
                    <div><img src="<?php echo str_replace($upload_dir['basedir'],$upload_dir['baseurl'],$value->imagem) ?>"></div>
                    <div><span><?php echo $value->nome; ?></span></div>
                </div></a>

            <?php } ?>

        <?php } ?>

        </div><!-- home-box05-segmentos-02 -->

        <div class="home-box05-link">
            <a href="">Mais segmentos</a>
        </div>

    </div><!-- container -->
</section><!-- home-box05 -->

<!-- <section class="home-box06">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/busqueporcidades.png">

        <div class="home-box06-cidades">
            <?php $tb_cidades = $wpdb->get_results("SELECT DISTINCT `cidade` FROM `tb_clientes` WHERE `cidade` != '' AND `cidade` != 'Não residente na Alemanha' LIMIT 0,6");
            $cidadesCount = 0;
            foreach ($tb_cidades as $key => $value) {
                $cidade_dados = $wpdb->prepare("SELECT * FROM `tb_cidades_alemanha` WHERE `cidade` = %s",array($value->cidade));
                $cidade_dados = $wpdb->get_results($cidade_dados);
                if($cidadesCount < 7){$cidadesCount++;}else{$cidadesCount = 1;} ?>
                <div class="home-box06-cidades-single">
                    <a href="<?php echo get_site_url().'/busca?cidade='.$cidade_dados[0]->id; ?>">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cidades/<?php echo $cidadesCount; ?>.png" class="cidade-img">
                    </a>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                    <span><?php echo $value->cidade; ?></span>
                </div>
            <?php } ?>

        </div>

        <div class="home-box06-cidades-02">
            <?php $tb_cidades = $wpdb->get_results("SELECT DISTINCT `cidade` FROM `tb_clientes` WHERE `cidade` != '' AND `cidade` != 'Não residente na Alemanha' LIMIT 6,6");
            $cidadesCount = 0;
            foreach ($tb_cidades as $key => $value) {
                if($cidadesCount < 7){$cidadesCount++;}else{$cidadesCount = 1;} ?>
                <div class="home-box06-cidades-single">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cidades/<?php echo $cidadesCount; ?>.png" class="cidade-img">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flags/flag_of_germany.png" class="flag">
                    <span><?php echo $value->cidade; ?></span>
                </div>
            <?php } ?>

        </div>

        <div class="home-box06-link">
            <a href="">Mais Cidades</a>
        </div>

    </div>
</section>-->

<!-- <section class="home-box07">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas.png">
        <div class="home-box07-ofertas">
            <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas/b49052d95964aed979af15ce69f89585.png"></div>
            <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas/df532c4c32fd2c91d72d5cfe3b8cdbea.png"></div>
            <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas/43194914bf432ea7013356ebbb16121d.png"></div>
            <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas/8d922d9d8b53c7bc1d4375a516c222d3.png"></div>
            <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ofertas/20f92d47f349fb6249f8d518dc6bce14.png"></div>
        </div>
    </div>
</section> -->

<!-- <section class="home-box08">
    <div class="container">

        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/conexao.png" class="home-box08-conexao">
        
        <div class="home-box08-single">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/house_green1.png">
            <h2>144120</h2>
            <h3>Brasileiros na Alemanha</h3>
        </div>
        
        <div class="home-box08-single">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/house_red2.png">
            <h2>138555</h2>
            <h3>Portugueses na Alemanha</h3>
        </div>

    </div>
</section> -->

<section class="home-box09">
    <div class="container">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/fiquepordentro.png">
        <div class="home-box09-wrapper">

            <div class="home-box04-arrow-left">
                <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow02.svg"></div>
            </div><!-- home-box04-arrow-left -->

            <div class="home-box09-posts">
                <?php 

                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'paged' => $paged
                    );
                    $the_query = new WP_Query($args);

                    $temp_query = $wp_query;
                    $wp_query = null;
                    $wp_query = $the_query;
                ?>
                <?php if($the_query->have_posts()) : while($the_query->have_posts()) : $the_query->the_post(); ?>

                    <div class="home-box09-post-single">
                        <div class="home-box09-post-single-img">
                            <?php the_post_thumbnail(); ?>
                            <h2><?php echo get_the_date('d'); ?><br><span><?php echo strtoupper(get_the_date('M')); ?><span></h2>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/heart-sharp.png" class="heart">
                            <div class="home-box09-post-single-img-gradient"></div>
                            <?php if((round(((time() - strtotime(get_the_date('Y-m-d'))) / (60 * 60 * 24)))) <= 7){ ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/destaque_blog.png" class="destaque">
                            <?php } ?>
                            <div class="home-box09-post-single-img-views">
                                <div class="home-box09-post-single-img-views-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/views01.svg">
                                </div>
                                <?php pvc_post_views(get_the_id()); ?>
                                <div class="home-box09-post-single-img-views-img">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/chat01.svg">
                                </div>
                                <div class="post-views">
                                    <p><?php echo get_comments_number(); ?></p>
                                </div>
                            </div>
                        </div><!-- home-box09-post-single-img -->
                        <div class="home-box09-post-single-text">
                            <h4><?php  the_title(); ?></h4>
                            <div class="home-box09-post-single-text-footer">
                                <p class="left">Autor: <?php echo get_the_author(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="right">Ver mais</a>
                                <div class="clear"></div>
                            </div>
                        </div><!-- home-box09-post-single-text -->
                    </div><!-- home-box09-post-single -->

                <?php endwhile; ?>
                <?php else : get_404_template(); endif; wp_reset_postdata(); ?>
                
            </div><!-- home-box09-posts -->

            <div class="home-box04-arrow-right">
                <div><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow02.svg"></div>
            </div><!-- home-box04-arrow-right -->
            
        </div>
    </div>
</section>

<section class="home-box10">
    <div class="container">
        <div class="home-box10-text">
            <h2>Filtramos teu público alvo, e o seu lucro será refrescante.</h2>
            <h3>Turbine suas vendas.</h3>
            <p>Anunciando gratuitamente no site do Lapraca você vai atrair mais pessoas para a sua página, vai expandir seus negócios para outras regiões, e ainda melhorar a reputação da sua empresa. Aproveite essa oportunidade para entrar na maior comunidade digital em português na Alemanha!</p>
            <a href="<?php echo get_home_url(); ?>/planos">Anuncie Grátis</a>
        </div>
        <div class="home-box10-img">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vector_filtrobarro.svg">
        </div>
    </div>
</section>

<?php get_footer(); ?>