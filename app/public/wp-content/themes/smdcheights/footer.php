<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SMDCHeights
 * @since 1.0.0
 */
?>

<footer id="colophon" class="footer-section">
    <div class="footer-container">
        <div class="footer-header">
            <?php
            $sidebar_logo = get_theme_mod('sidebar_logo_blue', get_template_directory_uri() . '/assets/images/smdc-heights-icon-white.png');
            ?>
            <img class="footer-icon" src="<?php echo esc_url($sidebar_logo); ?>" alt="Heights Logo" />
            <div class="footer-contact-info">
                <p><?php echo esc_html(get_theme_mod('contact_phone_1', '+63 2 8888 SMDC (7632)')); ?></p>
                <p class="footer-bullets">•</p>
                <p><?php echo esc_html(get_theme_mod('contact_phone_2', '+63 949 8888 7632')); ?></p>
                <p class="footer-bullets">•</p>
                <p><?php echo esc_html(get_theme_mod('contact_email', 'heights@smdevelopment.com')); ?></p>
            </div>
            <p class="footer-contact-address">
                <?php
                $address = get_theme_mod('office_address', '15th Floor, Two E-com Center, Harbor Drive, Mall of Asia Complex, Brgy. 76 Zone 10, CBP1A, Pasay City 1300 Philippines');
                $address_with_break = str_replace('Brgy.', '<br>Brgy.', $address);
                echo wp_kses_post($address_with_break);
                ?>
            </p>

            <hr class="footer-divider">
        </div>
        <div class="footer-links">
            <div class="footer-email">
                <p>Sign up to receive exclusive information and updates about our promos and properties.</p>
                <input class="footer-email-input" id="footer-email-input" type="email" placeholder="Enter your email address">
                <button class="footer-email-submit">Submit</button>
            </div>
            <div class="footer-menus">
                <ul class="footer-menu-links">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'tertiary',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'walker' => new Custom_Sidebar_Walker(),
                        'fallback_cb' => false
                    ));
                    ?>
                </ul>
            </div>
        </div>
        <div class="footer-info">
            <?php echo display_social_icons(); ?>
            <p>&copy; <?php echo date_i18n('Y'); ?> SMDC. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>