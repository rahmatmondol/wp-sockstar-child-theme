<?php
// Add AJAX action for non-logged in users
add_action('wp_ajax_nopriv_custom_login', 'custom_login');
add_action('wp_ajax_custom_login', 'custom_login');
//to get cover photo and profile photo images
add_action('wp_ajax_socks_cover_profile_images', 'socks_cover_profile_images');

function custom_login()
{
    // Check nonce
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'socks-nonce')) {
        wp_send_json_error(array('message' => 'Invalid nonce.'));
    }

    // Retrieve the values from the AJAX request
    $email = sanitize_email($_POST['user_email']);
    $password = $_POST['user_password'];

    // Perform your login logic here
    // Example: Check if the user exists
    $user = get_user_by('email', $email);

    if (!$user) {
        // User with this email does not exist
        wp_send_json_error(array('message' => 'Invalid email or password.'));
    }

    $user_id = $user->ID;

    // Check if the password is correct
    if (!wp_check_password($password, $user->user_pass, $user_id)) {
        wp_send_json_error(array('message' => 'The given password is wrong !'));
    }

    if (get_user_meta($user_id, 'user_flag', true) == 'inactive') {
        wp_send_json_error(array('message' => __('Your account is not active. Please contact with admin!', 'hello-elementor')));
    }

    $credentials = array(
        'user_login'    => $user->user_login, // Use the username associated with the email
        'user_password' => $password,
        'remember'      => true,
    );

    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        // Login failed
        wp_send_json_error(array('message' => $user->get_error_message()));
    } else {
        // Check user role after successful login
        $user_roles = get_userdata($user_id)->roles;

        // Redirect based on user role
        if (in_array('reseller', $user_roles)) {
            wp_send_json_success(array('message' => 'Login successful', 'redirect' => site_url() . '/user/dashboard'));
        } else {
            wp_send_json_success(array('message' => 'Login successful', 'redirect' => wc_get_account_endpoint_url('dashboard')));
        }
    }
}

//registration for reseller , team
add_action('wp_ajax_shocks_user_registration', 'shocks_user_registration');
add_action('wp_ajax_nopriv_shocks_user_registration', 'shocks_user_registration');

function shocks_user_registration()
{
    check_ajax_referer('socks-nonce', 'security');
    $register_type = $_POST['register_type'];
    if (!empty($register_type) && !isset($register_type) || !in_array($register_type, array('reseller', 'team'))) :
        wp_send_json_error(array('message' => __('Something went wrong! Please try again later.', 'hello-elementor')));
        exit();
    endif;
    // var_dump($_POST);
    // exit();
    $fullName           = sanitize_text_field($_POST['fullName']);
    $address            = sanitize_text_field($_POST['Address']);
    $zip_code           = sanitize_text_field($_POST['zipCode']);
    $postal_address     = sanitize_text_field($_POST['PostalAddress']);
    $email              = sanitize_email($_POST['EmailAddress']);
    $email_repeat       = sanitize_email($_POST['EmailAddressRepeat']);
    $password           = $_POST['password'];
    $confirmPassword    = $_POST['confirmPassword'];
    $bank_name          = $_POST['bank_name'];
    $account_number     = $_POST['account_number'];
    // $phone_number = sanitize_text_field($_POST['PhoneNumber']);
    if ($register_type == 'reseller') :
        // Get the user data from the AJAX request
        $user_type      = sanitize_text_field($_POST['userType']);
        $team_name      = sanitize_text_field($_POST['TeamName']);
        $role           = 'reseller';

        // Check if required fields are empty
        if (empty($user_type) || empty($team_name) || empty($address) || empty($zip_code) || empty($postal_address) || empty($email) || empty($email_repeat)) {
            wp_send_json_error(array('message' => __('All fields are required.', 'hello-elementor')));
        }
        $suc_msg = 'Your registration is pending approval.';
    elseif ($register_type == 'team') :
        $reseller_id    = sanitize_text_field($_POST['reseller_id']);
        $role           = 'subscriber';
        $suc_msg        = 'Your registration is successful.';
    endif;

    // Check if email and repeated email match
    if ($email !== $email_repeat) {
        wp_send_json_error(array('message' => __('Emails do not match.', 'hello-elementor')));
    }
    // Check if email already exist
    if (email_exists($email)) {
        wp_send_json_error(array('message' => __('Email already exist.Please try with different email.', 'hello-elementor')));
    }
    // Check if email and repeated email match
    if ($password !== $confirmPassword) {
        wp_send_json_error(array('message' => __('Password do not match.', 'hello-elementor')));
    }

    // Create a user with the 'reseller' role
    $user_id = wp_insert_user(array(
        'user_login' => sanitize_title($team_name),
        'user_email' => $email,
        // 'user_pass' => wp_hash_password($password),
        'user_pass' => $password,
        'first_name' => $fullName, // Add first name if needed
        'role' => $role,
    ));

    if (is_wp_error($user_id)) :
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    else :
        //send email for signup users with do action 
        do_action('socks_send_email_template_action', 'signup-email', $user_id, true);

        if ($register_type == 'reseller') :
            update_user_meta($user_id, 'user_type', $user_type);
            update_user_meta($user_id, 'team_name', $team_name);
            update_user_meta($user_id, 'user_flag', 'inactive');
        elseif ($register_type == 'team') :
            update_user_meta($user_id, 'reseller_id', $reseller_id);
        endif;
        // Update user meta with additional information
        update_user_meta($user_id, 'address', $address);
        update_user_meta($user_id, 'zip_code', $zip_code);
        update_user_meta($user_id, 'postal_address', $postal_address);
        update_user_meta($user_id, 'bank_name', $bank_name);
        update_user_meta($user_id, 'account_number', $account_number);
    // update_user_meta($user_id, 'phone_number', $phone_number);

    // // Call the socks_get_email_template filter
    // apply_filters('socks_email_template_show', '', 'signup-email', 1);

    endif;

    $userdata = [
        'register_type'     => $register_type,
        'redirect_url' => ($register_type == 'reseller') ? ' ' : site_url('/login'),
    ];
    wp_send_json_success(array('message' => __($suc_msg, 'hello-elementor'), 'data' => $userdata));
}

