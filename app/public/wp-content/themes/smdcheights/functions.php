<?php
require_once get_template_directory() . '/functions/news-settings.php';
require_once get_template_directory() . '/functions/property-settings.php';
require_once get_template_directory() . '/functions/navigation-settings.php';
require_once get_template_directory() . '/functions/social-links.php';
require_once get_template_directory() . '/functions/logo-settings.php';
require_once get_template_directory() . '/functions/swiper-settings.php';
require_once get_template_directory() . '/functions/location-settings.php';
require_once get_template_directory() . '/functions/breadcrumbs-settings.php';
require_once get_template_directory() . '/functions/quote-settings.php';
require_once get_template_directory() . '/functions/quote-table-class.php';


// Register navigation menus
function register_custom_menus()
{
    register_nav_menus(array(
        'sidebar_menu' => 'Sidebar Menu',
        'primary_menu' => 'Primary Menu',
        'footer_menu' => 'Tertiary Menu',
    ));
}
add_action('after_setup_theme', 'register_custom_menus');

// all css on the assets
// function enqueue_all_styles() {
//     $theme_dir = get_template_directory_uri();
//     $style_dir = get_template_directory() . '/assets/css/';

//     // Check if directory exists
//     if (is_dir($style_dir)) {
//         foreach (glob($style_dir . '*.css') as $file) {
//             $filename = basename($file);
//             wp_enqueue_style("custom-$filename", $theme_dir . "/assets/css/$filename", array(), filemtime($file));
//         }
//     }
// }
// add_action('wp_enqueue_scripts', 'enqueue_all_styles');

// Enqueue all JS files from assets/js/
// function enqueue_all_scripts() {
//     $theme_dir = get_template_directory_uri();
//     $script_dir = get_template_directory() . '/assets/js/';

//     if (is_dir($script_dir)) {
//         foreach (glob($script_dir . '*.js') as $file) {
//             $filename = basename($file);
//             wp_enqueue_script("custom-$filename", $theme_dir . "/assets/js/$filename", array('jquery'), filemtime($file), true);
//         }
//     }
// }
// add_action('wp_enqueue_scripts', 'enqueue_all_scripts');

