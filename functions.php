<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
//include files]
include_once get_stylesheet_directory() . '/functions/admin/admin-functions.php'; //admin functions all
include_once get_stylesheet_directory() . '/functions/scripts.php';
include_once get_stylesheet_directory() . '/functions/shortcodes.php';
include_once get_stylesheet_directory() . '/functions/custom-post-types.php';
include_once get_stylesheet_directory() . '/functions/metaboxes.php';
include_once get_stylesheet_directory() . '/functions/ajaxs.php';
// Actions & Hooks
//after setup theme hook
add_action('after_setup_theme', 'my_theme_add_woocommerce_support');
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');
//rewrite url
add_action('init', 'custom_rewrite_rules');
//add query var
add_filter('query_vars', 'socks_query_vars');
//template redirect
add_action('template_redirect', 'custom_template_redirect');
//logout hook
add_action('wp_logout', 'redirect_after_logout', 2);

// Add theme support for WooCommerce
function my_theme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
    flush_rewrite_rules();
    //hide admin bar
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}


// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;


// END ENQUEUE PARENT ACTION


// add_filter('wp_authenticate_user', function ($user) {
//     if (get_user_meta($user->ID, 'user_flag', true) == 'active') {
//         return $user;
//     }
//     return new WP_Error('Account is Not Active!');
// }, 10, 2);

function redirect_after_logout($user_id)
{
    $current_user = get_user_by('id', $user_id);
    $roles        = $current_user->roles;
    if (!in_array('administrator', $roles)) {
        wp_safe_redirect(site_url('/logga-in/'));
        exit;
    }
}


//create role:


// Check if the 'reseller' role doesn't exist
if (!get_role('reseller')) {
    add_role('reseller', __('Reseller'), array(
        'read'                      => true,
        'edit_posts'                => true,
        'upload_files'              => true,
        'edit_published_posts'      => true,
        'publish_posts'             => true,
        'delete_published_posts'    => true,
        'delete_posts'              => true,
        'create_posts'              => true,
        'manage_categories'         => true,
        'manage_woocommerce'        => true, // WooCommerce capabilities
        'view_woocommerce_reports'  => true, // View WooCommerce reports
        'edit_product'              => true,
        'read_product'              => true,
        'delete_product'            => true,
        'edit_products'             => true,
        'edit_others_products'      => true,
        'publish_products'          => true,
        'read_private_products'     => true,
        'delete_products'           => true,
        'delete_private_products'   => true,
        'delete_published_products' => true,
        'delete_others_products'    => true,
        'edit_private_products'     => true,
        'edit_published_products'   => true,
        'create_products'           => true,
        // Add more capabilities based on your requirements
    ));
}


// Register the query variable
function socks_query_vars($vars)
{
    $vars[] = 'reseller_username';
    $vars[] = 'member_username';
    $vars[] = 'reseller_dashboard';
    $vars[] = 'reseller_shopsettings';
    $vars[] = 'reseller_sales';
    $vars[] = 'reseller_edit_profile';
    $vars[] = 'user_change_password';
    $vars[] = 'team_register';
    $vars[] = 'team_members';
    $vars[] = 'payment_info';
    return $vars;
}

