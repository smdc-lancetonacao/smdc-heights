<?php

/**
 * Template for displaying single property posts
 */
get_header(); ?>

<div class="single-property-container">
    <?php while (have_posts()) : the_post(); ?>

        <!-- Property Hero Section -->
        <?php
        $property_hero = get_field('property_hero');
        if ($property_hero):
            $pr_hero_image_url = is_array($property_hero['property_hero_image']) ? $property_hero['property_hero_image']['url'] : $property_hero['property_hero_image'];
            $pr_hero_icon_url = is_array($property_hero['property_icon']) ? $property_hero['property_icon']['url'] : $property_hero['property_icon'];
        ?>
            <section class="property-hero-section">
                <img class="property-hero-image" src="<?php echo esc_url($pr_hero_image_url); ?>" alt="">
                <div class="property-hero-overlay">
                    <?php if (!empty($property_hero['property_icon'])): ?>
                        <img class="property-hero-icon animate-on-scroll animate-zoom-in delay-2" src="<?php echo esc_url($pr_hero_icon_url); ?>" alt="">
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Property Information Section -->
        <section class="property-information-section" id="property-information-section">
            <div class="information-container">
                <?php $property_description = get_field('property_description'); ?>

                <!-- <div class="sp-properties-filter-wrapper">
                    <div class="sp-properties-filter">
                        <a href="#property-information-section">Overview</a>
                        <a href="#property-map-section">Location</a>
                        <a href="#property-frontage-section">Frontage</a>
                        <a href="#property-units-section">Units</a>
                        <a href="#property-amenities-section">Amenities</a>
                        <a href="#property-news-section">News</a>
                        <a href="#property-quote-section">Get A Quote</a>
                    </div>
                </div> -->

                <div class="information-header">
                    <!-- <h2 class="information-header-title animate-on-scroll delay-1">Every ripple tells a <span>story</span></h2> -->
                    <?php if (!empty($property_description['property_title'])) : ?>
                        <h2 class="information-header-title animate-on-scroll delay-1"><?php echo ($property_description['property_title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($property_description['property_about_description'])) : ?>
                        <p class="information-header-description animate-on-scroll delay-2"><?php echo ($property_description['property_about_description']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="informations-grid">
                    <div class="information-item">
                        <div class="information-icon animate-on-scroll animate-zoom-in delay-3">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/location.png" alt="Location">
                        </div>
                        <div class="information-content">
                            <?php if (!empty($property_description['property_location_description'])) : ?>
                                <p class="animate-on-scroll animate-from-bottom delay-3"><?php echo ($property_description['property_location_description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="information-item">
                        <div class="information-icon animate-on-scroll animate-zoom-in delay-4">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/room.png" alt="Rooms">
                        </div>
                        <div class="information-content">
                            <?php if (!empty($property_description['property_rooms'])) : ?>
                                <p class="animate-on-scroll animate-from-bottom delay-4"><?php echo ($property_description['property_rooms']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="information-item">
                        <div class="information-icon animate-on-scroll animate-zoom-in delay-5">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/amenities.png" alt="Amenities">
                        </div>
                        <div class="information-content">
                            <?php if (!empty($property_description['property_amenities'])) : ?>
                                <p class="animate-on-scroll animate-from-bottom delay-5"><?php echo ($property_description['property_amenities']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Property Location Map Section -->
        <section class="property-map-section" id="property-map-section">
            <div class="property-map-container">
                <?php $property_location_map = get_field('property_location_map'); ?>
                <div class="map-location-header animate-on-scroll delay-1">
                    <h2 class="information-header-title"><span>Location</span> Map</h2>
                    <p class="information-header-description animate-on-scroll delay-2">Explore places nearby Sail Residences.</p>
                </div>
                <div class="map-links-container">
                    <!-- <?php if (!empty($property_location_map['property_nearby_establishment'])) : ?>
                        <a class="map-link-btn animate-on-scroll animate-zoom-in delay-3" href="<?php echo esc_html($property_location_map['property_nearby_establishment']); ?>">Show Nearby Establishments</a>
                    <?php endif; ?> -->
                    <?php if (!empty($property_location_map['property_google_map'])) : ?>
                        <a class="map-link-btn animate-on-scroll animate-zoom-in delay-3" href="<?php echo esc_html($property_location_map['property_google_map']); ?>">View on Google Maps</a>
                    <?php endif; ?>
                </div>
                <?php if ($property_location_map):
                    $map_url = is_array($property_location_map['property_map_image']) ? $property_location_map['property_map_image']['url'] : $property_location_map['property_map_image'];
                ?>
                    <img class="property-location-map-image animate-on-scroll animate-zoom-in delay-5" src="<?php echo esc_url($map_url); ?>" alt="Property Map">
                <?php endif; ?>
            </div>
        </section>

        <!-- Property Frontage Section -->
        <section class="property-frontage-section" id="property-frontage-section">
            <div class="property-frontage-container">
                <?php $property_frontage = get_field('property_frontage'); ?>
                <!-- Frontage Section Left Side -->
                <div class="frontage-left">
                    <div class="frontage-left-header">
                        <h2 class="frontage-header-title animate-on-scroll animate-from-left delay-1">Frontage</h2>
                        <?php if (!empty($property_frontage['property_frontage_description'])) : ?>
                            <p class="frontage-header-description animate-on-scroll animate-from-left delay-2"><?php echo esc_html($property_frontage['property_frontage_description']); ?></p>
                        <?php endif; ?>
                        <div>
                            <button class="frontage-previous-btn animate-on-scroll animate-from-right delay-3"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/frontage-previous-btn.png" alt="Rooms"></button>
                            <button class="frontage-next-btn animate-on-scroll animate-from-left delay-3"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/frontage-next-btn.png" alt="Rooms"></button>
                        </div>
                    </div>
                    <!-- <div class="frontage-left-buttons">
                        <hr class="animate-on-scroll animate-from-left delay-1">
                        <div>
                            <?php if (!empty($property_frontage['property_360_virtual_tour_link'])) : ?>
                                <a class="frontage-link-btn animate-on-scroll animate-zoom-in delay-2" href="<?php echo esc_html($property_frontage['property_360_virtual_tour_link']); ?>">360 Virtual Tour</a>
                            <?php endif; ?>
                            <?php if (!empty($property_frontage['property_walkthrough_link'])) : ?>
                                <a class="frontage-link-btn animate-on-scroll animate-zoom-in delay-2" href="<?php echo esc_html($property_frontage['property_walkthrough_link']); ?>">Property Walkthrough</a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (!empty($property_frontage['property_media_link'])) : ?>
                                <a class="frontage-link-btn animate-on-scroll animate-zoom-in delay-2" href="<?php echo esc_html($property_frontage['property_media_link']); ?>">Media</a>
                            <?php endif; ?>
                            <?php if (!empty($property_frontage['property_master_plan_link'])) : ?>
                                <a class="frontage-link-btn animate-on-scroll animate-zoom-in delay-2" href="<?php echo esc_html($property_frontage['property_master_plan_link']); ?>">Master Plan</a>
                            <?php endif; ?>
                        </div>
                    </div> -->
                </div>
                <!-- Frontage Section Right Side -->
                <div class="frontage-right">
                    <?php
                    $property_frontage = get_field('property_frontage');
                    if ($property_frontage && !empty($property_frontage['frontage_image_album'])) :
                    ?>
                        <div class="frontage-gallery">
                            <div class="carousel-track">
                                <?php foreach ($property_frontage['frontage_image_album'] as $row) :
                                    $image = $row['property_frontage_images']; // This is your image field name

                                    if ($image) :
                                        $image_url = $image['sizes']['large'] ?? $image['url'];
                                        $image_full = $image['sizes']['full'] ?? $image['url'];
                                ?>
                                        <div class="gallery-item">
                                            <img class="frontage-images animate-on-scroll animate-zoom-in delay-3"
                                                src="<?php echo esc_url($image_url); ?>"
                                                alt="<?php echo esc_attr($image['alt'] ?? ''); ?>"
                                                onclick="openLightbox('<?php echo esc_url($image_full); ?>')">
                                        </div>
                                <?php endif;
                                endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Property Living Spaces -->
        <section class="property-frontage-section" id="property-units-section">
            <div class="property-frontage-container">
                <?php $property_living_space = get_field('property_living_space'); ?>
                <div class="map-location-header">
                    <h2 class="information-header-title animate-on-scroll delay-1">Living <span>Spaces</span></h2>
                    <?php if (!empty($property_living_space['living_space_description'])) : ?>
                        <p class="information-header-description animate-on-scroll delay-2"><?php echo esc_html($property_living_space['living_space_description']); ?></p>
                    <?php endif; ?>
                </div>


                <?php
                $property_living_space = get_field('property_living_space');

                $bedroom_sections = [
                    [
                        'title' => '1 Bedroom with Balcony',
                        'album_key' => '1_bedroom_album',
                        'image_field' => '1_bedroom_images',
                        'desc_key' => '1_bedroom_description',
                    ],
                    [
                        'title' => '2 Bedroom with Balcony',
                        'album_key' => '2_bedroom_album',
                        'image_field' => '2_bedroom_images',
                        'desc_key' => '2_bedroom_description',
                    ],
                    [
                        'title' => '3 Bedroom with Balcony',
                        'album_key' => '3_bedroom_album',
                        'image_field' => '3_bedroom_images',
                        'desc_key' => '3_bedroom_description',
                    ],
                ];
                ?>
                <div class="bedroom-grid">
                    <?php foreach ($bedroom_sections as $section): ?>
                        <?php
                        $album = $property_living_space[$section['album_key']] ?? [];
                        $description = $property_living_space[$section['desc_key']] ?? '';
                        if (empty($album)) continue;
                        ?>
                        <div class="bedroom-carousel-section">
                            <div class="bedroom-carousel-container">
                                <div class="bedroom-carousel-track">
                                    <?php foreach ($album as $slide):
                                        $image = $slide[$section['image_field']];
                                        $image_url = $image['sizes']['large'] ?? $image['url'] ?? '';
                                        $image_alt = $image['alt'] ?? '';
                                        if (!$image_url) continue;
                                    ?>
                                        <div class="bedroom-gallery-item animate-on-scroll animate-zoom-in delay-1">
                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="bedroom-image">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <h2 class="bedroom-title animate-on-scroll animate-from-left delay-2"><?php echo esc_html($section['title']); ?></h2>
                                <?php if (!empty($description)): ?>
                                    <div class="bedroom-description animate-on-scroll animate-from-left delay-3">
                                        <?php echo wp_kses_post($description); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="bedroom-nav">
                                    <button class="frontage-previous-btn bedroom-prev-btn animate-on-scroll animate-from-right delay-2">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/frontage-previous-btn.png" alt="Previous">
                                    </button>
                                    <button class="frontage-next-btn bedroom-next-btn animate-on-scroll animate-from-left delay-3">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/frontage-next-btn.png" alt="Next">
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Property Amenities -->
        <section class="property-frontage-section" id="property-amenities-section">
            <div class="property-frontage-container">
                <?php $property_amenities = get_field('property_amenities'); ?>
                <div class="map-location-header">
                    <h2 class="information-header-title animate-on-scroll delay-1"><span>Amenities</span></h2>
                    <?php if (!empty($property_amenities['amenities_description'])) : ?>
                        <p class="information-header-description animate-on-scroll delay-2"><?php echo esc_html($property_amenities['amenities_description']); ?></p>
                    <?php endif; ?>
                </div>


                <?php
                $property_amenities = get_field('property_amenities');
                $amenities_album = $property_amenities['amenities_image_album'] ?? [];
                if (!empty($amenities_album)): ?>
                    <div class="amenities-scroll-wrapper animate-on-scroll animate-from-bottom delay-3">
                        <?php foreach ($amenities_album as $slide):
                            $image = $slide['amenities_images'] ?? null;
                            $image_url = $image['sizes']['large'] ?? $image['url'] ?? '';
                            $image_alt = $image['alt'] ?? '';
                            if (!$image_url) continue;
                        ?>
                            <div class="amenities-gallery-item">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="amenities-image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Property News Section -->
        <section id="property-news-section">
            <?php get_template_part('templates/home-module/news-section'); ?>
        </section>

        <!-- Property Quote Section -->
        <section id="property-quote-section">
            <?php get_template_part('templates/reusable-module/quote-section'); ?>
        </section>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>

<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const sp_info_section = document.querySelector('#property-information-section');
        const sp_map_section = document.querySelector('#property-map-section');
        const sp_frontage_section = document.querySelector('#property-frontage-section');
        const sp_units_section = document.querySelector('#property-units-section');
        const sp_amenities_section = document.querySelector('#property-amenities-section');
        const sp_news_section = document.querySelector('#property-news-section');
        const sp_quote_section = document.querySelector('#property-quote-section');

        const sp_filterWrapper = document.querySelector('.sp-properties-filter-wrapper');

        const sp_observer = new IntersectionObserver((entries) => {
            // Check if any of the observed sections are intersecting
            const anyVisible = entries.some(entry => entry.isIntersecting);

            if (anyVisible && !sp_filterWrapper.classList.contains('stuck')) {
                sp_filterWrapper.classList.add('stuck');
            } else if (!anyVisible && sp_filterWrapper.classList.contains('stuck')) {
                sp_filterWrapper.classList.remove('stuck');
            }
        }, {
            root: null,
            threshold: 0,
            rootMargin: "0px 0px -100% 0px"
        });

        // Observe multiple sections
        [sp_info_section, sp_map_section, sp_frontage_section, sp_units_section, sp_amenities_section, sp_news_section, sp_quote_section].forEach(section => {
            if (section) {
                sp_observer.observe(section);
            }
        });
    });
</script>