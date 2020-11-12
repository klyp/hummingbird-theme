<?php
    // General.
    $componentId          = get_sub_field('component_breadcrumb_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_breadcrumb_class');
    $enableComponent      = get_sub_field('component_breadcumb_enable');

    //Settings.
    $breadcrumbTitle      = get_sub_field('component_breadcrumb_title');
    $breadcrumbTitleColor = get_sub_field('component_breadcrumb_title_color') ?: '#ffffff' ;
    $breadcrumbColor1     = get_sub_field('component_breadcrumb_color1') ?: '#d7499a' ;
    $breadcrumbColor2     = get_sub_field('component_breadcrumb_color2') ?: '#b82932' ;
    $breadcrumbItems      = get_sub_field('component_breadcrumb_items');

    // generate css
    $customCss[$componentId]['desktop'] = array (
        'background' => 'linear-gradient(135.31deg, ' . $breadcrumbColor1 . ', ' . $breadcrumbColor2 . ');',
        '.hb-breadcumb__title' => array (
            'color' => $breadcrumbTitleColor,
        ),
    );
    ?>

<?php if ($enableComponent): ?>
<section id="<?php echo $componentId; ?>" class="hb-breadcumb hb-gradient-primary hb-breadcumb--color-white <?php echo $componentClass; ?>">
    <div class="hb-container">
        <div class="hb-row">
            <div class="hb-col-full">
                <h2 class="hb-breadcumb__title">
                    <?php echo $breadcrumbTitle; ?>
                </h2>
            </div>
            <div class="hb-col-full">
                <nav aria-label="breadcrumb" class="hb-breadcumb__nav">
                    <ol class="hb-breadcumb__nav-list">
                        <?php foreach ($breadcrumbItems as $key => $breadcrumbItem) : ?>
                            <?php if ($breadcrumbItem['link']['url'] == '#') : ?>
                                <li class="hb-breadcumb__item">
                                    <span><?php echo $breadcrumbItem['link']['title']; ?></span>
                                </li>
                            <?php else : ?>
                                <li class="hb-breadcumb__item">
                                    <a href="<?php echo $breadcrumbItem['link']['url']; ?>" target="<?php echo $breadcrumbItem['link']['target']; ?>">
                                    <?php echo $breadcrumbItem['link']['title']; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php echo klyp_minimize_css(klyp_process_css($customCss)); ?>
<?php endif; ?>
