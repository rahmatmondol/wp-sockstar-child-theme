<?php
if (!is_user_logged_in()) :
?>
    <div class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-12 pe-0">
                    <div id="error-message" class="bg-danger text-white p-3 my-2"><span class=" text-white"></span></div>
                    <form action="" class="row g-4 socks-login" method="post">
                        <div class="col-12">
                            <label class="text-dark"><?php echo __('Email/UserName', 'hello-elementor'); ?><span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text text-dark"><i class="fa-solid fa-user-secret"></i></div>
                                <input type="text" name="user_login" class="form-control" placeholder="<?php echo __('Enter Email Address', 'hello-elementor'); ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="text-dark"><?php echo __('Password', 'hello-elementor'); ?><span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text text-dark"><i class="fa-solid fa-key"></i></div>
                                <input type="password" name="user_password" class="form-control" placeholder="<?php echo __('Enter Password','hello-elementor'); ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                <label class="form-check-label text-dark" for="inlineFormCheck"><?php echo __('Remember me', 'hello-elementor'); ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <a href="<?php echo site_url('my-account/lost-password/'); ?>" class="float-end text-primary text-dark"><?php echo __('Forgot Password?', 'hello-elementor'); ?></a>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn theme-bg-primary px-4 mt-4"><?php echo __('login', 'hello-elementor'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
else :
?>
    <script>
        // Check if user is logged in and redirect
        document.addEventListener("DOMContentLoaded", function() {
            var userIsLoggedIn = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;

            if (userIsLoggedIn) {
                var userRoles = <?php echo json_encode(wp_get_current_user()->roles); ?>;

                if (userRoles.includes('reseller')) {
                    // Redirect resellers to the reseller dashboard
                    window.location.href = "<?php echo home_url('/user/dashboard'); ?>";
                } else {
                    // Redirect other users to the default my-account page
                    window.location.href = "<?php echo home_url('/my-account'); ?>";
                }
            }
        });
    </script>
<?php
endif;
