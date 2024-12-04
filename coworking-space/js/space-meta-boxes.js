/* gallery.js */
jQuery(document).ready(function($) {
    var meta_image_frame;

    $('.upload_image_button').click(function(e) {
        e.preventDefault();

        var $button = $(this);
        var $inputField = $button.prev('.image-text-image-field');

        if (meta_image_frame) {
            meta_image_frame.open();
            return;
        }

        meta_image_frame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });

        meta_image_frame.on('select', function() {
            var attachment = meta_image_frame.state().get('selection').first().toJSON();
            $inputField.val(attachment.id);
            $button.after('<img src="' + attachment.url + '" style="max-width:100px;"/>');
        });

        meta_image_frame.on('close', function() {
            meta_image_frame.detach(); // Detach the frame to avoid issues with reopening
        });

        meta_image_frame.open();
    });
});

jQuery(document).ready(function($) {
    function openMediaWindow(inputField, imagePreviewContainer) {
        var mediaFrame = wp.media({
            title: "Select or Upload Image",
            button: {
                text: "Use this image"
            },
            multiple: false
        });

        mediaFrame.on("select", function() {
            var attachment = mediaFrame.state().get("selection").first().toJSON();
            inputField.val(attachment.id);
            imagePreviewContainer.html("<img src=\"" + attachment.url + "\" style=\"max-width:100px;\"/>" +
                "<button class=\'remove_image_button button\'>Remove Image</button>");
        });

        mediaFrame.open();
    }

    $("#image-text-pairs-wrapper").on("click", ".upload_image_button", function(e) {
        e.preventDefault();
        var inputField = $(this).prev(".image-text-image-field");
        var imagePreviewContainer = $(this).next(".image-preview-container");
        openMediaWindow(inputField, imagePreviewContainer);
    });

    $("#image-text-pairs-wrapper").on("click", ".remove_pair_button", function(e) {
        e.preventDefault();
        $(this).closest(".image-text-pair").remove();
    });

    $("#image-text-pairs-wrapper").on("click", ".remove_image_button", function(e) {
        e.preventDefault();
        $(this).closest(".image-preview-wrapper").remove();
        $(this).prev(".image-text-image-field").val("");
    });

    $("#add_pair_button").on("click", function(e) {
        e.preventDefault();
        var pairHTML = `<div class="image-text-pair">
            <input type="hidden" name="image_text_image[]" value="" class="image-text-image-field">
            <button class="upload_image_button button">Select Image</button>
            <div class="image-preview-container"></div>
            <input type="text" name="image_text_text[]" value="" placeholder="Enter text" class="image-text-text-field">
            <button class="remove_pair_button button">Remove</button>
        </div>`;
        $("#image-text-pairs-wrapper").append(pairHTML);
    });
});
