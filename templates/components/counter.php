<?php
    // General.
    $componentId        = get_sub_field('component_counter_id') ?: 'random_' . rand();
    $componentClass     = get_sub_field('component_counter_class');

    //Settings.
    $enableIcon         = get_sub_field('component_counter_enable_icons');
    $counters           = get_sub_field('component_counter_counters');

if ($enableIcon) {
    $countClass     = 'hb-counter__count--gray';
    $contentClass   = '';
} else {
    $countClass     = '';
    $contentClass   = 'm-0';
}
?>

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
