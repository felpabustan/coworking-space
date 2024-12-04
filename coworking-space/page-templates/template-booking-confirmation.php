<?php
/* Template Name: Booking Confirmation */

get_header();

// Get query vars
$booking_id = get_query_var('booking_id');
$new_booking = get_query_var('new_booking');
$booking_post = get_post( $booking_id );
$booking = new Booking( $booking_post );
$user = new User(get_user_by('id',$booking->user_id));

$thumbnail_id = get_post_thumbnail_id( $booking->space->ID );
$image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
?>


<main class="container py-16">
    <?php if(!$new_booking):?>
        <a href="/my-account" class="text-xs underline">< Back to profile</a>
        <h1 class="text-3xl text-center font-display font-semibold uppercase mb-6"><?php echo 'Booking #' . $booking->post->ID;?></h1>
    <?php else:?>
        <img src="<?php echo $image_url;?>" class="max-w-full h-auto mx-auto rounded-lg shadow-md mb-6" />
        <h1 class="text-3xl text-center font-display font-semibold uppercase mb-6">Booking Confirmation</h1>
        <p class="text-center">We are pleased to inform you that your booking request has been received. We will send you an email confirmation shortly. Please refer to further instructions to secure your booking.</p>
    <?php endif;?>
    <!-- <h2 class="text-2xl font-display font-bold my-6">Booking Details</h2> -->
    <?php
    // Check if booking ID exists
    if ( $booking_id ) :
        // Check if the booking post exists and is a valid post type (assuming your post type is 'booking')
        if ( $booking_post && $booking_post->post_type === 'booking' ) :
            // Instantiate the Booking class with the post object
           
            
            // Perform the permission check
            if ( $booking->user_id == get_current_user_id() ) : // Use loose comparison
                // Display booking details?>
                <div class="">
                    <h3 class="font-semibold font-display text-xl">Booking Summary</h3>
                    <?php echo '<p>Room: ' . $booking->space->post_title . '</p>';?>
                    <?php echo '<p>Booked date/s: '. $booking->display_selected_dates() .'</p>';?>
                    <?php echo '<p>Booking ID: '. $booking->post->ID .'</p>';?>
                    <?php echo '<p class="capitalize">Status: ' . $booking->booking_status .'</p>';?>
                    <hr class="my-6"/>
                    <h3 class="font-semibold font-display text-xl">Client Details</h3>
                    <?php echo '<p>Name: ' . $user->first_name . ' ' . $user->last_name . '</p>';?>
                    <?php echo '<p>Company Name: ' . $user->company . '</p>';?>
                    <?php echo '<p>Phone: ' . $user->phone . '</p>';?>
                    <?php echo '<p>Email: ' . $user->email . '</p>';?>
                </div>
            <?php else: echo '<p>You do not have permission to view this booking.</p>';?>
                
            <?php endif;?>
        <?php else: echo '<p>Booking not found or invalid booking post type.</p>';?>
            
        <?php endif;?>
    <?php else: echo '<p>Booking not found or invalid ID.</p>';?>
        
    <?php endif;?>
</main>
<?php 
get_footer();