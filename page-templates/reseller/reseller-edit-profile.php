<?php
get_header();
// Check if the user is not logged in
if (!is_user_logged_in()) {
    // Display a message indicating that the user doesn't have access
?>
    <div class="container-fluid py-3">
        <?php include get_stylesheet_directory() . '/page-templates/forbiden.php'; ?>
    </div>
<?php
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_account_details'])) {
        // Sanitize and validate input data
        $first_name = sanitize_text_field($_POST['account_first_name']);
        $last_name = sanitize_text_field($_POST['account_last_name']);
        $display_name = sanitize_text_field($_POST['account_display_name']);
        $user_email = sanitize_email($_POST['account_email']);
        
        // Perform validation
        $errors = new WP_Error();

        if (empty($first_name)) {
            $errors->add('first_name', __('First name is required.', 'hello-elementor'));
        }

        if (empty($last_name)) {
            $errors->add('last_name', __('Last name is required.', 'hello-elementor'));
        }

        if (empty($display_name)) {
            $errors->add('display_name', __('Display name is required.', 'hello-elementor'));
        }

        if (!is_email($user_email)) {
            $errors->add('user_email', __('Invalid email address.', 'hello-elementor'));
        }

        // If no errors, update user data
        if (empty($errors->get_error_codes())) {
            $user_data = array(
                'ID' => $current_user->ID,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'display_name' => $display_name,
            );

            if ($user_email !== $current_user->user_email) {
                $user_data['user_email'] = $user_email;
            }
            $updated_user = wp_update_user($user_data);

            if (is_wp_error($updated_user)) {
                $errors->add('update_error', $updated_user->get_error_message());
            } else {
                echo '<div class="woocommerce-message">' . esc_html__('Account details updated successfully.', 'hello-elementor') . '</div>';
            }
        }

        // Display error messages
        if (!empty($errors->get_error_codes())) {
            foreach ($errors->get_error_codes() as $error_code) {
                echo '<div class="woocommerce-error">' . esc_html($errors->get_error_message($error_code)) . '</div>';
            }
        }
    }
    $user = wp_get_current_user();

?>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <!-- overlay to close sidebar on small screens -->
            <div class="w-100 vh-100 position-fixed overlay d-none" id="sidebar-overlay"></div>
            <!-- note: in the layout margin auto is the key as sidebar is fixed -->
            <div class="col-md-9 col-lg-10 ml-md-auto p-5">
                <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

                    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                        <label for="account_first_name"><?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                        <label for="account_last_name"><?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" />
                    </p>
                    <div class="clear"></div>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" /> <span><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>
                    </p>
                    <div class="clear"></div>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" />
                    </p>
                    <div class="clear"></div>

                    <p>
                        <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                        <button type="submit" class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                        <input type="hidden" name="action" value="save_account_details" />
                    </p>

                </form>
            </div>
        </div>
    </div>
<?php
}
get_footer();
?>