<?php
// Add Meta Box
function theme_add_gallery_meta_box() {
    add_meta_box(
        'theme_gallery_meta_box',
        'Gallery',
        'theme_render_gallery_meta_box',
        'space', // Replace with your post type slug
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'theme_add_gallery_meta_box');

function add_image_text_meta_box() {
    add_meta_box(
        'image_text_pairs',                   // Meta box ID
        'Inclusions',                         // Meta box title
        'theme_render_image_text_meta_box',   // Callback function
        'space',                              // Post type slug
        'normal',                             // Context
        'high'                                // Priority
    );
}
add_action('add_meta_boxes', 'add_image_text_meta_box');


// Render Meta Box: Gallery
function theme_render_gallery_meta_box($post) {
    wp_nonce_field('theme_save_gallery_meta_box', 'theme_gallery_meta_box_nonce');

    $gallery_data = get_post_meta($post->ID, '_theme_gallery', true);

    ?>
    <div id="theme-gallery-container">
        <button id="theme-add-image" class="button">Add Image</button>
        <ul id="theme-gallery-list">
            <?php if (!empty($gallery_data)) : ?>
                <?php foreach ($gallery_data as $image_id) : ?>
                    <li>
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <input type="hidden" name="theme_gallery[]" value="<?php echo esc_attr($image_id); ?>">
                        <button class="button theme-remove-image">Remove</button>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var frame;
            $('#theme-add-image').on('click', function(e) {
                e.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: 'Select or Upload Images',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: true
                });

                frame.on('select', function() {
                    var selection = frame.state().get('selection');
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        $('#theme-gallery-list').append(
                            '<li>' +
                            '<img src="' + attachment.sizes.thumbnail.url + '">' +
                            '<input type="hidden" name="theme_gallery[]" value="' + attachment.id + '">' +
                            '<button class="button theme-remove-image">Remove</button>' +
                            '</li>'
                        );
                    });
                });

                frame.open();
            });

            $('#theme-gallery-list').on('click', '.theme-remove-image', function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        });
    </script>
    <?php
}

// Render Meta Box: Image / Text Repeater
function theme_render_image_text_meta_box($post) {
    $image_text_pairs = get_post_meta($post->ID, 'image_text_pairs', true);

    // Add a nonce field for security
    wp_nonce_field('image_text_pairs_nonce', 'image_text_pairs_nonce_field');

    echo '<div id="image-text-pairs-wrapper">';

    if (!empty($image_text_pairs)) {
        foreach ($image_text_pairs as $pair) {
            $image_id = isset($pair['image']) ? $pair['image'] : '';
            $text = isset($pair['text']) ? esc_attr($pair['text']) : '';
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';

            echo '<div class="image-text-pair">';
            echo '<input type="hidden" name="image_text_image[]" value="' . esc_attr($image_id) . '" class="image-text-image-field">';
            echo '<button class="upload_image_button button">Select Image</button>';
            echo '<div class="image-preview-container">';

            if ($image_url) {
                echo '<div class="image-preview-wrapper">';
                echo '<img src="' . esc_url($image_url) . '" style="max-width:100px;"/>';
                echo '<button class="remove_image_button button">Remove Image</button>';
                echo '</div>';
            }

            echo '</div>'; // end .image-preview-container
            echo '<input type="text" name="image_text_text[]" value="' . $text . '" placeholder="Enter text" class="image-text-text-field">';
            echo '<button class="remove_pair_button button">Remove</button>';
            echo '</div>'; // end .image-text-pair
        }
    }

    echo '</div>'; // end #image-text-pairs-wrapper

    echo '<button id="add_pair_button" class="button">Add Pair</button>';
}