// Enqueue scripts and styles
function enqueue_custom_menu_assets()
{
    wp_enqueue_style('index-style', get_template_directory_uri() . '/assets/css/hero.css', array(), '1.0.0');
    wp_enqueue_style('header-menu-style', get_template_directory_uri() . '/assets/css/header.css', array(), '1.0.0');
    wp_enqueue_style('avp-section-style', get_template_directory_uri() . '/assets/css/avp-section.css', array(), '1.0.0');
    wp_enqueue_style('map-section-style', get_template_directory_uri() . '/assets/css/map-section.css', array(), '1.0.0');
    wp_enqueue_style('featured-section-style', get_template_directory_uri() . '/assets/css/featured-section.css', array(), '1.0.0');
    wp_enqueue_style('single-property-style', get_template_directory_uri() . '/assets/css/single-property.css', array(), '1.0.0');
    wp_enqueue_style('news-section-style', get_template_directory_uri() . '/assets/css/news-section.css', array(), '1.0.0');
    wp_enqueue_style('newsp-section-style', get_template_directory_uri() . '/assets/css/newsp-section.css', array(), '1.0.0');
    wp_enqueue_style('get-quote-style', get_template_directory_uri() . '/assets/css/get-a-quote.css', array(), '1.0.0');
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/css/footer.css', array(), '1.0.0');

    wp_enqueue_style('single-property-style', get_template_directory_uri() . '/assets/css/single-property.css', array(), '1.0.0');
    wp_enqueue_style('sp-hero-section-style', get_template_directory_uri() . '/assets/css/single-property/sp-hero-section.css', array(), '1.0.0');
    wp_enqueue_style('sp-info-section-style', get_template_directory_uri() . '/assets/css/single-property/sp-info-section.css', array(), '1.0.0');
    wp_enqueue_style('sp-location-map-style', get_template_directory_uri() . '/assets/css/single-property/sp-location-map-section.css', array(), '1.0.0');
    wp_enqueue_style('sp-frontage-style', get_template_directory_uri() . '/assets/css/single-property/sp-frontage-section.css', array(), '1.0.0');
    wp_enqueue_style('sp-living-space-style', get_template_directory_uri() . '/assets/css/single-property/sp-living-space-section.css', array(), '1.0.0');
    wp_enqueue_style('sp-amenities-style', get_template_directory_uri() . '/assets/css/single-property/sp-amenities-section.css', array(), '1.0.0');

    wp_enqueue_style('sn-hero-style', get_template_directory_uri() . '/assets/css/single-news/sn-hero.css', array(), '1.0.0');

    wp_enqueue_style('properties-section-style', get_template_directory_uri() . '/assets/css/properties-section.css', array(), '1.0.0');
    wp_enqueue_style('entrance-animation-style', get_template_directory_uri() . '/assets/css/entrance-animation.css', array(), '1.0.0');

    wp_enqueue_script('header-menu-script', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('quote-form-script', get_template_directory_uri() . '/assets/js/quote-form.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('navbar-scroll', get_template_directory_uri() . '/assets/js/navbar-scroll.js', array(), '1.0.0', true);
    wp_enqueue_script('frontage-carousel-script', get_template_directory_uri() . '/assets/js/frontage-carousel.js', array(), '1.0.0', true);
    wp_enqueue_script('bedroom-carousel-script', get_template_directory_uri() . '/assets/js/bedroom-carousel.js', array(), '1.0.0', true);


    // Localize script for AJAX
    wp_localize_script('custom-menu-script', 'propertySearchAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('property_search_nonce')
    ));

    wp_localize_script('quote-form-script', 'quoteForm', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('quote_form_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_menu_assets');

// Custom walker class for sidebar menu
class Custom_Sidebar_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="menu-item ' . esc_attr($class_names) . '"' : ' class="menu-item"';
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names . '>';
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}

// Function to display social media icons
function display_social_icons()
{
    $social_icons = array(
        'facebook' => get_theme_mod('facebook_url', '#'),
        'twitter-x' => get_theme_mod('twitter_url', '#'),
        'instagram' => get_theme_mod('instagram_url', '#'),
        'youtube' => get_theme_mod('youtube_url', '#'),
        'tiktok' => get_theme_mod('tiktok_url', '#'),
        'linkedin' => get_theme_mod('linkedin_url', '#')
    );

    $output = '<div class="social-icon-container">';
    foreach ($social_icons as $icon => $url) {
        if (!empty($url) && $url !== '#') {
            $output .= '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">';
            $output .= '<img class="social-icon" src="' . get_template_directory_uri() . '/assets/images/icons/' . $icon . '.svg" alt="' . ucfirst($icon) . ' Logo" />';
            $output .= '</a>';
        }
    }
    $output .= '</div>';
    return $output;
}

// Add customizer options for social media URLs and contact info
function custom_menu_customizer($wp_customize)
{
    // Social Media Section
    $wp_customize->add_section('social_media_section', array(
        'title' => 'Social Media Links',
        'priority' => 30,
    ));

    // Social Media Settings
    $social_platforms = array('facebook', 'twitter', 'instagram', 'youtube', 'tiktok', 'linkedin');
    foreach ($social_platforms as $platform) {
        $wp_customize->add_setting($platform . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($platform . '_url', array(
            'label' => ucfirst($platform) . ' URL',
            'section' => 'social_media_section',
            'type' => 'url',
        ));
    }

    // Contact Information Section
    $wp_customize->add_section('contact_info_section', array(
        'title' => 'Contact Information',
        'priority' => 31,
    ));

    $wp_customize->add_setting('contact_phone_1', array(
        'default' => '+63 2 8888 SMDC (7632)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone_1', array(
        'label' => 'Phone Number 1',
        'section' => 'contact_info_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_phone_2', array(
        'default' => '+63 917 123 4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone_2', array(
        'label' => 'Phone Number 2',
        'section' => 'contact_info_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('contact_email', array(
        'default' => 'heights@smdevelopment.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email', array(
        'label' => 'Email Address',
        'section' => 'contact_info_section',
        'type' => 'email',
    ));

    // Logo Settings
    $wp_customize->add_setting('header_logo_white', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo_white', array(
        'label' => 'Header Logo (White)',
        'section' => 'title_tagline',
        'settings' => 'header_logo_white',
    )));

    $wp_customize->add_setting('sidebar_logo_blue', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'sidebar_logo_blue', array(
        'label' => 'Sidebar Logo (Blue)',
        'section' => 'title_tagline',
        'settings' => 'sidebar_logo_blue',
    )));
}
add_action('customize_register', 'custom_menu_customizer');

// AJAX handler for properties search
function handle_property_search()
{
    check_ajax_referer('property_search_nonce', 'nonce');

    $search_query = sanitize_text_field($_POST['search_query']);
    $results = array();

    if (strlen($search_query) >= 2) {
        // Search in custom post type 'property'
        $args = array(
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            's' => $search_query,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => '_property_location',
                    'value' => $search_query,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'project_property',
                    'value' => $search_query,
                    'compare' => 'LIKE'
                )
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $location = get_post_meta(get_the_ID(), '_property_location', true);
                $property = get_post_meta(get_the_ID(), 'project_property', true);

                $results[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'location' => $location,
                    'property' => $property,
                    'url' => get_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
                );
            }
            wp_reset_postdata();
        }
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_property_search', 'handle_property_search');
add_action('wp_ajax_nopriv_property_search', 'handle_property_search');

// Template function to display the header menu
function display_custom_header_menu()
{
    $header_logo = get_theme_mod('header_logo_white', get_template_directory_uri() . '/assets/images/smdc-heights-icon-white.png');
    $sidebar_logo = get_theme_mod('sidebar_logo_blue', get_template_directory_uri() . '/assets/images/smdc-heights-icon-white.png');
?>
    <!-- Sidebar Menu -->
    <div class="sidebar" id="sidebar">
        <button class="close-btn" id="closeBtn">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/close.svg" alt="Close" />
        </button>
        <div class="sidebar-menu">
            <ul>
                <img class="menu-icon" src="<?php echo esc_url($sidebar_logo); ?>" alt="Heights Logo" />
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'sidebar_menu',
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'walker' => new Custom_Sidebar_Walker(),
                    'fallback_cb' => false
                ));
                ?>
            </ul>
            <div class="sidebar-extra-items"></div>
            <div class="contact-info">
                <h4>Contact Us</h4>
                <p><?php echo esc_html(get_theme_mod('contact_phone_1', '+63 2 8888 SMDC (7632)')); ?></p>
                <p><?php echo esc_html(get_theme_mod('contact_phone_2', '+63 949 8888 7632')); ?></p>
                <p><?php echo esc_html(get_theme_mod('contact_email', 'heights@smdevelopment.com')); ?></p>
                <?php echo display_social_icons(); ?>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="navbar" id="navbar">
        <div class="logo-header">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url($header_logo); ?>" alt="SMDC Heights Logo">
            </a>
        </div>
        <div class="nav-right">
            <!-- Project Search -->
            <div class="nav-search-wrapper">
                <div class="project-search-container">
                    <form class="project-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-wrapper">
                            <input type="text"
                                class="project-search-input"
                                name="project_search"
                                placeholder="What are you looking for?"
                                autocomplete="off"
                                aria-label="Search for projects">
                            <button type="submit" class="search-submit" aria-label="Search">
                                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div class="search-results-dropdown" id="searchResults" style="display: none;">
                        <div class="search-results-content"></div>
                    </div>
                </div>
            </div>

            <div class="nav-quote-wrapper">
                <button class="get-a-quote">GET A QUOTE</button>
            </div>

            <div class="nav-burger-wrapper">
                <div class="burger" id="burger">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/burger-menu.svg" alt="Menu" />
                </div>
            </div>
        </div>
    </header>

    <script>
        // Localize script data for AJAX
        var propertySearchAjax = {
            ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
            nonce: '<?php echo wp_create_nonce('property_search_nonce'); ?>'
        };
    </script>
<?php
}
?>