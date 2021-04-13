<?php
    // General.
    $componentId     = get_sub_field('component_blockquote_id') ?: 'random_' . rand();
    $componentClass  = get_sub_field('component_blockquote_class');
    $enableComponent = get_sub_field('component_blockquote_enable');
    $globalComponent = get_sub_field('component_blockquote_global_component');

    //Settings.
    $blockquote      = klyp_get_the_field_values($globalComponent, 'blockquote', 'quote');
?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="hb-general <?php echo $componentClass; ?>">
        <div class="hb-general__blockquote">
            <div class="hb-container">
                <div class="hb-row">
                    <div class="hb-col-full">
                        <div class="hb-general__blockquote-container">
                            <div class="hb-general__blockquote-text">
                                <?php echo wpautop($blockquote); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
