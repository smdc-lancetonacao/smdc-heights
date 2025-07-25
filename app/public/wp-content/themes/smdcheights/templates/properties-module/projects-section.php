<section class="properties-section">
    <div class="properties-container">
        <div class="properties-texts">
            <h2 class="properties-title"><span>Invest in Your Future</span> at the Heart of Metro Manila</h2>
            <p class="properties-description">Elevating city living with iconic addresses designed for ambition, balance, and the quiet power to thrive.</p>
        </div>
        <div class="properties-filter-wrapper">
            <div class="properties-filter">
                <button data-filter="Mall of Asia Complex">Bay Area</button>
                <button data-filter="Makati City">Makati City</button>
                <button data-filter="EDSA Corridor">EDSA Corridor</button>
                <button data-filter="Gold City">Gold City</button>
                <button data-filter="Others">Others</button>
            </div>
        </div>
        <div class="properties-grid">
            <?php
            $featured_query = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 99,
                'orderby' => 'date',
                'order' => 'ASC',
            ));

            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    $property_name = get_the_title();
                    $location_id = get_post_meta(get_the_ID(), '_property_location', true);
                    $location = $location_id ? get_the_title($location_id) : 'No location';

                    $is_preselling = get_post_meta(get_the_ID(), '_property_preselling', true);
                    $is_rfo = get_post_meta(get_the_ID(), '_property_rfo', true);
                    $is_complete = get_post_meta(get_the_ID(), '_property_complete', true);

                    $status = '';
                    if ($is_preselling === '1') {
                        $status = 'Pre-selling';
                    } elseif ($is_rfo === '1') {
                        $status = 'Move-in-ready';
                    } elseif ($is_complete === '1') {
                        $status = 'Completed';
                    }
            ?>
                    <?php
                    $main_locations = ['Mall of Asia Complex', 'Makati City', 'EDSA Corridor', 'Gold City'];
                    $is_other = !in_array($location, $main_locations);
                    ?>
                    <div class="properties-card" data-location="<?php echo esc_attr($location); ?>" data-group="<?php echo $is_other ? 'others' : 'main'; ?>">
                        <a class="properties-card-link" href="<?php the_permalink(); ?>">
                            <div class="properties-thumb">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('full');
                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" alt="No image">';
                                }
                                ?>
                            </div>
                            <div class="properties-info">
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
                echo '<p>No properties found.</p>';
            endif;
            ?>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.properties-filter button');
        const cards = document.querySelectorAll('.properties-card');

        function filterCards(filterValue) {
            filterValue = filterValue.toLowerCase();

            cards.forEach(card => {
                const cardLocation = card.getAttribute('data-location').toLowerCase();
                const cardGroup = card.getAttribute('data-group');

                const shouldShow = (
                    (filterValue === 'others' && cardGroup === 'others') ||
                    (cardLocation === filterValue)
                );

                if (shouldShow) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }


        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filterValue = button.getAttribute('data-filter');
                filterCards(filterValue);

                // Update active class
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });

        // Set default to 'Mall of Asia Complex' (Bay Area)
        const defaultFilter = 'Mall of Asia Complex';
        const defaultButton = Array.from(filterButtons).find(btn => btn.getAttribute('data-filter') === defaultFilter);
        if (defaultButton) {
            defaultButton.classList.add('active');
            filterCards(defaultFilter);
        }

        const section = document.querySelector('.properties-section');
        const filterWrapper = document.querySelector('.properties-filter-wrapper');

        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                filterWrapper.classList.add('stuck');
            } else {
                filterWrapper.classList.remove('stuck');
            }
        }, {
            root: null,
            threshold: 0,
            rootMargin: "0px 0px -100% 0px" // detects when section leaves top
        });

        observer.observe(section);
    });
</script>