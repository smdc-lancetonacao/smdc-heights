<?php
/*
     Template Name: Home Page
 */
get_header();
?>

<main class="home-page">
    <?php get_template_part('templates/home-module/home-hero'); ?>
    <?php get_template_part('templates/home-module/avp-section'); ?>
    <?php get_template_part('templates/home-module/map-section'); ?>
    <?php get_template_part('templates/home-module/featured-section'); ?>
    <?php get_template_part('templates/home-module/news-section'); ?>
    <?php get_template_part('templates/reusable-module/quote-section'); ?>
</main>

<?php get_footer(); ?>