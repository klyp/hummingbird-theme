<?php
    // General.
    $componentId     = get_sub_field('component_accordion_id') ?: 'random_' . rand();
    $componentClass  = get_sub_field('component_accordion_class');
    $enableComponent = get_sub_field('component_accordion_enable');
    $globalComponent = get_sub_field('component_accordion_global_component');

    //Settings.
    $accordionItems  = klyp_get_the_field_values($globalComponent, 'accordion', 'accordion_items');
    $accordionIcon   = klyp_get_the_field_values($globalComponent, 'accordion', 'accordion_fa_icon');
?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="hb-accordion <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div id="accordion">
                        <?php
                        foreach ($accordionItems as $key => $accordionItem) :
                            $accordionId = ! empty($accordionItem['id']) ? $accordionItem['id'] :
                            'accordion-' . $key . '-' . rand();
                            if ($key == 0) :
                                $accordionCollapse = '';
                                $accordionShow = 'show';
                            else :
                                $accordionCollapse = 'collapsed';
                                $accordionShow = '';
                            endif;
                            ?>
                            <div class="hb-accordion__card card">
                                <div id="headingOne" class="card-header hb-accordion__card-header">
                                    <button class="hb-accordion__card-btn btn btn-link <?php echo $accordionCollapse; ?>"data-toggle="collapse" data-target="#<?php echo $accordionId; ?>" aria-expanded="true" aria-controls="<?php echo $accordionId; ?>">
                                        <?php echo $accordionItem['title']; ?>
                                    </button>
                                    <div class="hb-accordion__card-icon">
                                        <?php echo $accordionIcon; ?>
                                    </div>
                                </div>
                                <div id="<?php echo $accordionId; ?>" class="collapse <?php echo $accordionShow; ?>" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body hb-accordion__card-body">
                                        <?php echo $accordionItem['description']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
