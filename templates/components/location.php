<?php
    // General.
    $componentId    = get_sub_field('component_location_id') ?: 'random_' . rand();
    $componentClass = get_sub_field('component_location_class');

    //Settings.
    $style          = get_sub_field('component_location_style');
    $addresses      = get_sub_field('component_location_addresses');

if ($style == 'full-width') {
    $containerClass = 'hb-container-fluid';
    $mapContentClass = 'hb-map__content--full';
} else {
    $containerClass = 'hb-container';
    $mapContentClass = '';
}
?>

<section id="<?php echo $componentId; ?>" class="hb-map <?php echo $componentClass; ?>">
    <div class="<?php echo $containerClass; ?>">
        <div class="hb-row">
            <div class="hb-col-full">
                <div class="hb-map__content <?php echo $mapContentClass; ?>">
                    <div class="hb-map__dropdown d-lg-none">
                        <select class="hb-map-select-store" name="state">
                            <?php foreach ($addresses as $key => $address) : ?>
                                <option value="store_address<?php echo $key; ?>"><?php echo $address['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="map" class="hb-map__map-height"></div>
                    <div class="hb-map__row">
                        <?php foreach ($addresses as $key => $address) : ?>
                            <div class="hb-map__col text-center" data-lat="<?php echo $address['address']['lat']; ?>" data-lng="<?php echo $address['address']['lng']; ?>" data-store="store_address<?php echo $key; ?>">
                                <div class="hb-map__location">
                                    <?php echo $address['title']; ?>
                                </div>
                                <div class="hb-map__address">
                                    <p>
                                        <?php echo $address['address']['address']; ?>
                                    </p>
                                </div>
                                <div class="hb-map__number">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/image/icon/call-gray.svg" alt="">
                                    <a href="tel:<?php echo str_replace(' ', '', $address['phone']); ?>">
                                        <?php echo $address['phone']; ?>
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
