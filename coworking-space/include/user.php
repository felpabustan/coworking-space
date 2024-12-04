<?php

//add custom fields to user meta
function theme_add_custom_user_meta_fields($user) {
    ?>
    <h3><?php _e("Additional User Information", "theme-textdomain"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="company"><?php _e("Company"); ?></label></th>
            <td>
                <input type="text" name="company" id="company" value="<?php echo esc_attr(get_the_author_meta('company', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your company."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="position"><?php _e("Position"); ?></label></th>
            <td>
                <input type="text" name="position" id="position" value="<?php echo esc_attr(get_the_author_meta('position', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your position."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="phone"><?php _e("phone"); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your phone number."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="birthdate"><?php _e("Birthdate"); ?></label></th>
            <td>
                <input type="date" name="birthdate" id="birthdate" value="<?php echo esc_attr(get_the_author_meta('birthdate', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Please enter your birthdate."); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="billing_address"><?php _e("Billing Address"); ?></label></th>
            <td>
                <input type="text" name="billing_street" id="billing_street" value="<?php echo esc_attr(get_the_author_meta('billing_street', $user->ID)); ?>" class="regular-text" placeholder="Street Address" /><br />
                <input type="text" name="billing_city" id="billing_city" value="<?php echo esc_attr(get_the_author_meta('billing_city', $user->ID)); ?>" class="regular-text" placeholder="City" /><br />
                <input type="text" name="billing_state" id="billing_state" value="<?php echo esc_attr(get_the_author_meta('billing_state', $user->ID)); ?>" class="regular-text" placeholder="State/Province" /><br />
                <input type="text" name="billing_zip" id="billing_zip" value="<?php echo esc_attr(get_the_author_meta('billing_zip', $user->ID)); ?>" class="regular-text" placeholder="ZIP/Postal Code" /><br />
                <input type="text" name="billing_country" id="billing_country" value="<?php echo esc_attr(get_the_author_meta('billing_country', $user->ID)); ?>" class="regular-text" placeholder="Country" /><br />
                <span class="description"><?php _e("Please enter your billing address."); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'theme_add_custom_user_meta_fields', 5); // For Profile view
add_action('edit_user_profile', 'theme_add_custom_user_meta_fields', 5); // For User edit view

//save custom user meta
function theme_save_custom_user_meta_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'company', sanitize_text_field($_POST['company']));
    update_user_meta($user_id, 'position', sanitize_text_field($_POST['position']));
    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'birthdate', sanitize_text_field($_POST['birthdate']));
    update_user_meta($user_id, 'billing_street', sanitize_text_field($_POST['billing_street']));
    update_user_meta($user_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    update_user_meta($user_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    update_user_meta($user_id, 'billing_zip', sanitize_text_field($_POST['billing_zip']));
    update_user_meta($user_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
}
add_action('personal_options_update', 'theme_save_custom_user_meta_fields');
add_action('edit_user_profile_update', 'theme_save_custom_user_meta_fields');

// Shortcode for the login form
function theme_login_form_shortcode() {
    $redirect_url = isset($_GET['redirect_to']) ? esc_url($_GET['redirect_to']) : home_url(); // Default to home if not set
    $errors = isset($_POST['theme_login_errors']) ? $_POST['theme_login_errors'] : '';

    ob_start(); ?>
   
    <form class="grid grid-cols-1 gap-5" method="post" action="">
        <label for="user_login" class="block">
            <span class="text-gray-700 font-display">Username or Email</span>
            <input type="text" name="log" id="user_login" autocomplete="username" value="<?php echo isset($_POST['log']) ? esc_attr($_POST['log']) : ''; ?>" size="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" placeholder="mailbox@domain.com" required>
            <?php if (!empty($errors['log'])): ?>
                <span class="text-red-500 text-sm"><?php echo esc_html($errors['log']); ?></span>
            <?php endif; ?>
        </label>
        <label for="user_pass" class="block">
            <span class="text-gray-700 font-display">Password</span>
            <input type="password" name="pwd" id="user_pass" autocomplete="current-password" spellcheck="false" value="" size="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" placeholder="" required>
            <?php if (!empty($errors['pwd'])): ?>
                <span class="text-red-500 text-sm"><?php echo esc_html($errors['pwd']); ?></span>
            <?php endif; ?>
        </label>
        <div class="flex flex-col gap-3">
            <div class="flex justify-between items-center">
                <label for="rememberme" class="inline-flex items-center">
                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="rounded border-gray-300 text-golden-grass-600 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-offset-0 focus:ring-golden-grass-200 focus:ring-opacity-50 text-xs">
                    <span class="ml-2 text-xs text-gray-700 font-display">Remember me</span>
                </label>
                <div>
                    <a class="font-display text-xs" href="/password-reset/">Lost your password?</a>
                </div>
            </div>
            <input type="submit" name="wp-submit" id="wp-submit" value="Log In" class="block hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
            <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_url); ?>">
        </div>
    </form>

    <?php if (!empty($errors['general'])): ?>
        <div class="mt-3 text-red-500 text-sm">
            <?php echo ($errors['general']); ?>
        </div>
    <?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('theme_login_form', 'theme_login_form_shortcode');

// Handle login form submission
function theme_handle_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log']) && isset($_POST['pwd'])) {
        $errors = [];
        $user = wp_signon([
            'user_login' => sanitize_user($_POST['log']),
            'user_password' => sanitize_text_field($_POST['pwd']),
            'remember' => isset($_POST['rememberme']) ? true : false
        ]);

        if (is_wp_error($user)) {
            $errors['general'] = $user->get_error_message();
        } else {
            wp_safe_redirect(esc_url_raw($_POST['redirect_to']));
            exit;
        }

        $_POST['theme_login_errors'] = $errors;
    }
}
add_action('template_redirect', 'theme_handle_login');


