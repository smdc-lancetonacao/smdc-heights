<?php
if (have_rows('news_hero_section')):
    while (have_rows('news_hero_section')) : the_row();
        $news_hero_image = get_sub_field('news_hero_image'); // Could be a URL or file object
        $news_image_url = is_array($news_hero_image) ? $news_hero_image['url'] : $news_hero_image;
?>
        <section class="hero-video-section" loading="lazy" style="position: relative; overflow: hidden;">
            <img class="hero-image" src="<?php echo esc_url($news_image_url); ?>" alt="Buildings">
        </section>
<?php
    endwhile;
endif;
?>