<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HummingBird
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <?php require_once locate_template('templates/partials/head.php'); ?>
</head>
<body <?php body_class(); ?>>
    <header class="hb-header">
        <div class="hb-container">
            <div class="hb-header__top-nav">
                <?php if (! empty(get_field('settings_contact', 'options')['settings_contact_number'])) : ?>
                    <a href="tel:<?= get_field('settings_contact', 'options')['settings_contact_number']; ?>" class="hb-header__top-nav-link">
                        <img src= "<?= get_stylesheet_directory_uri(); ?>/assets/src/image/icon/call-gray.svg" alt="">
                        <?= get_field('settings_contact', 'options')['settings_contact_number']; ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php require_once locate_template('includes/menu.php'); ?>
        </div>
    </header>
