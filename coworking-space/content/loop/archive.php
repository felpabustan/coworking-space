<div id="widget-item-<?php the_ID();?>" class="row py-2 justify-content-start widget-item">
	<figure class="col-3 article-image">
		<a href="<?php the_permalink();?>">
			<?php the_post_thumbnail( 'medium', array('class'=>'img-fluid') );?>
		</a>
	</figure>
	<figcaption class="col-9">
		<a href="<?php the_permalink();?>">
			<?php the_title();?>
		</a>
		<p><?php the_excerpt();?></p>
	</figcaption>
</div>