<?php
    // General.
    $componentId          = get_sub_field('component_tile_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_tile_class');
    $enableComponent      = get_sub_field('component_tile_enable');
    $globalComponent      = get_sub_field('component_tile_global_component');

    // Settings
    $tileData             = klyp_get_the_field_values($globalComponent, 'tile', 'tile_data');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-tile hb-bg-light text-center <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <?php foreach ($tileData as $data) { ?>
                    <?php $style = ''; ?>
                    <?php if (! empty($data['image'])) { ?>
                        <?php $style = 'style="background-image: url(' . $data['image'] . ');"' ?>
                    <?php } ?>
                    <div class="col-md-4 hb-tile__column">
                        <div class="hb-tile__column-bg" <?php echo $style; ?>>
                            <h4>
                                <a href="<?php echo $data['link']['url']; ?>"
                                    <?php echo ($data['link']['target']) ? 'target="_blank"' : ''; ?>>
                                    <?php echo $data['link']['title']; ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>
