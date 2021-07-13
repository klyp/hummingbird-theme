<?php
    // General.
    $componentId     = get_sub_field('component_images_id') ?: 'random_' . rand();
    $componentClass  = get_sub_field('component_images_class');
    $enableComponent = get_sub_field('component_images_enable');
    $globalComponent = get_sub_field('component_images_global_component');

    //Settings.
    $imageTitle      = klyp_get_the_field_values($globalComponent, 'images', 'title');
    $imageDesc       = klyp_get_the_field_values($globalComponent, 'images', 'description');
    $imageItems      = klyp_get_the_field_values($globalComponent, 'images', 'gallery');
?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="hb-gallery <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full text-center">
                    <h2 class="hb-gallery__title">
                        <?php echo $imageTitle; ?>
                    </h2>
                    <div class="hb-gallery__intro">
                        <div class="m-0">
                            <?php echo $imageDesc; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row hb-gallery__row">
                <?php foreach ($imageItems as $key => $imageItem) : ?>
                    <div class="hb-gallery__col">
                        <picture>
                            <source srcset="<?php echo get_post_meta($imageItem['image']['id'], '_webp_generated_url', true);?>" type="image/webp">
                            <source srcset="<?php echo $imageItem['image']['url']; ?>" type="image/jpeg">
                            <img data-src="<?php echo $imageItem['image']['url']; ?>" alt="<?php echo $imageItem['image']['title']; ?>" class="img-fluid">
                        </picture>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
