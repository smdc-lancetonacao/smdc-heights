
<section class="news-section">
    <div class="news-container">
        <div class="news-texts">
            <div class="news-texts-left">
                <h2 class="news-title animate-on-scroll animate-from-left delay-1"><span>Highlights</span> and Happenings</h2>
                <p class="news-description animate-on-scroll animate-from-left delay-1">
                    Stay informed with the latest stories, milestones, and moments shaping our communities. Discover new developments, inspiring perspectives, and insights that bring you closer to the life you envision. From project highlights to lifestyle features, explore what’s unfolding at SMDC Heights.
                </p>
            </div>
            <div class="news-texts-right">
                <a class="view-all-properties-btn animate-on-scroll animate-from-right delay-2" href="/news">View All News</a>
            </div>
        </div>

        <div class="news-grid animate-on-scroll delay-3">
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
                    <div class="news-card">
                        <div class="news-thumb">
                            <?php
                            $custom_image = get_post_meta(get_the_ID(), '_highlight_news_image', true);
                            if ($custom_image) :
                            ?>
                                <img src="<?php echo esc_url($custom_image); ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="news-info">
                            <div>
                                <p class="news-date"><?php echo get_the_date('F j, Y'); ?></p>
                                <h3 class="news-title"><?php the_title(); ?></h3>
                                <?php if ($subtitle) : ?>
                                    <p class="news-subtitle"><em><?php echo esc_html($subtitle); ?></em></p>
                                <?php endif; ?>
                                <?php if ($subdesc) : ?>
                                    <p class="news-subdesc"><?php echo esc_html($subdesc); ?></p>
                                <?php endif; ?>
                            </div>
                            <a class="news-read-more" href="<?php the_permalink(); ?>">Read More</a>
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