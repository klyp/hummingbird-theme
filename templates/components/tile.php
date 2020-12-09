<?php
    // General.
    $componentId          = get_sub_field('component_tile_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_tile_class');
    $enableComponent      = get_sub_field('component_tile_enable');

    // Settings
    $tileData             = get_sub_field('component_tile_data');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-counter hb-bg-light text-center <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <?php foreach ($tileData as $data) { ?>
                    <?php $style = ''; ?>
                    <?php if (! empty($data['image'])) { ?>
                        <?php $style = 'style="background-image: url(' . $data['image'] . ');"' ?>
                    <?php } ?>
                    <div class="col-4" <?php echo $style; ?>>
                        <a href="<?php echo $data['link']['url']; ?>"
                            <?php echo ($data['link']['target']) ? 'target="_blank"' : ''; ?>>
                            <?php echo $data['link']['title']; ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>
