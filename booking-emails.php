<?php


function new_booking_action($new_status, $old_status, $post)
{
    if ($new_status == 'publish' && $old_status != 'publish' && $post->post_type == 'booking') { //check if its a brand new post
        send_email('New booking created: ' . $post->post_title, 'New booking created');
    }
}
add_action('transition_post_status', 'new_booking_action', 10, 3);
