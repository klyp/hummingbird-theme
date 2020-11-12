<?php
    // General.
    $componentId          = get_sub_field('component_heading_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_heading_class');
    $enableComponent      = get_sub_field('component_heading_enable');

    //Settings.
    $headingTitle   = get_sub_field('component_heading_title');
    $headingDesc    = get_sub_field('component_heading_description');
?>

<?php if ($enableComponent): ?>
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
