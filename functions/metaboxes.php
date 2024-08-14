<?php

/**
 * Add or remove meta boxes for custom post types
 */
add_action('do_meta_boxes', 'socks_meta_boxes');

function socks_meta_boxes()
{
    remove_meta_box('postimagediv', 'profile-photos', 'side');
    add_meta_box('postimagediv', __('Profile Photo'), 'post_thumbnail_meta_box', 'profile-photos', 'normal', 'high');
    remove_meta_box('postimagediv', 'cover-photos', 'side');
    add_meta_box('postimagediv', __('Cover Photo'), 'post_thumbnail_meta_box', 'cover-photos', 'normal', 'high');
}
