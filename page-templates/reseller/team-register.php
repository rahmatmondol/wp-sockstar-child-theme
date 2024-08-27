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

    $reseller_id = get_current_user_id();
    $reseller_meta_data = get_user_meta($reseller_id);
    $team_name = isset($reseller_meta_data['team_name'][0]) ? $reseller_meta_data['team_name'][0] : '';
    $shop_name = isset($reseller_meta_data['shop_name'][0]) ? $reseller_meta_data['shop_name'][0] : '';



?>
    <div class="container-fluid user-dashboard">
        
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 ml-md-auto px-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-11 py-5">
                        <div class="signup-page">
                            <form method="post" action="" id="resellerRegistrationForm">
                                <div id="success-message" class="bg-success text-white p-3 my-2"><span class=" text-white"></span></div>
                                <div id="error-message" class="bg-danger text-white p-3 my-2"><span class=" text-white"></span></div>
                                <input type="hidden" id="reseller_id" name="reseller_id" value="<?php echo $reseller_id; ?>">
                                <input type="hidden" id="register_type" name="register_type" value="team">
                                <div class="row mb-3" style="margin-bottom: 20px;">
                                    <div class="form-group col-md-12">
                                        <label><?php _e('Name of association / Team / Class', 'hello-elementor'); ?></label>
                                        <input class="form-control" type="text" style="border-radius: 5px;" value="<?php echo $team_name; ?>" readonly>
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                </div>

                                <label class="header-label"><?php _e('Contact details', 'hello-elementor'); ?></label>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label><?php _e('First and last name', 'hello-elementor'); ?></label>
                                    <input required name="fullName" id="fullName" class="form-control" type="text" placeholder="<?php _e('Enter full name', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                    <span class="error-msg" style="color: red;"></span>
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label><?php _e('Address', 'hello-elementor'); ?></label>
                                    <input required name="Address" id="Address" class="form-control" autocomplete="shipping street-address" type="text" placeholder="<?php _e('Enter address', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                    <span class="error-msg" style="color: red;"></span>
                                </div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="form-group col-md-6">
                                        <label><?php _e('ZIP code', 'hello-elementor'); ?></label>
                                        <input required name="zipCode" id="zipCode" class="form-control" numbers-only minlength="5" maxlength="5" autocomplete="shipping postal-code" type="tel" placeholder="<?php _e('Enter zip code', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><?php _e('Postal address', 'hello-elementor'); ?></label>
                                        <input required name="PostalAddress" id="PostalAddress" class="form-control" autocomplete="shipping address-level2" type="text" placeholder="<?php _e('Enter postal address', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="form-group col-md-6 order-1 order-md-0">
                                        <label for="email1"><?php _e('Email address', 'hello-elementor'); ?></label>
                                        <input required name="EmailAddress" id="EmailAddress" class="form-control" id="email1" prevent-copy type="email" placeholder="<?php _e('Enter your e-mail', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email2"><?php _e('Enter your email address again', 'hello-elementor'); ?></label>
                                        <input required name="EmailAddressRepeat" id="EmailAddressRepeat" class="form-control" id="email2" prevent-copy aria-describedby="EmailRepeatBlock" type="email" placeholder="<?php _e('Please repeat', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="form-group col-md-6 order-1 order-md-0">

                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo __('Password', 'hello-elementor'); ?>" aria-label="<?php echo __('Password', 'hello-elementor'); ?>" aria-describedby="password">
                                            <span class="input-group-text showHidePassword"><i class="fa-solid fa-eye-slash"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 order-1 order-md-0">
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="<?php echo __('Confirm Password', 'hello-elementor'); ?>" aria-label="<?php echo __('Confirm Password', 'hello-elementor'); ?>" aria-describedby="confirmPassword">
                                            <span class="input-group-text showHidePassword"><i class="fa-solid fa-eye-slash"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn theme-bg-primary btn-block"><?php _e('Complete registration', 'hello-elementor'); ?></button>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3 text-center">
                                            <?php _e('When you have completed the registration, you will receive an email with a link to My Pages, where the group can easily manage their sales and share their own online shop', 'hello-elementor'); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
get_footer();

?>