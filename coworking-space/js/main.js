// Function to show toast notifications - Defined outside to make it globally accessible
function showToast(type, message) {

    let color;

    if (type == 'success') {
        color = ['50','950'];
    } else {
        color =['950', '50'];
    }

    var toastHTML = `
        <div class="toast items-center border border-golden-grass-300 bg-golden-grass-${color[0]} text-golden-grass-${color[1]} rounded shadow-sm fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-animation="true">
            <div class="flex px-6 py-4 text-lg">
                <div class="toast-body text-center">
                    ${message}
                </div>
                <button type="button" class="btn-close ms-4 m-auto font-display font-bold" data-bs-dismiss="toast" aria-label="Close">✖</button>
            </div>
        </div>
    `;
    jQuery('#toast-container').append(toastHTML);
    var toastElement = jQuery('#toast-container .toast').last();
    var toast = new bootstrap.Toast(toastElement[0]);
    toast.show();

    // Remove the toast from the DOM after it hides
    toastElement.on('hidden.bs.toast', function () {
        jQuery(this).remove();
    });
}

jQuery(document).ready(function($) {

    function toggleSpinner(form, action = 'show') {
        const spinnerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
        if (action === 'show') {
            $(form).find('.update-spinner').html(spinnerHTML);
        } else {
            $(form).find('.update-spinner').html('');
        }
    }

    $('#booking-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        toggleSpinner(this, 'show'); // Show spinner
        
        $.ajax({
            url: profileUpdateParams.ajaxurl,
            type: 'POST',
            data: $(this).serialize() + '&action=submit_booking',
            success: function(response) {
                toggleSpinner($('#booking-form'), 'hide'); // Hide spinner
                if (response.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    showToast('danger', 'Booking creation failed: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                toggleSpinner($('#booking-form'), 'hide');
                showToast('danger', 'An error occurred: ' + error + ' ' + xhr.responseText);
            }
        });
    });

    $('#inquiry-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        toggleSpinner(this, 'show'); // Show spinner
        
        $.ajax({
            url: profileUpdateParams.ajaxurl,
            type: 'POST',
            data: $(this).serialize() + '&action=submit_inquiry',
            success: function(response) {
                toggleSpinner($('#inquiry-form'), 'hide'); // Hide spinner
                if (response.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    showToast('danger', 'Inquiry creation failed: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                toggleSpinner($('#inquiry-form'), 'hide');
                showToast('danger', 'An error occurred: ' + error + ' ' + xhr.responseText);
            }
        });
    });
    
    

    $('#profile-update-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize(); // Gather all the form data
        toggleSpinner(this, 'show'); // Show spinner

        $.ajax({
            type: 'POST',
            url: profileUpdateParams.ajaxurl,
            data: formData + '&action=update_profile&security=' + profileUpdateParams.profileNonce,
            success: function(response) {
                toggleSpinner($('#profile-update-form'), 'hide'); // Hide spinner
                $('#updating-notice').hide();
                if (response.success) {
                    showToast('success', 'Profile updated successfully.');
                } else {
                    showToast('danger', 'Profile update failed. Please try again.');
                }
            },
            error: function() {
                toggleSpinner( $('#profile-update-form'), 'hide'); // Hide spinner
                $('#updating-notice').hide();
                showToast('danger', 'An error occurred. Please try again.');
            }
        });
    });

    $('#account-update-form').on('submit', function(e) {
        e.preventDefault();
    
        var formData = $(this).serialize(); // Gather all the form data
        toggleSpinner(this, 'show'); // Show spinner
    
        $.ajax({
            type: 'POST',
            url: profileUpdateParams.ajaxurl,
            data: formData + '&action=update_account_details&security=' + profileUpdateParams.accountNonce,
            success: function(response) {
                toggleSpinner( $('#account-update-form'), 'hide'); // Show spinner
                $('#updating-notice').hide(); // Hide updating notice
    
                if (response.success) {
                    showToast('success', response.data.message); // Show success toast
                    
                    // Log the user out and redirect to the login page after a 1.5-second delay
                    setTimeout(function() {
                        window.location.href = profileUpdateParams.logoutUrl; // Use the passed logout URL
                    }, 1500); // 1.5-second delay to allow the user to read the message
                } else {
                    showToast('danger', 'Account update failed. Please try again.'); // Show error toast
                }
            },
            error: function() {
                toggleSpinner( $('#account-update-form'), 'hide'); // Show spinner
                $('#updating-notice').hide(); // Hide updating notice
                showToast('danger', 'An error occurred. Please try again.'); // Show error toast
            }
        });
    });

    $('#reset-password-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        toggleSpinner(this, 'show'); // Show spinner
        
        $('#reset-submit').prop('disabled', true);
    
        $.ajax({
            type: 'POST',
            url: profileUpdateParams.ajaxurl,
            data: formData + '&action=password_reset_trigger&security=' + profileUpdateParams.resetPasswordNonce,
            success: function(response) {
                toggleSpinner($('#reset-password-form'), 'hide'); // Show spinner
                $('#reset-submit').prop('disabled', false);
                if (response.success) {
                    $('#reset-message').html('<div class="text-center text-sm font-display">' + response.data.message + '</div>');
                } else {
                    $('#reset-message').html('<div class="text-red-500 text-center text-sm font-display">' + response.data.message + '</div>');
                }
            },
            error: function() {
                toggleSpinner($('#reset-password-form'), 'hide'); // Show spinner
                $('#reset-submit').prop('disabled', false);
                $('#reset-message').html('<div class="text-red-500 text-center text-sm font-display">An error occurred. Please try again.</div>');
            }
        });
    });
    
    $('.view-booking-details-btn').on('click', function() {
        var bookingId = $(this).data('booking-id');

        $.ajax({
            url: profileUpdateParams.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_booking_details',
                booking_id: bookingId,
                security: profileUpdateParams.bookingDetailsNonce // Add this nonce in your localized script
            },
            success: function(response) {
                if (response.success) {
                    $('#booking-details-content').html(response.data.details);
                    $('#booking-details-modal').modal('show');
                } else {
                    $('#booking-details-content').html('<p>Failed to load details. Please try again.</p>');
                }
            }
        });
    });
    
    
    
});
