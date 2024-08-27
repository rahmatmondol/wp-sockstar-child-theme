<?php
function add_user_status_field($user)
{
    $status = get_user_meta($user->ID, 'user_flag', true);
    $bank_name = get_user_meta($user->ID, 'bank_name', true);
    $account_number = get_user_meta($user->ID, 'account_number', true);

?>
    <h3>User Status</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_flag">Status</label></th>
            <td>
                <select name="user_flag" id="user_flag">
                    <option value="active" <?php selected($status, 'active'); ?>>Active</option>
                    <option value="inactive" <?php selected($status, 'inactive'); ?>>Inactive</option>
                    <option value="declined" <?php selected($status, 'declined'); ?>>Declined</option>
                </select>
            </td>
        </tr>
    </table>

    <h3>Bank Details</h3>
    <table class="form-table">
        <tr>
            <th><label for="bank_name">Bank Name</label></th>
            <td>
                <input type="text" name="bank_name" id="bank_name" value="<?php echo esc_attr($bank_name); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="account_number">Account Number</label></th>
            <td>
                <input type="text" name="account_number" id="account_number" value="<?php echo esc_attr($account_number); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_user_status_field');
add_action('edit_user_profile', 'add_user_status_field');


function save_user_status_field($user_id)
{
    // Check that the current user has the capability to edit the user.
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    // Retrieve the current value of user_flag from the database.
    $current_status = get_user_meta($user_id, 'user_flag', true);
    $new_status = isset($_POST['user_flag']) ? $_POST['user_flag'] : '';

    // Update the user meta with the new status.
    update_user_meta($user_id, 'user_flag', $new_status);

    // Check if the new status is 'active' and the current status is not 'active'.
    if ($new_status === 'active' && $current_status !== 'active') {
        $send_admin_email = 0;
        do_action('socks_send_email_template_action', 'welcome-reseller-email', $user_id, $send_admin_email);
    }
    // Sanitize and update user meta with the new bank name and account number.
    update_user_meta($user_id, 'bank_name', sanitize_text_field($_POST['bank_name']));
    update_user_meta($user_id, 'account_number', sanitize_text_field($_POST['account_number']));
}
add_action('personal_options_update', 'save_user_status_field');
add_action('edit_user_profile_update', 'save_user_status_field');
