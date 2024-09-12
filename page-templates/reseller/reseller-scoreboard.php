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
    $theme_directory = get_template_directory_uri();

    if ($user_type) {
        $reseller_id = $user_type;
    }

    $members_query = new WP_User_Query(
        array(
            'limit'        => -1,
            'meta_key' => 'reseller_id',
            'meta_value' => $reseller_id,
            'fields' => 'all',
        )
    );
    $total_users = $members_query->total_users;
    $members = $members_query->get_results();

    // Array to store users and their order count
    $users_with_orders = array();

    // Loop through each user and get their orders
    foreach ($members as $user) {
        $args = array(
            'limit'        => -1, // Get all orders for the user
            'return'       => 'ids', // Return only order IDs
            'meta_key'     => 'team_id',
            'meta_value'   => $user->ID,
            'meta_compare' => '=', // Match the reseller_id in the order meta
        );

        // Create the query to fetch orders
        $order_query = new WC_Order_Query($args);
        $order_ids = $order_query->get_orders(); // Get all order IDs for this user

        // Count the number of orders for the user
        $order_count = count($order_ids);

        // Calculate the total sold price for the user
        $total_sold_price = 0;
        foreach ($order_ids as $order_id) {
            $order = wc_get_order($order_id);
            $total_sold_price += (float) $order->get_total(); // Add the total price of the order to the total sold price
        }

        // Add the user and their order count to the array
        $users_with_orders[] = array(
            'user' => $user,
            'order_count' => $order_count,
            'total_sold_price' => $total_sold_price
        );
    }

    // Sort users by order count in descending order
    usort($users_with_orders, function ($a, $b) {
        return $b['order_count'] - $a['order_count'];
    });

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
                                        <th scope="col"><?php echo __('Products Sold', 'hello-elementor'); ?></th>
                                        <th scope="col"><?php echo __('Total Earned', 'hello-elementor'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users_with_orders as $key => $user_data) :
                                        $user = $user_data['user'];
                                        $order_count = $user_data['order_count'];
                                        $total_sold_price = $user_data['total_sold_price'];
                                        $rank = ($paged - 1) * $users_per_page + $key + 1;

                                        if ($rank == 1 && $order_count > 0) {
                                            $badg = '<img src="'.get_stylesheet_directory_uri().'/assets/images/gold-medal.png" alt="" style="width: 30px;">';
                                        } elseif ($rank == 2 && $order_count > 0) {
                                            $badg = '<img src="'.get_stylesheet_directory_uri().'/assets/images/silver-medal.png" alt="" style="width: 30px;">';
                                        } elseif ($rank == 3 && $order_count > 0) {
                                            $badg = '<img src="'.get_stylesheet_directory_uri().'/assets/images/bronze-medal.png" alt="" style="width: 30px;">';
                                        } else {
                                            $badg = $rank;
                                        }
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $badg; ?></th>
                                            <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                            <td><?php echo $order_count; ?></td>
                                            <td><?php echo wc_price($total_sold_price); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

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