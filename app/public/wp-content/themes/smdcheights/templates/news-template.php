<?php
/*
     Template Name: News Page
 */
get_header();
?>

<main class="news-page">
    <?php get_template_part('templates/news-module/news-hero'); ?>
    <?php get_template_part('templates/news-module/newsp-section'); ?>
</main>

<?php get_footer(); ?>