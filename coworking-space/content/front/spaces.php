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
          'terms'    => 'coworking-space',   // The slug of the tag you want to filter by
          
      ),
  ),
);
$coworking_spaces_query = new WP_Query($coworking_spaces);
?>

<section id="workspaces" class="grid lg:grid-cols-8 gap-8 grid-flow-row items-center">
    <div class="lg:col-start-2 lg:col-span-2 text-center lg:text-right flex flex-col gap-5 px-12 lg:px-0 to-animate -translate-x-5 delay-500">
        <h3 class="uppercase text-golden-grass-950 text-4xl xl:text-5xl font-display font-medium"><span class="text-golden-grass-400 font-bold">Explore</span> Our Workspaces</h3>
        <p>Dicover our coworking space where connectivity and innovation converge to increase productivity.</p>
    </div>
    <div class="lg:col-span-5 to-animate -translate-x-5 delay-500 order-last lg:order-1">
        <div id="" class="content-roll grid grid-flow-col auto-cols-[90%] md:auto-cols-[45%] gap-5 lg:gap-10 overflow-x-auto overscroll-x-contain snap-x snap-mandatory scroll-smooth pb-6 px-8 to-animate translate-y-5 delay-500" style="scrollbar-width: thin;">
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
        <div id="content-rollNav" class="flex justify-between">
            <svg  id="" class="content-roll-nav-left absolute left-0 -rotate-180 inset-y-0 m-auto" width="42" height="42" viewBox="-5 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-right</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-473.000000, -1195.000000)" fill="#000000"> <path d="M486.717,1206.22 L474.71,1195.28 C474.316,1194.89 473.678,1194.89 473.283,1195.28 C472.89,1195.67 472.89,1196.31 473.283,1196.7 L484.566,1206.98 L473.283,1217.27 C472.89,1217.66 472.89,1218.29 473.283,1218.69 C473.678,1219.08 474.316,1219.08 474.71,1218.69 L486.717,1207.75 C486.927,1207.54 487.017,1207.26 487.003,1206.98 C487.017,1206.71 486.927,1206.43 486.717,1206.22" id="chevron-right" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
            <svg  id="" class="content-roll-nav-right absolute right-0 inset-y-0 m-auto" width="42" height="42" viewBox="-5 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-right</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-473.000000, -1195.000000)" fill="#000000"> <path d="M486.717,1206.22 L474.71,1195.28 C474.316,1194.89 473.678,1194.89 473.283,1195.28 C472.89,1195.67 472.89,1196.31 473.283,1196.7 L484.566,1206.98 L473.283,1217.27 C472.89,1217.66 472.89,1218.29 473.283,1218.69 C473.678,1219.08 474.316,1219.08 474.71,1218.69 L486.717,1207.75 C486.927,1207.54 487.017,1207.26 487.003,1206.98 C487.017,1206.71 486.927,1206.43 486.717,1206.22" id="chevron-right" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
        </div>
    </div>
</section>

<?php
$premium_facility = array(
  'post_type' => 'space',       // Custom post type
  'posts_per_page' => -1,       // Number of posts to display (-1 for all)
  'tax_query' => array(
      array(
          'taxonomy' => 'post_tag',  // Assuming 'service' is a tag
          'field'    => 'slug',
          'terms'    => 'premium-facility',   // The slug of the tag you want to filter by
      ),
  ),
);

$premium_facility_query = new WP_Query($premium_facility);
?>

<section id="facilities" class="grid lg:grid-cols-8 gap-8 grid-flow-row items-center">
    <div class="lg:col-span-5 flex flex-col gap-5 to-animate -translate-x-5 delay-500e order-last lg:order-1">
        <div id="" class="content-roll grid grid-flow-col auto-cols-[90%] md:auto-cols-[45%] gap-5 lg:gap-10 overflow-x-auto overscroll-x-contain snap-x snap-mandatory scroll-smooth pb-6 px-8 to-animate translate-y-5 delay-500">
            <?php if ($premium_facility_query->have_posts()): while ($premium_facility_query->have_posts()) : $premium_facility_query->the_post(); ?>
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
        <div id="content-rollNav" class="flex justify-between">
            <svg  id="" class="content-roll-nav-left absolute left-0 -rotate-180 inset-y-0 m-auto" width="42" height="42" viewBox="-5 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-right</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-473.000000, -1195.000000)" fill="#000000"> <path d="M486.717,1206.22 L474.71,1195.28 C474.316,1194.89 473.678,1194.89 473.283,1195.28 C472.89,1195.67 472.89,1196.31 473.283,1196.7 L484.566,1206.98 L473.283,1217.27 C472.89,1217.66 472.89,1218.29 473.283,1218.69 C473.678,1219.08 474.316,1219.08 474.71,1218.69 L486.717,1207.75 C486.927,1207.54 487.017,1207.26 487.003,1206.98 C487.017,1206.71 486.927,1206.43 486.717,1206.22" id="chevron-right" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
            <svg  id="" class="content-roll-nav-right absolute right-0 inset-y-0 m-auto" width="42" height="42" viewBox="-5 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-right</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-473.000000, -1195.000000)" fill="#000000"> <path d="M486.717,1206.22 L474.71,1195.28 C474.316,1194.89 473.678,1194.89 473.283,1195.28 C472.89,1195.67 472.89,1196.31 473.283,1196.7 L484.566,1206.98 L473.283,1217.27 C472.89,1217.66 472.89,1218.29 473.283,1218.69 C473.678,1219.08 474.316,1219.08 474.71,1218.69 L486.717,1207.75 C486.927,1207.54 487.017,1207.26 487.003,1206.98 C487.017,1206.71 486.927,1206.43 486.717,1206.22" id="chevron-right" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
        </div>
    </div>
    <div class="lg:col-span-2 text-center lg:text-left flex flex-col gap-5 px-12 lg:px-0 to-animate -translate-x-5 delay-500 order-first  lg:order-1">
         <h3 class="uppercase text-golden-grass-950 text-4xl xl:text-5xl font-display font-medium"><span class="text-golden-grass-400 font-bold">Premium</span> Facilities</h3>
        <p>Take advantage of our top-notch facilities designed to support your productivity and make your work experience seamless and enjoyable.</p>
    </div>
</section>

<script>
  document.querySelectorAll('.content-roll').forEach((contentRoll) => {
    const contentRollNavLeft = contentRoll.parentElement.querySelector('.content-roll-nav-left');
    const contentRollNavRight = contentRoll.parentElement.querySelector('.content-roll-nav-right');

    if (!contentRoll || !contentRollNavLeft || !contentRollNavRight) {
      console.error('One or more elements not found. Please check the class names.');
      return;
    }

    contentRollNavLeft.style.opacity = 0; // Initial opacity for the left arrow

    contentRollNavLeft.addEventListener('click', () => {
      contentRoll.scrollLeft -= 400; // Adjust the scroll amount as needed
    });

    contentRollNavRight.addEventListener('click', () => {
      contentRoll.scrollLeft += 400; // Adjust the scroll amount as needed
    });

    contentRoll.addEventListener('scroll', () => {
      // Check if scroll is at the start
      if (contentRoll.scrollLeft === 0) {
        contentRollNavLeft.style.opacity = 0; // Adjust the opacity as needed
      } else {
        contentRollNavLeft.style.opacity = 1;
      }

      // Check if scroll is at the end
      if (contentRoll.scrollLeft + contentRoll.clientWidth >= contentRoll.scrollWidth) {
        contentRollNavRight.style.opacity = 0; // Adjust the opacity as needed
      } else {
        contentRollNavRight.style.opacity = 1;
      }
    });
  });
</script>