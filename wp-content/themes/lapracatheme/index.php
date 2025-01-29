<?php get_header(); ?>

<section class="blog01">
    <div class="container">
        <div class="blog01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span>Blog</span></p>
        </div>
        <div class="blog01-titulo">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blog.png">
        </div>
    </div>
</section>

<section class="blog02">
	<div class="container">
		<div class="blog02-conteudo">
			<div class="blog02-conteudo-wrapper">

				<?php 

					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 10,
						'paged' => $paged
					);

					if(is_tag()){
					    $tag = get_queried_object();

						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 10,
							'paged' => $paged,
							'tag' => $tag->slug
						);
					}else if(is_category()){
					    $tag = get_queried_object();

						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 10,
							'paged' => $paged,
							'category_name' => $tag->slug
						);
					}else if(is_archive()){

						global $wp;
						$url_explode =  home_url( $wp->request );
						$url_explode = explode('/',$url_explode);

						$args = array(
							'post_type' => 'post',
							'posts_per_page' => 10,
							'paged' => $paged,
							'date_query' => array(array(
								'year' => $url_explode[count($url_explode) - 2],
								'month' => $url_explode[count($url_explode) - 1]
							))
						);
					}

					$the_query = new WP_Query($args);

					$temp_query = $wp_query;
					$wp_query = null;
					$wp_query = $the_query;
				?>
				<?php if($the_query->have_posts()) : $postCount = 0; while($the_query->have_posts()) : $postCount++; $the_query->the_post(); ?>

                    <div class="home-box09-post-single <?php if($postCount == 1){echo 'home-box09-post-single-first';} ?>">
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
                            <?php  if($postCount == 1){ ?>
                            	<div class="home-box09-post-single-img-text">
                            		<h4><?php  the_title(); ?></h4>
                            	</div>
                            <?php } ?>
                        </div><!-- home-box09-post-single-img -->
                        <div class="home-box09-post-single-text">
                            <h4><?php  the_title(); ?></h4>
                            <p><?php echo get_the_excerpt(); ?></p>
                            <div class="home-box09-post-single-text-footer">
                                <a href="<?php the_permalink(); ?>">Ler mais</a>
                            </div>
                        </div><!-- home-box09-post-single-text -->
                    </div><!-- home-box09-post-single -->

				<?php endwhile; ?>
				<?php else : get_404_template(); endif; wp_reset_postdata(); ?>
				
			</div><!-- blog02-conteudo-wrapper -->

			<div class="blog-paginacao">
				<div class="container">
				    <?php 
				        echo paginate_links( array(
				            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				            'total'        => $the_query->max_num_pages,
				            'current'      => max( 1, get_query_var( 'paged' ) ),
				            'format'       => '?paged=%#%',
				            'show_all'     => false,
				            'type'         => 'plain',
				            'end_size'     => 2,
				            'mid_size'     => 1,
				            'prev_next'    => true,
				            'prev_text'    => sprintf( '<i></i> %1$s', __( '← Página anterior', 'text-domain' ) ),
				            'next_text'    => sprintf( '%1$s <i></i>', __( 'Próxima página →', 'text-domain' ) ),
				            'add_args'     => false,
				            'add_fragment' => '',
				        ) );
				    ?>
					<?php 
						$wp_query = NULL;
						$wp_query = $temp_query;
					 ?>
				</div>
			</div><!-- blog-paginacao -->

		</div><!-- blog02-conteudo -->
		<div class="blog02-widget">
			<?php if ( is_home() && is_active_sidebar( 'custom-header-widget' ) ){ ?>
			    <div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">
			    <?php dynamic_sidebar( 'custom-header-widget' ); ?>
			    </div>
			<?php }else if ( !is_home() && is_active_sidebar( 'custom-header-widget-single' ) ){ ?>
			    <div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">
			    <?php dynamic_sidebar( 'custom-header-widget-single' ); ?>
			    </div>
			<?php } ?>
		</div><!-- blog02-widget -->
	</div><!-- container -->
</section><!-- blog02 -->

<?php get_footer(); ?>