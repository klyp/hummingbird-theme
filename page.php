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
            <div class="site-preloader">
                <svg class="pl" viewBox="0 0 128 128" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="pl-grad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="hsl(193,90%,55%)" />
                            <stop offset="100%" stop-color="hsl(223,90%,55%)" />
                        </linearGradient>
                    </defs>
                    <circle class="pl__ring" r="56" cx="64" cy="64" fill="none" stroke="hsla(0,10%,10%,0.1)" stroke-width="16" stroke-linecap="round" />
                    <path class="pl__worm" d="M92,15.492S78.194,4.967,66.743,16.887c-17.231,17.938-28.26,96.974-28.26,96.974L119.85,59.892l-99-31.588,57.528,89.832L97.8,19.349,13.636,88.51l89.012,16.015S81.908,38.332,66.1,22.337C50.114,6.156,36,15.492,36,15.492a56,56,0,1,0,56,0Z" fill="none" stroke="url(#pl-grad)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="44 1111" stroke-dashoffset="10" />
                </svg>
            </div>
            <?php
            if (have_posts()) :
                $componentCount = 0;
                $theComponents = get_field_objects();
                $components = $theComponents['components']['value'];
                if ($components) {
                    foreach ($components as $key => $component) {
                        $componentAttribute['layout']       = $component['acf_fc_layout'];
                        $componentAttribute['page_id']      = get_the_ID();
                        $componentAttribute['order']        = $componentCount;
                        echo '<div class="klypComponents" data-ajax="' . admin_url('admin-ajax.php') . '" data-nonce="' . wp_create_nonce('klyp-hummingbird') . '" data-component=' . json_encode($componentAttribute) . '></div>';
                        $componentCount++;
                    }
                }
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
    <?php
}

get_footer();
