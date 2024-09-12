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
    $user_type = isset($reseller_meta_data['reseller_id'][0]) ? $reseller_meta_data['reseller_id'][0] : false;
    $team_name = isset($reseller_meta_data['team_name'][0]) ? $reseller_meta_data['team_name'][0] : '';
    $shop_name = isset($reseller_meta_data['shop_name'][0]) ? $reseller_meta_data['shop_name'][0] : '';
    // Get users with reseller_id and usermeta field 'wp'
    // Number of users per page
    $users_per_page = 10;


    // Get the current page number
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if ($user_type) {
        // Get users with reseller_id
        $members_query = new WP_User_Query(
            array(
                'meta_key' => 'reseller_id',
                'meta_value' => $user_type,
                'fields' => 'all',
                'number' => $users_per_page,
                'paged' => $paged,
                'count_total'  => true,
            )
        );
    } else {
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
    }

    $total_users = $members_query->total_users;
    $members = $members_query->get_results();

    $args = array(
        'limit'        => $per_page_data, // Get limited orders per page
        'return'       => 'ids', // Return only order IDs
        'page'         => $paged, // Set the current page number
        'meta_compare' => '=', // Optional, you can change it to 'LIKE', '>', '<', etc.
    );

    // Create the query
    $order_query = new WC_Order_Query($args);
    $order_ids = $order_query->get_orders();


?>



    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 ml-md-auto px-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-11 py-5">

                        <pre>
                            <?php print_r($order_ids); ?>
                        </pre>
                        <div class="table-responsive">

                            <table class="table caption-top">
                                <caption><?php echo __('List of Members', 'hello-elementor'); ?></caption>
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"><?php echo __('Name', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Products Sold', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Totall Earned', 'hello-elementor'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($members as $key => $user) : ?>
                                        <tr>
                                            <th scope="row"><?php echo ($paged - 1) * $users_per_page + $key + 1; ?></th>
                                            <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                            <td><?php echo $user->user_email; ?></td>
                                            <td><?php echo $user->user_login; ?></td>
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