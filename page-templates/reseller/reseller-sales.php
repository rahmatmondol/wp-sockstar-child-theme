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

    global $wpdb;

    // Define the meta key and value
    $meta_key = 'referenceNumber';
    $current_user = wp_get_current_user();

    // Get the user roles
    $user_roles = $current_user->roles;

    // Check if the user has the "reseller" role
    if (in_array('reseller', $user_roles)) {
        // User is a reseller
        $meta_value = $current_user->ID; // Use the user ID as the meta value
    } else {
        // User is not a reseller, use the reseller usermeta key value
        $meta_value = get_user_meta($current_user->ID, 'reseller_id', true);
    }

    $per_page_data = 10;

    // Get the current page number
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Query to get total number of orders matching the criteria
    $total_orders_query = new WC_Order_Query(array(
        'return'       => 'ids',
        'meta_key'     => $meta_key,
        'meta_value'   => $meta_value,
        'meta_compare' => '=',
    ));
    $total_orders = count($total_orders_query->get_orders());

    $args = array(
        'limit'        => $per_page_data, // Get limited orders per page
        'return'       => 'ids', // Return only order IDs
        'page'         => $paged, // Set the current page number
        'meta_key'     => $meta_key,
        'meta_value'   => $meta_value,
        'meta_compare' => '=', // Optional, you can change it to 'LIKE', '>', '<', etc.
    );

    // Create the query
    $order_query = new WC_Order_Query($args);
    $order_ids = $order_query->get_orders();

    // Calculate total pages
    $total_pages = ceil($total_orders / $per_page_data);
    ?>

    <div class="container-fluid user-dashboard">
        <div class="row">
            <?php include_once get_stylesheet_directory() . '/page-templates/dashboard-sidebar.php'; ?>
            <div class="col-md-9 col-lg-10 ml-md-auto px-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-11 py-5">

                        <table class="table caption-top">
                            <caption><?php echo __('List of Orders', 'hello-elementor'); ?></caption>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo __('Order ID', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Shipping First Name', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Shipping Last Name', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Shipping Address', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Product Name', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Quantity', 'hello-elementor'); ?></th>
                                    <th scope="col"><?php echo __('Order Notes', 'hello-elementor'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $row_index = 1; // Counter for row numbers
                                foreach ($order_ids as $order_id) {
                                    $order = wc_get_order($order_id);

                                    // Get shipping information
                                    $shipping_first_name = $order->get_shipping_first_name();
                                    $shipping_last_name = $order->get_shipping_last_name();
                                    $shipping_address = $order->get_shipping_address_1(); // You can use other shipping address fields as needed
                                    $order_notes = $order->get_customer_note(); // Get order notes

                                    // Get order items
                                    $items = $order->get_items();
                                    ?>
                                    <tr>
                                        <td><?php echo $row_index++; ?></td>
                                        <td><?php echo $order->get_id(); ?></td>
                                        <td><?php echo $shipping_first_name; ?></td>
                                        <td><?php echo $shipping_last_name; ?></td>
                                        <td><?php echo $shipping_address; ?></td>
                                        <td>
                                            <?php
                                            // Output each order item along with shipping information
                                            foreach ($items as $item_id => $item) {
                                                $product = $item->get_product(); // Get the product object
                                                $quantity = $item->get_quantity(); // Get the quantity of the product
                                                ?>
                                                <a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $quantity; ?></td>
                                        <td><?php echo $order_notes; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            <?php
                            echo '<nav aria-label="Page navigation example"><ul class="pagination">';

                            // Previous button
                            echo '<li class="page-item ' . ($paged <= 1 ? 'disabled' : '') . '">';
                            echo '<a class="page-link" href="' . esc_url(add_query_arg('paged', max(1, $paged - 1))) . '" tabindex="-1" aria-disabled="true">Previous</a>';
                            echo '</li>';

                            // Pagination links
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item ' . ($paged == $i ? 'active' : '') . '">';
                                echo '<a class="page-link" href="' . esc_url(add_query_arg('paged', $i)) . '">' . $i . '</a>';
                                echo '</li>';
                            }

                            // Next button
                            echo '<li class="page-item ' . ($paged >= $total_pages ? 'disabled' : '') . '">';
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
    <?php
}
get_footer();
?>
