<?php
    // General.
    $componentId          = get_sub_field('component_call_to_action_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_call_to_action_class');

    //Settings.
    $alignment            = get_sub_field('component_call_to_action_alignment');
    $image                = get_sub_field('component_call_to_action_image');
    $header               = get_sub_field('component_call_to_action_header');
    $subHeader            = get_sub_field('component_call_to_action_sub_header');
    $description          = get_sub_field('component_call_to_action_description');
    $primaryCta           = get_sub_field('component_call_to_action_primary_cta');
    $desktopImagePosition = get_sub_field('component_call_to_action_desktop_position');
    $mobileImagePosition  = get_sub_field('component_call_to_action_mobile_position');

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
    $customCss[$componentId]['desktop'] = array (
        '.hb-no-webp .hb-cta-section__bg' => array (
            'background-image' => 'url('. $image['url'] . ')',
            'background-position' => $desktopImagePosition,
        ),

        '.hb-webp .hb-cta-section__bg' => array (
            'background-image' => 'url('. get_post_meta($image['id'], '_webp_generated_url', true) . ')',
        ),
    );

    $customCss[$componentId]['mobile'] = array (
        '.hb-cta-section__bg' => array (
            'background-position' => $mobileImagePosition,
        )
    );
    ?>

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
