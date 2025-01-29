<?php get_header(); ?>

<section class="blog01">
    <div class="container">
        <div class="blog01-breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <a href="<?php echo get_home_url(); ?>/novidades">Blog</a> / <span><?php echo get_the_title(); ?></span></p>
        </div>
        <div class="blog01-titulo">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blog.png">
        </div>
    </div>
</section>

<section class="blog02">
	<div class="container">
		<div class="blog02-conteudo">
			<div class="page-single">
				<h2><?php the_title(); ?></h2>
				<?php the_post_thumbnail(); ?>
				<div class="page-single-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div><!-- blog02-conteudo -->
		<div class="blog02-widget">
			<?php if ( is_active_sidebar( 'custom-header-widget-single' ) ){ ?>
			    <div id="header-widget-area" class="chw-widget-area widget-area" role="complementary">
			    <?php dynamic_sidebar( 'custom-header-widget-single' ); ?>
			    </div>
			<?php } ?>
		</div><!-- blog02-widget -->
	</div><!-- container -->
</section><!-- blog02 -->

<?php get_footer(); ?>