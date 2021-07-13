<?php
    // General.
    $componentId     = get_sub_field('component_team_id') ?: 'random_' . rand();
    $componentClass  = get_sub_field('component_team_class');
    $enableComponent = get_sub_field('component_team_enable');
    $globalComponent = get_sub_field('component_team_global_component');

    //Settings.
    $heading         = klyp_get_the_field_values($globalComponent, 'team', 'heading');
    $teams           = klyp_get_the_field_values($globalComponent, 'team', 'teams');
?>

<?php if ($enableComponent): ?>
    <section id="<?php echo $componentId; ?>" class="hb-card-list <?php echo $componentClass; ?>">
        <div class="hb-container">
            <div class="hb-row">
                <?php if ($heading) : ?>
                <div class="hb-col-full">
                    <h2 class="hb-card-list__heading">
                        <?php echo $heading; ?>
                    </h2>
                </div>
                <?php endif; ?>
                <div class="hb-col-full">
                    <?php foreach ($teams as $key => $team) : ?>
                        <div class="hb-card-list__row">
                            <div class="hb-row">
                                <?php if ($team['image']) : ?>
                                    <div class="hb-card-list__col-profile">
                                        <div class="hb-card-list__profile">
                                        <picture>
                                            <source srcset="<?php echo get_post_meta($team['image']['id'], '_webp_generated_url', true);?>" type="image/webp">
                                            <source srcset="<?php echo $team['image']['url']; ?>" type="image/jpeg">
                                            <img data-src="<?php echo $team['image']['url']; ?>" class="img-fluid" alt="Profile Image">
                                        </picture>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="hb-card-list__col-description">
                                    <h2 class="hb-card-list__title">
                                        <?php echo $team['name']; ?>
                                    </h2>
                                    <?php if ($team['position']) : ?>
                                        <h5 class="hb-card-list__des">
                                            <?php echo $team['position']; ?>
                                        </h5>
                                    <?php endif; ?>
                                    <?php if (isset($team['socials']) && ! empty($team['socials'])) : ?>
                                        <ul class="hb-card__social-list list-inline">
                                            <?php foreach ($team['socials'] as $skey => $component_team_social) : ?>
                                                <li class="hb-card__social-list-item list-inline-item">
                                                    <a href="<?php echo $component_team_social['social_link']['url']; ?>" alt="<?php echo $component_team_social['social_link']['title']; ?>" target="<?php echo $component_team_social['social_link']['target']; ?>">
                                                        <?php echo $component_team_social['social_icon']; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if ($team['description']) : ?>
                                    <div class="hb-card-list__content">
                                        <div class="m-0">
                                            <?php echo $team['description']; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
