<?php
//Show status in users table
function add_user_status_column($columns)
{
    $columns['status'] = 'Status';
    return $columns;
}
add_filter('manage_users_columns', 'add_user_status_column');


function show_user_status_column_content($value, $column_name, $user_id)
{
    if ($column_name == 'status') {
        // Retrieve user status (example: from user meta or custom logic)
        $status = get_user_meta($user_id, 'user_flag', true);
        // if (!$status) {
        //     $status = 'inactive'; // default value
        // } else {
        //     $status = 'active'; // default value
        // }
        return $status;
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_user_status_column_content', 10, 3);
function make_user_status_column_sortable($columns)
{
    $columns['status'] = 'status';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'make_user_status_column_sortable');

// function sort_user_status_column($query)
// {
//     if (!is_admin()) {
//         return;
//     }

//     $orderby = $query->get('orderby');

//     if ('status' == $orderby) {
//         // Modify the query to sort by the user meta 'status'
//         $query->set('meta_key', 'user_flag');
//         $query->set('orderby', 'meta_value');
//     }
// }
// add_action('pre_get_users', 'sort_user_status_column');
