<?php
/* Template Name: New Password */
get_header();

?>
 <main class="w-full py-6 md:py-12" role="main">
    <div class="max-w-xl mx-auto md:shadow-lg md:border py-5 rounded-lg">
<?php
if (isset($_GET['key']) && isset($_GET['login'])) {
    $key = sanitize_text_field($_GET['key']);
    $login = sanitize_text_field($_GET['login']);
    $user = check_password_reset_key($key, $login);
    
    if (is_wp_error($user)) {
        echo '<p class="text-center text-sm font-display my-10">Invalid password reset link. Please request for new password link <a href="/password-reset" class="underline text-golden-grass-600">here</a>.</p>';
    } else {
        if (isset($_POST['new_password'])) {
            $new_password = sanitize_text_field($_POST['new_password']);
            reset_password($user, $new_password);
            echo '<p class="text-center text-sm font-display my-10">Your password has been successfully reset. <a class="text-golden-grass-600 underline" href="' . site_url('/my-account/') . '">Log in</a>.</p>';
        } else {
            ?>
            <h2 class="text-center text-golden-grass-950 text-2xl mb-3 font-bold font-display">Enter your new password below</h2>
            <form id="new-password-form" class="w-full md:w-2/3 mx-auto px-8 grid grid-cols-1 gap-5" method="post" action="">
                <label for="new_password">
                    <span class="text-gray-700 font-display">New Password</span>
                    <input type="password" name="new_password" id="new_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
                </label>
                <input type="submit" value="Set New Password" class="block hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
            </form>
                
            <?php
        }
    }
} else {
    ?>
    <h2 class="px-8 text-center text-golden-grass-950 text-2xl mb-3 font-bold font-display">Forgot Password?</h2>
    <p class="px-8 text-center">Please enter your username or email address. You will receive an email message with instructions on how to reset your password.</p>
    <hr class="my-6"/>
    <form id="reset-password-form" class="w-full md:w-2/3 mx-auto px-8 grid grid-cols-1 gap-5" method="post">
        <label for="user_login">
            <span class="text-gray-700 font-display">Username or Email Address</span>
            <input type="text" name="user_login" id="user_login" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
        </label>
        <div class="flex items-center justify-center gap-x-3 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
            <input type="submit"name="submit" id="reset-submit" value="<?php _e('Send Reset Email', 'textdomain'); ?>">
            <div class="update-spinner"></div>
        </div>
    </form>
    <div id="reset-message" class="mt-4"></div>

    <?php
}
?>
    </div>
</main>
<?php  get_footer();