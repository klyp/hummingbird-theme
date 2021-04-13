<?php
    // General.
    $componentId            = get_sub_field('component_hero_id') ?: 'random_' . rand();
    $componentClass         = get_sub_field('component_hero_class');
    $enableComponent        = get_sub_field('component_hero_enable');
    $globalComponent        = get_sub_field('component_hero_global_component');

    //Settings.
    $alignment              = klyp_get_the_field_values($globalComponent, 'hero', 'alignment');
    $size                   = klyp_get_the_field_values($globalComponent, 'hero', 'size');
    $image                  = klyp_get_the_field_values($globalComponent, 'hero', 'image');
    $header                 = klyp_get_the_field_values($globalComponent, 'hero', 'header');
    $subHeader              = klyp_get_the_field_values($globalComponent, 'hero', 'sub_header');
    $description            = klyp_get_the_field_values($globalComponent, 'hero', 'description');
    $primaryCta             = klyp_get_the_field_values($globalComponent, 'hero', 'primary_cta');
    $secondaryCta           = klyp_get_the_field_values($globalComponent, 'hero', 'secondary_cta');
    $desktopImagePosition   = klyp_get_the_field_values($globalComponent, 'hero', 'desktop_image_position');
    $mobileImagePosition    = klyp_get_the_field_values($globalComponent, 'hero', 'mobile_image_position');

switch ($size) {
    case 'full-height':
        $heightClass = 'hb-fs-banner__height';
        break;

    case 'large':
        $heightClass = 'hb-fs-banner__large';
        break;

    case 'small':
    default:
        $heightClass = '';
        break;
}

switch ($alignment) {
    case 'right':
        $alignClass = 'hb-fs-banner__content--right';
        break;

    case 'center':
        $alignClass = 'hb-fs-banner__content--center';
        break;

    case 'left':
    default:
        $alignClass = '';
        break;
}

    // generate css
    $customCss[$componentId]['desktop'] = array (
        'background-image' => 'url('. $image . ')',
        'background-position' => $desktopImagePosition,
    );

    $customCss[$componentId]['mobile'] = array (
        'background-position' => $mobileImagePosition,
    );
    ?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="hb-fs-banner <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="<?php echo $heightClass; ?> hb-fs-banner__height--value">
                        <div class="hb-fs-banner__content <?php echo $alignClass; ?>">
                            <h5 class="hb-fs-banner__intro">
                                <?php echo $subHeader; ?>
                            </h5>
                            <h2 class="hb-fs-banner__title">
                                <?php echo $header; ?>
                            </h2>
                            <div class="hb-fs-banner__text">
                                <p>
                                <?php echo $description; ?>
                                </p>
                            </div>
                            <div class="hb-btn-row">
                                <?php if ($primaryCta) : ?>
                                    <a href="<?php echo $primaryCta['url']; ?>" class="hb-btn-primary" target="<?php echo $primaryCta['target']; ?>">
                                        <?php echo $primaryCta['title']; ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($secondaryCta) : ?>
                                    <a href="<?php echo $secondaryCta['url']; ?>" class="hb-btn-primary hb-btn-primary--outline" target="<?php echo $secondaryCta['target']; ?>"><?php echo $secondaryCta['title']; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php echo klyp_minimize_css(klyp_process_css($customCss)); ?>
<?php endif; ?>
