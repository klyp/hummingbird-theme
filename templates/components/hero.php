<?php
    // General.
    $componentId            = get_sub_field('component_hero_id') ?: 'random_' . rand();
    $componentClass         = get_sub_field('component_hero_class');

    //Settings.
    $alignment              = get_sub_field('component_hero_alignment');
    $size                   = get_sub_field('component_hero_size');
    $image                  = get_sub_field('component_hero_image');
    $header                 = get_sub_field('component_hero_header');
    $subHeader              = get_sub_field('component_hero_subheader');
    $description            = get_sub_field('component_hero_desciption');
    $primaryCta             = get_sub_field('component_hero_primary_cta');
    $secondaryCta           = get_sub_field('component_hero_secondary_cta');
    $desktopImagePosition   = get_sub_field('component_hero_desktop_position');
    $mobileImagePosition    = get_sub_field('component_hero_mobile_position');

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

<section id="<?php echo $componentId; ?>" class="hb-fs-banner <?php echo $componentClass; ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="<?php echo $heightClass; ?> d-flex align-items-center">
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
