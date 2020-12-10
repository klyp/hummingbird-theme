<?php
    // General.
    $componentId          = get_sub_field('component_timeline_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_timeline_class');
    $enableComponent      = get_sub_field('component_timeline_enable');

    // Settings
    $timelineData         = get_sub_field('component_timeline_data');
?>

<?php if ($enableComponent) : ?>
    <section class="hb-timeline">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-timeline__items-wrapper">
                        <?php foreach ($timelineData as $data) { ?>
                            <div class="hb-timeline__item-row">
                                <div class="hb-timeline__item-column hb-timeline__item__column--left">
                                    <div class="hb-timeline__item-content">
                                        <h4><?php echo date('l, d F Y', strtotime($data['date'])); ?></h4>
                                        <h2>
                                            <?php echo $data['description']; ?>
                                        </h2>
                                    </div>
                                </div>
                                <div class="hb-timeline__line-column">
                                    <div class="hb-timeline__line">
                                        <span class="hb-timeline__line--icon">
                                        </span>
                                    </div>
                                </div>
                                <div class="hb-timeline__item-column hb-timeline__item__column--right">
                                    <div class="hb-timeline__item-date">
                                        <h4><?php echo date('l, d F Y', strtotime($data['date'])); ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
