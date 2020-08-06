<?php
/**
 * Displays the sidebar widget area
 *
 * @package WordPress
 * @subpackage Hummingbird
 * @since Hummingbird 1.0.0
 */

if (is_active_sidebar('sidebar-1')) : ?>
    <aside class="widget-area col-12 col-md-4" role="complementary"
    aria-label="<?php esc_attr_e('Sidebar', 'klyp'); ?>">
        <?php
        if (is_active_sidebar('sidebar-1')) {
            dynamic_sidebar('sidebar-1');
        }
        ?>
    </aside><!-- .widget-area -->

<?php endif; ?>
