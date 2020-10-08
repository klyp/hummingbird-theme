<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package HummingBird
 */

get_header();
?>

    <?= klyp_breadcrumb(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                        <section class="hb-general">
                            <div class="hb-general__txt-img">
                                <div class="hb-container">
                                    <div class="hb-row">
                                        <div class="hb-col-full">
                                        <?php
                                        if (is_single()) {
                                            the_title('<h2 class="hb-general__txt-img-title">', '</h2>');
                                        }
                                        ?>
                                            <div class="hb-general__txt-img-image">
                                                <img src="<?= get_the_post_thumbnail_url(); ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="hb-general__txt-img-content">
                                            <?php
                                                the_content(
                                                    sprintf(
                                                        /* translators: %s: Post title. */
                                                        __(
                                                            'Continue reading<span class="screen-reader-text">
                                                            "%s"</span>',
                                                            'klyp'
                                                        ),
                                                        get_the_title()
                                                    )
                                                );

                                                wp_link_pages(
                                                    array(
                                                        'before'      => '<div class="page-links">' . esc_html__(
                                                            'Pages:',
                                                            'klyp'
                                                        ),
                                                        'after'       => '</div>',
                                                        'link_before' => '<span class="page-number">',
                                                        'link_after'  => '</span>',
                                                    )
                                                );
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php
                endwhile;
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
