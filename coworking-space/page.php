<?php get_header(); ?>
<main class="w-full py-6 md:py-12" role="main">
	<?php while ( have_posts() ) : the_post();?>
		<article id="page-<?php the_ID();?>" class="<?php post_class()?>;">
			<header class="hidden">
				<h1 class="w-auto entry-title"><?php the_title();?></h1>
			</header>
			<div class="w-full entry-content prose max-w-none prose-a:text-chocolate">
				<?php the_content();?>
			</div>
		</article>					
	<?php endwhile;?>	
</main>
<?php get_footer(); ?>