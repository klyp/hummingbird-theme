<?php
    // General.
    $componentId    = get_sub_field('component_form_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_form_class');

    //Settings.
    $shortcode      = get_sub_field('component_form_shortcode');
?>

<section id="<?php echo $componentId; ?>" class="hb-form <?php echo $componentClass; ?>">
    <div class="hb-form__container">
        <div class="hb-row">
            <div class="hb-col-full">
                <?php echo $shortcode; ?>
            </div>
        </div>
    </div>
</section>