// Shortcode for the registration form
function theme_register_form_shortcode() {
    // Retrieve error messages
    $errors = get_transient('registration_errors');
    delete_transient('registration_errors'); // Clear errors after displaying

    ob_start(); ?>
    <form class="grid grid-cols-1 gap-5" method="post">
        <label for="reg_user" class="block">
            <span class="text-gray-700 font-display">Username</span>
            <input type="text" name="reg_user" id="reg_user" autocomplete="username" value="<?php echo isset($_POST['reg_user']) ? esc_attr($_POST['reg_user']) : ''; ?>" size="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" placeholder="" required>
            <?php if ( $errors && $errors->get_error_message('empty_username') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('empty_username')) . '</p>'; ?>
            <?php if ( $errors && $errors->get_error_message('username_exists') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('username_exists')) . '</p>'; ?>
        </label>
        <label for="reg_email" class="block">
            <span class="text-gray-700 font-display">Email</span>
            <input type="email" name="reg_email" id="reg_email" autocomplete="email" value="<?php echo isset($_POST['reg_email']) ? esc_attr($_POST['reg_email']) : ''; ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" placeholder="mailbox@domain.com" required>
            <?php if ( $errors && $errors->get_error_message('empty_email') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('empty_email')) . '</p>'; ?>
            <?php if ( $errors && $errors->get_error_message('invalid_email') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('invalid_email')) . '</p>'; ?>
            <?php if ( $errors && $errors->get_error_message('email_exists') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('email_exists')) . '</p>'; ?>
        </label>
        <hr/>
        <label for="password" class="block relative">
            <span class="text-gray-700 font-display">Password</span>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
            <i class="fa absolute right-5 bottom-4 text-gray-500 fa-eye-slash" id="togglePassword"></i>
            <div id="password-strength-status" class="text-sm text-gray-600 mt-1"></div>
            <?php if ( $errors && $errors->get_error_message('empty_password') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('empty_password')) . '</p>'; ?>
        </label>
        <label for="confirm_password" class="block">
            <span class="text-gray-700 font-display">Confirm Password</span>
            <div class="relative">
                <input type="password" name="confirm_password" id="confirm_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
                <i class="fa absolute right-5 bottom-4 text-gray-500 fa-eye-slash" id="toggleConfirmPassword"></i>
            </div>
            <div id="#confirm_password_message"></div>
            <?php if ( $errors && $errors->get_error_message('password_mismatch') ) echo '<p class="text-red-600">' . esc_html($errors->get_error_message('password_mismatch')) . '</p>'; ?>
        </label>
        <input type="submit" name="wp-register" id="wp-register" value="Register" class="block hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('theme_register_form', 'theme_register_form_shortcode');

//Registration handler
function theme_handle_registration_redirect() {
    if ( isset($_POST['wp-register']) ) {
        $user_login = sanitize_user($_POST['reg_user']);
        $user_email = sanitize_email($_POST['reg_email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = new WP_Error();

        // Validate username
        if ( empty($user_login) ) {
            $errors->add('empty_username', 'Please enter a username.');
        } elseif ( username_exists($user_login) ) {
            $errors->add('username_exists', 'Username already exists.');
        }

        // Validate email
        if ( empty($user_email) ) {
            $errors->add('empty_email', 'Please enter an email address.');
        } elseif ( !is_email($user_email) ) {
            $errors->add('invalid_email', 'Please enter a valid email address.');
        } elseif ( email_exists($user_email) ) {
            $errors->add('email_exists', 'Email already registered.');
        }

        // Validate passwords
        if ( empty($password) || empty($confirm_password) ) {
            $errors->add('empty_password', 'Please enter a password and confirm it.');
        } elseif ( $password !== $confirm_password ) {
            $errors->add('password_mismatch', 'Passwords do not match.');
        }

        // If there are no errors, register the user
        if ( empty($errors->errors) ) {
            $user_id = wp_create_user($user_login, $password, $user_email);

            if ( !is_wp_error($user_id) ) {
                // Log the user in
                wp_set_auth_cookie($user_id);
                wp_set_current_user($user_id);
                do_action('wp_login', $user_login, $user_id);

                // Redirect to the provided URL or the account page if no redirect URL is provided
                $redirect_url = !empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/my-account/');
                wp_safe_redirect($redirect_url);
                exit;
            } else {
                $errors->add('registration_error', $user_id->get_error_message());
            }
        }

        // Save errors to session and redirect back to the registration form
        set_transient('registration_errors', $errors, 30); // Save errors for 30 seconds
        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit;
    }
}
add_action('init', 'theme_handle_registration_redirect');

// Shortcode to display user profile details and update form
function display_user_profile() {
    
    $current_user = wp_get_current_user();
    $user = new User($current_user);

    ob_start(); ?>

    <h2 class="text-4xl font-bold mb-6 font-display">Profile Details</h2>
    <?php if(!$user->first_name || !$user->last_name || !$user->company || !$user->position):?>
        <p class="text-sm mb-4">Please complete your profile details below to make your inquiry submission seamless as possible.</p>
    <?php endif;?>
    <form id="profile-update-form" class="grid grid-cols-1 gap-5" method="post">
        <?php wp_nonce_field('profile_update_nonce', 'security'); ?>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block" for="first_name">First Name*</label>
                <input type="text" name="first_name" id="first_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->first_name); ?>" />
            </div>
            <div>
                <label class="block" for="last_name">Last Name*</label>
                <input type="text" name="last_name" id="last_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->last_name); ?>" />
            </div>
        </div>
        <div>
            <label class="block" for="company">Company*</label>
            <input type="text" name="company" id="company" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->company); ?>" />
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block" for="position">Position*</label>
                <input type="text" name="position" id="position" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->position); ?>" />
            </div>
            <div>
                <label class="block" for="phone">Phone*</label>
                <input type="text" name="phone" id="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->phone); ?>" />
            </div>
        </div>
        <div>
            <label class="block" for="birthdate">Birthdate*</label>
            <input type="date" name="birthdate" id="birthdate" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->birthdate); ?>" />
        </div>
        <hr class="bg-gray-300">
        <div>
            <label class="block" for="">Billing Address*</label>
            <input type="text" name="billing_street" id="billing_street" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->billing_street);?>" placeholder="Street Address" />
            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="billing_city" id="billing_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->billing_city);?>" placeholder="City" />
                <input type="text" name="billing_state" id="billing_state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->billing_state);?>" placeholder="State/Province" />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="billing_country" id="billing_country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->billing_country);?>" placeholder="Country" />
                <input type="text" name="billing_zip" id="billing_zip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->billing_zip);?>" placeholder="ZIP/Postal Code" />
            </div>
        </div>
        <div class="flex items-center justify-center gap-x-3 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
            <input type="submit" name="update_profile" value="Update Profile" class="" />
            <div class="update-spinner"></div>
        </div>
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('user_profile', 'display_user_profile');

