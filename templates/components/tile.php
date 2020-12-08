<?php
    // General.
    $componentId          = get_sub_field('component_tile_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_tile_class');
    $enableComponent      = get_sub_field('component_tile_enable');

    // Settings
    $title                = get_sub_field('component_tile_title');
    $subTitle             = get_sub_field('component_tile_subtitle');
    $percentage           = get_sub_field('component_tile_percentage');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-counter hb-bg-light text-center <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="col-12">
                    <h3 class="hb-fs-banner__title hb-fs-banner__title--small"><?php echo $subTitle; ?></h3>
                    <h2 class="hb-fs-banner__title"><?php echo $title; ?></h2>
                </div>
            </div>
            <div class="hb-row">
                <?php foreach ($percentage as $key => $data) : ?>
                    <div class="hb-counter__col">
                        <div class="hb-counter__content">
                            <h2 class="hb-counter__count">
                                <span class="hb-counter__number">
                                    <?php if ($data['radio'] == 'percent') {
                                        echo $data['percent'];
                                    } else {
                                        echo $data['number'];
                                    } ?>
                                </span>
                                <?php if ($data['radio'] == 'percent') echo '%'; ?>
                            </h2>
                            <div class="hb-counter__title">
                                <?php echo $data['body']; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
