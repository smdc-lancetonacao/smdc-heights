<?php
// Register Custom Post Type
function register_good_life_post_type()
{
    $labels = array(
        'name'               => 'Highlights and Happenings',
        'singular_name'      => 'Highlight',
        'menu_name'          => 'Highlights',
        'name_admin_bar'     => 'Highlight',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Highlight',
        'new_item'           => 'New Highlight',
        'edit_item'          => 'Edit Highlight',
        'view_item'          => 'View Highlight',
        'all_items'          => 'All Highlights',
        'search_items'       => 'Search Highlights',
        'not_found'          => 'No highlights found.',
        'not_found_in_trash' => 'No highlights found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'highlights-and-happenings'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('highlights', $args);
}
add_action('init', 'register_good_life_post_type');

// Register Custom Taxonomy
function register_good_life_categories()
{
    $labels = array(
        'name'              => 'Categories',
        'singular_name'     => 'Category',
        'search_items'      => 'Search Categories',
        'all_items'         => 'All Categories',
        'parent_item'       => 'Parent Category',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Categories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'highlight-category'),
    );

    register_taxonomy('highlight_category', array('highlights'), $args);

    // Optional: Insert default categories
    $default_categories = array('Events', 'In The News', 'Press Release');
    foreach ($default_categories as $cat) {
        if (!term_exists($cat, 'highlight_category')) {
            wp_insert_term($cat, 'highlight_category');
        }
    }
}
add_action('init', 'register_good_life_categories');

// Add Meta Boxes
function good_life_add_meta_boxes()
{
    add_meta_box('highlight_details', 'Highlight Details', 'good_life_render_meta_box', 'highlights', 'normal', 'high');
}
add_action('add_meta_boxes', 'good_life_add_meta_boxes');

// Render Meta Box
function good_life_render_meta_box($post)
{
    wp_nonce_field('good_life_save_meta_box', 'good_life_meta_box_nonce');

    $subtitle       = get_post_meta($post->ID, '_highlight_subtitle', true);
    $sub_description = get_post_meta($post->ID, '_highlight_sub_description', true);
    $news_content   = get_post_meta($post->ID, '_highlight_news', true);
    $news_image     = get_post_meta($post->ID, '_highlight_news_image', true);
    $gallery_ids    = get_post_meta($post->ID, '_highlight_gallery_images', true);
    $is_featured    = get_post_meta($post->ID, '_highlight_featured', true);
    ?>

    <p>
        <label><strong>Subtitle:</strong></label><br />
        <input type="text" name="highlight_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width: 100%;" />
    </p>

    <p>
        <label><strong>Headline:</strong></label><br />
        <input type="text" name="highlight_sub_description" value="<?php echo esc_attr($sub_description); ?>" style="width: 100%;" />
    </p>

    <p>
        <label><strong>The News:</strong></label><br />
        <textarea name="highlight_news" rows="5" style="width: 100%;"><?php echo esc_textarea($news_content); ?></textarea>
    </p>

    <p>
        <label><strong>News Image (Hero Banner):</strong></label><br />
        <input type="text" name="highlight_news_image" id="highlight_news_image" value="<?php echo esc_url($news_image); ?>" style="width: 80%;" />
        <input type="button" class="button" id="upload_image_button" value="Upload Image" />
    </p>

    <div id="news_image_preview" style="margin-top: 10px;">
        <?php if ($news_image): ?>
            <img src="<?php echo esc_url($news_image); ?>" alt="News Image Preview" style="max-width: 300px; height: auto;" />
        <?php endif; ?>
    </div>

    <!-- ✅ Multiple Image Gallery Field -->
    <p>
        <label><strong>Gallery Images:</strong></label><br />
        <input type="hidden" name="highlight_gallery_images" id="highlight_gallery_images" value="<?php echo esc_attr($gallery_ids); ?>" />
        <input type="button" class="button" id="upload_gallery_button" value="Upload Images" />
    </p>

    <div id="gallery_preview" style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px;">
        <?php
        if (!empty($gallery_ids)) {
            $ids = explode(',', $gallery_ids);
            foreach ($ids as $image_id) {
                $img_url = wp_get_attachment_url($image_id);
                if ($img_url) {
                    echo '<img src="' . esc_url($img_url) . '" style="max-width: 100px; height: auto;">';
                }
            }
        }
        ?>
    </div>

    <p>
        <label>
            <input type="checkbox" name="highlight_featured" <?php checked($is_featured, 'on'); ?> />
            Include in Featured News on Homepage
        </label>
    </p>

    <script>
        jQuery(document).ready(function ($) {
            // Hero Image
            $('#upload_image_button').click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    multiple: false
                }).open()
                    .on('select', function () {
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        $('#highlight_news_image').val(image_url);
                    });
            });

            // Gallery Images
            $('#upload_gallery_button').click(function (e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Select or Upload Gallery Images',
                    button: {
                        text: 'Use these images'
                    },
                    multiple: true
                });

                frame.on('select', function () {
                    var attachment_ids = [];
                    var previewHTML = '';
                    var attachments = frame.state().get('selection');

                    attachments.each(function (attachment) {
                        attachment = attachment.toJSON();
                        attachment_ids.push(attachment.id);
                        previewHTML += '<img src="' + attachment.url + '" style="max-width: 100px; height: auto; margin-right: 10px;">';
                    });

                    $('#highlight_gallery_images').val(attachment_ids.join(','));
                    $('#gallery_preview').html(previewHTML);
                });

                frame.open();
            });
        });
    </script>
<?php
}

// Save Meta Fields
function good_life_save_meta_box($post_id)
{
    if (!isset($_POST['good_life_meta_box_nonce']) || !wp_verify_nonce($_POST['good_life_meta_box_nonce'], 'good_life_save_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, '_highlight_subtitle', sanitize_text_field($_POST['highlight_subtitle'] ?? ''));
    update_post_meta($post_id, '_highlight_sub_description', sanitize_text_field($_POST['highlight_sub_description'] ?? ''));
    update_post_meta($post_id, '_highlight_news', wp_kses_post($_POST['highlight_news'] ?? ''));
    update_post_meta($post_id, '_highlight_news_image', esc_url_raw($_POST['highlight_news_image'] ?? ''));
    update_post_meta($post_id, '_highlight_gallery_images', sanitize_text_field($_POST['highlight_gallery_images'] ?? ''));
    update_post_meta($post_id, '_highlight_featured', isset($_POST['highlight_featured']) ? 'on' : 'off');
}
add_action('save_post', 'good_life_save_meta_box');