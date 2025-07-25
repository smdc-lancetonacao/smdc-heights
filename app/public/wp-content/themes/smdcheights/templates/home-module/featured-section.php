<section class="featured-section">
    <div class="featured-container">
        <div class="featured-texts">
            <div class="featured-texts-left">
                <h2 class="featured-title animate-on-scroll animate-from-left delay-1"><span>Invest in Your Future</span> at the Heart of Metro Manila</h2>
                <p class="featured-description animate-on-scroll animate-from-left delay-1">SMDC creates vibrant, inclusive, and thoughtfully designed communities designed for modern living. As part of the SM Group, SMDC creates homes that connect people to life’s essentials and enrich their everyday experiences.</p>
            </div>
            <div class="featured-texts-right">
                <a class="view-all-properties-btn animate-on-scroll animate-from-right delay-2" href="/properties/">View All Properties</a>
            </div>
        </div>
        <div class="residence-grid animate-on-scroll delay-2">
            <?php
            $featured_query = new WP_Query(array(
                'post_type' => 'property',
                'orderby' => 'date',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => '_property_featured',
                        'value' => '1'
                    )
                )
            ));

            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    $property_name = get_the_title();
                    $location_id = get_post_meta(get_the_ID(), '_property_location', true);
                    $location = $location_id ? get_the_title($location_id) : 'No location';

                    $is_preselling = get_post_meta(get_the_ID(), '_property_preselling', true);
                    $is_rfo = get_post_meta(get_the_ID(), '_property_rfo', true);

                    $status = '';
                    if ($is_preselling === '1') {
                        $status = 'Pre-selling';
                    } elseif ($is_rfo === '1') {
                        $status = 'Move-in-ready';
                    }
            ?>
                    <div class="residence-card">
                        <a class="residence-card-link" href="<?php the_permalink(); ?>">
                            <div class="residence-thumb">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('full');
                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" alt="No image">';
                                }
                                ?>
                            </div>
                            <div class="residence-info">
                                <h3><?php echo esc_html($property_name); ?></h3>
                                <div>

                                    <?php if ($status): ?>
                                        <p class="location"><?php echo esc_html($location); ?> • </p>
                                        <span class="status <?php echo esc_attr(strtolower(str_replace(' ', '-', $status))); ?>">
                                            <?php echo esc_html($status); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>

                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No featured residences found.</p>';
            endif;
            ?>
        </div>

</section>