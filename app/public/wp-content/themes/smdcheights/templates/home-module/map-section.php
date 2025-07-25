<?php
$map_title = get_field('map_title');
$map_description = get_field('map_description');
$map_count_title = get_field('map_count_title');
$map_count_description = get_field('map_count_description');

$map_image = get_field('map_image');
$map_image_url = is_array($map_image) ? $map_image['url'] : $map_image;

$theme_url = get_template_directory_uri();
?>

<?php if ($map_title || $map_description || $map_count_title || $map_count_description || $map_image): ?>
    <section class="map-section">
        <div class="map-container">

            <!-- Left Column: Text Groups -->
            <div class="map-texts">
                <?php if ($map_title): ?>
                    <h2 class="map-title animate-on-scroll animate-from-left delay-1"><?php echo ($map_title); ?></h2>
                <?php endif; ?>
                <div class="map-texts-group animate-on-scroll animate-from-top delay-1">
                    <div class="map-group-top">
                        <?php if ($map_description): ?>
                            <p class="map-description animate-on-scroll animate-from-left delay-1"><?php echo ($map_description); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="map-group-bottom">
                        <img class="skycrapper-img animate-on-scroll delay-1" src="<?php echo $theme_url; ?>/assets/images/skycrapper-img.png" alt="Skycrapper Image">
                        <div id="map-counter" class="map-group-bottom-texts">
                            <?php if ($map_count_title):
                                // Extract the number and the text
                                preg_match('/\+?(\d+)\s*(.*)/', $map_count_title, $matches);
                                $number = $matches[1] ?? 0;
                                $text = $matches[2] ?? '';
                            ?>
                                <h3 class="map-count-title animate-on-scroll delay-1">
                                    <span class="count-number" data-count="<?php echo $number; ?>">0</span>
                                    <span class="count-text"><?php echo esc_html($text); ?></span>
                                </h3>
                            <?php endif; ?>

                            <?php if ($map_count_description): ?>
                                <p class="map-count-description animate-on-scroll"><?php echo esc_html($map_count_description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Map Image -->
            <div class="map-image-wrapper">
                <div class="interactive-map map-image animate-on-scroll animate-zoom-in delay-2">
                    <?php echo file_get_contents(get_template_directory() . '/assets/images/ncr-map.svg'); ?>
                </div>
                <div class="map-label" id="label-edsa">
                    <div class="label-line"></div>
                    <div class="label-text">EDSA Corridor</div>
                </div>
                <div class="map-label" id="label-makati">
                    <div class="label-line"></div>
                    <div class="label-text">Makati</div>
                </div>
                <div class="map-label" id="label-bay">
                    <div class="label-line"></div>
                    <div class="label-text">Bay Area</div>
                </div>
                <div class="map-label" id="label-gold">
                    <div class="label-line"></div>
                    <div class="label-text">Gold City</div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
    document.querySelectorAll('.cls-1').forEach(region => {
        region.addEventListener('mouseenter', () => {
            const label = document.getElementById(`label-${region.id}`);
            if (label) label.classList.add('active');
        });
        region.addEventListener('mouseleave', () => {
            const label = document.getElementById(`label-${region.id}`);
            if (label) label.classList.remove('active');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const counter = document.querySelector(".count-number");
        if (!counter) return;

        let hasCounted = false;

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !hasCounted) {
                    hasCounted = true; // Prevent repeat animation
                    animateCount(counter);
                }
            });
        }, {
            threshold: 0.6
        }); // Trigger when 60% visible

        observer.observe(document.querySelector("#map-counter"));

        function animateCount(counter) {
            const target = +counter.dataset.count;
            const duration = 1500;
            const frameRate = 60;
            const totalFrames = Math.round(duration / (1000 / frameRate));
            let frame = 0;

            const countUp = () => {
                frame++;
                const progress = frame / totalFrames;
                const value = Math.round(target * easeOutQuad(progress));
                counter.textContent = "+" + value;

                if (frame < totalFrames) {
                    requestAnimationFrame(countUp);
                }
            };

            function easeOutQuad(t) {
                return t * (2 - t);
            }

            requestAnimationFrame(countUp);
        }
    });
</script>