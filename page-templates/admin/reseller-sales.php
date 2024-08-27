global $wpdb;

// Your meta key and value
$meta_key = 'socksresellerid';
$meta_value = 'your_meta_value';

// Get the current year and month
$current_year = date('Y');
$current_month = date('m');

// Prepare the query to get total products sold
$query = $wpdb->prepare("
    SELECT SUM(oim_qty.meta_value) as total_products_sold
    FROM {$wpdb->prefix}woocommerce_order_items AS oi
    JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim ON oi.order_item_id = oim.order_item_id
    JOIN {$wpdb->prefix}posts AS p ON oi.order_id = p.ID
    JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim_qty ON oi.order_item_id = oim_qty.order_item_id
    WHERE oim.meta_key = %s
    AND oim.meta_value = %s
    AND oim_qty.meta_key = '_qty'
    AND p.post_type = 'shop_order'
    AND p.post_status IN ('wc-completed', 'wc-processing')  -- Adjust status as needed
    AND YEAR(p.post_date) = %d
    AND MONTH(p.post_date) = %d
", $meta_key, $meta_value, $current_year, $current_month);

// Execute the query
$total_products_sold = $wpdb->get_var($query);
