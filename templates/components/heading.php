<?php
    // General.
    $componentId     = get_field('component_heading_id') ?: 'random_' . rand();
    $componentClass  = get_field('component_heading_class');
    $enableComponent = get_field('component_heading_enable');
    $globalComponent = get_field('component_heading_global_component');

    //Settings.
    $headingTitle    = klyp_get_the_field_values($globalComponent, 'heading', 'heading');
    $headingDesc     = klyp_get_the_field_values($globalComponent, 'heading', 'description');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-intro <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-short-content text-center">
                        <h2 class="hb-short-content__title">
                            <?php echo $headingTitle; ?>
                        </h2>
                        <div class="hb-short-content__text">
                            <?php echo $headingDesc; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
