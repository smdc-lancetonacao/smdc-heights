<?php
/*
     Template Name: Privacy Policy Page
 */
get_header();
?>

<main class="privacy-policy-page">
    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>