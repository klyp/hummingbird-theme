<?php
    // General.
    $componentId     = get_field('component_counter_id') ?: 'random_' . rand();
    $componentClass  = get_field('component_counter_class');
    $enableComponent = get_field('component_counter_enable');
    $globalComponent = get_field('component_counter_global_component');

    //Settings.
    $enableIcon      = klyp_get_the_field_values($globalComponent, 'counter', 'enable_icons');
    $counters        = klyp_get_the_field_values($globalComponent, 'counter', 'counters');

if ($enableIcon) {
    $countClass     = 'hb-counter__count--gray';
    $contentClass   = '';
} else {
    $countClass     = '';
    $contentClass   = 'm-0';
}
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-counter hb-bg-light text-center <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <?php foreach ($counters as $key => $counter) : ?>
                    <div class="hb-counter__col">
                        <div class="hb-counter__content <?php echo $contentClass; ?>">
                            <?php if ($enableIcon) : ?>
                                <div class="hb-counter__icon">
                                    <img src="<?php echo $counter['icon']['url'] ?>" alt="<?php echo $counter['icon']['title'] ?>">
                                </div>
                            <?php endif; ?>
                            <h2 class="hb-counter__count <?php echo $countClass; ?>">
                                <span class="hb-counter__number">
                                    <?php echo $counter['stat'] ?>
                                </span>
                            </h2>
                            <div class="hb-counter__title">
                                <?php echo $counter['title'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