// Redirect to custom template when reseller_username is present
function custom_template_redirect()
{
    global $wp_query;

    $reseller_username      = $wp_query->get('reseller_username');
    $reseller_dashboard     = $wp_query->get('reseller_dashboard');
    $reseller_shopsettings  = $wp_query->get('reseller_shopsettings');
    $reseller_sales         = $wp_query->get('reseller_sales');
    $reseller_edit_profile  = $wp_query->get('reseller_edit_profile');
    $user_change_password   = $wp_query->get('user_change_password');
    $team_register          = $wp_query->get('team_register');
    $team_members           = $wp_query->get('team_members');
    $payment_info           = $wp_query->get('payment_info');
    $current_user           = wp_get_current_user();
    if ($reseller_username) {
        // Specify the path to your custom reseller profile template file
        $custom_template = get_stylesheet_directory() . '/page-templates/reseller/reseller-profile.php';

        if (file_exists($custom_template)) {
            include $custom_template;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($reseller_dashboard) {
        // Specify the path to your custom reseller dashboard template file
        $dashboard_template = get_stylesheet_directory() . '/page-templates/dashboard.php';

        if (file_exists($dashboard_template)) {
            include $dashboard_template;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($reseller_shopsettings) {
        // Specify the path to your custom reseller dashboard template file
        $shop_settings_template = get_stylesheet_directory() . '/page-templates/reseller/reseller-shop-settings.php';

        if (file_exists($shop_settings_template)) {
            include $shop_settings_template;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($reseller_sales) {
        // Specify the path to your custom reseller dashboard template file
        $reseller_sales_tempalte = get_stylesheet_directory() . '/page-templates/reseller/reseller-sales.php';

        if (file_exists($reseller_sales_tempalte)) {
            include $reseller_sales_tempalte;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($reseller_edit_profile) {
        // Specify the path to your custom reseller dashboard template file
        $reseller_profile_edit_tempalte = get_stylesheet_directory() . '/page-templates/reseller/reseller-edit-profile.php';

        if (file_exists($reseller_profile_edit_tempalte)) {
            include $reseller_profile_edit_tempalte;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($user_change_password) {
        // Specify the path to your custom reseller dashboard template file
        $user_change_password_tempalte = get_stylesheet_directory() . '/page-templates/change-password.php';

        if (file_exists($user_change_password_tempalte)) {
            include $user_change_password_tempalte;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($team_members) {
        // Specify the path to your custom team register template file
        $team_members_template = get_stylesheet_directory() . '/page-templates/reseller/team-members.php';

        if (file_exists($team_members_template)) {
            include $team_members_template;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($team_register) {
        // Specify the path to your custom team register template file
        $team_register_template = get_stylesheet_directory() . '/page-templates/reseller/team-register.php';

        if (file_exists($team_register_template)) {
            include $team_register_template;
            exit();  // Make sure to exit after including the template
        }
    } elseif ($payment_info) {
        // Specify the path to your custom team register template file
        $payment_info_template = get_stylesheet_directory() . '/page-templates/reseller/payment-info.php';

        if (file_exists($payment_info_template)) {
            include $payment_info_template;
            exit();  // Make sure to exit after including the template
        }
    }
}

// Custom rewrite rules for Polylang integration
function custom_rewrite_rules()
{
    // Add rewrite rule for reseller pages
    $reseller_base = "lag/([^/]+)/?$";
    add_rewrite_rule($reseller_base, 'index.php?reseller_username=$matches[1]', 'top');

    $reseller_base = 'lag/([^/]+)/([^/]+)/?$';
    add_rewrite_rule($reseller_base, 'index.php?reseller_username=$matches[1]&member_username=$matches[2]', 'top');

    // Add rewrite rule for the reseller-dashboard
    $dashboard_base = "user/dashboard/?$";
    add_rewrite_rule($dashboard_base, 'index.php?reseller_dashboard=1', 'top');

    // Add rewrite rule for shop settings
    $shopsettings_base = 'user/shop-settings/?$';
    add_rewrite_rule($shopsettings_base, 'index.php?reseller_shopsettings=1', 'top');

    // Add rewrite rule for sales
    $orders_base = 'user/orders/?$';
    add_rewrite_rule($orders_base, 'index.php?reseller_sales=1', 'top');

    // Add rewrite rule for profile edit
    $profile_edit_base = 'user/edit-profile/?$';
    add_rewrite_rule($profile_edit_base, 'index.php?reseller_edit_profile=1', 'top');

    // Add rewrite rule for change password
    $change_password_base = 'user/change-password/?$';
    add_rewrite_rule($change_password_base, 'index.php?user_change_password=1', 'top');

    // Add rewrite rule for team members list
    $team_members_base = 'user/team-members/?$';
    add_rewrite_rule($team_members_base, 'index.php?team_members=1', 'top');

    // Add rewrite rule for team register
    $team_register_base = 'user/team-register/?$';
    add_rewrite_rule($team_register_base, 'index.php?team_register=1', 'top');

    // Add rewrite rule for team register
    $payment_info = 'user/payment-info/?$';
    add_rewrite_rule($payment_info, 'index.php?payment_info=1', 'top');

    // Flush rewrite rules
    flush_rewrite_rules();
}



// add_action('woocommerce_cart_calculate_fees', 'change_currency_on_country_update');

// function change_currency_on_country_update() {
//     if (is_admin() && !defined('DOING_AJAX')) {
//         return;
//     }

//     $country = WC()->customer->get_billing_country();

//     if (class_exists('WOOMULTI_CURRENCY_F_Data')) {
//         $wmc = WOOMULTI_CURRENCY_F_Data::get_ins();
//         switch ($country) {
//             case 'CA':
//                 $wmc->set_current_currency('CAD');
//                 break;
//             default:
//                 $wmc->set_current_currency('USD');
//         }
// 		var_dump($wmc);
// 		exit();
//     }
// }


/*****************************
 * Send email socks
 * 
 *****************************/
add_action('socks_send_email_template_action', 'socks_send_email_template', 11, 3);

if (!function_exists('socks_send_email_template')) {
    /**
     * First parameter template name, second one user id where the mail will send third one mail will send to admin or not true false
     */
    function socks_send_email_template($template_id = '', $user_id = '', $admin_send_email =  '')
    {
        $admin_email = get_option('admin_email');
        if (!empty($user_id)) {
            $user_data  = get_userdata($user_id);
            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name  = get_user_meta($user_id, 'last_name', true);
            // Define user data (you need to replace these with actual user data)
            $user_info = array(
                '{{username}}'      => $user_data->user_login,
                '{{first_name}}'    => $first_name,
                '{{last_name}}'     => $last_name,
                '{{full_name}}'     => $first_name . ' ' . $last_name,
                '{{email}}'         => $user_data->user_email,
                '{{admin_email}}'   => $admin_email,
                '{{site_url}}'      => site_url(),
            );
        }

        // Retrieve the email template content from the options table
        $email_data = get_option('socks_email_templates', array($template_id => ''))[$template_id];
        $subject    = isset($email_data['subject']) ? $email_data['subject'] : '';
        $body       = isset($email_data['body']) ? $email_data['body'] : '';

        // Replace placeholders with actual user data
        $email_body = str_replace(array_keys($user_info), array_values($user_info), $body);
        $site_name = get_bloginfo('name');

        // Include the email template file containing the full email content
        $email_template_file = get_stylesheet_directory() . '/page-templates/emails/' . $template_id . '.php';
        if (file_exists($email_template_file)) {
            $email_template_file = $email_template_file;
        } else {
            $email_template_file = get_stylesheet_directory() . '/page-templates/emails/default.php';
        }
        if (!is_wp_error($email_template_file)) {
            ob_start();
            include $email_template_file;
            $email_content = ob_get_clean();
            // Send email using wp_mail to reseller
            // $subject = 'Your Email Subject Here'; // Set your email subject
            $to_signup_user = $user_data->user_email; // Set recipient email address
            // $headers = array('Content-Type: text/html; charset=UTF-8');
            // Set headers
            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $site_name . ' <' . $admin_email . '>', // Set "From" name and email address
            );
            // Send email
            wp_mail($to_signup_user, $subject, $email_content, $headers);

            if ($admin_send_email) {
                // Send email using wp_mail to site admin

                $to_admin = $admin_email; // Set recipient email address
                // $headers = array('Content-Type: text/html; charset=UTF-8');
                // Set headers
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . $site_name . ' <' . $user_data->user_email . '>', // Set "From" name and email address
                );
                // Send email
                wp_mail($to_admin, $subject, $email_content, $headers);
            }
        }
    }
}


// Custom hidden field in add to cart form
add_action('woocommerce_before_add_to_cart_button', 'hidden_field_before_add_to_cart_button', 5);
function hidden_field_before_add_to_cart_button()
{
    // Check if resellerid parameter is set in the URL
    $resellerid = isset($_GET['resellerid']) ? sanitize_text_field($_GET['resellerid']) : '';

    // Output the hidden field
    if (!empty($resellerid)) {
        echo '<input type="hidden" name="socksresellerid" id="socksresellerid" value="' . esc_attr($resellerid) . '">';
    }
}

// Store reseller ID in session
add_action('woocommerce_add_to_cart', 'store_reseller_id_in_session');
function store_reseller_id_in_session()
{
    if (isset($_POST['socksresellerid']) && !empty($_POST['socksresellerid'])) {
        WC()->session->set('socksresellerid', sanitize_text_field($_POST['socksresellerid']));
    }
}

add_action('woocommerce_checkout_create_order', 'add_custom_field_on_placed_order', 10, 2);

function add_custom_field_on_placed_order($order, $data)
{
    // Assuming you want to use a dynamic value instead of the hardcoded 31.
    $reseller_id = WC()->session->get('socksresellerid');

    if ($reseller_id) {
        $is_team = get_user_meta($reseller_id, 'reseller_id', true);
        if ($is_team) {
            $order->update_meta_data('referenceNumber', $is_team);
            $order->update_meta_data('team_id', $reseller_id);
        } else {
            $order->update_meta_data('referenceNumber', $reseller_id);
        }
    }
}


// Display custom field in the admin order details
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_field_in_admin_order_details', 10, 1);
function display_custom_field_in_admin_order_details($order)
{
    //reseler name
    $resellerid = $order->get_meta('referenceNumber');
    if ($resellerid) {
        $reseller_user = get_user_by('id', $resellerid);
        if ($reseller_user) {
            echo '<p><strong>' . __('Reseler Name') . ':</strong> ' . esc_html($reseller_user->display_name) . '</p>';
        }
    }

    //team name
    $team_id = $order->get_meta('team_id');
    if ($team_id) {
        $team = get_user_by('id', $team_id);
        if ($team) {
            echo '<p><strong>' . __('Team Name') . ':</strong> ' . esc_html($team->display_name) . '</p>';
        }
    }
}


function woocommerce_new_pass_redirect($user)
{
    wp_redirect(site_url('logga-in'));
    exit;
}

add_action('woocommerce_customer_reset_password', 'woocommerce_new_pass_redirect');