// Shortcode to display user account details and update form
function display_account_details_form() {
    $current_user = wp_get_current_user();
    $user = new User($current_user);

    ob_start(); ?>

    <h2 class="text-4xl font-bold mb-6 font-display">Account Details</h2>
    <form id="account-update-form" class="grid grid-cols-1 gap-5" method="post" action="">
        <?php wp_nonce_field('update_account_details', 'account_details_nonce'); ?>
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" class="mt-1 block w-full rounded-md bg-gray-300 border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->username); ?>" disabled>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" value="<?php echo esc_attr($user->email); ?>" required>
        </div>
        <hr/>
        <label for="password" class="block">
            <span class="text-gray-700 font-display">New Password</span>
            <div class="relative">
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
                <i class="fa absolute right-5 bottom-4 text-gray-500 fa-eye-slash" id="togglePassword"></i>
            </div>
            <div id="password-strength-status" class="text-sm text-gray-600 mt-1"></div>
        </label>
        <div class="">
            <div class="flex items-center justify-center gap-x-3 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
                <input type="submit" value="Update Account Details">
                <div class="update-spinner"></div>
            </div>
            <span class="mt-1 text-xs italic">Note: Updating your email or your password will automatically log you out. You will be asked to log in again.</span>
        </div>
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('account_details', 'display_account_details_form');

