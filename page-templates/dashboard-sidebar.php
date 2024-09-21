<!-- sidebar -->
<style>
    #user-header {
        display: none !important;
    }

    #team-header {
        display: block;
    }

    /* sidebar for small screens */
    @media screen and (min-width: 767px)  {
        #team-header {
            display: none;
            /* Hides the element with the id 'team-header' */
        }

        #user-header {
            display: none;
            /* Hides the element with the id 'user-header' */
        }
    }
</style>


<div class="col-md-3 col-lg-2 px-0 vh-50 bg-white shadow-sm sidebar" id="sidebar">
    <div id="sidebar-close">
        X
    </div>
    <span class="px-3 py-2">
        <?php
        echo __('Username:', 'hello-elementor') . esc_html($current_user->user_login) . '<br />';
        ?>
    </span>
    <div class="list-group rounded-0">

        <a href="<?php echo site_url('/user/dashboard'); ?>" class="list-group-item list-group-item-action border-0 d-flex align-items-center <?php echo ($reseller_dashboard) ? 'active' : ''; ?>">
            <i class="fa fa-th-large"></i>
            <span class="ml-2"><?php echo __('Dashboard', 'hello-elementor'); ?></span>
        </a>
        <?php if ($rols == 'reseller'): ?>
            <a href="<?php echo site_url('/user/shop-settings'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($reseller_shopsettings) ? 'active' : ''; ?>">
                <i class="fa-solid fa-shop"></i>
                <span class="ml-2"><?php echo __('Shop Settings', 'hello-elementor'); ?></span>
            </a>
        <?php endif; ?>
        <a href="<?php echo site_url('/user/orders'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($reseller_sales) ? 'active' : ''; ?>">
            <i class="fa fa-box"></i>
            <span class="ml-2"><?php echo __('Sales', 'hello-elementor'); ?></span>
        </a>
        <a href="<?php echo site_url('/user/scoreboard'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($reseller_scoreboard) ? 'active' : ''; ?>">
            <i class="fa fa-box"></i>
            <span class="ml-2"><?php echo __('Scoreboard', 'hello-elementor'); ?></span>
        </a>
        <?php if ($rols == 'reseller'): ?>
            <a href="<?php echo site_url('/user/team-members'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($team_members) ? 'active' : ''; ?>">
                <i class="fa fa-box"></i>
                <span class="ml-2"><?php echo __('Members', 'hello-elementor'); ?></span>
            </a>
            <a href="<?php echo site_url('/user/team-register'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($team_register) ? 'active' : ''; ?>">
                <i class="fa fa-box"></i>
                <span class="ml-2"><?php echo __('Member Register', 'hello-elementor'); ?></span>
            </a>
            <a href="<?php echo site_url('/user/edit-profile'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($reseller_profilesettings) ? 'active' : ''; ?>">
                <i class="fa fa-box"></i>
                <span class="ml-2"><?php echo __('Edit Profile', 'hello-elementor'); ?></span>
            </a>
            <a href="<?php echo site_url('/user/payment-info'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($payment_info) ? 'active' : ''; ?>">
                <i class="fa fa-box"></i>
                <span class="ml-2"><?php echo __('Payment info', 'hello-elementor'); ?></span>
            </a>
        <?php endif; ?>
        <a href="<?php echo site_url('/user/change-password'); ?>" class="list-group-item list-group-item-action border-0 align-items-center <?php echo ($reseller_changepassword) ? 'active' : ''; ?>">
            <i class="fa fa-box"></i>
            <span class="ml-2"><?php echo __('Change Password', 'hello-elementor'); ?></span>
        </a>

        <!-- <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#sale-collapse">
                    <div>
                        <span class="fa fa-shopping-cart"></span>
                        <span class="ml-2">Sales</span>
                    </div>
                    <span class="fa fa-chevron-down small"></span>
                </button>
                <div class="collapse" id="sale-collapse" data-bs-parent="#sidebar">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action border-0 pl-5">Customers</a>
                        <a href="#" class="list-group-item list-group-item-action border-0 pl-5">Sale Orders</a>
                    </div>
                </div> -->

        <!-- <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#purchase-collapse">
                    <div>
                        <span class="fa fa-cart-plus"></span>
                        <span class="ml-2">Purchase</span>
                    </div>
                    <span class="fa fa-chevron-down small"></span>
                </button>
                <div class="collapse" id="purchase-collapse" data-bs-parent="#sidebar">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action border-0 pl-5">Sellers</a>
                        <a href="#" class="list-group-item list-group-item-action border-0 pl-5">Purchase Orders</a>
                    </div>
                </div> -->
        <a href="<?php echo wp_logout_url(home_url('login')); ?>" class="list-group-item list-group-item-action bg-danger  text-white border-0 d-flex align-items-center">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="ml-2"><?php echo __('Logout', 'hello-elementor'); ?></span>
        </a>
    </div>
</div>
<!-- overlay to close sidebar on small screens -->
<div class="w-100 vh-100 position-fixed overlay" id="sidebar-overlay" style="display: none;"></div>