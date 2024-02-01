<?php

/**
 * Plugin Name: tdp-bookings
 * Version: 1.0
 */

require_once dirname(__FILE__) . '/handle-booking-form.php';
require_once dirname(__FILE__) . '/handle-new-booking.php';

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


//add admin plugin button to trigger email_test function
function add_email_test_button($links)
{
    $email_test_link = '<a href="' . admin_url('admin-post.php?action=email_test') . '">Run email_test function</a>';
    array_unshift($links, $email_test_link);
    return $links;
}
add_filter('plugin_action_links_tdp-bookings/tdp-bookings-plugin.php', 'add_email_test_button');

function email_test()
{
    global $supplier_email_template;
    // xdebug_break();
    $to = "oskar.vedel@gmail.com";
    $subject = "Ny booking fra Tjekdepot.dk";
    $headers = array(
        'From: system@tjekdepot.dk <system@tjekdepot.dk>',
        'Content-Type: text/html; charset=UTF-8',
    );

    wp_mail($to, $subject, $supplier_email_template, $headers);
    wp_redirect(admin_url('plugins.php?s=tdp&plugin_status=all'));
    exit;
}
add_action('admin_post_email_test', 'email_test');
