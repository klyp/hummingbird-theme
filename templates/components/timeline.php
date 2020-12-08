<?php
    // General.
    $componentId          = get_sub_field('component_timeline_id') ?: 'random_' . rand();
    $componentClass       = get_sub_field('component_timeline_class');
    $enableComponent      = get_sub_field('component_timeline_enable');

    // Settings
    $timelineData         = get_sub_field('component_timeline_data');
?>

<?php if ($enableComponent) { ?>
    <section id="<?php echo $componentId; ?>" class="hb-bg-light text-center <?php echo $componentClass; ?>">
        <?php if (! empty($timelineData)) { ?>
            <h2 class="hb-fs-banner__title">Timeline</h2>
            <?php foreach ($timelineData as $data) { ?>
                <div>
                    <?php echo $data['date']; ?>
                </div>
                <div>
                    <a class="ia-view-all__button" 
                    href="<?php echo $data['link']['url']; ?>" 
                    <?php if (! empty($data['link']['target'])) {
                        echo 'target="' . $data['link']['target'] . '"';
                    }?>>
                        <?php echo $data['link']['title']; ?>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </section>
<?php } ?>