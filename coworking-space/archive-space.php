<?php get_header(); $category = get_queried_object(); ?>
<main class="container py-12 flex flex-col gap-10">
  <h1 class="text-3xl text-center uppercase font-bold font-display">Services</h1>
  <section class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php while ( have_posts() ) : the_post();?>
      <article class="relative">
          <div class="group flex flex-col justify-end text-white absolute px-8 pb-8 gap-5 items-start h-full bg-gradient-to-t from-golden-grass-700 transition-all rounded-3xl">
              <h4 class="text-golden-grass-100 font-semibold uppercase font-display text-3xl -translate-y-2.5 transition-all delay-75"><?php the_title();?></h4>
              <p class="text-golden-grass-50"><?php echo the_excerpt();?></p>
              <a href="<?php the_permalink();?>" class="hover:scale-105 hover:bg-golden-grass-500 bg-golden-grass-400 rounded-full py-2 px-4 font-semibold font-display shadow-md -translate-y-2.5 transition-all delay-75">Learn More</a>
              <?php
                $seats = get_post_meta(get_the_ID(), '_space_seats', true);
                if($seats) {
                  echo '<div class="absolute top-5 right-5 text-xs text-golden-grass-50 bg-golden-grass-800 px-2 py-1 rounded-xl uppercase font-display">' . $seats . '-seater</div>';
                }
              ?>
          </div>
          <?php the_post_thumbnail('full', array('class'=>'w-full mx-auto rounded-3xl shadow-md object-center object-cover h-[32rem]'));?>
          <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/front-view-off-office-desk 2.png" class="w-full h-auto mx-auto rounded-3xl shadow-md" /> -->
      </article>
    <?php endwhile;?>
  </section>

</main>

<?php get_footer(); ?> 