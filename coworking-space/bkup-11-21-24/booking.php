<?php

/**
 * Booking Post Type Setup
 * 
 */
// Create custom post: Booking
function booking_post_type() {
    $labels = array(
        'name'               => 'Bookings',
        'singular_name'      => 'Booking',
        'menu_name'          => 'Bookings',
        'name_admin_bar'     => 'Booking',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Booking',
        'new_item'           => 'New Booking',
        'edit_item'          => 'Edit Booking',
        'view_item'          => 'View Booking',
        'all_items'          => 'All Bookings',
        'search_items'       => 'Search Bookings',
        'not_found'          => 'No bookings found.',
        'not_found_in_trash' => 'No bookings found in Trash.',
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => false,  // No frontend access
        'show_ui'            => true,   // Show in admin
        'show_in_menu'       => true,   // Show in admin menu
        'query_var'          => false,  // Disable frontend queries
        'rewrite'            => false,  // No rewrite rules
        'capability_type'    => 'post',
        'has_archive'        => false,  // No archive pages
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-calendar-alt',  // Icon similar to WooCommerce orders
        'supports'           => array('revisions','author'),
        // 'show_in_rest'       => true,
        'exclude_from_search'   => false,
		'publicly_queryable'    => true,
    );
    
    register_post_type('booking', $args);
}
add_action('init', 'booking_post_type');

