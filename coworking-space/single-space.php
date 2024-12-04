<?php
get_header(); 
$single_gallery = theme_get_gallery(get_the_ID());
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); //Post's featured image

$inclusions = theme_get_image_text_pairs(get_the_ID());
$with_window = get_post_meta(get_the_ID(), '_space_with_window', true);
$non_bookable = get_post_meta(get_the_ID(), '_space_non_bookable', true);
?>
<div id="single_space<?php echo the_ID();?>" class="flex flex-col gap-20 pt-20">
    <div class="container grid md:grid-cols-5 gap-5">
        <div class="md:col-span-3 flex flex-col md:flex-row gap-3 items-center to-animate -translate-x-5 delay-100">
            <div id="single_space_carousel-thumb" class="order-2 md:order-1 md:w-2/12 splide">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php
                            if(!empty( $featured_img_url )) {
                                echo '<a type="button" class="splide__slide w-full block rounded" aria-current="true" aria-label="Slide 0">';
                                    echo '<img src="'.esc_url($featured_img_url).'" style="" class="object-cover object-center h-full w-full rounded shadow-md">';
                                echo '</a>';

                            }
                            
                            if( !empty( $single_gallery ) ) {
                                $count = 1;
                                foreach ($single_gallery as $item) {
                                    if( !empty( $item['url'] ) ){
                                        echo '<a type="button" class="splide__slide w-full block rounded" aria-label="Slide '.$count.'">';
                                            echo '<img src="'.esc_url($item['url']).'" style="" class="object-cover object-center h-full w-full rounded shadow-md">';
                                        echo '</a>';
                                    }
                                    $count ++;
                                }
                            }
                        ?>
                    </div>
                </div>
		    </div>

            <div id="single_space_carousel" class="order-1 md:order-2 md:w-10/12 splide">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php
                            if(!empty( $featured_img_url )) {
                                echo '<div class="splide__slide" aria-current="true" aria-label="Slide 0">';
                                echo '<img src="'.esc_url($featured_img_url).'"class="w-full md:h-[500px] object-contain object-cover rounded-3xl shadow-md bg-white mb-4" alt="">';
                                echo '</div>';
                            }

                            if( !empty( $single_gallery ) ) {
                                $count = 1;
                                foreach ($single_gallery as $item) {
                                    if( !empty( $item['url'] ) ){
                                        echo '<div class="splide__slide" aria-label="Slide '.$count.'">';
                                        echo '<img src="'.esc_url($item['url']).'"class="w-full md:h-[500px] object-contain object-cover rounded-3xl shadow-md bg-white mb-4" alt="">';
                                        echo '</div>';
                                    }
                                    $count ++;
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                document.addEventListener( 'DOMContentLoaded', function () {
                    var main = new Splide( '#single_space_carousel', {
                        type      : 'slide',
                        rewind    : true,
                        pagination: false,
                        arrows    : true,
                    } );
                    var thumbnails = new Splide( '#single_space_carousel-thumb', {
                        height		: 300,
                        width		: 150,
                        gap			: 5,
                        rewind		: true,
                        pagination	: false,
                        arrows		: false,
                        perPage		: 4,
                        isNavigation: true,
                        focus      	: 'center',
                        direction	: 'ttb',
                        breakpoints	: {
                            600: {
                            width: 500,
                            height: 50,
                            direction: 'ltr',
                            },
                        },

                        // type		: 'loop',
                        // focus       : 'center',
                        // direction	: 'ttb',
                        // breakpoints	: {
                        // 	640: {
                        // 		direction: 'ltr',
                        // 	},
                        // },
                    } );
                    main.sync( thumbnails );
                    main.mount();
                    thumbnails.mount();
                } );
            </script>
        </div>
        <div class="md:col-span-2 flex flex-col gap-8 items-start to-animate translate-x-5 delay-300">
            <header class="flex flex-col gap-3">
                <h1 class="uppercase font-bold text-4xl md:text-5xl font-display text-golden-grass-900"><?php the_title();?></h1>
                <?php echo ($with_window) ? '<h6 class="font-display text-sm text-gray-950">with Window/s</h6>':'';?>
                <?php the_content();?>
            </header>
            <aside>
                <ul class="flex flex-col gap-2">
                    <?php
                        $seats = get_post_meta(get_the_ID(), '_space_seats', true);
                        if($seats) {
                            echo '<li class="flex gap-1 items-center">';
                            echo '<img src="https://intellideskcoworking.com/wp-content/uploads/2024/08/conference.webp" alt="number of seats" class="" width="30" height="30" />';
                            echo '<span class="font-display text-gray-700 text-sm">' . $seats . ' seater</span>';
                            echo '</li>';
                        }
                        if (!empty($inclusions)) {
                            foreach($inclusions as $inclusion) {
                                // Get the image URL and alt text
                                $image_url = wp_get_attachment_image_url($inclusion['image'], 'full');
                                $image_alt = get_post_meta($inclusion['image'], '_wp_attachment_image_alt', true);

                                // Get the associated text
                                $text = esc_html($inclusion['text']);

                                // Output the image and text
                                echo '<li class="flex gap-1 items-center">';
                                if ($image_url) {
                                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="" width="30" height="30" />';
                                }
                                echo '<span class="font-display text-gray-700 text-sm">' . $text . '</span>';
                                echo '</li>';
                            }
                        }
                    ?>
                </ul>
            </aside>
            <div class="py-10 flex items-start justify-start w-full">
                <?php if($non_bookable):?>
                    <button type="button" class="hover:scale-105 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white text-3xl rounded-full py-4 px-10 font-semibold font-display shadow-md group-hover:translate-y-0 -translate-y-2.5 delay-75" data-bs-toggle="modal" data-bs-target="#inquireModal">
                        Inquire Now
                    </button>
                <?php else:?>
                    <?php if(!is_user_logged_in()):?>
                            <a href="<?php echo esc_url( add_query_arg( 'redirect_to', get_permalink(), home_url( '/my-account/' ) ) ); ?>" class="hover:scale-105 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white text-3xl rounded-full py-4 px-10 font-semibold font-display shadow-md group-hover:translate-y-0 -translate-y-2.5 delay-75">
                                Login/Register
                            </a>
                        <?php else:?>
                            <button type="button" class="hover:scale-105 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white text-3xl rounded-full py-4 px-10 font-semibold font-display shadow-md group-hover:translate-y-0 -translate-y-2.5 delay-75" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                Book Now
                            </button>
                    <?php endif;?>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php
        get_template_part( 'content/front/spaces' );
        get_template_part( 'content/front/others' );
    ?>
</div>
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center uppercase font-display text-golden-grass-950 font-bold text-5xl" id="bookingModalLabel">Booking Form</h5>
                <button type="button" class="btn-close text-sm font-display self-start uppercase" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <div class="modal-body">
                <p class="mb-4">You are submitting a booking request for <?php the_title();?>. To complete your <?php echo ($non_bookable) ? 'inquiry':'request';?>, please fill out the form below:</p>
                <?php echo do_shortcode('[booking_form]');?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inquireModal" tabindex="-1" aria-labelledby="inquireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center uppercase font-display text-golden-grass-950 font-bold text-5xl" id="inquireModalLabel">Inquiry Form</h5>
                <button type="button" class="btn-close text-sm font-display self-start uppercase" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <div class="modal-body">
                <p class="mb-4">You are submitting an inquiry for <?php the_title();?>. To complete your <?php echo ($non_bookable) ? 'inquiry':'request';?>, please fill out the form below:</p>
                <?php //echo do_shortcode('[contact-form-7 id="2da7176" title="Contact form - General"]');?>
                <?php echo do_shortcode('[inquiry_form]');?>
            </div>
        </div>
    </div>
</div>


<?php get_footer();?>