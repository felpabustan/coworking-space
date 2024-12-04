<?php

function inquiry_post_type() {
  $labels = array(
      'name'                  => 'Inquiries',
      'singular_name'         => 'Inquiry',
      'menu_name'             => 'Inquiries',
      'name_admin_bar'        => 'Inquiry',
      'add_new'               => 'Add New',
      'add_new_item'          => 'Add New Inquiry',
      'new_item'              => 'New Inquiry',
      'edit_item'             => 'Edit Inquiry',
      'view_item'             => 'View Inquiry',
      'all_items'             => 'All Inquiries',
      'search_items'          => 'Search Inquiries',
      'not_found'             => 'No inquiries found.',
      'not_found_in_trash'    => 'No inquiries found in Trash.',
  );

  $args = array(
      'labels'                => $labels,
      'public'                => false,  // No frontend access
      'show_ui'               => true,   // Show in admin
      'show_in_menu'          => true,   // Show in admin menu
      'query_var'             => false,  // Disable frontend queries
      'rewrite'               => false,  // No rewrite rules
      'capability_type'       => 'post',
      'has_archive'           => false,  // No archive pages
      'hierarchical'          => false,  // Flat structure
      'menu_position'         => 6,
      'menu_icon'             => 'dashicons-email',  // Icon to represent inquiries
      'supports'              => array('title', 'editor', 'custom-fields', 'author'),
      'exclude_from_search'   => true,  // Exclude from search results
      'publicly_queryable'    => false, // Not accessible via frontend queries
  );

  register_post_type('inquiry', $args);
}
add_action('init', 'inquiry_post_type');

function remove_inquiry_meta_boxes() {
  remove_post_type_support('inquiry', 'title');
  remove_post_type_support('inquiry', 'editor');
  remove_post_type_support('inquiry', 'media');
  remove_meta_box('authordiv', 'inquiry', 'normal');
  remove_meta_box('postcustom', 'inquiry', 'normal'); 
  remove_meta_box('commentsdiv', 'inquiry', 'normal'); 
}
add_action('admin_menu', 'remove_inquiry_meta_boxes');


function add_inquiry_meta_box() {
  add_meta_box(
      'inquiry_meta_box',                // ID for the meta box
      'Inquiry Details',                 // Title of the meta box
      'display_inquiry_data_meta_box',   // Callback function to display the content
      'inquiry',                         // Post type (inquiry)
      'normal',                          // Context (where to display)
      'default'                          // Priority (default position)
  );
}
add_action('add_meta_boxes', 'add_inquiry_meta_box');

function display_inquiry_data_meta_box($post) {
  $inquiry = new Inquiry($post);
  $space_image = wp_get_attachment_image_src( get_post_thumbnail_id( $inquiry->space->ID ));
  ?>
  <h3><?php the_title(); ?></h3>
  <h4>Inquiry Details</h4>
  <p><?php echo 'Company: ' . $inquiry->company; ?></p>
  <p><?php echo 'Name: ' . $inquiry->name; ?></p>
  <p><?php echo 'Email: ' . $inquiry->email; ?></p>
  <p><?php echo 'Phone: ' . $inquiry->phone; ?></p>
  <p><?php echo 'Subject: ' . $inquiry->subject; ?></p>
  <p><?php echo 'Message: ' . nl2br($inquiry->message); ?></p>
  <p><?php echo 'Date & Time: ' . $inquiry->get_date_and_time(); ?></p>
  <p><?php echo 'Number of People: ' . $inquiry->pax; ?></p>

  <h4>Space Information</h4>
  <p><?php echo 'Space: ' . $inquiry->space->post_title; ?></p>
  <p><?php echo 'Price Type: ' . $inquiry->space->price_type; ?></p>
  <img src="<?php echo $space_image[0]?>" alt="">
  <?php

}

function save_inquiry_meta($post_id) {
  // Check if the post type is 'inquiry' and not auto-saving
  if (get_post_type($post_id) !== 'inquiry' || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
  }

  // Check if the current user has permission to edit the post
  if (!current_user_can('edit_post', $post_id)) {
      return;
  }

  // Save or update the inquiry metadata
  if (isset($_POST['booking_status'])) {
      update_post_meta($post_id, '_inquiry_status', sanitize_text_field($_POST['booking_status']));
  }

  // You can add other fields here as needed, similar to how you handled bookings.
}
add_action('save_post', 'save_inquiry_meta');

