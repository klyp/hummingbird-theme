<?php
    // General.
    $componentId    = get_sub_field('component_image_content_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_image_content_class');

    //Settings.
    $image          = get_sub_field('component_image_content_image');
    $heading        = get_sub_field('component_image_content_heading');
    $description    = get_sub_field('component_image_content_desciption');
?>

<section id="<?php echo $componentId; ?>" class="hb-about-text <?php echo $componentClass; ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="hb-about-text__image">
                    <img src="<?php echo $image; ?>" alt="" class="img-fluid">
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
