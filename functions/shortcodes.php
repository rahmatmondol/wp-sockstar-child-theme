<?php

/**
 * Polylang Shortcode - https://wordpress.org/plugins/polylang/
 * Add this code in your functions.php
 * Put shortcode [polylang_langswitcher] to post/page for display flags
 *
 * @return string
 */
function custom_polylang_langswitcher()
{
    $output = '<style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            text-align: center;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
        }

        .dropdown-item img {
            margin-right: 5px;
            width: 20px;
            height: 20px;
        }
    </style>';

    if (function_exists('pll_the_languages')) {
        $languages = pll_the_languages(['raw' => 1, 'hide_current' => 1]);
        $output = '<div class="socks-lang-switcher">';

        if (count($languages) > 1) {
            // Multiple languages, create a dropdown
            $output .= '<div class="dropdown polylang_langswitcher">';
            $output .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

            foreach ($languages as $language) {
                if ($language['current_lang']) {
                    $output .= '<img src="' . $language['flag'] . '" alt="icon"> ' . $language['slug'];
                }
            }

            $output .= '</button>';
            $output .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

            foreach ($languages as $language) {
                $output .= '<a class="dropdown-item" href="' . $language['url'] . '"><img src="' . $language['flag'] . '" alt="icon"> ' . $language['slug'] . '</a>';
            }

            $output .= '</div>';
            $output .= '</div>';
        } else if (count($languages) === 1) {
            // Single language, display it without a dropdown
            $languageInfo = reset($languages);
            if ($languageInfo['slug'] == 'en') {
                $icon_img = '<i class="fa-solid fa-globe"></i>';
            } else {
                $icon_img = '<img src="' . $languageInfo['flag'] . '" alt="icon">';
            }
            if ($languageInfo['slug'] == 'sv') {
                $currency = 'SEK';
            } else {
                $currency = 'EUR';
            }
            $output .= '<a href="' . $languageInfo['url'] . '?wmc-currency=' . $currency . '">' . $icon_img . ' <span>' . $languageInfo['name'] . '</span></a>';
        }
        $output .= '</div>';
        return $output;
    }
}

add_shortcode('polylang_langswitcher', 'custom_polylang_langswitcher');

//reseller / agent list shortcode
add_shortcode('resellers_lists', 'socks_reseller_list');
function socks_reseller_list()
{
    ob_start();
    try {
        include_once get_stylesheet_directory() . '/page-templates/reseller/reseller-list.php';
    } catch (Exception $e) {
        return "Error loading shortcode content.";
    }
    return ob_get_clean();
}
//login page shortcode
add_shortcode('socks_login', 'socks_login');
function socks_login()
{
    ob_start();
    try {
        include_once get_stylesheet_directory() . '/page-templates/login.php';
    } catch (Exception $e) {
        return "Error loading shortcode content.";
    }
    return ob_get_clean();
}
//signup page shortcode
add_shortcode('socks_signup', 'socks_signup');
function socks_signup()
{
    ob_start();
    try {
        include_once get_stylesheet_directory() . '/page-templates/reseller/reseller-signup.php';
    } catch (Exception $e) {
        return "Error loading shortcode content.";
    }
    return ob_get_clean();
}
//Profit Calculator shortcode
add_shortcode('socks_profit_calculator', 'socks_profit_calculator');
function socks_profit_calculator()
{
    ob_start();
    try {
        include_once get_stylesheet_directory() . '/page-templates/profit-calculator.php';
    } catch (Exception $e) {
        return "Error loading shortcode content.";
    }
    return ob_get_clean();
}


// Register the shortcode
add_shortcode('my_account_button', 'my_account_shortcode');

function my_account_shortcode()
{
    ob_start();

    if (is_user_logged_in()) {
        // User is logged in
        $user = wp_get_current_user();
        $text =  __('My Account', 'hello-elementor');


        if (in_array('reseller', $user->roles)) {
            // Reseller role, display dashboard link
            $url = esc_url(home_url('user/dashboard'));
        } else {
            // Normal user, display my account link
            $url = esc_url(home_url('/my-account'));
        }
    } else {
        // User is not logged in
        $url =  esc_url(home_url('/logga-in'));
        $text =  __('Login', 'hello-elementor');
    }
    echo '<div class="socks-lang-switcher"><a href="' . $url . '"><i class="fa-solid fa-user"></i> ' . $text . '</a></div>';

    return ob_get_clean();
}
