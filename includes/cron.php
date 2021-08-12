<?php

/**
 * Add a cron schedule.
 * @since    1.0.0
 */
function klyp_cron_schedule()
{
    if (! wp_next_scheduled('klyp_cc_cron_schedule')) {
        wp_schedule_event(time(), 'klyp_cc_ten_minutes', 'klyp_cc_cron_schedule');
    }

    if (! wp_next_scheduled('klyp_cc_cron_logs')) {
        wp_schedule_event(time(), 'hourly', 'klyp_cc_cron_logs');
    }
}
add_action('init', 'klyp_cron_schedule');
