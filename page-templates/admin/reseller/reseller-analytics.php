<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/rajucs
 * @since      1.0.0
 *
 * @package    Ar_Music_School_Booking
 * @subpackage Ar_Music_School_Booking/admin/partials
 */
$exampleListTable = new Example_List_Table_Expired();
$exampleListTable->prepare_items();


$resellers = get_users(array(
    'role__in'     => array('reseller'),
));
if (isset($_POST['submit'])) {
    //     $reseller_id = $_POST['reseller_id'];
    //     $date_range = $_POST['range_date'];
    //     // Use explode to split the string by ' - '
    //     $date_parts = explode(' - ', $date_range);

    //     // Assign start and end dates to variables
    //     $start_date = $date_parts[0];
    //     $end_date = $date_parts[1];


    //     global $wpdb;
    //     echo $wpdb->prefix;

    //     $meta_key = 'socksresellerid';
    //     $meta_value = $reseller_id; // replace with your actual meta value// Create DateTime objects
    //     $start_date_obj = new DateTime($start_date);
    //     $end_date_obj = new DateTime($end_date);

    //     // Format dates to 'Y/m/d'
    //     $start_date = $start_date_obj->format('Y-m-d');
    //     $end_date   = $end_date_obj->format('Y-m-d');


    //     $query = $wpdb->prepare("
    //     SELECT *
    //     FROM
    //         {$wpdb->prefix}wc_orders o
    //     JOIN
    //         {$wpdb->prefix}wc_orders_meta om ON o.id = om.order_id
    //     WHERE
    //         om.meta_key = 'referenceNumber'
    //         AND om.meta_value = %s
    // ", $reseller_id); // Pass the value 6 as an argument to the prepare function

    //     // Retrieve the results
    //     $orders = $wpdb->get_results($query);
    //     // $orderid = $results[0]->order_id;
    //     // $order = wc_get_order( $orderid );
    //     // echo "<pre>";
    //     // var_dump($order);
    //     // echo "<pre>";

    //     // exit();

}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap bootstrap-iso">
    <h2 class="wp-heading-inline">All Reseller Earnings</h2>
    <hr class="wp-header-end">
    <div class="status-updatemsg"></div>
    <div class="clear"></div>
    <form class="form-inline" method="post" action="">
        <div class="form-group mb-2">
            <label for="resellers" class="sr-only">Resellers</label>
            <select class="form-control select2 p-4" id="resellers" name="reseller_id">
                <option value="">Select Reseller</option>
                <?php
                if (isset($resellers) && !empty($resellers)) :
                    foreach ($resellers as $data) :
                        echo '<option value="' . $data->ID . '"> ' . $data->user_login . '</option>';
                    endforeach;
                else :
                    echo "<option>Nothing Found</option>";
                endif;
                ?>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputdaterange2" class="sr-only">daterange</label>
            <input type="text" name="range_date" class="form-control-sm mb-2 date_range" id="inputdaterange2" size="30">
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-sm">Search</button>
    </form>

    <section class="py-0 py-xl-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-warning bg-opacity-15 rounded-3">
                        <span class="display-6 lh-1 text-warning mb-0"><i class="fas fa-tv"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex justify-content-center">
                                <h5 class="purecounter mb-0 fw-bold text-white" data-purecounter-start="0" data-purecounter-end="10" data-purecounter-delay="200" data-purecounter-duration="0"><?php echo $exampleListTable->get_total_earnings(); ?></h5>
                                <!-- <span class="mb-0 h5">K</span> -->
                            </div>
                            <p class="mb-0"><?php echo __('Total Earnings', 'hello-elementor'); ?></p>
                        </div>
                    </div>
                </div>
                <!-- Counter item -->
                <!-- <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-success bg-opacity-10 rounded-3">
                        <span class="display-6 lh-1 text-light mb-0"><i class="bi bi-patch-check-fill"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex">
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="6" data-purecounter-delay="300" data-purecounter-duration="0">6</h5>
                                <span class="mb-0 h5">K+</span>
                            </div>
                            <p class="mb-0"><?php echo __('Total Revenue', 'hello-elementor'); ?></p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- <a class=" mb-3 btn btn-dark" href="admin.php?page=ar-msb-service-categories">Add Services Categories</a> -->
    <?php if (isset($msg)) { ?>
        <h3 class="text-success text-center"><?php echo $msg; ?></h3>
    <?php } ?>
    <?php $exampleListTable->display(); ?>
</div>

