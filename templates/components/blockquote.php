<?php
    // General.
    $componentId    = get_sub_field('component_blockquote_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_blockquote_class');

    //Settings.
    $blockquote     = get_sub_field('component_blockquote_quote');
?>

<section id="<?php echo $componentId; ?>" class="hb-general <?php echo $componentClass; ?>">
    <div class="hb-general__blockquote">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hb-general__blockquote-container position-relative">
                        <div class="hb-general__blockquote-text">
                            <?php echo wpautop($blockquote); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
