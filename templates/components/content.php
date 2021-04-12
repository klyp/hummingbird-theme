<?php
    // General.
    $componentId     = get_sub_field('component_content_id') ?: 'random_' . rand();
    $componentClass  = get_sub_field('component_content_class');
    $enableComponent = get_sub_field('component_content_enable');
    $globalComponent = get_sub_field('component_content_global_component');

    //Settings.
    $image           = klyp_get_the_field_values($globalComponent, 'content', 'image');
    $header          = klyp_get_the_field_values($globalComponent, 'content', 'header');
    $description     = klyp_get_the_field_values($globalComponent, 'content', 'description');
?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="<?php echo $componentClass; ?> hb-general">
        <div class="hb-general__txt-img">
            <div class="hb-container">
                <div class="hb-row">
                    <div class="hb-col-full">
                        <?php if ($header) : ?>
                            <h2 class="hb-general__txt-img-title">
                                <?php echo $header; ?>
                            </h2>
                        <?php endif; ?>
                        <div class="hb-general__txt-img-image">
                            <picture>
                                <source srcset="<?php echo get_post_meta($image['id'], '_webp_generated_url', true);?>" type="image/webp">
                                <source srcset="<?php echo $image['url']; ?>" type="image/jpeg">
                                <img src="<?php echo $image['url']; ?>" class="img-fluid" alt="">
                            </picture>
                        </div>
                        <div class="hb-general__txt-img-content">
                            <?php echo $description; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
