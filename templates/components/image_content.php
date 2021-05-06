<?php
    // General.
    $componentId     = get_field('component_image_content_id') ?: 'random_' . rand();
    $componentClass  = get_field('component_image_content_class');
    $enableComponent = get_field('component_image_content_enable');
    $globalComponent = get_field('component_image_content_global_component');

    //Settings.
    $image           = klyp_get_the_field_values($globalComponent, 'image_content', 'image');
    $heading         = klyp_get_the_field_values($globalComponent, 'image_content', 'heading');
    $description     = klyp_get_the_field_values($globalComponent, 'image_content', 'description');
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-about-text <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-about-text__image">
                        <picture>
                            <source srcset="<?php echo get_post_meta($image['id'], '_webp_generated_url', true);?>" type="image/webp">
                            <source srcset="<?php echo $image['url']; ?>" type="image/jpeg">
                            <img src="<?php echo $image['url']; ?>" alt="" class="img-fluid">
                        </picture>
                    </div>
                    <?php if (! empty($heading)) : ?>
                        <h2 class="hb-about-text__title text-center">
                            <?php echo $heading; ?>
                        </h2>
                    <?php endif; ?>
                    <?php if (! empty($description)) : ?>
                        <div class="hb-about-text__content">
                            <?php echo $description; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
