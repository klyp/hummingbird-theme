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
                $componentCount = 0;
                $theComponents = get_field_objects();
                $components = $theComponents['components']['value'];
                if ($components) {
                    foreach ($components as $key => $component) {
                        $componentAttribute['layout']       = $component['acf_fc_layout'];
                        $componentAttribute['component_id'] = $component['id'];
                        $componentAttribute['page_id']      = get_the_ID();
                        $componentAttribute['order']        = $componentCount;
                        echo '<div class="component-container-' . $componentCount .'" data-component=' . json_encode($componentAttribute) . '></div>';
                        $componentCount++;
                    }
                }
                echo '<input type="hidden" id="comp-count" value="' . $componentCount . '">';
            endif;
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->
    <?php
}

get_footer();
