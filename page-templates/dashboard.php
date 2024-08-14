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
    $current_user = wp_get_current_user();
?>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once('dashboard-sidebar.php'); ?>
            <!-- overlay to close sidebar on small screens -->
            <div class="w-100 vh-100 position-fixed overlay d-none" id="sidebar-overlay"></div>
            <!-- note: in the layout margin auto is the key as sidebar is fixed -->
            <div class="col-md-9 col-lg-10 ml-md-auto px-0 dasboard-body">
                <div class="row justify-content-center align-items-center p-5">
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                        <a class="text-decoration-none" href="#">
                            <div class="card p-3 shadow bg-purple text-center border-0">
                                <div class="card-body">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/dashboard-sales.jpg" alt="">
                                    <hr />
                                    <p class="card-title lead"><?php echo __('Sales', 'hello-elementor'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                        <a class="text-decoration-none" href="#">
                            <div class="card p-3 shadow bg-purple text-center border-0">
                                <div class="card-body">
                                    <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                    <hr />
                                    <p class="card-title lead"><?php echo __('Students', 'hello-elementor'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                        <a class="text-decoration-none" href="#">
                            <div class="card p-3 shadow bg-purple text-center border-0">
                                <div class="card-body">
                                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                    <hr />
                                    <a href="<?php echo site_url('/contact'); ?>" class="card-title lead"><?php echo __('Enquiry', 'hello-elementor'); ?></a>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                        <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#modelHELP">
                            <div class="card p-3 shadow bg-purple text-center border-0">
                                <div class="card-body">
                                    <i class="fa fa-question fa-2x" aria-hidden="true"></i>
                                    <hr />
                                    <a href="<?php echo site_url('/contact'); ?>" class="card-title lead"><?php echo __('Support', 'hello-elementor'); ?></a>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php }
get_footer();
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const openSidebarButton = document.getElementById('open-sidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        openSidebarButton.addEventListener('click', () => {
            // add class active on #sidebar
            sidebar.classList.add('active');
            // show sidebar overlay
            sidebarOverlay.classList.remove('d-none');
        });

        sidebarOverlay.addEventListener('click', () => {
            // add class active on #sidebar
            sidebar.classList.remove('active');
            // show sidebar overlay
            sidebarOverlay.classList.add('d-none');
        });
    });
</script>