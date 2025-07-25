<?php
/*
     Template Name: Properties Page
 */
get_header();
?>

<main class="news-page">
    <?php get_template_part('templates/properties-module/properties-hero'); ?>
    <?php get_template_part('templates/properties-module/projects-section'); ?>
    <?php get_template_part('templates/reusable-module/quote-section'); ?>
</main>

<?php get_footer(); ?>