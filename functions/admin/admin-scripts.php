<?php
add_action('admin_enqueue_scripts', 'shocks_admin_css_js');
function shocks_admin_css_js()
{
    // Enqueue Bootstrap CSS with proper dependencies
    wp_enqueue_style('shocks-bootstrap-iso46', get_stylesheet_directory_uri() . '/assets/css/bootstrap-iso.min.css', array(), '4.6', 'all');
    wp_enqueue_style('shocks-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.6', 'all');
    wp_enqueue_style('shocks-daterangepicker',  'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css', array(),'4.0.13', 'all');
    wp_enqueue_style('shocks-adminjs',  get_stylesheet_directory_uri() . '/assets/css/admin.css', '4.6', 'all');

    wp_enqueue_script('jquery');
    wp_enqueue_script('shocks-select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', '4.6', true);
    wp_enqueue_script('shocks-momentum', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', '1', true);
    wp_enqueue_script('shocks-daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', '1', true);
    wp_enqueue_script('shocks-adminjs',  get_stylesheet_directory_uri() . '/assets/js/admin-script.js', '4.6', true);
    wp_enqueue_editor();
    // Localize the script with new data
    wp_localize_script(
        'shocks-adminjs',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('socks-nonce'),
        )
    );
}
