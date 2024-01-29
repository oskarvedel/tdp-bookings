<?php


function handle_new_booking($new_status, $old_status, $post)
{
    trigger_error('handle_new_booking called', E_USER_NOTICE);
    if ($new_status == 'publish' && $old_status != 'publish' && $post->post_type == 'booking') { //check if its a brand new post
        send_email('New booking created: ' . $post->post_title, 'New booking created');
    }
}
add_action('transition_post_status', 'handle_new_booking', 1, 3);
