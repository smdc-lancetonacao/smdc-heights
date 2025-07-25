<?php
// 1. Register Custom Post Type
function register_property_post_type() {
    $labels = array(
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'menu_name'          => 'Properties',
        'name_admin_bar'     => 'Property',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Property',
        'new_item'           => 'New Property',
        'edit_item'          => 'Edit Property',
        'view_item'          => 'View Property',
        'all_items'          => 'All Properties',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found.',
        'not_found_in_trash' => 'No properties found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'properties'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-home',
        'supports'           => array('title', 'thumbnail', 'custom-fields'),
    );

    register_post_type('property', $args);
}
add_action('init', 'register_property_post_type');

function flush_rewrite_rules_on_activation() {
    register_property_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_on_activation');

// 3. Add Metabox for Property Location
add_action('add_meta_boxes', 'add_property_location_metabox');
function add_property_location_metabox() {
    add_meta_box(
        'property_location_metabox',
        'Property Location',
        'render_property_location_metabox',
        'property',
        'side',
        'default'
    );
}

function render_property_location_metabox($post) {
    $selected_location = get_post_meta($post->ID, '_property_location', true);
    $locations = get_posts([
        'post_type' => 'location',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    echo '<label for="property_location_field">Select Location:</label><br />';
    echo '<select name="property_location_field" id="property_location_field" style="width:100%;">';
    echo '<option value="">— Select —</option>';
    foreach ($locations as $location) {
        $selected = ($selected_location == $location->ID) ? 'selected' : '';
        echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
    }
    echo '</select>';
}

// 4. Save the selected location
add_action('save_post', 'save_property_location_metabox');
function save_property_location_metabox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['property_location_field'])) {
        update_post_meta($post_id, '_property_location', sanitize_text_field($_POST['property_location_field']));
    }
}

// 5. Add Metabox for Featured Property and Status
add_action('add_meta_boxes', 'add_featured_property_metabox');
function add_featured_property_metabox() {
    add_meta_box(
        'featured_property_metabox',
        'Featured & Status',
        'render_featured_property_metabox',
        'property',
        'side',
        'default'
    );
}

function render_featured_property_metabox($post) {
    $is_featured = get_post_meta($post->ID, '_property_featured', true);
    $is_preselling = get_post_meta($post->ID, '_property_preselling', true);
    $is_rfo = get_post_meta($post->ID, '_property_rfo', true);
    $is_complete = get_post_meta($post->ID, '_property_complete', true);
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'thumbnail') : '';
    echo '<label><input type="checkbox" name="property_featured" value="1"' . checked($is_featured, '1', false) . '> Featured Property</label><br><br>';
    echo '<strong>Status:</strong><br>';
    echo '<label><input type="checkbox" name="property_preselling" value="1"' . checked($is_preselling, '1', false) . '> Pre-Selling</label><br>';
    echo '<label><input type="checkbox" name="property_rfo" value="1"' . checked($is_rfo, '1', false) . '> Move-in-ready</label><br>';
    echo '<label><input type="checkbox" name="property_complete" value="1"' . checked($is_complete, '1', false) . '> Completed</label><br><br>';
    echo '<strong>Thumbnail:</strong><br>';
    $img_src = $thumbnail_url ? esc_url($thumbnail_url) : get_template_directory_uri() . '/assets/images/placeholder.png';
    echo '<div><img id="property-thumbnail-preview" src="' . $img_src . '" style="width:100%;height:auto;display:block;margin-top:8px;" /></div>';
    echo '<div style="margin-top:8px;">';   
    echo '<button type="button" class="button set-property-thumbnail">Set/Change Thumbnail</button> ';
    echo '</div>';
    echo '<p style="font-size:11px;color:#666;">Use these buttons to set, change, or remove the property thumbnail using the Media Library. This is the same as the Featured Image.</p>';
}

// 6. Save Featured and Status Metabox
add_action('save_post', 'save_featured_property_metabox');
function save_featured_property_metabox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    update_post_meta($post_id, '_property_featured', isset($_POST['property_featured']) ? '1' : '0');
    update_post_meta($post_id, '_property_preselling', isset($_POST['property_preselling']) ? '1' : '0');
    update_post_meta($post_id, '_property_rfo', isset($_POST['property_rfo']) ? '1' : '0');
    update_post_meta($post_id, '_property_complete', isset($_POST['property_complete']) ? '1' : '0');
}

// AJAX handler to set property featured image
add_action('wp_ajax_set_property_featured_image', function() {
    check_ajax_referer('property_metabox_nonce', '_ajax_nonce');
    $post_id = intval($_POST['post_id']);
    $thumbnail_id = intval($_POST['thumbnail_id']);
    if (current_user_can('edit_post', $post_id)) {
        set_post_thumbnail($post_id, $thumbnail_id);
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
});

// AJAX handler to remove property featured image
add_action('wp_ajax_remove_property_featured_image', function() {
    check_ajax_referer('property_metabox_nonce', '_ajax_nonce');
    $post_id = intval($_POST['post_id']);
    if (current_user_can('edit_post', $post_id)) {
        delete_post_thumbnail($post_id);
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
});

// Localize script with nonce and placeholder for AJAX security
add_action('admin_enqueue_scripts', function($hook) {
    global $post;
    if (($hook == 'post.php' || $hook == 'post-new.php') && isset($post) && $post->post_type === 'property') {
        wp_enqueue_media();
        wp_enqueue_script('property-metabox-js', get_template_directory_uri() . '/assets/js/property-metabox.js', array('jquery'), null, true);
        wp_localize_script('property-metabox-js', 'propertyMetabox', array(
            'nonce' => wp_create_nonce('property_metabox_nonce'),
            'placeholder' => get_template_directory_uri() . '/assets/images/placeholder.png'
        ));
    }
});

// Enqueue property metabox JS for admin
// add_action('admin_enqueue_scripts', function($hook) {
//     global $post;
//     if ($hook == 'post.php' || $hook == 'post-new.php') {
//         if (isset($post) && $post->post_type === 'property') {
//             wp_enqueue_media();
//             wp_enqueue_script('property-metabox-js', get_template_directory_uri() . '/assets/js/property-metabox.js', array('jquery'), null, true);
//         }
//     }
// });

?>