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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_payment_info'])) {
        // Sanitize and validate input data
        $bank_name = sanitize_text_field($_POST['bank_name']);
        $account_number = sanitize_text_field($_POST['account_number']);

        // Perform validation
        $errors = new WP_Error();

        if (empty($bank_name)) {
            $errors->add('bank_name', __('Bank Name is required.', 'hello-elementor'));
        }

        if (empty($account_number)) {
            $errors->add('account_number', __('Account Number is required.', 'hello-elementor'));
        }

        // If no errors, update user data
        if (empty($errors->get_error_codes())) {
            $current_user_id = $current_user->ID;
            update_user_meta($current_user_id, 'bank_name', $bank_name);
            update_user_meta($current_user_id, 'account_number', $account_number);
        }
    }
    $user            = wp_get_current_user();
    $current_user_id = $user->ID;
    $bank_name       = get_user_meta($current_user_id, 'bank_name', true);
    $account_number  = get_user_meta($current_user_id, 'account_number', true);

?>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <!-- overlay to close sidebar on small screens -->
            <div class="w-100 vh-100 position-fixed overlay d-none" id="sidebar-overlay"></div>
            <!-- note: in the layout margin auto is the key as sidebar is fixed -->
            <div class="col-md-9 col-lg-10 ml-md-auto p-5">
                <div class="row">
                    <div class="col-12">
                        <?php
                        // Display error messages
                        if (isset($errors) && !empty($errors->get_error_codes())) {
                            echo '<div class="woocommerce-error">';
                            foreach ($errors->get_error_codes() as $error_code) {
                                echo esc_html($errors->get_error_message($error_code));
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>
                    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                        <label for="bank_name"><?php esc_html_e('Bank Name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="bank_name" id="bank_name" autocomplete="Bank Name" value="<?php echo esc_attr($bank_name); ?>" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                        <label for="account_number"><?php esc_html_e('Account Number', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_number" id="account_number" autocomplete="Accoutn Number" value="<?php echo esc_attr($account_number); ?>" />
                    </p>
                    <div class="clear"></div>

                    <p>
                        <?php wp_nonce_field('save_payment_info', 'save-account-details-nonce'); ?>
                        <button type="submit" class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="save_payment_info" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                        <input type="hidden" name="action" value="save_payment_info" />
                    </p>

                </form>
            </div>
        </div>
    </div>
<?php
}
get_footer();
?>