function socks_cover_profile_images()
{
    $post_type = $_POST['type'];
    $category_id = $_POST['category'];
    $taxonomy = $post_type . '-category';

    $args = array(
        'post_type' => $post_type,
    );

    // If category is provided, filter by category
    if (!empty($category_id)) {

        // Get all categories for the post type
        $category_info = get_terms(array(
            'taxonomy'   => $taxonomy, // Replace with your custom taxonomy
            'hide_empty' => true,
        ));

        $categories = array();

        // Loop through categories and add name, slug, and id to the array
        foreach ($category_info as $category) {
            $categories[] = array(
                'name' => $category->name,
                'slug' => $category->slug,
                'id'   => $category->term_id,
            );
        }


        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy, // Replace with your custom taxonomy
                'field'    => 'term_id', // Change to 'term_id' for taxonomy term ID
                'terms'    => $category_id,
            ),
        );


        $query = new WP_Query($args);

        $posts = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $attachment_id = get_post_thumbnail_id();
                $attachment_url = wp_get_attachment_url($attachment_id);

                // Add both URL and ID to the posts$posts array
                $posts[] = array(
                    'url'           => $attachment_url,
                    'id'            => $attachment_id,
                    'category_id'   =>  $category_id
                );
            }
            wp_reset_postdata();
        }
    } else {
        $result = get_posts_with_categories($post_type, $taxonomy);
        $categories = $result['categories'];
        $posts = $result['posts'];
    }

    // Send JSON response
    wp_send_json(array(
        'success' => 200,
        'categories' => $categories,
        'posts' => $posts,
    ));

    // Always exit to avoid further execution
    wp_die();
}


//get posts with categories
function get_posts_with_categories($post_type, $taxonomy)
{
    // Get all categories for the post type
    $category_info = get_terms(array(
        'taxonomy'   => $taxonomy, // Replace with your custom taxonomy
        'hide_empty' => true,
    ));

    $categories = array();

    // Loop through categories and add name, slug, and id to the array
    foreach ($category_info as $category) {
        $categories[] = array(
            'name' => $category->name,
            'slug' => $category->slug,
            'id'   => $category->term_id,
        );
    }

    if (!empty($category_info)) {
        $images = array();

        $category_id = $category_info[1]->term_id;
        // Query posts with tax query
        $args = array(
            'post_type'         => $post_type,
            'posts_per_page'    => -1,
            'tax_query'         => array(
                array(
                    'taxonomy'  => $taxonomy, // Replace with your custom taxonomy
                    'field'     => 'term_id',
                    'terms'     => $category_id,
                ),
            ),
        );

        $query = new WP_Query($args);


        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Get the attachment ID
                $attachment_id  = get_post_thumbnail_id();
                // Get the attachment URL
                $attachment_url = wp_get_attachment_url($attachment_id);

                // Add both URL and ID to the images array
                $images[] = array(
                    'url'           => $attachment_url,
                    'id'            => $attachment_id,
                    'category_id'   =>  $category_id
                );
            }

            wp_reset_postdata();
        }

        // Process $images array as needed

    } else {
        // If no categories, get all posts
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);

        $images = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $attachment_id = get_post_thumbnail_id();
                $attachment_url = wp_get_attachment_url($attachment_id);

                // Add both URL and ID to the images array
                $images[] = array(
                    'url' => $attachment_url,
                    'id'  => $attachment_id,
                );
            }
            wp_reset_postdata();
        } else {
        }
    }

    $result = array(
        'categories' => $categories,
        'posts' => $images,
    );

    return $result;
}
