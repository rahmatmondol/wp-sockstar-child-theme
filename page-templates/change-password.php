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
        $current_password = isset($_POST['password_current']) ? $_POST['password_current'] : '';
        $new_password = isset($_POST['password_1']) ? $_POST['password_1'] : '';
        $confirm_password = isset($_POST['password_2']) ? $_POST['password_2'] : '';

        // Perform validation
        $errors = new WP_Error();

        if (!empty($new_password) && strlen($new_password) < 6) {
            $errors->add('password_length', __('Password should be at least 6 characters long.', 'hello-elementor'));
        }

        if (!empty($new_password) && $new_password !== $confirm_password) {
            $errors->add('password_mismatch', __('New password and confirm password do not match.', 'hello-elementor'));
        }

        if (!empty($current_password) && !wp_check_password($current_password, $current_user->user_pass, $current_user->ID)) {
            $errors->add('current_password_mismatch', __('Current password is incorrect.', 'hello-elementor'));
        }

        // If no errors, update user data
        if (empty($errors->get_error_codes())) {
            $user_data = array(
                'ID' => $current_user->ID,
            );

            if (!empty($new_password)) {
                $user_data['user_pass'] = $new_password;
            }

            $updated_user = wp_update_user($user_data);

            if (is_wp_error($updated_user)) {
                $errors->add('update_error', $updated_user->get_error_message());
            } else {
                echo '<div class="woocommerce-message">' . esc_html__('Account details updated successfully.', 'hello-elementor') . '</div>';
            }
        }
    }
?>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <!-- overlay to close sidebar on small screens -->
            <div class="w-100 vh-100 position-fixed overlay d-none" id="sidebar-overlay"></div>
            <!-- note: in the layout margin auto is the key as sidebar is fixed -->
            <div class="col-md-9 col-lg-10 ml-md-auto p-5">
                <?php
                // Display error messages
                if (isset($errors) && !empty($errors->get_error_codes())) {
                    foreach ($errors->get_error_codes() as $error_code) {
                        echo '<div class="woocommerce-error">' . esc_html($errors->get_error_message($error_code)) . '</div>';
                    }
                }
                ?>
                <form class="woocommerce-EditAccountForm edit-account" action="" method="post">
                    <fieldset>
                        <legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" required />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" required />
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" required />
                        </p>
                    </fieldset>
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