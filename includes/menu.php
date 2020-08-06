<?php

    $mainLogoUrl        = get_field('logo', 'options') ?: get_stylesheet_directory_uri() . '/assets/src/image/logo/logo.png';
    $mobileLogoUrl      = get_stylesheet_directory_uri() . '/assets/src/image/icon/call-gray.svg';
    $menuCloseIconUrl   = get_stylesheet_directory_uri() . '/assets/dist/img/nav-close-icon.svg';
    $contactNumber      = ! empty(get_field('settings_contact', 'options')['settings_contact_number']) ? get_field('settings_contact', 'options')['settings_contact_number'] : '';
    $primaryMenu        = klyp_generate_nav_menu('menu-primary');

?>

<nav class="hb-header__nav navbar navbar-expand-lg px-0">
    <a href="<?= get_home_url(); ?>" class="hb-header__brand navbar-brand">
        <img src="<?= $mainLogoUrl; ?>" class="img-fluid hb-header__nav-logo" alt="<?= get_bloginfo('name'); ?>">
    </a>
    <?php if (! empty($contactNumber)) : ?>
        <a href="tel:<?= $contactNumber; ?>" class="hb-header__call-mob">
            <img src="<?= $mobileLogoUrl; ?>" class="img-fluid" alt="">
        </a>
    <?php endif; ?>
    <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarSupportedContent" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto align-items-lg-center">
            <?php foreach ($primaryMenu as $index => $item) : ?>
                <?php if (isset($item['children']) && count($item['children']) > 0) : ?>
                    <li class="nav-item dropdown <?= $index == 0 ? 'active' : ''; ?>">
                        <a href="<?= $item['url']; ?>" id="navbarDropdown" class="nav-link dropdown-toggle <?= implode(' ', $item['class']); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $item['title']; ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($item['children'] as $subItem) : ?>
                                <a href="<?= $subItem['url']; ?>" class="dropdown-item <?= implode(' ', $subItem['class']); ?>">
                                <?= $subItem['title']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="<?= $item['url']; ?>" class="nav-link <?= implode(' ', $item['class']); ?>">
                            <?= $item['title']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