// Profile Update AJAX Handler
function ajax_handle_profile_update() {
    check_ajax_referer('profile_update_nonce', 'security');

    $user_id = get_current_user_id();

    if ($user_id) {
        // Sanitize and update user profile data
        wp_update_user([
            'ID' => $user_id,
            'first_name' => sanitize_text_field($_POST['first_name']),
            'last_name' => sanitize_text_field($_POST['last_name']),
        ]);

        update_user_meta($user_id, 'company', sanitize_text_field($_POST['company']));
        update_user_meta($user_id, 'position', sanitize_text_field($_POST['position']));
        update_user_meta($user_id, 'birthdate', sanitize_text_field($_POST['birthdate']));
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
        update_user_meta($user_id, 'billing_street', sanitize_text_field($_POST['billing_street']));
        update_user_meta($user_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
        update_user_meta($user_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
        update_user_meta($user_id, 'billing_zip', sanitize_text_field($_POST['billing_zip']));
        update_user_meta($user_id, 'billing_country', sanitize_text_field($_POST['billing_country']));

        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_update_profile', 'ajax_handle_profile_update');

// Account Details Update AJAX Handler
function ajax_handle_account_details_update() {
    check_ajax_referer('update_account_details', 'account_details_nonce');

    $user_id = get_current_user_id();

    if ($user_id) {
        // Sanitize and update email and password
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        if (!empty($email) && is_email($email)) {
            wp_update_user(['ID' => $user_id, 'user_email' => $email]);
        }

        if (!empty($password)) {
            wp_set_password($password, $user_id);
        }

        // Send a custom response to inform the frontend
        wp_send_json_success(['message' => 'Account details updated. You will be logged out.']);
    } else {
        wp_send_json_error(['message' => 'Error updating account details.']);
    }
}
add_action('wp_ajax_update_account_details', 'ajax_handle_account_details_update');

// Shortcode to display user bookings 
function display_user_bookings() {
    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'booking',
        'meta_query' => array(
            array(
                'key' => '_booking_user_id',
                'value' => $current_user->ID,
                'compare' => '='
            )
        )
    );

    $bookings = new WP_Query($args);

    $table_headers = '
        <thead class="font-display font-semibold text-sm bg-golden-grass-100 text-golden-grass-950">
            <tr>
                <td class="px-6 py-4">Booking ID</td>
                <td class="px-6 py-4">Date Booked</td>
                <td class="px-6 py-4">Space</td>
                <td class="px-6 py-4">Status</td>
                <td></td>
            </tr>
        </thead>
    ';

    ob_start();
    echo '<h2 class="text-4xl font-bold mb-6 font-display">Bookings</h2>';
    if ($bookings->have_posts()) : 
        echo '<table class="border-collapse	w-full border shadow-sm">';
        echo $table_headers;
        echo '<tbody>';
        while ($bookings->have_posts()) : $bookings->the_post();
            
            $space_id = get_post_meta(get_the_ID(), '_booking_space_id', true);
            $space_name = get_the_title($space_id);
            $booking_id = get_the_ID();
            
            echo '<tr class="odd:bg-white even:bg-golden-grass-50 even:dark:bg-gray-800 py-4 text-sm">';
                echo '<td class="px-6 py-4">'. get_the_ID() . '</td>';
                echo '<td class="px-6 py-4">'. esc_html(get_the_date('Y-m-d', get_the_ID())) . '</td>';
                echo '<td class="px-6 py-4">'. esc_html($space_name) . '</td>';
                echo '<td class="px-6 py-4">'. esc_html(get_post_meta(get_the_ID(), '_booking_status', true)) . '</td>';
                echo '<td class="px-6 py-4"><a class="view-booking-details-btn" href="' . home_url( '/booking?booking_id=' .get_the_ID() ) . '">View Details</a></td>';
            echo'</tr>';
        endwhile;
        echo '</tbody></table>';
    else :
        echo '<p>No bookings found.</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('user_bookings', 'display_user_bookings');

function get_booking_details() {
    check_ajax_referer('booking_details_nonce', 'security');

    if (!isset($_POST['booking_id'])) {
        wp_send_json_error(['message' => 'Invalid booking ID.']);
    }

    $booking_id = intval($_POST['booking_id']);
    $booking_details = '';

    // Fetch the booking details (you can customize this with more details)
    $space_id = get_post_meta($booking_id, '_booking_space_id', true);
    $space_name = get_the_title($space_id);
    $status = get_post_meta($booking_id, '_booking_status', true);
    $date_booked = get_the_date('Y-m-d', $booking_id);
    // Add more details as needed

    $booking_details .= '<p><strong>Booking ID:</strong> ' . $booking_id . '</p>';
    $booking_details .= '<p><strong>Date Booked:</strong> ' . $date_booked . '</p>';
    $booking_details .= '<p><strong>Space:</strong> ' . esc_html($space_name) . '</p>';
    $booking_details .= '<p><strong>Status:</strong> ' . esc_html($status) . '</p>';
    // Append more details

    wp_send_json_success(['details' => $booking_details]);
}
add_action('wp_ajax_get_booking_details', 'get_booking_details');
add_action('wp_ajax_nopriv_get_booking_details', 'get_booking_details');


function password_reset_trigger() {
    // Check the nonce for security
    check_ajax_referer('reset_password_nonce', 'security');

    if (!isset($_POST['user_login']) || empty($_POST['user_login'])) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    $username_or_email = sanitize_text_field($_POST['user_login']);
    $user = get_user_by('email', $username_or_email);

    if (!$user) {
        wp_send_json_error(['message' => 'No user found with that email address.']);
    }

    // Generate the reset key and password reset link
    $reset_key = get_password_reset_key($user);
    if (is_wp_error($reset_key)) {
        wp_send_json_error(['message' => 'Could not generate reset key.']);
    }

    // Generate the custom password reset link
    $reset_url = site_url('/new-password/?key=' . $reset_key . '&login=' . rawurlencode($user->user_login));

    // Send the reset password email
    $message = "Hi " . $user->user_login . ",\n\n";
    $message .= "You requested a password reset for your account. Click the link below to reset your password:\n\n";
    $message .= $reset_url . "\n\n";
    $message .= "If you did not request this change, please ignore this email.\n\n";
    $message .= "Thanks,\nYour Website Team";

    $mail_sent = wp_mail($user->user_email, 'Password Reset', $message);

    if ($mail_sent) {
        wp_send_json_success(['message' => 'Password reset email sent. Please check your inbox.']);
    } else {
        wp_send_json_error(['message' => 'Failed to send the password reset email.']);
    }
}
add_action('wp_ajax_nopriv_password_reset_trigger', 'password_reset_trigger');
add_action('wp_ajax_password_reset_trigger', 'password_reset_trigger');


/**
 * Emails
 */

function custom_welcome_email($user_id) {
    $user = get_userdata($user_id);
    $email = $user->user_email;
    $subject = __('Welcome!', 'textdomain');
    $message  = sprintf( __( 'Hi %s,' ), $user->user_login ) . "\r\n\r\n";
    $message .= __( 'Thank you for registering at ' . $blogname . '.' ) . "\r\n";
    $message .= __( 'Here are your login details:' ) . "\r\n\r\n";
    $message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n";
    $message .= __( 'You can login and access your account here:' ) . "\r\n";
    $message .= 'https://beautyinsider.sg/my-account' . "\r\n\r\n";
    $message .= __( 'We hope you enjoy using our website!' ) . "\r\n";
    $message .= __( 'Thanks,' ) . "\r\n";
    $message .= __( $blogname );

    wp_mail($email, $subject, $message);
}
add_action('user_register', 'custom_welcome_email');