function display_inquiry_form() {
  ?>
  <form id="inquiry-form" method="post" action="submit_inquiry" class="bg-white p-6 mx-auto">
      <div class="mb-5">
          <h2 class="text-lg font-bold text-gray-800 mb-3">Personal Information</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col">
                  <label for="company" class="text-sm font-medium text-gray-700 mb-1">Company</label>
                  <input 
                      type="text" 
                      id="company" 
                      name="company" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                      placeholder="Company">
              </div>
              <div class="flex flex-col">
                  <label for="first_name" class="text-sm font-medium text-gray-700 mb-1">First Name</label>
                  <input 
                      type="text" 
                      id="first_name" 
                      name="first_name" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                      placeholder="First Name">
              </div>
              <div class="flex flex-col">
                  <label for="last_name" class="text-sm font-medium text-gray-700 mb-1">Last Name</label>
                  <input 
                      type="text" 
                      id="last_name" 
                      name="last_name" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                      placeholder="Last Name">
              </div>
              <div class="flex flex-col">
                  <label for="email" class="text-sm font-medium text-gray-700 mb-1">Email</label>
                  <input 
                      type="email" 
                      id="email" 
                      name="email" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                      placeholder="Email">
              </div>
              <div class="flex flex-col">
                  <label for="phone" class="text-sm font-medium text-gray-700 mb-1">Phone</label>
                  <input 
                      type="text" 
                      id="phone" 
                      name="phone" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
                      placeholder="Phone">
              </div>
          </div>
      </div>

      <div class="mb-5">
          <h2 class="text-lg font-bold text-gray-800 mb-3">Inquiry Details</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex flex-col">
                  <label for="number_of_people" class="text-sm font-medium text-gray-700 mb-1">Number of People</label>
                  <input 
                      type="number" 
                      id="number_of_people" 
                      name="number_of_people" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
              </div>
              <div class="flex flex-col">
                  <label for="date" class="text-sm font-medium text-gray-700 mb-1">Date</label>
                  <input 
                      type="text" 
                      id="date" 
                      name="inquiry_date" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
              </div>
              <div class="flex flex-col">
                  <label for="time" class="text-sm font-medium text-gray-700 mb-1">Time</label>
                  <select 
                      id="time" 
                      name="inquiry_time" 
                      required 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                      <option value="">Select Time</option>
                      <?php 
                      $start = 8; 
                      $end = 17; 
                      for ($i = $start; $i <= $end; $i++) {
                          $time = date('h:i A', strtotime("$i:00"));
                          echo "<option value='$i:00'>$time</option>";
                      }
                      ?>
                  </select>
              </div>
          </div>
      </div>

      <div class="mb-5">
          <label for="subject" class="text-sm font-medium text-gray-700 mb-1">Subject</label>
          <input 
              type="text" 
              name="subject" 
              required 
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition"
              placeholder="Subject">
      </div>

      <div class="mb-5">
          <label for="message" class="text-sm font-medium text-gray-700 mb-1">Your Message (Optional)</label>
          <textarea 
              id="message" 
              name="message" 
              rows="6" 
              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition min-h-[150px]"
              placeholder="Enter your message"></textarea>
      </div>

      <input type="hidden" name="space_id" value="<?php echo get_the_ID(); ?>">
      <input type="hidden" name="action" value="submit_inquiry">

      <div class="flex items-center justify-center gap-x-3 bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold">
          <input 
              type="submit" 
              name="submit_inquiry" 
              value="Submit Inquiry" 
              class="cursor-pointer">
          <div class="update-spinner"></div>
          <input type="hidden" name="inquiry_nonce" value="<?php echo wp_create_nonce('submit_inquiry_nonce'); ?>">
      </div>
  </form>

  <script>
      $(document).ready(function () {
          $("#date").datepicker({
              dateFormat: "yy-mm-dd", 
              minDate: 1, 
              beforeShowDay: function (date) {
                  const day = date.getDay(); 
                  return [day !== 3, ""]; 
              }
          });
      });
  </script>
  <?php
}
add_shortcode('inquiry_form', 'display_inquiry_form');

