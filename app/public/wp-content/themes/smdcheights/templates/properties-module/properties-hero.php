<?php
if (have_rows('properties_hero_section')):
    while (have_rows('properties_hero_section')) : the_row();
        $hero_image = get_sub_field('properties_hero_image'); // Could be a URL or file object
        $image_url = is_array($hero_image) ? $hero_image['url'] : $hero_image;

        $hero_title = get_sub_field('properties_hero_title');
?>
        <section class="hero-video-section" loading="lazy">
            <img class="hero-image" src="<?php echo esc_url($image_url); ?>" alt="City">
            <div class="hero-overlay">
                <?php if ($hero_title): ?>
                    <h1 class="hero-subtitle"><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
            </div>
        </section>
<?php
    endwhile;
endif;
?>