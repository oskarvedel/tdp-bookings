<?php

/**
 * Plugin Name: tdp-bookings
 * Version: 1.0
 */

require_once dirname(__FILE__) . '/handle-booking-form.php';

function custom_rewrite_booking_confirmation()
{
    add_rewrite_rule('^reservation/confirmation/([0-9]+)/?$', 'index.php?pagename=reservation-confirmation&booking_id=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_booking_confirmation');

function custom_query_vars_filter($vars)
{
    $vars[] .= 'booking_id';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars_filter');

function custom_template_include($template)
{
    if (get_query_var('booking_id')) {
        $new_template = locate_template(array('reservation-confirmation.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'custom_template_include', 99);
