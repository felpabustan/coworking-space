<?php
/**
 * Mapletreemedia Theme
 *
 * @package WordPress
 * @author Maple Tree Media <info@mapletreemedia.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */


// include the libraries (post type and taxonomies)
require_once('include/walker.php');
// require_once('include/walker-widget.php');
require_once('include/walker-menu-mobile.php');
require_once ('include/space-meta-boxes.php');
require_once('include/booking.php');
require_once('include/inquiry.php');
require_once('include/user.php');
require_once('include/custom-post-tax.php');
require_once('include/classes.php');



function giyo_setup() {
    load_theme_textdomain( 'mapletheme' );
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    // image sizes
   
    // menu
    register_nav_menus( array(       
        'main'  => __( 'Main', 'mapletheme' ),              
    ) );

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );    

    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );   
    // Add support for responsive embedded content.
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );

    //sidebars for footer and other sections
    register_sidebars(1, array('name'=>'Sidebar'));
    register_sidebars(3, 
        array(
            'name'          =>'Footer %d',            
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => "</div>\n",
        )
    );
}


add_action( 'after_setup_theme', 'giyo_setup' );
remove_action('wp_head', 'wp_generator'); 

function giyo_initialize(){
	//tailwind 3
   // wp_enqueue_style( 'giyo-tailwindcss', get_template_directory_uri() . '/css/tailwind.prod.css', array('giyo-bootstrap'), filemtime(get_template_directory() .'/css/tailwind.prod.css'), 'all');
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'jquery-ui-styles' );
    wp_enqueue_script('jquery-ui-datepicker');

    wp_enqueue_style('jquery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');


    //bootstrap 5
    wp_enqueue_style( 'giyo-bootstrap'    , get_template_directory_uri().'/css/bootstrap.min.css' );
    wp_enqueue_script( 'giyo-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js',array('jquery'), true );

    //splide 4
    wp_enqueue_script( 'giyo-splide-slider', get_template_directory_uri() . '/js/splide.min.js',array('jquery'), true); //splide4
    wp_enqueue_style( 'giyo-splide-slider-css', get_template_directory_uri() . '/css/splide.min.css');

    //fontawesome 5.13
    wp_enqueue_style( 'giyo-font-awesome', '//use.fontawesome.com/releases/v5.13.0/css/all.css');

    //giyo main
    wp_enqueue_style( 'giyo-main-css', get_template_directory_uri() . '/css/main.css' );
    wp_enqueue_script( 'giyo-main-js', get_template_directory_uri() . '/js/main.js' );
    
    wp_enqueue_style( 'giyo-font-awesome', '//use.fontawesome.com/releases/v5.7.2/css/all.css');   
    
    wp_localize_script('giyo-main-js', 'profileUpdateParams', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'profileNonce' => wp_create_nonce('profile_update_nonce'),
        'accountNonce' => wp_create_nonce('account_update_nonce'),
        'resetPasswordNonce' => wp_create_nonce('reset_password_nonce'),
        'bookingDetailsNonce' => wp_create_nonce('booking_details_nonce'),
        'logoutUrl' => wp_logout_url(home_url('/my-account/')),
    ));

    if (is_page('my-account')) { // Replace with your registration page slug
        wp_enqueue_script('password-strength-meter');
        wp_enqueue_script('wp-util');
    }
}

add_action( 'wp_enqueue_scripts', 'giyo_initialize', PHP_INT_MAX );

