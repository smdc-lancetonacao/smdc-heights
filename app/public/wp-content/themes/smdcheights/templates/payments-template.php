<?php
/*
     Template Name: Payments Page
 */
get_header();
?>

<main class="payments-page">
    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>