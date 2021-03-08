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

if (post_password_required()) {
    $title = get_field('title');
    $content = get_field('content'); ?>
    <section class="component_full_width_content password-protected" id="full_width_content-0-<?php echo get_the_ID(); ?>">
        <h2 class="content__title"><?php echo $title; ?></h2>
        <div class="content__container">
            <div class="content__item content__item--0">
                <div class="content__content">
                    <?php echo $content; ?>
                    <hr>
                    <?php echo get_the_password_form(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    if (have_rows('components')) {
                        while (have_rows('components')) {
                            the_row();
                            $layoutName = get_row_layout();
                            get_template_part('/templates/components/' . $layoutName);
                        }
                    }
                endwhile;
            endif;
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->
    <?php
}

get_footer();
