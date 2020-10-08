<?php
    // General.
    $componentId    = get_sub_field('component_image_column_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_image_column_class');

    //Settings.
    $title          = get_sub_field('component_image_column_title');
    $description    = get_sub_field('component_image_column_description');
    $cta            = get_sub_field('component_image_column_cta');
    $images         = get_sub_field('component_image_column_items');
?>

<section id="<?php echo $componentId; ?>" class="hb-image-column hb-bg-light hb-contact-cta pb-5 <?php echo $componentClass; ?>">
    <div class="hb-container">
        <div class="hb-row">
            <div class="hb-col-full">
                <div class="hb-short-content text-center">
                    <h2 class="hb-short-content__title">
                        <?php echo $title; ?>
                    </h2>
                    <div class="hb-short-content__text">
                        <p><?php echo $description; ?></p>
                    </div>
                    <?php if (isset($cta) && ! empty($cta)) : ?>
                        <div class="hb-contact-cta__cta">
                            <a href="<?php echo $cta['url']; ?>" class="hb-btn-primary" target="<?php echo $cta['target']; ?>">
                                <?php echo $cta['title']; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hb-image-column hb-bg-light">
    <div class="hb-container">
        <div class="hb-row">
            <?php foreach ($images as $key => $image) : ?>
                <div class="hb-image-column__col">
                    <img src="<?php echo $image['image']['url']; ?>" alt="<?php echo $image['image']['title']; ?>" class="img-fluid">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
