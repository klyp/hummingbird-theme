<?php
    // General.
    $componentId    = get_sub_field('component_gallery_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_gallery_class');

    //Settings.
    $galleryItems  = get_sub_field('component_gallery_items');

if (count($galleryItems) == 6) {
    $galleryColClass = 'col-6 col-md-4';
} else {
    $galleryColClass = 'col-12 col-md-6';
}
?>

<section id="<?php echo $componentId; ?>" class="hb-gallery-popup <?php echo $componentClass; ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="hb-gallery-popup__gallery">
                    <div class="row hb-gallery-popup__gallery-row">
                        <?php foreach ($galleryItems as $key => $galleryItem) : ?>
                            <div class="<?php echo $galleryColClass; ?> col-lg">
                                <div class="hb-gallery-popup__gallery-image" style="background-image: url('<?php echo $galleryItem['image']; ?>');">
                                    <a href="<?php echo $galleryItem['image']; ?>" class="d-block hb-gallery-popup__gallery-image-icon" data-title="<?php echo $galleryItem['title']; ?>" data-caption="<?php echo $galleryItem['description']; ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/image/Gallery/popup-icon.svg" class="img-fluid popup-icon" alt="<?php echo $galleryItem['title']; ?>">
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
