<?php
    // General.
    $componentId    = get_sub_field('component_content_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_content_class');

    //Settings.
    $image          = get_sub_field('component_content_header_image');
    $header         = get_sub_field('component_content_header');
    $description    = get_sub_field('component_content_description');
?>

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