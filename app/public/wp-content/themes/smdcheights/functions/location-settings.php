<?php
// 1. Register Custom Post Type: Location
add_action('init', 'register_location_cpt');
function register_location_cpt() {
    register_post_type('location', [
        'labels' => [
            'name' => 'Locations',
            'singular_name' => 'Location',
            'add_new' => 'Add New Location',
            'add_new_item' => 'Add New Location',
            'edit_item' => 'Edit Location',
            'new_item' => 'New Location',
            'view_item' => 'View Location',
            'search_items' => 'Search Locations',
            'not_found' => 'No locations found',
            'not_found_in_trash' => 'No locations found in Trash',
        ],
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => ['title', 'thumbnail'],
        'rewrite' => ['slug' => 'locations'],
        'show_in_rest' => true, // for block editor support
    ]);
}

// 2. Add Thumbnail Support for 'location'
add_action('after_setup_theme', 'add_location_thumbnail_support');
function add_location_thumbnail_support() {
    add_theme_support('post-thumbnails', ['location']);
}

// Register a custom taxonomy for Location
add_action('init', function() {
    register_taxonomy('location_category', 'location', [
        'labels' => [
            'name' => 'Location Categories',
            'singular_name' => 'Location Category',
            'search_items' => 'Search Location Categories',
            'all_items' => 'All Location Categories',
            'edit_item' => 'Edit Location Category',
            'update_item' => 'Update Location Category',
            'add_new_item' => 'Add New Location Category',
            'new_item_name' => 'New Location Category Name',
            'menu_name' => 'Location Categories',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => ['slug' => 'location-category'],
        'show_in_rest' => true,
    ]);
});

// 3. Shortcode to Display Locations in a Grid
add_shortcode('locations_grid', 'display_all_locations');
function display_all_locations() {
    $args = [
        'post_type' => 'location',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ];
    $locations = new WP_Query($args);

    if (!$locations->have_posts()) {
        return '<p>No locations found.</p>';
    }

    ob_start();
    ?>
    <style>
        .locations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .location-card {
            text-align: center;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
        }
        .location-card:hover {
            transform: translateY(-4px);
        }
        .location-card img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }
        .location-name {
            margin-top: 12px;
            font-weight: 600;
            font-size: 1.1em;
        }
        .location-taxonomies {
            margin-top: 8px;
            font-size: 0.9em;
            color: #666;
        }
        .location-taxonomy {
            display: inline-block;
            background-color: #f1f1f1;
            border-radius: 4px;
            padding: 4px 8px;
            margin: 0 4px;
        }
    </style>
    <div class="locations-grid">
        <?php while ($locations->have_posts()): $locations->the_post(); ?>
            <div class="location-card">
                <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>
                <div class="location-name"><?php the_title(); ?></div>
                <?php
                $terms = get_the_terms(get_the_ID(), 'location_category');
                if ($terms && !is_wp_error($terms)) {
                    echo '<div class="location-taxonomies">';
                    foreach ($terms as $term) {
                        echo '<span class="location-taxonomy">' . esc_html($term->name) . '</span> ';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}