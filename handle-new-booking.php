<?php


function handle_new_booking($new_status, $old_status, $post)
{
    if ($post->post_type === 'booking') {
        if ('publish' === $new_status && 'publish' !== $old_status) {
            trigger_error('handle_new_booking called', E_USER_NOTICE);
            //allow some time for the booking fields to be updated
            sleep(10);
            error_log('New booking created: ' . $post->post_title);

            //get all the fields via post meta calls
            $first_name = get_post_meta($post->ID, 'customer_first_name', true);
            $last_name = get_post_meta($post->ID, 'customer_last_name', true);
            $email = get_post_meta($post->ID, 'customer_email_address', true);
            $phone = get_post_meta($post->ID, 'customer_phone', true);
            $move_in_date = get_post_meta($post->ID, 'move_in_date', true);
            $move_in_date_unknown = get_post_meta($post->ID, 'move_in_date_unknown', true);
            $supplier_booking_email_disabled = get_post_meta($post->ID, 'supplier_booking_email_disabled', true);
            $direct_booking_active = get_post_meta($post->ID, 'direct_booking_active', true);
            $unit_id = get_post_meta($post->ID, 'unit_link', true);
            $booking_link = get_post_meta($post->ID, 'booking_link', true);
            $supplier_email = get_post_meta($post->ID, 'supplier_email_address', true);
            $lokation_name = get_post_meta($post->ID, 'department_name', true);
            $rel_lokation = get_post_meta($post->ID, 'rel_lokation', true);
            $unit_price = get_post_meta($post->ID, 'unit_price', true);
            $department_address = get_post_meta($post->ID, 'department_address', true);


            // Construct the email body
            $email_body = "New booking created: " . $post->post_title . "\n\n";
            $email_body .= "Time of booking: " . date('Y-m-d H:i:s') . "\n";
            $email_body .= "Customer first name: " . $first_name . "\n";
            $email_body .= "Customer last name: " . $last_name . "\n";
            $email_body .= "Customer email address: " . $email . "\n";
            $email_body .= "Customer phone: " . $phone . "\n";
            $email_body .= "Move in date: " . $move_in_date . "\n";
            $email_body .= "Move in date unknown: " . $move_in_date_unknown . "\n";
            $email_body .= "Supplier booking email disabled: " . $supplier_booking_email_disabled . "\n";
            $email_body .= "Direct booking active: " . $direct_booking_active . "\n";
            $email_body .= "Unit link: " . $unit_id . "\n";
            $email_body .= "Booking link: " . $booking_link . "\n";
            $email_body .= "Supplier email address: " . $supplier_email . "\n";
            $email_body .= "Department name: " . $lokation_name . "\n";
            $email_body .= "Rel lokation: " . $rel_lokation['ID'] . "\n";
            $email_body .= "Unit price: " . $unit_price . "\n";
            $email_body .= "Department address: " . $department_address . "\n";

            send_email('New booking created: ' . $post->post_title, $email_body);
        }
    }
}
add_action('transition_post_status', 'handle_new_booking', 11, 3);
