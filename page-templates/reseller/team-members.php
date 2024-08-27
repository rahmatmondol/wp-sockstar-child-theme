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
    // Get users with reseller_id and usermeta field 'wp'
    // Number of users per page
    $users_per_page = 10;

    // Get the current page number
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Get users with reseller_id
    $members_query = new WP_User_Query(
        array(
            'meta_key' => 'reseller_id',
            'meta_value' => $reseller_id,
            'fields' => 'all',
            'number' => $users_per_page,
            'paged' => $paged,
            'count_total'  => true,
        )
    );
    $total_users = $members_query->total_users;
    $members = $members_query->get_results();
?>
    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 ml-md-auto px-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-11 py-5">
                        <div class="table-responsive">

                            <table class="table caption-top">
                                <caption><?php echo __('List of Members', 'hello-elementor'); ?></caption>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><?php echo __('Name', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Email', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Username', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Referral link', 'hello-elementor'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($members as $key => $user) : ?>
                                        <tr>
                                            <th scope="row"><?php echo ($paged - 1) * $users_per_page + $key + 1; ?></th>
                                            <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                            <td><?php echo $user->user_email; ?></td>
                                            <td><?php echo $user->user_login; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('reseller/' . $current_user->user_login . '?refid=' . $user->ID); ?>">Click Here</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                <?php
                                echo '<nav aria-label="..."><ul class="pagination">';

                                // Previous button
                                echo '<li class="page-item ' . ($paged <= 1 ? 'disabled' : '') . '">';
                                echo '<a class="page-link" href="' . esc_url(add_query_arg('paged', max(1, $paged - 1))) . '" tabindex="-1" aria-disabled="true">Previous</a>';
                                echo '</li>';

                                // Pagination links
                                for ($i = 1; $i <= ceil($total_users / $users_per_page); $i++) {
                                    echo '<li class="page-item ' . ($paged == $i ? 'active' : '') . '">';
                                    echo '<a class="page-link" href="' . esc_url(add_query_arg('paged', $i)) . '">' . $i . '</a>';
                                    echo '</li>';
                                }

                                // Next button
                                echo '<li class="page-item ' . ($paged >= ceil($total_users / $users_per_page) ? 'disabled' : '') . '">';
                                echo '<a class="page-link" href="' . esc_url(add_query_arg('paged', $paged + 1)) . '">Next</a>';
                                echo '</li>';

                                echo '</ul></nav>';
                                ?>
                            </div>
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