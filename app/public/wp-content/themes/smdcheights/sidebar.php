<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MyAwesomeTheme
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return; // Don't show sidebar if no widgets are active
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'sidebar-1' ); // Displays the widgets in sidebar-1 ?>
</aside>```

**Explanation:**

* `is_active_sidebar( 'sidebar-1' )`: Checks if the sidebar we registered in `functions.php` has any widgets assigned to it. If not, it won't display the sidebar, keeping your HTML clean.
* `dynamic_sidebar( 'sidebar-1' )`: This function displays all the widgets assigned to the `sidebar-1` widget area.

**Action:**
1.  Create `sidebar.php` in your theme's root directory.
2.  Copy and paste the above code.
3.  Add some widgets to your "Sidebar" in `Appearance > Widgets`.
4.  Refresh your site. You should now see a sidebar (though its positioning will depend on your CSS).

### Step 10: `inc/template-tags.php` - Custom Template Functions

It's a good practice to keep theme-specific functions that are used repeatedly in a separate file, typically in an `inc` folder.

**Action:**
1.  Create a new folder named `inc` inside your `my-awesome-theme` directory.
2.  Inside `inc`, create a file named `template-tags.php`.

**`inc/template-tags.php` example:**

```php
<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package MyAwesomeTheme
 * @since 1.0.0
 */

if ( ! function_exists( 'my_awesome_theme_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function my_awesome_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'my-awesome-theme' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

if ( ! function_exists( 'my_awesome_theme_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function my_awesome_theme_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'my-awesome-theme' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;