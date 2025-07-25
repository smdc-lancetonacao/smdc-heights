<?php
/*
     Template Name: Terms and Conditions Page
 */
get_header();
?>

<main class="terms-and-conditions-page">
    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>