// Save Meta Box Data: Gallery
function theme_save_gallery_meta_box($post_id) {
    if (!isset($_POST['theme_gallery_meta_box_nonce']) || !wp_verify_nonce($_POST['theme_gallery_meta_box_nonce'], 'theme_save_gallery_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['theme_gallery'])) {
        update_post_meta($post_id, '_theme_gallery', array_map('sanitize_text_field', $_POST['theme_gallery']));
    } else {
        delete_post_meta($post_id, '_theme_gallery');
    }
}
add_action('save_post', 'theme_save_gallery_meta_box');

// Save Meta Box Data: Image / Text Repeater
function save_image_text_meta_box($post_id) {
    // Verify the nonce for security
    if (!isset($_POST['image_text_pairs_nonce_field']) || !wp_verify_nonce($_POST['image_text_pairs_nonce_field'], 'image_text_pairs_nonce')) {
        return;
    }

    // Avoid autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $image_text_pairs = [];

    if (isset($_POST['image_text_image']) && is_array($_POST['image_text_image'])) {
        foreach ($_POST['image_text_image'] as $index => $image_id) {
            $text = sanitize_text_field($_POST['image_text_text'][$index]);
            $image_text_pairs[] = [
                'image' => intval($image_id),
                'text'  => $text,
            ];
        }
    }

    // Save the data
    update_post_meta($post_id, 'image_text_pairs', $image_text_pairs);
}
add_action('save_post', 'save_image_text_meta_box');

// Styles inject: Image / Text Repeater
function image_text_meta_box_styles() {
    echo '<style>
        .image-text-pair {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .image-text-pair .button {
            margin-right: 10px;
        }
        .image-text-pair input[type="text"] {
            flex: 1;
        }
        .image-text-pair .remove_pair_button {
            margin-left: 10px;
            color: #a00;
        }
        .image-preview-wrapper img {
            max-width: 100px;
            margin-right: 10px;
        }
    </style>';
}
add_action('admin_head', 'image_text_meta_box_styles');

// Files inject: Image / Text Repeater
function theme_enqueue_meta_box_scripts($hook) {
    global $post;
    
    if ($hook === 'post-new.php' || $hook === 'post.php') {
        if ('space' === $post->post_type) { // Replace 'space' with your post type slug
            wp_enqueue_media();
            wp_enqueue_script('theme-gallery-js', get_template_directory_uri() . '/js/space-meta-boxes.js', array('jquery'), null, true);
            wp_enqueue_style('theme-gallery-css', get_template_directory_uri() . '/css/space-meta-boxes.css');
        }
    }
}
add_action('admin_enqueue_scripts', 'theme_enqueue_meta_box_scripts');

function theme_get_gallery($post_id) {
    $gallery_images = get_post_meta($post_id, '_theme_gallery', true); // Retrieve the stored gallery images array
    
    if (!$gallery_images) {
        return []; // Return an empty array if no images are found
    }
    
    $images = [];
    
    foreach ($gallery_images as $image_id) {
        $image_url = wp_get_attachment_image_url($image_id, 'full');
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true); // Get the alt text
        $images[] = [
            'url' => $image_url,
            'alt' => $image_alt ? $image_alt : '',
        ];
    }
    
    return $images;
}


function theme_get_image_text_pairs($post_id) {
    // Retrieve the meta data stored in the '_image_text_pairs' key
    $image_text_pairs = get_post_meta($post_id, 'image_text_pairs', true);

    // Check if the data exists and is an array
    if (!empty($image_text_pairs) && is_array($image_text_pairs)) {
        return $image_text_pairs;
    }

    // Return an empty array if no data is found
    return [];
}

function add_space_details_meta_box() {
    add_meta_box(
        'space_details_meta_box',
        'Space Details',
        'render_space_details_meta_box',
        'space', // Your post type slug
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_space_details_meta_box');

function render_space_details_meta_box($post) {
    // Fetch existing meta values
    $price_type = get_post_meta($post->ID, '_space_rate_type', true);
    $weekday_rate = get_post_meta($post->ID, '_space_price_weekday', true);
    $weekend_rate = get_post_meta($post->ID, '_space_price_weekend', true);
    $halfday_rate = get_post_meta($post->ID, '_space_halfday_rate', true);
    $halfday_rate_weekend = get_post_meta($post->ID, '_space_halfday_rate_weekend', true);
    $monthly_rate = get_post_meta($post->ID, '_space_price_monthly', true);
    $seats = get_post_meta($post->ID, '_space_seats', true);
    $vat_included = get_post_meta($post->ID, '_space_vat_included', true);
    $with_window = get_post_meta($post->ID, '_space_with_window', true);
    $non_bookable = get_post_meta($post->ID, '_space_non_bookable', true);

    ?>
    <div class="space-details">
        <h3>Price</h3>
        <label for="price_type">Price Type</label>
        <select name="price_type" id="price_type">
            <option value="default">Select Price Type</option>
            <option value="daily" <?php selected($price_type, 'daily'); ?>>Daily</option>
            <option value="monthly" <?php selected($price_type, 'monthly'); ?>>Monthly</option>
        </select>

        <div id="daily_prices" style="display: <?php echo ($price_type == 'daily') ? 'block' : 'none'; ?>;">
            <h4>Daily Rates</h4>
            <p><label for="weekday_rate">Weekday Rate</label>
            <input type="text" name="weekday_rate" id="weekday_rate" value="<?php echo esc_attr($weekday_rate); ?>" /></p>

            <p><label for="weekend_rate">Weekend Rate</label>
            <input type="text" name="weekend_rate" id="weekend_rate" value="<?php echo esc_attr($weekend_rate); ?>" /></p>

            <p><label for="halfday_rate">Half Day Rate</label>
            <input type="text" name="halfday_rate" id="halfday_rate" value="<?php echo esc_attr($halfday_rate); ?>" /></p>
            
            <p><label for="halfday_rate_weekend">Half Day Rate Weekend</label>
            <input type="text" name="halfday_rate_weekend" id="halfday_rate_weekend" value="<?php echo esc_attr($halfday_rate_weekend); ?>" /></p>
        </div>

        <div id="monthly_price" style="display: <?php echo ($price_type == 'monthly') ? 'block' : 'none'; ?>;">
            <h4>Monthly Rate</h4>
            <p><label for="monthly_rate">Monthly Rate</label>
            <input type="text" name="monthly_rate" id="monthly_rate" value="<?php echo esc_attr($monthly_rate); ?>" /></p>
        </div>

        <p><input type="checkbox" name="vat_included" id="vat_included" value="1" <?php checked($vat_included, '1'); ?> />
        <label for="vat_included">VAT Included</label></p>

        <h3>Others</h3>
        <p><input type="checkbox" name="with_window" id="with_window" value="1" <?php checked($with_window, '1'); ?> />
        <label for="with_window">with Windows</label></p>

        <p><input type="checkbox" name="non_bookable" id="non_bookable" value="1" <?php checked($non_bookable, '1'); ?> />
        <label for="non_bookable">Non-Bookable</label></p>

        <h3>Seats</h3>
        <p><label for="seats">Seats</label>
        <input type="number" name="seats" id="seats" value="<?php echo esc_attr($seats); ?>" /></p>
    </div>

    <script>
    // Simple JS to toggle daily/monthly fields
    document.getElementById('price_type').addEventListener('change', function() {
        var dailyPrices = document.getElementById('daily_prices');
        var monthlyPrice = document.getElementById('monthly_price');
        
        if (this.value === 'daily') {
            dailyPrices.style.display = 'block';
            monthlyPrice.style.display = 'none';
        } else {
            dailyPrices.style.display = 'none';
            monthlyPrice.style.display = 'block';
        }
    });
    </script>
    <?php
}

function save_space_details_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    if (isset($_POST['price_type'])) {
        update_post_meta($post_id, '_space_rate_type', sanitize_text_field($_POST['price_type']));
    }

    if (isset($_POST['weekday_rate'])) {
        update_post_meta($post_id, '_space_price_weekday', sanitize_text_field($_POST['weekday_rate']));
    }

    if (isset($_POST['weekend_rate'])) {
        update_post_meta($post_id, '_space_price_weekend', sanitize_text_field($_POST['weekend_rate']));
    }

    if (isset($_POST['halfday_rate'])) {
        update_post_meta($post_id, '_space_halfday_rate', sanitize_text_field($_POST['halfday_rate']));
    }

    if (isset($_POST['halfday_rate_weekend'])) {
        update_post_meta($post_id, '_space_halfday_rate_weekend', sanitize_text_field($_POST['halfday_rate']));
    }

    if (isset($_POST['monthly_rate'])) {
        update_post_meta($post_id, '_space_price_monthly', sanitize_text_field($_POST['monthly_rate']));
    }

    if (isset($_POST['seats'])) {
        update_post_meta($post_id, '_space_seats', intval($_POST['seats']));
    }

    $vat_included = isset($_POST['vat_included']) ? '1' : '';
    update_post_meta($post_id, '_space_vat_included', $vat_included);

    $non_bookable = isset($_POST['non_bookable']) ? '1' : '';
    update_post_meta($post_id, '_space_non_bookable', $non_bookable);

    $with_window = isset($_POST['with_window']) ? '1' : '';
    update_post_meta($post_id, '_space_with_window', $with_window);
}
add_action('save_post', 'save_space_details_meta_box');
