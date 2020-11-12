<?php
    // General.
    $componentId          = get_sub_field('component_call_to_action_full_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_call_to_action_full_class');
    $enableComponent      = get_sub_field('component_cta_full_enable');

    //Settings.
    $image                = get_sub_field('component_call_to_action_full_image');
    $header               = get_sub_field('component_call_to_action_full_header');
    $primaryCta           = get_sub_field('component_call_to_action_full_primary_cta');
    $desktopImagePosition = get_sub_field('component_call_to_action_full_desktop_position');
    $mobileImagePosition  = get_sub_field('component_call_to_action_full_mobile_position');

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
<section id="<?php echo $componentId; ?>" class="hb-fs-banner hb-fs-banner--left <?php echo $componentClass; ?>">
    <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-fs-banner__flex">
                        <div class="hb-fs-banner__content">
                            <h2 class="hb-fs-banner__title hb-fs-banner__title--gray hb-fs-banner__title--small">
                                <?php echo $header; ?>
                            </h2>
                             <?php if (isset($primaryCta) && ! empty($primaryCta)) : ?>
                                <div class="hb-btn-row">
                                    <a href="<?php echo $primaryCta['url']; ?>" class="hb-btn-primary" target="<?php echo $primaryCta['target']; ?>">
                                    <?php echo $primaryCta['title']; ?></a>
                                </div>
                             <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php echo klyp_minimize_css(klyp_process_css($customCss)); ?>
<?php endif; ?>
