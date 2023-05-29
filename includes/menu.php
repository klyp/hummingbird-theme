<?php

    $mainLogoUrl        = get_field('settings_logo', 'option')['settings_logo_primary'] ?: get_stylesheet_directory_uri() . '/assets/src/image/logo/logo.png';
    $mobileLogoUrl      = get_stylesheet_directory_uri() . '/assets/src/image/icon/call-gray.svg';
    $menuCloseIconUrl   = get_stylesheet_directory_uri() . '/assets/dist/img/nav-close-icon.svg';
    $contactNumber      = ! empty(get_field('settings_contact', 'option')['settings_contact_number']) ? get_field('settings_contact', 'option')['settings_contact_number'] : '';
    $primaryMenu        = klyp_generate_nav_menu('menu-primary');

?>

<nav class="hb-header__nav navbar navbar-expand-lg px-0">
    <a href="<?php echo get_home_url(); ?>" class="hb-header__brand navbar-brand">
        <img src="<?php echo $mainLogoUrl; ?>" class="img-fluid hb-header__nav-logo" alt="<?php echo get_bloginfo('name'); ?>">
    </a>
    <?php if (! empty($contactNumber)) : ?>
        <a href="tel:<?php echo $contactNumber; ?>" class="hb-header__call-mob">
            <img src="<?php echo $mobileLogoUrl; ?>" class="img-fluid" alt="">
        </a>
    <?php endif; ?>
    <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarSupportedContent" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto align-items-lg-center">
            <?php foreach ($primaryMenu as $index => $item) : ?>
                <?php if (isset($item['children']) && count($item['children']) > 0) : ?>
                    <li class="nav-item dropdown <?php echo $index == 0 ? 'active' : ''; ?>">
                        <a href="<?php echo $item['url']; ?>" id="navbarDropdown" class="nav-link dropdown-toggle <?php echo implode(' ', $item['class']); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $item['title']; ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($item['children'] as $subItem) : ?>
                                <a href="<?php echo $subItem['url']; ?>" class="dropdown-item <?php echo implode(' ', $subItem['class']); ?>">
                                <?php echo $subItem['title']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="<?php echo $item['url']; ?>" class="nav-link <?php echo implode(' ', $item['class']); ?>">
                            <?php echo $item['title']; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
