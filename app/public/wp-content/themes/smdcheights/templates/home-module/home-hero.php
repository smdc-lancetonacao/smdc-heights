<?php
if (have_rows('hero_section')):
    while (have_rows('hero_section')) : the_row();
        $hero_video = get_sub_field('hero_video'); // Could be a URL or file object
        $video_url = is_array($hero_video) ? $hero_video['url'] : $hero_video;
        $hero_image = get_sub_field('hero_image'); // Could be a URL or file object
        $image_url = is_array($hero_image) ? $hero_image['url'] : $hero_image;

        $hero_title = get_sub_field('hero_title');
        $hero_subtitle = get_sub_field('hero_subtitle');
        $hero_button_text = get_sub_field('hero_button_text');
        $hero_button_link = get_sub_field('hero_button_link');

?>
        <section class="hero-video-section" loading="lazy" style="position: relative; overflow: hidden;">
            <!-- Video Background Home -->
            <!-- <video class="hero-bg-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video> -->
            <img class="hero-image" src="<?php echo esc_url($image_url); ?>" alt="City">
            <div class="hero-overlay">
                <?php if ($hero_title): ?>
                    <h1 class="hero-title animate-on-scroll animate-from-buttom delay-1"><?php echo ($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($hero_subtitle): ?>
                    <p class="hero-subtitle animate-on-scroll animate-from-buttom delay-2"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
                <?php if ($hero_button_text && $hero_button_link): ?>
                    <a class="hero-button animate-on-scroll-btn delay-5" href="<?php echo esc_url($hero_button_link); ?>">
                        <span class="button-text"><?php echo esc_html($hero_button_text); ?></span>
                        <span class="border-line bottom-line"></span>
                        <span class="border-line left-line"></span>
                    </a>
                    <!-- <a class="hero-button" href="<?php echo esc_url($hero_button_link); ?>">
                        <?php echo esc_html($hero_button_text); ?>
                    </a> -->
                <?php endif; ?>
            </div>
        </section>
<?php
    endwhile;
endif;
?>