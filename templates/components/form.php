<?php
    // General.
    $componentId     = get_field('component_form_id') ?: 'random_' . rand();
    $componentClass  = get_field('component_form_class');
    $enableComponent = get_field('component_form_enable');
    $globalComponent = get_field('component_form_global_component');

    //Settings.
    $shortcode       = klyp_get_the_field_values($globalComponent, 'form', 'shortcode');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-form <?php echo $componentClass; ?>">
        <div class="hb-form__container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <?php echo $shortcode; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
