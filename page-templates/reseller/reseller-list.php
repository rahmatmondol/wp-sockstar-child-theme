<div class="container p-5 reseller-lists">
    <div class="row">
        <?php
        // Define the number of resellers per page
        $resellers_per_page = get_option('posts_per_page');;

        // Get the current page number from the URL parameter
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Get users with the "reseller" role
        $args = array(
            'role' => 'reseller',
            'number' => $resellers_per_page,
            'paged' => $paged,
        );
        $resellers_query = new WP_User_Query($args);
        $resellers = $resellers_query->get_results();

        // echo "<pre>";
        // print_r($resellers);
        // echo "</pre>";

        foreach ($resellers as $reseller) {
            // Get reseller metadata
            // $team_name = get_user_meta($reseller->ID, 'team_name', true);
            $user_meta_data = get_user_meta($reseller->ID);
            $team_name = isset($user_meta_data['team_name'][0]) ? $user_meta_data['team_name'][0] : '';

            $shop_profile_image_id = isset($user_meta_data['shop_profile_image_id'][0]) ? $user_meta_data['shop_profile_image_id'][0] : '';
            $shop_profile_image = wp_get_attachment_image_url($shop_profile_image_id, 'full');
            $shop_profile_image_scrsrc = wp_get_attachment_image_srcset($shop_profile_image_id, 'full');


            // Display user information
        ?>

            <div class="col-md-3 col-12 mt-3">
                <div class="card h-100 shadow-sm">
                    <div class="text-center">
                        <div class="img-hover-zoom img-hover-zoom--colorize">
                            <img src="<?php echo !empty($shop_profile_image) ? $shop_profile_image : '" class="img-fluid rounded-circle'; ?>" srcset="<?php echo !empty($shop_profile_image_scrsrc) ? $shop_profile_image_scrsrc : ''; ?>" alt="Banner image" class="img-fluid">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="clearfix mb-3"></div>
                        <div class="my-2 text-center">
                            <h1><?php echo esc_html($team_name); ?></h1>
                        </div>
                        <div class="box">
                            <div>
                                <?php
                                $reseller_id = $reseller->ID; // Assuming $reseller is a WP_User object
                                $reseller_url = site_url('team/' . $reseller->user_login);
                                // Output the link
                                ?>
                                <a href="<?php echo esc_url($reseller_url); ?>" class="btn theme-bg-primary btn-sm"><?php echo __('Visit Shop', 'hello-elementor'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Bootstrap 5 Pagination -->
    <!-- <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3"> -->
    <div class="d-flex justify-content-center py-4 text-center">
        <?php
        // Output pagination
        $total_user = $resellers_query->total_users;
        $total_pages = ceil($total_user / $resellers_per_page);
        echo paginate_links(array(
            'total' => $total_pages,
            'current' => max(1, get_query_var('paged')),
            'format' => '?paged=%#%',
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<i class="fas fa-chevron-left"></i>',
            'next_text' => '<i class="fas fa-chevron-right"></i>',
        ));
        ?>
    </div>
    <!-- </div> -->
</div>