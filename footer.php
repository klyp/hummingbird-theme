<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hummingbird
 */

    $socialMedia    = get_field('settings_social_media', 'options');
    $footerLogoUrl  = get_field('settings_logo', 'options')['settings_logo_footer'] ?:get_stylesheet_directory_uri() . '/assets/src/image/logo/footer-logo.svg';
    $footerMenu     = klyp_generate_nav_menu('menu-footer');
?>

    <footer class="hb-footer">
        <div class="hb-container">
            <div class="hb-footer__row">
                <div class="hb-footer__col">
                    <ul class="hb-footer__social list-inline">
                        <?php if (isset($socialMedia['settings_linkedin']['url'])) : ?>
                            <li class="hb-footer__social-item list-inline-item">
                                <a href="<?php echo $socialMedia['settings_linkedin']['url']; ?>" target="<?php echo $socialMedia['settings_linkedin']['target']; ?>">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($socialMedia['settings_twitter']['url'])) : ?>
                            <li class="hb-footer__social-item list-inline-item">
                                <a href="<?php echo $socialMedia['settings_twitter']['url']; ?>" target="<?php echo $socialMedia['settings_twitter']['target']; ?>">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($socialMedia['settings_instagram']['url'])) : ?>
                            <li class="hb-footer__social-item list-inline-item">
                                <a href="<?php echo $socialMedia['settings_instagram']['url']; ?>" target="<?php echo $socialMedia['settings_instagram']['target']; ?>">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($socialMedia['settings_facebook']['url'])) : ?>
                            <li class="hb-footer__social-item list-inline-item">
                                <a href="<?php echo $socialMedia['settings_facebook']['url']; ?>" target="<?php echo $socialMedia['settings_facebook']['target']; ?>">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="hb-footer__col">
                    <ul class="hb-footer__links list-inline">
                        <?php foreach ($footerMenu as $index => $item) : ?>
                            <li class="hb-footer__links-item list-inline-item">
                                <a href="<?php echo $item['url']; ?>">
                                    <?php echo $item['title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="hb-footer__col">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <a href="#" class="hb-footer__logo d-inline-block">
                            <img src="<?php echo $footerLogoUrl; ?>" alt="Footer Logo" class="img-fluid">
                        </a>
                        Copyright &copy; <?php echo get_bloginfo(); ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--====  End of  footer  ====-->

<?php wp_footer(); ?>
</body>
</html>
