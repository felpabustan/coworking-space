<?php get_header();?>

<main class="w-full py-6 md:py-12" role="main">
    <div class="max-w-xl mx-auto md:shadow-lg md:border py-5 rounded-lg">
         <h2 class="px-8 text-center text-golden-grass-950 text-2xl mb-3 font-bold font-display">Forgot Password?</h2>
        <p class="px-8 text-center">Please enter your username or email address. You will receive an email message with instructions on how to reset your password.</p>
        <hr class="my-6"/>
        <form id="reset-password-form" class="w-full md:w-2/3 mx-auto px-8 grid grid-cols-1 gap-5" method="post">
            <label for="user_login">
                <span>Username or Email Address</span>
                <input type="text" name="user_login" id="user_login" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-golden-grass-300 focus:ring focus:ring-golden-grass-200 focus:ring-opacity-50" required>
            </label>
            <div class="flex items-center justify-center gap-x-3 hover:bg-golden-grass-500 transition-all bg-golden-grass-400 text-white rounded-md py-3 px-4 font-semibold font-display shadow-sm group-hover:translate-y-0 -translate-y-2.5 delay-75">
                <input type="submit"name="submit" id="reset-submit" value="<?php _e('Reset Password', 'textdomain'); ?>">
                <div class="update-spinner"></div>
            </div>
        </form>

        <div id="reset-message" class="mt-4"></div>
    </div>
</main>
<?php get_footer(); ?>