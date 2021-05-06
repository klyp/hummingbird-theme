<?php
    // General.
    $componentId     = get_field('component_slider_id') ?: 'random_' . rand();
    $componentClass  = get_field('component_slider_class');
    $enableComponent = get_field('component_slider_enable');
    $globalComponent = get_field('component_slider_global_component');

    //Settings.
    $style           = klyp_get_the_field_values($globalComponent, 'slider', 'style');
    $leftArrow       = klyp_get_the_field_values($globalComponent, 'slider', 'slider_pre_arrow');
    $rightArrow      = klyp_get_the_field_values($globalComponent, 'slider', 'slider_next_arrow');
    $sliders         = klyp_get_the_field_values($globalComponent, 'slider', 'slides');

switch ($style) {
    case 'compact':
        $slidexClass = '';
        break;
    case 'full-width-with-fixed-height':
        $slidexClass = 'hb-slider__fix';
        break;
    case 'full-screen':
    default:
        $slidexClass = 'hb-slider__height';
}
?>

<?php if ($enableComponent) : ?>
    <section id="<?php echo $componentId; ?>" class="hb-slider <?php echo $componentClass; ?>">
        <div class="hb-slider__slide owl-carousel owl-theme">
            <?php foreach ($sliders as $key => $slider) : ?>
                <?php
                switch ($slider['alignment']) {
                    case 'center':
                        $sliderContentClass = 'hb-slider__content--center';
                        $textClass          = 'hb-slider__intro--gray';
                        $secondaryCtaClass  = 'hb-btn-primary--outline-gray';
                        break;
                    case 'right':
                        $sliderContentClass = 'hb-slider__content--right';
                        $textClass          = '';
                        $secondaryCtaClass  = '';
                        break;
                    case 'left':
                    default:
                        $sliderContentClass = '';
                        $textClass          = '';
                        $secondaryCtaClass  = '';
                }
                ?>
                <?php if ($style == 'compact') : ?>
                    <div class="<?php echo $slidexClass; ?> hb-slider__slide-item">
                <?php else : ?>
                    <div class="<?php echo $slidexClass; ?> hb-slider__slide-item" style="background-image: url('<?php echo $slider['image']['url']; ?>');">
                <?php endif; ?>
                        <div class="hb-slider__space">
                            <div class="hb-container">
                                <div class="hb-row">
                                    <div class="hb-col-full">
                                        <?php if ($style == 'compact') : ?>
                                            <div class="hb-slider__contianer-img" style="background-image: url('<?php echo $slider['image']['url']; ?>');">
                                                <div class="hb-slider-nav" style="color: <?php echo $slider['arrows_color']; ?>;">
                                                    <div class="hb-slider-nav__pre">
                                                        <?php echo $leftArrow; ?>
                                                    </div>
                                                    <div class="hb-slider-nav__next">
                                                        <?php echo $rightArrow; ?>
                                                    </div>
                                                </div>
                                        <?php endif; ?>
                                        <div class="hb-slider__content <?php echo $sliderContentClass; ?>">
                                            <?php if (! empty($slider['subtitle'])) : ?>
                                            <h5 class="hb-slider__intro <?php echo $textClass; ?>" style="color: <?php echo $slider['text_color']; ?>;">
                                                <?php echo $slider['subtitle']; ?>
                                            </h5>
                                            <?php endif; ?>
                                            <h2 class="hb-slider__title">
                                                <?php echo $slider['title']; ?>
                                            </h2>
                                            <div class="hb-slider__text <?php echo $textClass; ?>"
                                            style="color: <?php echo $slider['text_color']; ?>;">
                                                <p class="m-0">
                                                    <?php echo $slider['description']; ?>
                                                </p>
                                            </div>
                                            <div class="hb-btn-row">
                                                <?php if ($slider['primary_cta']) : ?>
                                                    <a href="<?php echo $slider['primary_cta']['url']; ?>" class="hb-btn-primary" target="<?php echo $slider['primary_cta']['target']; ?>">
                                                        <?php echo $slider['primary_cta']['title']; ?>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($slider['secondary_cta']) : ?>
                                                    <a href="<?php echo $slider['secondary_cta']['url']; ?>" class="hb-btn-primary hb-btn-primary--outline" target="<?php echo $slider['secondary_cta']['target']; ?>">
                                                    <?php echo $slider['secondary_cta']['title']; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if ($style == 'compact') : ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($style != 'compact') : ?>
                                        <div class="hb-slider-nav" style="color: <?php echo $slider['arrows_color']; ?>;">
                                            <div class="hb-slider-nav__pre">
                                                <?php echo $leftArrow; ?>
                                            </div>
                                            <div class="hb-slider-nav__next">
                                                <?php echo $rightArrow; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
