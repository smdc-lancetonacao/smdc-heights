<?php

function custom_breadcrumbs_with_svg() {
    if (is_front_page()) return; // Don't show on homepage

    $separator = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256" style="margin: 0 8px; vertical-align: middle;"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>';

    echo '<div class="breadcrumb-wrapper">';
    echo '<nav class="breadcrumb" aria-label="Breadcrumb">';
    echo '<a href="' . home_url() . '">Home</a>';

    global $post;
    if (is_single()) {
        $category = get_the_category();
        if ($category) {
            echo $separator . '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>';
        }
        echo $separator . '<span>' . get_the_title() . '</span>';

    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = [];

        while ($parent_id) {
            $page = get_post($parent_id);
            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
            $parent_id = $page->post_parent;
        }

        foreach (array_reverse($breadcrumbs) as $crumb) {
            echo $separator . $crumb;
        }

        echo $separator . '<span>' . get_the_title() . '</span>';

    } elseif (is_page()) {
        echo $separator . '<span>' . get_the_title() . '</span>';

    } elseif (is_category()) {
        echo $separator . '<span>' . single_cat_title('', false) . '</span>';

    } elseif (is_tag()) {
        echo $separator . '<span>' . single_tag_title('', false) . '</span>';

    } elseif (is_archive()) {
        echo $separator . '<span>' . post_type_archive_title('', false) . '</span>';

    } elseif (is_search()) {
        echo $separator . '<span>Search: ' . get_search_query() . '</span>';

    } elseif (is_404()) {
        echo $separator . '<span>Error 404</span>';
    }

    echo '</nav>';
    echo '</div>';
}
