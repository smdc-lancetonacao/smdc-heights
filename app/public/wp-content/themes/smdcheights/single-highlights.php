<?php get_header(); ?>

<?php
// Get post meta values
$subtitle = get_post_meta(get_the_ID(), '_highlight_subtitle', true);
$sub_description = get_post_meta(get_the_ID(), '_highlight_sub_description', true);
$news_content = get_post_meta(get_the_ID(), '_highlight_news', true);
$news_image = get_post_meta(get_the_ID(), '_highlight_news_image', true);

?>

<div class="highlight-article">
    <div class="article-container">
        <?php if ($news_image): ?>
            <div class="hero-highlight-section">
                <img class="hero-highlight-image" src="<?php echo esc_url($news_image); ?>" alt="News Image">
            </div>
        <?php endif; ?>

        <div class="highlight-header">
            <h1 class="highlight-title"><?php the_title(); ?></h1>
            <p class="highlight-subtitle"><?php echo esc_html($subtitle); ?></p>
            <p class="highlight-headline"><?php echo esc_html($sub_description); ?></p>
            <?php
            $terms = get_the_terms(get_the_ID(), 'highlight_category');
            $term_names = [];
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
            }
            $category_output = !empty($term_names) ? implode(', ', $term_names) : 'Uncategorized';
            ?>
            <p class="highlight-meta">BY <?php echo esc_html($category_output); ?> • <span class="highlight-meta-date"><?php echo get_the_date(); ?></span> • <span class="highlight-meta-mins">3 MIN READ</span></p>
        </div>

        <div class="highlight-content">
            <?php echo wp_kses_post($news_content); ?>
        </div>

        <?php
        $gallery_ids = get_post_meta(get_the_ID(), '_highlight_gallery_images', true);
        if (!empty($gallery_ids)) :
            $ids = explode(',', $gallery_ids);
        ?>
            <div class="highlight-gallery">
                <?php
                foreach ($ids as $id) {
                    $img_url = wp_get_attachment_url($id);
                    if ($img_url) {
                        echo '<img src="' . esc_url($img_url) . '" alt="Gallery Image">';
                    }
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>