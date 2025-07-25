<section class="quote-section" id="quote-section">
    <div class="quote-container">
        <div class="quote-form-box">
            <h2 class="featured-title animate-on-scroll animate-from-left delay-1">Plan Your <span>Investment</span></h2>
            <p class="featured-title animate-on-scroll animate-from-left delay-1">Let us help you find the perfect home. Share a few details and we’ll be in touch to guide you every step of the way.</p>

            <form class="quote-form" id="quote-form">
                <label class="animate-on-scroll animate-from-left delay-2" for="property_interest ">Property of Interest</label>
                <select class="animate-on-scroll animate-from-left delay-2" name="property_interest" id="property_interest" required>
                    <option disabled selected hidden>Select Residences</option>

                    <?php
                    $properties = get_posts(array(
                        'post_type'      => 'property',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ));

                    if ($properties):
                        foreach ($properties as $property):
                    ?>
                            <option value="<?php echo esc_attr($property->post_title); ?>">
                                <?php echo esc_html($property->post_title); ?>
                            </option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>

                <div class="quote-form-row animate-on-scroll animate-from-left delay-3">
                    <div class="quote-form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="quote-form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                </div>

                <div class="quote-form-row animate-on-scroll animate-from-left delay-4">
                    <div class="quote-form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" required>
                    </div>
                    <div class="quote-form-group">
                        <label for="email_address">Email Address</label>
                        <input type="email" name="email_address" id="email_address" required>
                    </div>
                </div>


                <label class="animate-on-scroll animate-from-left delay-5" for="country">COUNTRY OF RESIDENCE</label>
                <?php
                $countries = json_decode(file_get_contents(get_template_directory() . '/assets/js/countries.json'), true);
                ?>

                <select class="animate-on-scroll animate-from-left delay-5" name="country" id="country" required>
                    <option disabled selected hidden>Select Country</option>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo esc_attr($country); ?>">
                            <?php echo esc_html($country); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button class="animate-on-scroll animate-from-left delay-5" type="submit" name="submit_quote_form">Submit</button>
            </form>
        </div>
        <div class="quote-image-box animate-on-scroll animate-zoom-in delay-2">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/get-a-quote-img.png" alt="Get a Quote">
        </div>
    </div>

    <div id="quote-success-modal">
        <div class="quote-modal-content">
            <h3>Thank you!</h3>
            <p>Your quote request has been submitted.</p>
            <span id="close-quote-modal">Close</span>
        </div>
    </div>
</section>