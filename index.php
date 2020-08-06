<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hummingbird
 */

get_header();

$settings_blog_style = get_field('settings_blog', 'option')['settings_blog_style'];

switch ($settings_blog_style) {
    case 'card-w-sidebar':
        $rowClass    = 'col-md-8';
        $showSidebar = 'yes';
        break;
    case 'card-wo-sidebar':
        $rowClass    = '';
        $showSidebar = 'no';
        break;
    case 'list-w-sidebar':
        $rowClass    = 'col-md-8';
        $showSidebar = 'yes';
        break;
    case 'list-wo-sidebar':
        $rowClass    = '';
        $showSidebar = 'no';
        break;
    default:
        $rowClass    = '';
        $showSidebar = 'no';
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?= klyp_breadcrumb(); ?>

        <?php
        if (have_posts()) : ?>
            <section class="hb-blog">
                <div class="container">
                    <div class="row">
                        <div class="col-12 <?= $rowClass; ?>">
                            <div class="row hb-blog__row">
                            <?php
                                /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                /*
                                * Include the Post-Type-specific template for the content.
                                * If you want to override this in a child theme, then include a file
                                * called content-___.php (where ___ is the Post Type name) and that will be used
                                * instead.
                                */
                                get_template_part('templates/content', get_post_type());
                            endwhile;
                            ?>
                            </div>
                            <?= klyp_posts_navigation(); ?>
                        </div>
                        <?php
                        if ('yes' == $showSidebar) {
                            get_template_part('templates/content', 'widgets');
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php
        else :
            get_template_part('templates/content', 'none');
        endif;
        ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
