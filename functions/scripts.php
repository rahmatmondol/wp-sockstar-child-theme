<?php
// to add scripts
add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 100);
if (!function_exists('child_theme_configurator_css')) :
    function child_theme_configurator_css()
    {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('hello-elementor', 'hello-elementor', 'hello-elementor-theme-style'));
        wp_enqueue_style('socks-bs5', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css', array());
        wp_enqueue_style('socks-fw', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', array());
        // Enqueue your custom JavaScript file
        wp_enqueue_script('jquery');
        wp_enqueue_script('socks-popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('socks-bs', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('socks-custom-script', trailingslashit(get_stylesheet_directory_uri()) . 'assets/script.js', array('jquery'), '1.0.0', true);
        // Localize the script with new data
        wp_localize_script(
            'socks-custom-script',
            'ajax_object',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('socks-nonce'),
            )
        );
    }
endif;
