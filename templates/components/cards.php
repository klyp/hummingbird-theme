<?php
    // General.
    $componentId          = get_sub_field('component_cards_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_cards_class');
    $enableComponent      = get_sub_field('component_card_enable');

    //Settings.
    $style          = get_sub_field('component_cards_style');
    $style_color    = get_sub_field('component_cards_bg_color') ?: '#d7499a';
    $cards          = get_sub_field('component_cards');

switch ($style) {
    case 'icon-grid-wo-bg':
        $sectionClass           = 'mb-5';
        $backgroundColorClass   = '';
        $checkIconOrImage       = 'hb-card__icon';
        $style_color            = '';
        $layout                 = '1';
        break;

    case 'icon-grid-w-bg':
        $sectionClass           = 'hb-card--bg';
        $backgroundColorClass   = 'hb-card__col--white';
        $checkIconOrImage       = 'hb-card__icon';
        $layout                 = '1';
        break;

    case 'image-grid-w-border':
        $sectionClass           = '';
        $backgroundColorClass   = '';
        $style_color            = '';
        $checkIconOrImage       = 'hb-card__image';
        $layout                 = '1';
        break;

    case 'image-grid-wo-border':
    default:
        $layout                 = '2';
        $style_color            = '';
        break;
}
?>
<?php if ($enableComponent): ?>
<?php if ($layout == '1') : ?>
    <section id="<?php echo $componentId; ?>" class="hb-card <?php echo $componentClass; ?>
    <?php echo $sectionClass; ?>" style="background-color: <?php echo $style_color; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <div class="hb-col-full">
                    <div class="hb-card__row">
                        <?php foreach ($cards as $key => $card) : ?>
                            <div class="hb-card__col <?php echo $backgroundColorClass; ?>">
                                <div class="hb-card__content hb-card__content--border text-center">
                                    <div class="<?php echo $checkIconOrImage; ?>">
                                        <picture>
                                            <source srcset="<?php echo get_post_meta($card['icon']['id'], '_webp_generated_url', true);?>" type="image/webp">
                                            <source srcset="<?php echo $card['icon']['url']; ?>" type="image/jpeg">
                                            <img src="<?php echo $card['icon']['url']; ?>" class="img-fluid" alt="">
                                        </picture>
                                    </div>
                                    <div class="hb-card__content-space">
                                        <h2 class="hb-card__title">
                                            <?php echo $card['header']; ?>
                                        </h2>
                                        <?php if (isset($card['social_icons']) && ! empty($card['social_icons'])) : ?>
                                            <ul class="hb-card__social-list list-inline">
                                                <?php foreach ($card['social_icons'] as $key => $social_icon) : ?>
                                                    <li class="hb-card__social-list-item list-inline-item">
                                                        <a href="<?php echo $social_icon['social_link']['url']; ?>">
                                                            <?php echo $social_icon['social_icon']; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <div class="hb-card__text">
                                            <?php echo wpautop($card['description']); ?>
                                        </div>
                                        <?php if (isset($card['cta']) && ! empty($card['cta'])) : ?>
                                            <div class="hb-card__link">
                                                <a href="<?php echo $card['cta']['url']; ?>" class="hb-btn-primary hb-btn-primary--outline hb-btn-primary--outline-gray" target="<?php echo $card['cta']['target']; ?>"><?php echo $card['cta']['title']; ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif ($layout == '2') : ?>
    <section class="hb-card">
        <div class="hb-container">
            <div class="hb-card__layout-row">
                <?php foreach ($cards as $key => $card) : ?>
                    <div class="hb-card__layout-col">
                        <div class="hb-card__content hb-card__content--no-border text-center">
                            <div class="hb-card__image">
                                <picture>
                                    <source srcset="<?php echo get_post_meta($card['icon']['id'], '_webp_generated_url', true);?>" type="image/webp">
                                    <source srcset="<?php echo $card['icon']['url']; ?>" type="image/jpeg">
                                    <img src="<?php echo $card['icon']['url']; ?>" class="img-fluid" alt="">
                                </picture>
                            </div>
                            <h2 class="hb-card__title">
                                <?php echo $card['header']; ?>
                            </h2>
                            <div class="hb-card__text">
                                <?php echo wpautop($card['description']); ?>
                            </div>
                            <div class="hb-card__link">
                                <?php if (isset($card['cta']) && ! empty($card['cta'])) : ?>
                                    <a href="<?php echo $card['cta']['url']; ?>" class="hb-btn-primary hb-btn-primary--outline hb-btn-primary--outline-gray" target="<?php echo $card['cta']['target']; ?>"><?php echo $card['cta']['title']; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php endif; ?>
