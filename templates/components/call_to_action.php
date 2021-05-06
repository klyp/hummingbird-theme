<?php
    // General.
    $componentId          = get_field('component_call_to_action_id') ?: 'random_' . rand();
    $componentClass       = get_field('component_call_to_action_class');
    $enableComponent      = get_field('component_cta_enable');
    $globalComponent      = get_field('component_call_to_action_global_component');

    //Settings.
    $alignment            = klyp_get_the_field_values($globalComponent, 'call_to_action', 'alignment');
    $image                = klyp_get_the_field_values($globalComponent, 'call_to_action', 'image');
    $header               = klyp_get_the_field_values($globalComponent, 'call_to_action', 'header');
    $subHeader            = klyp_get_the_field_values($globalComponent, 'call_to_action', 'sub_header');
    $description          = klyp_get_the_field_values($globalComponent, 'call_to_action', 'description');
    $primaryCta           = klyp_get_the_field_values($globalComponent, 'call_to_action', 'primary_cta');
    $desktopImagePosition = klyp_get_the_field_values($globalComponent, 'call_to_action', 'desktop_image_position');
    $mobileImagePosition  = klyp_get_the_field_values($globalComponent, 'call_to_action', 'mobile_image_position');

switch ($alignment) {
    case 'right':
        $blogClass  = 'flex-row-reverse';
        $titleClass = 'hb-cta-section__col-right';
        $linkClass  = 'text-center';
        break;

    case 'center':
        $blogClass  = 'text-center';
        $titleClass = '';
        $linkClass  = '';
        break;

    case 'left':
    default:
        $blogClass  = '';
        $titleClass = 'hb-cta-section__col-left';
        $linkClass  = 'text-left';
        break;
}

// generate css
if ($image) {
    $customCss[$componentId]['desktop'] = array (
        '.hb-no-webp .hb-cta-section__bg' => array (
            'background-image' => 'url(' . $image['url'] . ')',
            'background-position' => $desktopImagePosition,
        ),

        '.hb-webp .hb-cta-section__bg' => array (
            'background-image' => 'url(' . get_post_meta($image['id'], '_webp_generated_url', true) . ')',
        ),
    );
}

$customCss[$componentId]['mobile'] = array (
    '.hb-cta-section__bg' => array (
        'background-position' => $mobileImagePosition,
    )
);
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-cta-section <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-cta-section__bg hb-container-bk-image">
                        <div class="hb-cta-section__row <?php echo $blogClass; ?>">
                            <div class="col-12 <?php echo $titleClass; ?>">
                                <?php if ($alignment == 'center') : ?>
                                    <div class="hb-cta-section__center">
                                <?php endif; ?>
                                    <h5 class="hb-cta-section__intro">
                                        <?php echo $subHeader; ?>
                                    </h5>
                                    <h2 class="hb-cta-section__title">
                                        <?php echo $header; ?>
                                    </h2>
                                    <div class="hb-cta-section__text">
                                        <?php echo $description; ?>
                                    </div>
                                <?php if ($alignment == 'center') : ?>
                                    <?php if ($primaryCta) : ?>
                                        <a href="<?php echo $primaryCta['url']; ?>" class="hb-btn-primary" target="<?php echo $primaryCta['target']; ?>">
                                            <?php echo $primaryCta['title']; ?>
                                        </a>
                                    <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($alignment != 'center') : ?>
                                <?php if ($primaryCta) : ?>
                                    <div class="col-12 col-md-6 <?php echo $linkClass; ?>">
                                        <a href="<?php echo $primaryCta['url']; ?>" class="hb-btn-primary" target="<?php echo $primaryCta['target']; ?>">
                                            <?php echo $primaryCta['title']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo klyp_minimize_css(klyp_process_css($customCss)); ?>
<?php endif; ?>
