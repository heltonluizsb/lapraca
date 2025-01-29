<?php 
	// Template Name: Políticas
?>

<?php get_header(); ?>

<section style="padding-top: 250px;">
	<div class="container">
        <div class="breadcrumb">
            <p><a href="<?php echo get_home_url(); ?>">Home</a> / <span><?php echo get_the_title(); ?></span></p>
        </div>
		<h1><?php echo get_the_title(); ?></h1>
		<?php the_content(); ?>		
	</div>
</section>

<?php get_footer(); ?>