<?php
add_action('admin_menu', 'shocs_wp_admin_menu');

function shocs_wp_admin_menu()
{
    add_menu_page('Theme Settings', 'Theme Settings', 'manage_options', 'shocks-theme-settings-dashboard', 'shocks_email_templates', 'dashicons-admin-network', 3);
    // add_submenu_page('shocks-theme-settings-dashboard', 'Email Templates', 'Email Templates', 'manage_options', 'shocks-email-templates', 'shocks_email_templates');
    add_menu_page('Resellers', 'Resellers', 'manage_options', 'shocks-resellers', 'shocks_reseller_analytics', 'dashicons-admin-network', 3);
    // add_submenu_page('shocks-resellers', 'Analytics', 'Analytics', 'manage_options', 'shocks-reseller-analytics', 'shocks_reseller_analytics');
}

function theme_settings_dashboard()
{
    echo 'dashboard';
}

function shocks_email_templates()
{
    // Specify the path to your custom reseller dashboard template file
    $shop_settings_template = get_stylesheet_directory() . '/page-templates/admin/email-templates.php';

    if (file_exists($shop_settings_template)) {
        include $shop_settings_template;
        exit();  // Make sure to exit after including the template
    }
}


//reseller menu functions
function shocks_reseller_analytics(){
     // Specify the path to your custom reseller dashboard template file
     $reseller_analytics_template = get_stylesheet_directory() . '/page-templates/admin/reseller/reseller-analytics.php';

     if (file_exists($reseller_analytics_template)) {
         include $reseller_analytics_template;
         exit();  // Make sure to exit after including the template
     }
}