<?php
// File: /functions/quote-settings.php

// Register Custom Post Type equivalent - we'll use custom DB table instead
add_action('init', function () {
    global $wpdb;
    $table = $wpdb->prefix . 'quote_requests';

    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(100),
        message text,
        property varchar(255),
        country varchar(255),
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
});

// Enqueue AJAX and Modal assets
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('quote-form-script', get_template_directory_uri() . '/assets/js/quote-form.js', array('jquery'), '1.0.0', true);
    wp_localize_script('quote-form-script', 'quoteForm', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('quote_form_nonce')
    ]);

    wp_enqueue_style('quote-form-style', get_template_directory_uri() . '/css/quote-form.css');
});

// Handle AJAX Submission
add_action('wp_ajax_submit_quote_form', 'handle_quote_submission');
add_action('wp_ajax_nopriv_submit_quote_form', 'handle_quote_submission');

function handle_quote_submission()
{
    global $wpdb;
    $table = $wpdb->prefix . 'quote_requests';

    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name = sanitize_text_field($_POST['last_name'] ?? '');
    $email = sanitize_email($_POST['email_address'] ?? '');
    $phone = sanitize_text_field($_POST['contact_number'] ?? '');
    $property = sanitize_text_field($_POST['property_interest'] ?? '');
    $country = sanitize_text_field($_POST['country'] ?? '');

    if (empty($first_name) || empty($last_name) || empty($email)) {
        wp_send_json_error('Missing required fields.');
    }

    $name = trim("$first_name $last_name");

    $wpdb->insert($table, [
        'name'     => $name,
        'email'    => $email,
        'phone'    => $phone,
        'property' => $property,
        'country'  => $country,
        'message'  => ''
    ]);

    wp_send_json_success(['message' => 'Submission successful']);
}

// Shortcode to render the Get a Quote Form
add_shortcode('get_a_quote_form', function () {
    ob_start();
?>
    <form id="quote-form">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <input type="text" name="phone" placeholder="Contact Number" />
        <input type="text" name="property" placeholder="Property of Interest" />
        <input type="text" name="country" placeholder="Country" />
        <textarea name="message" placeholder="Message..."></textarea>
        <button type="submit">Get a Quote</button>
    </form>

    <div id="quote-success-modal" style="display:none">
        <div class="modal-content">
            <h2>Thank You!</h2>
            <p>Your quote request has been received.</p>
            <script>
                fbq && fbq('track', 'Lead');
            </script>
        </div>
    </div>
<?php
    return ob_get_clean();
});
