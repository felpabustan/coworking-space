<?php get_header();?>

<main class="w-full py-6 md:py-12" role="main">
    <div class="max-w-xl mx-auto md:shadow-lg md:border py-5 rounded-lg">
        <h2 class="text-center text-golden-grass-950 text-2xl mb-3 font-bold font-display">Welcome to Intellidesk Coworking Space!</h2>
        <p class="text-center">To get started, please complete the form below:</p>
        <hr class="my-6"/>
        <div class="w-full md:w-2/3 mx-auto px-8 flex flex-col gap-5">
            <?php echo do_shortcode('[theme_register_form]');?>
            <p class="text-sm text-center">Back to <a class="underline text-golden-grass-600" href="/my-account">Login page</a>.</p>
        </div>
    </div>
</main>
<script>
    const icon = document.getElementById('togglePassword');
    let password = document.getElementById('password');

    const confirmIcon = document.getElementById('toggleConfirmPassword');
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

    confirmIcon.addEventListener('click', function() {
        if(confirmPassword.type === "password") {
            confirmPassword.type = "text";
            confirmIcon.classList.add("fa-eye-slash");
            confirmIcon.classList.remove("fa-eye");
        }
        else {
            confirmPassword.type = "password";
            confirmIcon.classList.add("fa-eye");
            confirmIcon.classList.remove("fa-eye-slash");
        }
    });
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