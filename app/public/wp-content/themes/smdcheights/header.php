<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'textdomain'); ?></a>

    <?php
    // Display the custom header menu
    display_custom_header_menu();
    ?>

    <div id="content" class="site-content">
        <?php
        // You can add additional header content here if needed
        ?>
    </div>

<?php
/**
 * Instructions for use:
 * 
 * 1. Copy the PHP code from the first artifact to your theme's functions.php file
 * 
 * 2. Create a 'css' folder in your theme directory and save the CSS code as 'custom-menu.css'
 * 
 * 3. Create a 'js' folder in your theme directory and save the JavaScript code as 'custom-menu.js'
 * 
 * 4. Replace your existing header.php with this template, or integrate the display_custom_header_menu() function call into your existing header
 * 
 * 5. Create an 'images' folder in your theme directory with the following structure:
 *    - images/heights-white.png (white logo for header)
 *    - images/heights-blue.png (blue logo for sidebar)
 *    - images/icons/close.svg (close button icon)
 *    - images/icons/facebook.svg
 *    - images/icons/twitter-x.svg
 *    - images/icons/instagram.svg
 *    - images/icons/youtube.svg
 *    - images/icons/tiktok.svg
 *    - images/icons/linkedin.svg
 * 
 * 6. Go to WordPress Admin > Appearance > Menus
 *    - Create a new menu and assign it to "Sidebar Menu" location
 *    - Add your menu items (About Us, Properties, News, etc.)
 * 
 * 7. Go to WordPress Admin > Appearance > Customize
 *    - Configure your social media links in the "Social Media Links" section
 *    - Set your contact information in the "Contact Information" section
 *    - Upload your logos in the "Site Identity" section
 * 
 * 8. The menu will be responsive and include:
 *    - Slide-out sidebar navigation
 *    - Social media integration
 *    - Contact information display
 *    - Smooth animations and transitions
 *    - Accessibility features (keyboard navigation, ARIA attributes)
 *    - Touch/swipe support for mobile devices
 * 
 * Additional Features:
 * - Customizable through WordPress Customizer
 * - SEO-friendly markup
 * - Accessibility compliant
 * - Mobile-responsive design
 * - Smooth scrolling for anchor links
 * - Overlay background when sidebar is open
 * - Prevention of body scroll when sidebar is active
 */
?>