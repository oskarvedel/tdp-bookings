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

// function handle_new_booking($new_status, $old_status, $post)
// {
//     trigger_error('handle_new_booking called', E_USER_NOTICE);
//     if ($new_status == 'publish' && $old_status != 'publish' && $post->post_type == 'booking') { //check if its a brand new post
//         send_email('New booking created: ' . $post->post_title, 'New booking created');
//     }
// }
// add_action('transition_post_status', 'handle_new_booking', 50, 3);


// function handle_new_booking($new_status, $old_status, $post)
// {
//     trigger_error('handle_new_booking called', E_USER_NOTICE);
//     if ('booking' === $post->post_type) {
//         if ('publish' === $new_status && 'publish' !== $old_status) {
//             error_log('New booking created: ' . $post->post_title);
//             send_email('New booking created: ' . $post->post_title, 'New booking created');
//         }
//     }
// }
// add_action('transition_post_status', 'handle_new_booking', 10, 3);


function handle_new_booking2($new_status, $old_status, $post)
{
    trigger_error('handle_new_booking called', E_USER_NOTICE);
    if ('booking' === $post->post_type) {
        if ('publish' === $new_status && 'publish' !== $old_status) {
            error_log('New booking created: ' . $post->post_title);
            send_email('New booking created: ' . $post->post_title, 'New booking created');
        }
    }
}
add_action('transition_post_status', 'handle_new_booking2', 11, 3);
