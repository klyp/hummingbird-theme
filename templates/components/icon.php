<?php
    // General.
    $componentId    = get_sub_field('component_icon_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_icon_class');

    //Settings.
    $iconTitle      = get_sub_field('component_icon_title');
    $iconDesc       = get_sub_field('component_icon_description');
    $bgColor        = get_sub_field('component_icon_bg_color') ?: '#fafafa';
    $icons          = get_sub_field('component_icon');

    // generate css
    $customCss[$componentId]['desktop'] = array (
        'background-color' => $bgColor
    );
    ?>

<section id="<?php echo $componentId; ?>" class="hb-bg-light hb-icon-card <?php echo $componentClass; ?>">
    <div class="hb-container">
        <div class="hb-row">
            <div class="hb-icon-card__col-header">
                <h2 class="hb-gallery__title">
                    <?php echo $iconTitle; ?>
                </h2>
                <div class="hb-gallery__intro">
                    <p>
                        <?php echo $iconDesc; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="hb-icon-card__row">
            <?php foreach ($icons as $key => $icon) : ?>
                <div class="hb-icon-card__col">
                    <div class="hb-icon-card__box text-center">
                        <div class="hb-icon-card__icon">
                            <img src="<?php echo $icon['image']['url']; ?>" alt="<?php echo $icon['header']; ?>" class="img-fluid">
                        </div>
                        <div class="hb-icon-card__title">
                            <?php echo $icon['header']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php echo klyp_minimize_css(klyp_process_css($customCss)); ?>