function handle_inquiry_form_submission() {
  if (!isset($_POST['inquiry_nonce']) || !wp_verify_nonce($_POST['inquiry_nonce'], 'submit_inquiry_nonce')) {
      wp_send_json_error('Nonce verification failed.');
      return;
  }

  if (isset($_POST['action']) && $_POST['action'] === 'submit_inquiry') {
      $company =  isset($_POST['company']) ? sanitize_text_field($_POST['company']) : null;
      $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : null;
      $first_name =  isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : null;
      $last_name =  isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : null;
      $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : null;
      $inquiry_date = isset($_POST['inquiry_date']) ? sanitize_text_field($_POST['inquiry_date']) : null;
      $inquiry_time = isset($_POST['inquiry_time']) ? sanitize_text_field($_POST['inquiry_time']) : null;
      $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : 'No subject';
      $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : 'No message';
      $space_id = isset($_POST['space_id']) ? intval($_POST['space_id']) : 0;
      $pax = isset($_POST['number_of_people']) ? intval($_POST['number_of_people']) : null;

      if (empty($email) || empty($phone) || empty($inquiry_date) || empty($inquiry_time)) {
          wp_send_json_error('Required fields are missing.');
          return;
      }

      // Create the inquiry post
      $inquiry_id = wp_insert_post([
          'post_type'   => 'inquiry',
          'post_status' => 'publish',
      ]);

      if ($inquiry_id) {
          $post_title = $email . ' - INQUIRY #' . $inquiry_id;
          $full_name =  $first_name . ' ' . $last_name;
          wp_update_post([
              'ID'         => $inquiry_id,
              'post_title' => $post_title,
          ]);

          // Update post meta
          update_post_meta($inquiry_id, '_inquiry_company', $company);
          update_post_meta($inquiry_id, '_inquiry_name', $full_name);
          update_post_meta($inquiry_id, '_inquiry_email', $email);
          update_post_meta($inquiry_id, '_inquiry_subject', $subject);
          update_post_meta($inquiry_id, '_inquiry_message', $message);
          update_post_meta($inquiry_id, '_inquiry_phone', $phone);
          update_post_meta($inquiry_id, '_inquiry_date', $inquiry_date);
          update_post_meta($inquiry_id, '_inquiry_time', $inquiry_time);
          update_post_meta($inquiry_id, '_inquiry_space_id', $space_id);
          update_post_meta($inquiry_id, '_inquiry_pax', $pax);

          send_inquiry_email_notification($inquiry_id);

          wp_send_json_success([
            'inquiry_id' => $inquiry_id,
            'redirect_url' => home_url('/inquiry/' . $inquiry_id . '?new_inquiry=true')
          ]);
      } else {
          wp_send_json_error('Failed to create inquiry post.');
      }
  }
}
add_action('wp_ajax_submit_inquiry', 'handle_inquiry_form_submission');
add_action('wp_ajax_nopriv_submit_inquiry', 'handle_inquiry_form_submission');

function send_inquiry_email_notification($inquiry_id) {
    $inquiry_post = get_post($inquiry_id);
    $inquiry = new Inquiry($inquiry_post);

    $space_thumbnail_id = get_post_thumbnail_id($inquiry->space->ID);
    $space_image_url = wp_get_attachment_image_url($space_thumbnail_id, 'full');
    $space_name = get_the_title($inquiry->space->ID);
    $inquiry_date_and_time = $inquiry->get_date_and_time();
    $company = $inquiry->company;
    $email = $inquiry->email;
    $phone = $inquiry->phone;
    $full_name = $inquiry->name;
    $pax = $inquiry->pax;

    $admin_email = get_option('admin_email');

    $message = '';

    ob_start();

    include(get_template_directory() . '/content/email/header.php'); // locate and include if found  
    include(get_template_directory() . '/content/email/new-inquiry.php'); // locate and include if found   
    include(get_template_directory() . '/content/email/footer.php'); // locate and include if found     

    $message = ob_get_clean();    

    $subject = 'INTELLIDESK INQUIRY REQUEST ID #'.$inquiry->post->ID;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $headers[] = 'Cc: hello@intellideskcoworking.com, georgio.amista@gmail.com';

    wp_mail($user->email, $subject, $message, $headers);
}