<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Example_List_Table_Expired extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public $total_earnings;
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        if (isset($data)) {
            usort($data, array(&$this, 'sort_data'));

            $perPage = 10;
            $currentPage = $this->get_pagenum();
            $totalItems = count($data);

            $this->set_pagination_args(array(
                'total_items' => $totalItems,
                'per_page'    => $perPage
            ));

            $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

            $this->_column_headers = array($columns, $hidden, $sortable);
            $this->items = $data;
        }
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'Name' => 'Name',
            'Email' => 'Email',
            'Price' => 'Price',
            'Earning' => 'Earning',
            'Order Date' => 'Order Date',
            'Action'  => 'Action'
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
            'Order Date' => array('Order Date', false),
            'Name' => array('Name', false),
            'Price' => array('Price', false),
            'Earning' => array('Earning', false),
            'Email' => array('Email', false),
        );
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = [];

        $total_earnings = 0;
        if (isset($_POST['submit'])) {
            global $wpdb;

            $reseller_id = $_POST['reseller_id'];
            $date_range = $_POST['range_date'];
            // Use explode to split the string by ' - '
            $date_parts = explode(' - ', $date_range);

            // Assign start and end dates to variables
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];


            $meta_key = 'socksresellerid';
            $meta_value = $reseller_id; // replace with your actual meta value// Create DateTime objects
            $start_date_obj = new DateTime($start_date);
            $end_date_obj = new DateTime($end_date);

            // Format dates to 'Y/m/d'
            $start_date = $start_date_obj->format('Y-m-d');
            $end_date   = $end_date_obj->format('Y-m-d');


            $query = $wpdb->prepare("
            SELECT *
            FROM
                {$wpdb->prefix}wc_orders o
            JOIN
                {$wpdb->prefix}wc_orders_meta om ON o.id = om.order_id
            WHERE
                om.meta_key = 'referenceNumber'
                AND om.meta_value = %s
        ", $reseller_id); // Pass the value 6 as an argument to the prepare function

            // Retrieve the results
            $orders = $wpdb->get_results($query);
            // $orderid = $results[0]->order_id;
            // $order = wc_get_order( $orderid );
            // echo "<pre>";
            // var_dump($order);
            // echo "<pre>";

            // exit();

            //$cc = count($all_members_array);
            foreach ($orders as $order) {
                $order_data = wc_get_order($order->order_id);
                // Get the Customer ID (User ID)
                $customer_id = $order_data->get_customer_id(); // Or $order_data->get_user_id();

                // Get the WP_User Object instance
                $user = $order_data->get_user();

                // Get the WP_User roles and capabilities
                $user_roles = $user->roles;

                // Get the Customer billing email
                $billing_email  = $order_data->get_billing_email();

                // Get the Customer billing phone
                $billing_phone  = $order_data->get_billing_phone();

                // Customer billing information details
                $billing_first_name = $order_data->get_billing_first_name();
                $billing_last_name  = $order_data->get_billing_last_name();
                $billing_company    = $order_data->get_billing_company();
                $billing_address_1  = $order_data->get_billing_address_1();
                $billing_address_2  = $order_data->get_billing_address_2();
                $billing_city       = $order_data->get_billing_city();
                $billing_state      = $order_data->get_billing_state();
                $billing_postcode   = $order_data->get_billing_postcode();
                $billing_country    = $order_data->get_billing_country();

                // Customer shipping information details
                $shipping_first_name = $order_data->get_shipping_first_name();
                $shipping_last_name  = $order_data->get_shipping_last_name();
                $shipping_company    = $order_data->get_shipping_company();
                $shipping_address_1  = $order_data->get_shipping_address_1();
                $shipping_address_2  = $order_data->get_shipping_address_2();
                $shipping_city       = $order_data->get_shipping_city();
                $shipping_state      = $order_data->get_shipping_state();
                $shipping_postcode   = $order_data->get_shipping_postcode();
                $shipping_country    = $order_data->get_shipping_country();
                $total_quantity      = $order_data->get_item_count();
                $order_total         = $order_data->get_total();
                $order_edit_url      = $order_data->get_edit_order_url();
                $earning = $order_total / 2; // Example calculation for earnings

                $total_earnings += $earning;

                $data[] = array(
                    'Name'   => $billing_first_name,
                    'Email'     => $billing_email,
                    'Price'  => $order_total,
                    'Earning'  => $order_total / 2,
                    'Order Date'     => date('Y-m-d', strtotime($order_data->get_date_created())),
                    'Action'         => '
                <a class="btn btn-warning btn-sm"  href="' . $order_edit_url . '"><i class="bi bi-eye"></i> View Order</a>
              '
                );
            }
        }
        $this->total_earnings = $total_earnings;

        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'Name':
            case 'Email':
            case 'Price':
            case 'Earning':
            case 'Order Date':
            case 'Action':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data($a, $b)
    {
        // Set defaults
        $orderby = 'Order Date';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if (!empty($_GET['orderby'])) {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if (!empty($_GET['order'])) {
            $order = $_GET['order'];
        }


        $result = strnatcmp($a[$orderby], $b[$orderby]);

        if ($order === 'asc') {
            return $result;
        }

        return -$result;
    }

    public function get_total_earnings()
    {
        return $this->total_earnings;
    }
}

?>


<script>
    jQuery(document).ready(function($) {

        $('input.date_range').daterangepicker({
            autoApply: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },



        });
    });
</script>