// Add custom meta boxes
function add_booking_meta_boxes() {
    add_meta_box(
        'create_manual_booking',
        'Create Manual Booking',
        'display_create_new_booking',
        'booking',
        'normal',
        'high'
    );

    add_meta_box(
        'booking_data',
        'Booking Details',
        'display_booking_data_meta_box',
        'booking',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_booking_meta_boxes');

// Display booking meta boxes: user & space
function display_create_new_booking($post) {
    echo '<table class="form-table">';
    
    if ($post->post_status == 'auto-draft') { // New booking (auto-draft status)
        $user_id = get_post_meta($post->ID, '_booking_user_id', true);
        $space_id = get_post_meta($post->ID, '_booking_space_id', true);
        ?>
        <tr>
            <td>
                <label for="booking_user_id">User:</label>
                <select id="booking_user_id" name="booking_user_id">
                    <option value="">Select a user</option>
                        <?php
                        $users = get_users();
                        foreach ($users as $user) {
                            echo '<option value="' . esc_attr($user->ID) . '"' . selected($user_id, $user->ID, false) . '>' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</option>';
                        }
                        ?>
                </select>
            </td>
            <td>
                <label for="booking_space_id">Space:</label>
                <select id="booking_space_id" name="booking_space_id">
                    <option value="">Select a space</option>
                        <?php
                        $spaces = get_posts(array('post_type' => 'space', 'numberposts' => -1));
                        foreach ($spaces as $space) {
                            echo '<option value="' . esc_attr($space->ID) . '"' . selected($space_id, $space->ID, false) . '>' . esc_html($space->post_title) . '</option>';
                        }
                        ?>
                </select>
            </td>
        </tr>
        
        <?php
    } else {
        echo '<tr>';
        echo 'Not applicable; Click the add new button above to generate manual booking.';
        echo '</tr>';
    }
    echo '</table>';
}

// Display booking data meta boxes
function display_booking_data_meta_box($post) {

    $booking = new Booking($post);
    $user = new User(get_user_by('id',$booking->user_id));

    ?>
    <h3><?php the_title();?></h3>
    <h4>Booking Details</h4>
    <p><?php echo 'Company Name: ' . $user->company;?></p>
    <p><?php echo 'Authorized Person: ' . $user->first_name.' '.$user->last_name;?></p>
    <?php if($booking->space->price_type == 'monthly'):?>
        <p><?php echo 'Start Date: ' . ($booking->start_date ? $booking->start_date : 'N/A');?></p>
        <p><?php echo 'End Date: ' . ($booking->end_date ? $booking->end_date : 'N/A');?></p>
    <?php else:?>
        <p><?php echo 'Date/s: <br/>' .$booking->display_selected_dates(); ?></p>
    <?php endif;?>
    <p><?php echo 'Room Type: ' . $booking->space->post_title;?></p>
    <p><?php echo 'Rate/s: ' . $booking->get_base_rate();?></p>
    <p><?php echo $booking->space->seats ? 'Occupancy: '.$booking->space->seats.'-seater' :''?></p>
    <p>
        <?php echo 'Inclusions:';?>
        <ul>
            <?php foreach($booking->space->inclusions as $item):?>
                <li><?php echo $item['txt'];?></li>
            <?php endforeach;?>
        </ul>
    </p>
    <h4>Payment Breakdown</h4>
    <table>
        <?php if($booking->space->price_type == 'monthly'):?>
            <tr>
                <td>
                    <p>1 month advance +12% VAT</p>
                </td>
                <td>
                    <p><?php echo $booking->calculate_booking_rate(); ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>2 months security deposit</p>
                </td>
                <td>
                    <p><?php echo $booking->get_deposit_for_monthly(); ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Total</p>
                </td>
                <td>
                    <p><?php echo $booking->get_total_for_monthly();?></p>
                </td>
            </tr>
        <?php else:?>
        <tr>
            <td>
                <p><?php echo $booking->space->post_title;?></p>
            </td>
            <td>
                <p><?php echo $booking->get_base_rate(); ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p><?php echo 'Total (for '.$booking->get_booking_length().' day/s): ' ;?></p>
            </td>
            <td>
                <p><?php echo $booking->calculate_booking_rate();?></p>
            </td>
        </tr>
        <?php endif;?>
    </table>
 

    <label for="booking_status">Status:</label>
    <select name="booking_status" id="booking_status">
        <option value="pending" <?php selected($booking->booking_status, 'open'); ?>>Open</option>
        <option value="pending" <?php selected($booking->booking_status, 'pending'); ?>>Pending</option>
        <option value="ongoing" <?php selected($booking->booking_status, 'ongoing'); ?>>Ongoing</option>
        <option value="cancelled" <?php selected($booking->booking_status, 'cancelled'); ?>>Cancelled</option>
        <option value="completed" <?php selected($booking->booking_status, 'completed'); ?>>Completed</option>
    </select>

    <?php
    echo '<pre>';
    var_dump($booking);
    echo '</pre>';
}

// Save booking meta and calculate the rates
function save_booking_meta_boxes($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Save start and end date
    if (isset($_POST['booking_start_date'])) {
        update_post_meta($post_id, '_booking_start_date', sanitize_text_field($_POST['booking_start_date']));
    }
    // if (isset($_POST['booking_end_date'])) {
    //     $end_date = sanitize_text_field($_POST['booking_end_date']);
    //     if (empty($end_date)) {
    //         // Automatically set end date to a month after start date if not provided (for monthly bookings)
    //         $start_date = sanitize_text_field($_POST['booking_start_date']);
    //         $end_date = date('Y-m-d', strtotime($start_date . ' +1 month'));
    //     }
    //     update_post_meta($post_id, '_booking_end_date', $end_date);
    // }

    if (isset($_POST['booking_status'])) {
        update_post_meta($post_id, '_booking_status', sanitize_text_field($_POST['booking_status']));
    }

    // // Get space rate type and calculate the total
    // $space_id = get_post_meta($post_id, '_booking_space_id', true);
    // $rate_type = get_post_meta($space_id, '_space_rate_type', true);
    // $price_weekday = get_post_meta($space_id, '_space_price_weekday', true);
    // $price_weekend = get_post_meta($space_id, '_space_price_weekend', true);
    // $price_monthly = get_post_meta($space_id, '_space_price_monthly', true);
    // $seats = get_post_meta($space_id, '_space_seats', true);
    // $vat_included = get_post_meta($space_id, '_space_vat_included', true);

    // if ($rate_type === 'daily') {
    //     // Logic to accumulate the rate based on number of days and weekend/weekday split
    //     // Future implementation for half-day options can be added here.
    // } elseif ($rate_type === 'monthly') {
    //     // Calculate total for monthly rate
    //     $booking_rate = (int) $price_monthly * (int) $seats;
    //     $vat_amount = ($vat_included === 'no') ? $booking_rate * 0.12 : 0;
    //     $total_rate = $booking_rate + $vat_amount;

    //     update_post_meta($post_id, '_booking_rate', $total_rate);
    // }
}
add_action('save_post', 'save_booking_meta_boxes');

// Add custom columns to the booking post list in wp
function add_booking_custom_columns($columns) {
    $columns['booking_status'] = 'Booking Status';
    $columns['date_submitted'] = 'Date Submitted';
    $columns['space_name'] = 'Space Name';
    unset($columns['date']); //remove default date column
    return $columns;
}
add_filter('manage_booking_posts_columns', 'add_booking_custom_columns');

// Populate custom columns with data in wp
function populate_booking_custom_columns($column, $post_id) {
    if ($column == 'booking_status') {
        $status = get_post_meta($post_id, '_booking_status', true);
        echo esc_html(ucfirst($status)); // Display the booking status
    }
    if ($column == 'date_submitted') {
        echo esc_html(get_the_date('Y-m-d H:i:s', $post_id)); // Display the date submitted
    }
    if ($column == 'space_name') {
        $space_id = get_post_meta($post_id, '_booking_space_id', true);
        $space_name = get_the_title($space_id);
        echo esc_html($space_name); // Display the space name
    }
}
add_action('manage_booking_posts_custom_column', 'populate_booking_custom_columns', 10, 2);

// Make custom columns sortable
function make_booking_custom_columns_sortable($columns) {
    $columns['booking_status'] = 'booking_status';
    $columns['date_submitted'] = 'date_submitted';
    $columns['space_name'] = 'space_name';    
    return $columns;
}
add_filter('manage_edit-booking_sortable_columns', 'make_booking_custom_columns_sortable');

/**
 * Booking Form and Handling
 * 
 */
// Booking form HTML + auto-populate data


function display_booking_form() {
    $current_user = wp_get_current_user();
    $user = new User($current_user);
    $space = new Space(get_post()); // Assuming $post is the current space post
    $booked_dates = $space->get_booked_dates(); // Get array of booked dates
    $non_bookable = $space->non_bookable; // Check if the space is non-bookable (for inquiries)
    $price_type = $space->price_type; // Monthly or Daily pricing
    $is_hotdesk = has_tag('hotdesk'); // Check if it's a hotdesk space
    
    if (empty($booked_dates)) {
        $booked_dates = []; // Ensure it's an empty array if no dates are booked
    }
    ?>
    <style>
        .ui-datepicker .highlight-selected-date a {
            background-color: #ffd700 !important; /* Golden color for highlight */
            color: #ffffff !important;
            border-radius: 50%;
        }
    </style>

    <form class="grid grid-cols-1 gap-5" id="booking-form" method="post" action="submit_booking">
        <!-- Email & Phone Fields (always shown) -->
        <div class="grid grid-cols-2 gap-3">
            <input type="email" id="email" name="email" value="<?php echo esc_attr($user->email); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Email">
            <input type="text" id="phone" name="phone" value="<?php echo esc_attr($user->phone); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Phone">
        </div>

        <!-- Booking mode -->
        <?php if ($price_type == 'monthly'): ?>
            <!-- Monthly Pricing -->
            <div class="grid grid-cols-3 gap-3">
                <label for="start_date" class="col-span-1">
                    <input type="text" id="start_date" name="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Start Date">
                </label>
                <label for="length" class="col-span-1">
                    <input type="number" id="length" name="length" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" min="1" max="5" placeholder="Length in <?php echo $is_hotdesk ? 'months' : 'years'; ?>">
                </label>
                <label for="end_date" class="col-span-1">
                    <input type="text" id="end_date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" disabled placeholder="End Date">
                </label>
            </div>
        <?php elseif ($price_type == 'daily'): ?>
            <!-- Daily Pricing -->
            <div class="grid grid-cols-2 gap-2">
                <label for="multi_date">
                    <input type="text" id="multi_date" name="multi_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Select Dates">
                </label>
                <div class="flex justify-start items-center gap-1">                
                    <select id="single_date_option" name="single_date_option" class="ml-6">
                        <option value="full">Full Day</option>
                        <option value="8-12">8 AM - 12 PM</option>
                        <option value="1-5">1 PM - 5 PM</option>
                    </select>
                </div>
            </div>
            <!-- Multi-date options -->
            <div id="multi_date_options" class="grid grid-cols-3 gap-2 hidden">
                <label class="col-span-3 font-display text-gray-700">
                    Dates and Time Slots:
                </label>
                <div id="selected_dates" class="col-span-3">
                    <!-- Dynamically populated based on selected dates -->
                </div>
            </div>
        <?php endif; ?>

        <!-- Customer Notes Field -->
        <textarea id="customer_notes" name="customer_notes" placeholder="Other notes/remarks"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>

        <!-- Submit Button -->
        <div class="flex items-center justify-center gap-x-3 bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold">
            <input type="submit" name="submit_booking" value="Submit">
            <div class="update-spinner"></div>
            <input type="hidden" name="booking_nonce" value="<?php echo wp_create_nonce('submit_booking_nonce'); ?>">
            <input type="hidden" name="space_id" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="non_bookable" value="<?php echo $non_bookable;?>">
        </div>
    </form>
    <script>
        let bookedDates = <?php echo json_encode($booked_dates); ?>;
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('booking_form', 'display_booking_form');


function handle_booking_form_submission() {
  if (!isset($_POST['booking_nonce']) || !wp_verify_nonce($_POST['booking_nonce'], 'submit_booking_nonce')) {
      wp_send_json_error('Nonce verification failed.');
      return;
  }

  if (isset($_POST['action']) && $_POST['action'] === 'submit_booking' && is_user_logged_in()) {
      $current_user_id = get_current_user_id();
      $current_user = wp_get_current_user();

      // Check and update user meta only if the fields are empty
      $fields_to_update = ['first_name', 'last_name', 'company', 'position', 'phone', 'birthdate'];
      foreach ($fields_to_update as $field) {
          if (empty(get_user_meta($current_user_id, $field, true))) {
              $value = sanitize_text_field($_POST[$field]);
              update_user_meta($current_user_id, $field, $value);
          }
      }

      $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : null;
      $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : null;
      $booking_length = sanitize_text_field($_POST['length']);
      $customer_notes = sanitize_textarea_field($_POST['customer_notes']);
      $space_id = isset($_POST['space_id']) ? intval($_POST['space_id']) : 0;
      $non_bookable = isset($_POST['non_bookable']) ? $_POST['non_bookable'] : false;
      $single_date_options = sanitize_text_field($_POST['single_date_option']);


      // Handle the booking creation
      $booking_id = wp_insert_post([
          'post_type' => 'booking',
          'post_status' => 'publish',
      ]);

      if ($booking_id) {
          // Generate the booking post title
          $post_title = $current_user->first_name . ' ' . $current_user->last_name . ' - Booking #' . $booking_id;
          wp_update_post([
              'ID' => $booking_id,
              'post_title' => $post_title,
          ]);

          // Save booking-specific meta fields
          update_post_meta($booking_id, '_booking_user_id', $current_user_id);
          update_post_meta($booking_id, '_booking_space_id', $space_id);
          update_post_meta($booking_id, '_booking_start_date', $start_date);
          if ($end_date) {
              update_post_meta($booking_id, '_booking_end_date', $end_date);
          }
          update_post_meta($booking_id, '_booking_booking_length', $booking_length);
          update_post_meta($booking_id, '_booking_customer_notes', $customer_notes);
          update_post_meta($booking_id, '_booking_status', 'pending'); 
          update_post_meta($booking_id, '_booking_single_date_options', $single_date_options);
          

         // Handle multi-date selection or single date
          if (isset($_POST['multi_date']) && !empty($_POST['multi_date'])) {
              // Convert single date string to array for consistency
              $multi_dates = is_array($_POST['multi_date']) ? $_POST['multi_date'] : explode(', ', $_POST['multi_date']);
              
              // Ensure options are properly handled
              $multi_date_options = isset($_POST['multi_date_option']) ? $_POST['multi_date_option'] : [];

              $date_meta = [];
              foreach ($multi_dates as $index => $date) {
                  $option = isset($multi_date_options[$index]) ? sanitize_text_field($multi_date_options[$index]) : 'full';
                  $date_meta[] = [
                      'date' => sanitize_text_field($date),
                      'option' => $option,  // 'full', '8-12', '1-5'
                  ];
              }

              // Save the array as serialized meta data
              update_post_meta($booking_id, '_booking_multi_dates', $date_meta);
          }

          send_new_booking_notification($booking_id);

          // Return a JSON response with the booking ID and redirect URL
          wp_send_json_success([
              'booking_id' => $booking_id,
              'redirect_url' => home_url('/booking/' . $booking_id . '?new_booking=true')
          ]);
      } else {
          wp_send_json_error('Booking creation failed.');
      }
  }
}
add_action('wp_ajax_submit_booking', 'handle_booking_form_submission');
add_action('wp_ajax_nopriv_submit_booking', 'handle_booking_form_submission');


// Add custom rewrite rule for booking confirmation with optional new_booking parameter
function booking_confirmation_rewrite_rule() {
    add_rewrite_rule(
        '^booking/([0-9]+)/?',
        'index.php?pagename=booking&booking_id=$matches[1]&new_booking=$matches[2]',
        'top'
    );
}
add_action('init', 'booking_confirmation_rewrite_rule');

// Add booking_id and new_booking as query vars so we can retrieve them in the template
function add_booking_query_vars($vars) {
    $vars[] = 'booking_id';
    $vars[] = 'new_booking';
    return $vars;
}
add_filter('query_vars', 'add_booking_query_vars');

/**
 * Booking Life Cycle & Emails
 * 
 */

//New Booking Email Notification
function send_new_booking_notification($booking_id) {
    $booking_post = get_post( $booking_id );
    $booking = new Booking($booking_post);
    $space_inclusions = $booking->space->inclusions;
    $non_bookable = $booking->space->non_bookable;
    $thumbnail_id = get_post_thumbnail_id( $booking->space->ID );
    $image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
    
    $user = new User(get_user_by('id',$booking->user_id));
    $admin_email = get_option('admin_email');

    $message = '';
    ob_start();
    // get email template         
    include(get_template_directory() . '/content/email/header.php'); // locate and include if found  
    include(get_template_directory() . '/content/email/new-booking.php'); // locate and include if found   
    include(get_template_directory() . '/content/email/footer.php'); // locate and include if found     
    
    $message = ob_get_clean();    

    $subject = 'INTELLIDESK BOOKING REQUEST ID #'.$booking->post->ID;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $headers[] = 'Cc: hello@intellideskcoworking.com, georgio.amista@gmail.com';

    // Send email to user
    wp_mail($user->email, $subject, $message, $headers);

    // $admin_message = '';
    // ob_start();
    // // get email template         
    // include(get_template_directory() . '/content/email/header.php'); // locate and include if found  
    // include(get_template_directory() . '/content/email/new-booking-admin.php'); // locate and include if found   
    // include(get_template_directory() . '/content/email/footer.php'); // locate and include if found     
    
    // $admin_message = ob_get_clean();

    // $admin_subject ='A new booking has been created by ' . $user->first_name . ' ' . $user->last_name;

    // // Send email to admin
    // wp_mail($admin_email, $admin_subject, $admin_message, $headers);
}