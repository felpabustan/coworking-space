<?php get_header(); ?>
<section class="container">	
	<div class="row pt-3">
		<main class="col-8" role="main">
			<?php while ( have_posts() ) : the_post();?>				
					<?php get_template_part('content/single/article');?>				
			<?php endwhile;?>	
		</main>
		<aside class="sidebar col-4" role="complementary">
			<?php get_template_part('sidebar/article');?>
		</aside>		
	</div>	
</section>
<?php get_footer(); ?> 