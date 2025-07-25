<?php
if (have_rows('news_hero_section')):
    while (have_rows('news_hero_section')) : the_row();
        $news_hero_title = get_sub_field('news_hero_title');
        $news_hero_description = get_sub_field('news_hero_description');
?>
        <section class="newsp-section">
            <div class="newsp-container">
                <div class="newsp-texts">
                    <?php if ($news_hero_title): ?>
                        <h2 class="newsp-title animate-on-scroll animate-from-buttom delay-1"><?php echo ($news_hero_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($news_hero_description): ?>
                        <p class="newsp-description animate-on-scroll animate-from-buttom delay-1"><?php echo ($news_hero_description); ?></p>
                    <?php endif; ?>
                </div>
<?php
    endwhile;
    endif;
?>

        <div class="newsp-grid">
            <?php
            $news_query = new WP_Query(array(
                'post_type'      => 'highlights',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'meta_query' => array(
                    array(
                        'key'     => '_highlight_featured',
                        'value'   => 'on',
                        'compare' => '='
                    )
                )
            ));

            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
                    $subtitle = get_post_meta(get_the_ID(), '_highlight_subtitle', true);
                    $subdesc = get_post_meta(get_the_ID(), '_highlight_sub_description', true);
            ?>
                    <div class="newsp-card">
                        <div class="newsp-thumb">
                            <?php
                            $custom_image = get_post_meta(get_the_ID(), '_highlight_news_image', true);
                            if ($custom_image) :
                            ?>
                                <img src="<?php echo esc_url($custom_image); ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="newsp-info">
                            <div>
                                <p class="newsp-date"><?php echo get_the_date('F j, Y'); ?></p>
                                <h3 class="newsp-title"><?php the_title(); ?></h3>
                                <?php if ($subtitle) : ?>
                                    <p class="newsp-subtitle"><em><?php echo esc_html($subtitle); ?></em></p>
                                <?php endif; ?>
                                <?php if ($subdesc) : ?>
                                    <p class="newsp-subdesc"><?php echo esc_html($subdesc); ?></p>
                                <?php endif; ?>
                            </div>
                            <a class="newsp-read-more" href="<?php the_permalink(); ?>">Read More</a>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No news found.</p>';
            endif;
            ?>
        </div>
            </div>
        </section>