<?php
    // General.
    $componentId    = get_sub_field('component_images_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_images_class');

    //Settings.
    $imageTitle     = get_sub_field('component_images_title');
    $imageDesc      = get_sub_field('component_images_description');
    $imageItems     = get_sub_field('component_images_items');
?>

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
                    <img src="<?php echo $imageItem['image']['url']; ?>" alt="<?php echo $imageItem['image']['title']; ?>" class="img-fluid">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
