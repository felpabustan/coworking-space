<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" >
	
	<figure class="display-block mx-auto text-center">		
		<?php the_post_thumbnail( 'large', array('class' => 'max-w-full h-auto mx-auto') );?>
	</figure>	
	
	<header class="post-title">
		<h1 class="entry-title mb-5 text-uppercase text-center"><?php the_title();?></h1>		
	</header>	
	
	<!--
	<section class="categories py-2">
		<span>Categories : </span>
		<?php the_category( ', ' ); ?>
	</section>
	-->

	<div class="entry-content">
		<?php the_content();?>
	</div>

	<!--
	<footer class="tags py-2 mb-3">		
		<?php the_tags( '<h4>Tags</h4>', '',''); ?> 		
		
	</footer>
	-->

</article><!-- end of article -->