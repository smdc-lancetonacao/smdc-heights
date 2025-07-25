<?php
$avp_title = get_field('avp_title');
$avp_description = get_field('avp_description');
$avp_video = get_field('avp_video');
$video_url = is_array($avp_video) ? $avp_video['url'] : $avp_video;

if ($avp_title || $avp_description || $video_url): ?>
    <section class="avp-section">
        <div class="avp-content">
            <?php if ($avp_title): ?>
                <h2 class="avp-title animate-on-scroll delay-1"><?php echo $avp_title; ?></h2>
            <?php endif; ?>

            <?php if ($avp_description): ?>
                <p class="avp-description animate-on-scroll delay-2"><?php echo ($avp_description); ?></p>
            <?php endif; ?>

            <?php if ($video_url): ?>
                <video class="avp-video animate-on-scroll delay-2" muted autoplay loop>
                    <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>