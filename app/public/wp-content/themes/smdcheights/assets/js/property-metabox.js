jQuery(document).ready(function($) {
    let mediaFrame;

    $('.set-property-thumbnail').on('click', function(e) {
        e.preventDefault();

        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        mediaFrame = wp.media({
            title: 'Select Property Thumbnail',
            button: {
                text: 'Select image'
            },
            multiple: false
        });

        mediaFrame.on('select', function() {
            const attachment = mediaFrame.state().get('selection').first().toJSON();

            // ✅ Use full-size image to prevent blurriness
            $('#property-thumbnail-preview').attr('src', attachment.url);

            // ✅ Save selected image as featured image via AJAX
            wp.ajax.post('set_property_featured_image', {
                _ajax_nonce: propertyMetabox.nonce,
                post_id: $('#post_ID').val(),
                thumbnail_id: attachment.id
            }).done(function(response) {
                console.log('Thumbnail updated');
            }).fail(function() {
                alert('Failed to set thumbnail.');
            });
        });

        mediaFrame.open();
    });
});
