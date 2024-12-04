<?php
// Define the custom query
$coworking_spaces = array(
  'post_type' => 'space',       // Custom post type
  'posts_per_page' => -1,       // Number of posts to display (-1 for all)
  'order' => 'ASC',
  'orderby' => 'date',
  'tax_query' => array(
      array(
          'taxonomy' => 'post_tag',  // Assuming 'service' is a tag
          'field'    => 'slug',
          'terms'    => ['hotdesk','virtual-office'],   // The slug of the tag you want to filter by
      ),
  ),
);

$coworking_spaces_query = new WP_Query($coworking_spaces);


?>
<section id="highlights" class="container space-y-12">
    <h3 class="uppercase lg:col-span-8 text-golden-grass-950 text-5xl font-display font-medium text-center"><span class="text-golden-grass-400 font-bold">Other</span> Services</h3>
    <div class="content-roll grid grid-flow-col auto-cols-[90%] md:auto-cols-[45%] gap-5 lg:gap-10 overflow-x-auto overscroll-x-contain snap-x snap-mandatory scroll-smooth pb-6 px-8 to-animate translate-y-5 delay-500">
    <?php if ($coworking_spaces_query->have_posts()): while ($coworking_spaces_query->have_posts()) : $coworking_spaces_query->the_post(); ?>
        <div class="relative">
            <div class="group flex flex-col justify-end text-white absolute px-8 pb-8 gap-5 items-start h-full bg-gradient-to-t from-golden-grass-700 transition-all md:opacity-0 hover:opacity-100 rounded-3xl">
                <h4 class="text-golden-grass-100 font-semibold uppercase font-display text-4xl group-hover:translate-y-0 -translate-y-2.5 transition-all delay-75 md:opacity-0 group-hover:opacity-100"><?php the_title();?></h4>
                <p class="text-golden-grass-50 group-hover:translate-y-0 -translate-y-2.5 transition-all delay-100  md:opacity-0 group-hover:opacity-100"><?php echo the_excerpt();?></p>
                <a href="<?php the_permalink();?>" class="hover:scale-105 hover:bg-golden-grass-500 bg-golden-grass-400 rounded-full py-2 px-4 font-semibold font-display shadow-md group-hover:translate-y-0 -translate-y-2.5 transition-all delay-75">Learn More</a>
                <?php
                    $seats = get_post_meta(get_the_ID(), '_space_seats', true);
                    if($seats) {
                    echo '<div class="absolute top-5 right-5 text-xs text-golden-grass-50 bg-golden-grass-800 px-2 py-1 rounded-xl uppercase font-display">' . $seats . '-seater</div>';
                    }
                ?>
            </div>
            <?php the_post_thumbnail('full', array('class'=>'w-full mx-auto rounded-3xl shadow-md object-center object-cover h-96 xl:h-[32rem]'));?>
            <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/front-view-off-office-desk 2.png" class="w-full h-auto mx-auto rounded-3xl shadow-md" /> -->
        </div>
    <?php endwhile; endif; wp_reset_postdata();?>
    </div>
</section>