function enqueue_booking_form_scripts() {
    wp_enqueue_script('booking-form', get_template_directory_uri() . '/js/booking-form.js', ['jquery'], null, true);
    
    // Localize script to pass PHP data to JS
    wp_localize_script('booking-form', 'bookingFormParams', [
        'isHotdesk' => has_tag('hotdesk'),
        //'bookedDates' => $space->get_booked_dates() // Example of passing dynamic data to JS
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_booking_form_scripts');


function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');

/* reusable wp_query call */
function display_post($args,$template,$columns=1){
    $index = 0;
    $query = new WP_Query( $args );     
    if ($query->have_posts()) {     
        while ($query->have_posts()) {       
            $query->the_post();                     
            $col = 12 / $columns;
            $colClass="col-".$col;
            include( locate_template($template) );            
            $index++;
        }
        wp_reset_postdata();
    }else{
        //bi_no_articles();
    }
}

/*pagination*/
function giyo_pagination( \WP_Query $wp_query = null, $echo = true ) {
    if ( null === $wp_query ) {
        global $wp_query;
    }
    $pages = paginate_links( [
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => __( '« Prev' ),
            'next_text'    => __( 'Next »' ),
            'add_args'     => false,
            'add_fragment' => ''
        ]
    );
    if ( is_array( $pages ) ) {
        //$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
        if(wp_is_mobile()){
            $pagination = '<nav aria-label="navigation" class="pagination-container"><ul class="pagination pagination-sm justify-content-center">';
        }else{
            $pagination = '<nav aria-label="navigation" class="pagination-container"><ul class="pagination justify-content-center">';
        }
        foreach ( $pages as $page ) {
           $pagination .= '<li class="page-item '.(strpos($page, 'current') !== false ? 'active' : '').'"> ' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
        }
        $pagination .= '</ul></nav>';
        if ( $echo ) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }
    return null;
}


//redirect pages to templates
function template_display_redirect( $template ) {
    if ( $template === locate_template('page.php') || $template === locate_template('index.php') ) {
        // global $post;
        // $page_slug = $post->post_name;

        $page_templates = array(
            'my-account' => 'page-templates/my-account.php',
            'password-reset' => 'page-templates/password-reset.php',
            'register' => 'page-templates/register.php',
            'new-password' => 'page-templates/new-password.php',
            'booking' => 'page-templates/template-booking-confirmation.php',
        );

        foreach ( $page_templates as $slug => $template_path ) {
            if ( is_page($slug) ) {
                $new_template = locate_template( array( $template_path ) );
                if ( '' != $new_template ) {
                    return $new_template;
                }
            }
        }
    }

    return $template;
}
add_filter( 'template_include', 'template_display_redirect', 99 );

// add filtering of space post via url param within space archive
function filter_space_archive_by_tag( $query ) {
    // Ensure this only runs on the main query and on the 'space' archive
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'space' ) ) {

        // Check if the 'tag' parameter exists in the URL
        if ( isset( $_GET['tag'] ) ) {
            $query->set( 'tag', sanitize_text_field( $_GET['tag'] ) );
        }
    }
}
add_action( 'pre_get_posts', 'filter_space_archive_by_tag' );

function custom_login_redirect() {
    global $pagenow;

    // Check if the current page is wp-login.php
    if ($pagenow == 'wp-login.php' && !is_user_logged_in()) {
        // Customize the URL to where you want to redirect
        wp_redirect( home_url('/my-account/') );
        exit;
    }
}
add_action('init', 'custom_login_redirect');

// Remove <p> and <br/> from Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

// Modify Custom Post Type Archive Order:
function modify_custom_post_archive_order( $query ) {
    // Ensure we're in the main query and not in admin
    if ( ! is_admin() && $query->is_main_query() ) {
        
        // Check if we are on an archive page for the custom post type
        if ( is_post_type_archive( 'space' ) || ( is_archive() && strpos( $_SERVER['REQUEST_URI'], '/space/' ) !== false ) ) {
            
            // Set the order and orderby parameters
            $query->set( 'orderby', 'date' ); // You can change this to other fields like 'title', 'meta_value', etc.
            $query->set( 'order', 'ASC' );  // Change this to 'DESC' for ascending order
            
            // Optionally, you can modify other query parameters like posts_per_page, meta_query, etc.
            // $query->set( 'posts_per_page', 10 );
        }
    }
}
add_action( 'pre_get_posts', 'modify_custom_post_archive_order' );

function get_all_booking_data($space_id) {
    $args = [
      'post_type' => 'booking',
      'posts_per_page' => -1, 
      'meta_query' => [
          [
              'key' => '_booking_space_id',
              'value' => $space_id,
              'compare' => '=', 
          ]
      ]
    ];

    $query = new WP_Query($args);
    $bookings_data = []; 

    if ($query->have_posts()) {
      while ($query->have_posts()) {
          $query->the_post();
          
          $booking_id = get_the_ID();

          $all_booking_meta = get_post_meta($booking_id);

          $booking_info = [
              'booking_id' => $booking_id,
              'meta' => []
          ];

          foreach ($all_booking_meta as $meta_key => $meta_value) {
              $formatted_value = (is_array($meta_value)) ? implode(', ', $meta_value) : $meta_value;
              $booking_info['meta'][$meta_key] = $formatted_value;
          }
          $bookings_data[] = $booking_info;
      }
    } else {
      $bookings_data = ['message' => 'No bookings found for this space ID.'];
    }

    wp_reset_postdata();

    return $bookings_data;
}
