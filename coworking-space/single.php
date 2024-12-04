<?php get_header(); ?>
<main class="container-fluid px-0" role="main">
	<?php while ( have_posts() ) : the_post();?>
	<?php $postFormat = get_post_format( get_the_id() ); ?>
		<?php get_template_part('content/single/article'); ?>
	<?php endwhile;?>	
</main>
<?php get_footer(); ?> 