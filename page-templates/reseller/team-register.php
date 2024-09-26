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
            <div class="col-md-9 col-lg-10 ml-md-auto">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-11 py-5">
                        <div class="signup-page">
                            <form method="post" action="" id="memberRegistrationForm">
                                <div id="success-message" class="bg-success text-white p-3 my-2"><span class=" text-white"></span></div>
                                <div id="error-message" class="bg-danger text-white p-3 my-2"><span class=" text-white"></span></div>
                                <input type="hidden" id="reseller_id" name="reseller_id" value="<?php echo $reseller_id; ?>">
                                <input type="hidden" id="register_type" name="register_type" value="team">

                                <input class="form-control" type="hidden" style="border-radius: 5px;" value="<?php echo $team_name; ?>" readonly>

                                <label class="header-label"><?php _e('Contact details', 'hello-elementor'); ?></label>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label><?php _e('First and last name', 'hello-elementor'); ?></label>
                                    <input required name="fullName" id="fullName" class="form-control" type="text" placeholder="<?php _e('Enter full name', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                    <span class="error-msg" style="color: red;"></span>
                                </div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="form-group col-md-6 order-1 order-md-0">
                                        <label for="email"><?php _e('Email address', 'hello-elementor'); ?></label>
                                        <input required name="email" id="emailAddress" class="form-control" prevent-copy type="email" placeholder="<?php _e('Email Address', 'hello-elementor'); ?>" style="border-radius: 5px;">
                                        <span class="error-msg" style="color: red;"></span>
                                    </div>
                                    <div class="form-group col-md-6 order-1 order-md-0">
    <label for="password"><?php _e('Lösenord', 'hello-elementor'); ?></label>
    <div class="input-group mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo __('Password', 'hello-elementor'); ?>" aria-label="<?php echo __('Password', 'hello-elementor'); ?>" aria-describedby="password">
        <span class="input-group-text showHidePassword"><i class="fa-solid fa-eye-slash"></i></span>
    </div>
    <!-- Lägg till texten här under lösenordsfältet -->
    <p style="color: grey; font-size: 14px; margin-top: -10px;">
        <?php echo __('Välj ett lösenord som alla kan börja med ex: vi123</br>säljaren kan ändra sitt lösenord senare om hen vill.', 'hello-elementor'); ?>
    </p>
</div>

                                </div>

                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn theme-bg-primary btn-block"><?php _e('Skapa användare', 'hello-elementor'); ?></button>
                                            </div>
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