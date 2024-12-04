<?php get_header();?>

<main class="w-full py-6 md:py-12" role="main">
    <?php if (!is_user_logged_in()):?>
        <div class="max-w-xl mx-auto md:shadow-lg md:border py-5 rounded-lg">
            <h2 class="text-center text-golden-grass-950 text-2xl mb-3 font-bold font-display">Welcome to Intellidesk Coworking Space!</h2>
            <p class="text-center">To send us a booking inquiry, please login below:</p>
            <hr class="my-6"/>
            <div class="w-full md:w-2/3 mx-auto px-8 flex flex-col gap-5">
                <?php echo do_shortcode('[theme_login_form]');?> 
                <p class="text-sm text-center">Don't have an account yet? Register <a class="underline text-golden-grass-600" href="/register">here</a>.</p>
            </div>
            
        </div>
    <?php else:
        $user_id = get_current_user_id();
        $user = get_userdata($user_id);

        // Fetch user meta data
        $company = get_user_meta($user_id, 'company', true);
        $position = get_user_meta($user_id, 'position', true);
    ?>
        
        <div class="container grid grid-cols-3 gap-10">
            <div class="">
                <div class="border-gray-300 shadow-md rounded-xl pt-8 flex flex-col gap-10">
                    <div class="flex flex-col gap-3 items-center px-8">
                        <h1 class="font-display text-3xl font-semibold">Welcome<?php if($user->first_name) echo ', '.esc_attr($user->first_name); ?>!</h1>
                        <?php echo get_avatar( get_current_user_id(), $size = '96', $default = '', $alt = '', $args = array( 'class' => 'rounded-full border-gray-300 shadow-md px-1 mx-auto' ) ); ?>
                        <div>
                            <h3 class="text-xl font-display"><?php echo esc_attr($company); ?></h3>
                            <h4 class="italic"><?php echo esc_attr($position); ?></h4>
                        </div>
                    </div>
                    <ul class="nav mb-3 flex-col justfy-center items-center justify-center w-full divide-y border-y" id="nav-tab" role="tablist">
                        <a class="nav-link w-full font-semibold aria-selected:!bg-golden-grass-500 aria-selected:!text-white text-golden-grass-950 active" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
                        <a class="nav-link w-full font-semibold aria-selected:!bg-golden-grass-500 aria-selected:!text-white text-golden-grass-950" id="nav-account-tab" data-bs-toggle="tab" href="#nav-account" type="button" role="tab" aria-controls="nav-account" aria-selected="false">Account</a>
                        <a class="nav-link w-full font-semibold aria-selected:!bg-golden-grass-500 aria-selected:!text-white text-golden-grass-950" id="nav-booking-tab" data-bs-toggle="tab" href="#nav-booking" type="button" role="tab" aria-controls="nav-booking" aria-selected="false">Bookings</a>
                    </ul>
                    <a class="nav-link w-full text-center text-red-800 mt-8 border-t py-4" id="nav-logout-tab" href="<?php echo wp_logout_url(home_url('/my-account/')); ?>">Logout</a>
                </div>
            </div>
            <div class="col-span-2 tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <?php echo do_shortcode('[user_profile]');?>
                </div>
                <div class="tab-pane fade" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab" tabindex="1">
                    <?php echo do_shortcode('[account_details]');?>
                </div>
                <div class="tab-pane fade" id="nav-booking" role="tabpanel" aria-labelledby="nav-booking-tab" tabindex="2">
                    <?php echo do_shortcode('[user_bookings]');?>
                </div>
            </div>
        </div>
        
    <?php endif;?>
</main>
<script>
    const icon = document.getElementById('togglePassword');
    let password = document.getElementById('password');

    // const confirmIcon = document.getElementById('toggleConfirmPassword');
    let confirmPassword = document.getElementById('confirm_password');

    /* Event fired when <i> is clicked */
    icon.addEventListener('click', function() {
        if(password.type === "password") {
            password.type = "text";
            icon.classList.add("fa-eye-slash");
            icon.classList.remove("fa-eye");
        }
        else {
            password.type = "password";
            icon.classList.add("fa-eye");
            icon.classList.remove("fa-eye-slash");
        }
    });

    // confirmIcon.addEventListener('click', function() {
    //     if(confirmPassword.type === "password") {
    //         confirmPassword.type = "text";
    //         icon.classList.add("fa-eye-slash");
    //         icon.classList.remove("fa-eye");
    //     }
    //     else {
    //         confirmPassword.type = "password";
    //         icon.classList.add("fa-eye");
    //         icon.classList.remove("fa-eye-slash");
    //     }
    // });
    jQuery(document).ready(function($) {
        $('#password').on('keyup', function() {
            var strength = wp.passwordStrength.meter($('#password').val(), wp.passwordStrength.userInputBlacklist(), $('#user_login').val());

            var statusText = '';
            switch (strength) {
                case 2:
                    statusText = 'Weak';
                    break;
                case 3:
                    statusText = 'Medium';
                    break;
                case 4:
                    statusText = 'Strong';
                    break;
                default:
                    statusText = 'Very Weak';
            }
            $('#password-strength-status').text(statusText);
        });
        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#confirm_password_message').html('Matching').css('color', 'green');
            } else 
                $('#confirm_password_message').html('Not Matching').css('color', 'red');
            });
        });
        
</script>
<?php get_footer(); ?>