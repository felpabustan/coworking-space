<?php get_header(); 
$category = get_queried_object(); 
?>
<main class="container-fluid">  
  <div class="row">
    <div class="col">

      <?php if ( !wp_is_mobile() ): ?>
      
        <banner class="row d-flex align-items-center blogbg">
          <div class="col-4 text-right">
            <h1 class="mb-3"><?php echo $category->name; ?></h1>
          </div>
          <div class="col-8"></div>
        </banner>

      <?php else: ?>

        <banner class="row text-center">
          <div class="col-12 d-flex align-items-end blogbg justify-content-center pb-3 mb-3">
            <h3 class=""> </h3>
          </div>
          <div class="col-12">
            <h2 class="mb-3"><?php echo $category->name; ?></h2>
          </div>
        </banner>

      <?php endif; ?>

      <blog class="row py-5 mx-auto">

          <?php $ctr = 1; ?>

          <?php if ( !wp_is_mobile() ): ?>

              <div id="main-slider" class="splide">
                  <div class="splide__track">   
                      <ul class="splide__list ">

                                               
                          <?php while ( have_posts() ) : the_post();?>
                              
                              <?php if($ctr == 1): ?>
                                <li class="splide__slide m-5" >                                   
                                  <div class="row">
                              <?php endif; ?>  

                                  <?php if($ctr < 9): ?>
                                      <div class="col-3 mx-auto">
                                        <div id="post-<?php the_ID(); ?>" class="w-4/5 bg_ivory border-box p-3 mb-5" role="contentinfo">
                                           <a href="<?php the_permalink();?>">
                                              <div class="d-flex flex-row-reverse">
                                                <?php the_post_thumbnail( 'thumbnail', array('class' =>'rounded-full mb-1') ); ?>
                                              </div>
                                              <small class="font-bold text-blue-500 mb-1">Post #<?php echo $ctr; ?></small>
                                              <p class="font-bold mb-1"><?php echo wp_trim_words(get_the_title(), 10); ?></p>
                                              <small><?php echo wp_trim_words(get_the_content(), 12); ?></small>
                                            </a>
                                        </div>
                                      </div>
                                  <?php elseif($ctr == 9): ?>
                                      </div>
                                    </li>
                                    <?php $ctr = 0; ?>
                                  <?php endif; ?>
                              
                              <?php $ctr++; ?>
                          <?php endwhile;?> 

                      </ul>                 
                   </div>
              </div>

              <script type="text/javascript">
                document.addEventListener( 'DOMContentLoaded', function() {
                var splide = new Splide( '#main-slider',{
                  type: 'loop',
                });
                splide.mount(); 
                } );
              </script>

          <?php else: ?>

              <?php while ( have_posts() ) { the_post(); ?>                 
                                                        
                  <article id="post-<?php the_ID(); ?>" class="col-12 mb-4" role="contentinfo">
                      <a href="<?php the_permalink();?>">             
                        <div class="w-4/5 border-box-shadow bg_ivory p-3 mx-auto">
                            <div class="d-flex flex-row-reverse">
                                <?php the_post_thumbnail( 'thumbnail', array('class' =>'rounded-full mb-1') ); ?>
                            </div>
                            <small class="font-bold text-blue-500 mb-1">Post #<?php echo $ctr; ?></small>
                            <p class="font-bold mb-1"><?php echo wp_trim_words(get_the_title(), 10); ?></p>
                            <small><?php echo wp_trim_words(get_the_content(), 12); ?></small>
                        </div>
                      </a> 
                  </article>

                <?php $ctr++; ?>
              <?php } ?>              

          <?php endif; ?>
        
      </blog>

    </div>
  </div>
</main>


<?php get_footer(); ?> 