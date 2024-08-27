<?php
// to add custom post type
add_action('init', 'socks_custom_post_type');
function socks_custom_post_type()
{
    if (!session_id()) {
        session_start();
    }

    if (isset($_GET['refid'])) {
        $_SESSION['refid'] = sanitize_text_field($_GET['refid']);
    }
    if (isset($_SESSION['refid'])) :
        add_query_arg('key', 'value', site_url());
    endif;

    $post_type = [
        'profile-photos' => [
            'name'              => 'Profile Photos',
            'slug'              => 'profile-photos',
            'is_category'       => true,
            'taxonomy'          => 'profile-photos-category',
            'icon'              => 'dashicons-images-alt',
            'editor'            =>  false,
            'excerpt'           =>  false,
            'thumbnail'         =>  true
        ],
        'cover-photos' => [
            'name'              => 'Cover Photos',
            'slug'              => 'cover-photos',
            'is_category'       => true,
            'taxonomy'          => 'cover-photos-category',
            'icon'              => 'dashicons-cover-image',
            'editor'            =>  false,
            'excerpt'           =>  false,
            'thumbnail'         =>  true
        ]
    ];
    $i = 4;
    foreach ($post_type as $k => $v) {
        if ($v['editor']) {
            $editor = 'editor';
        } else {
            $editor = '';
        }
        if ($v['thumbnail']) {
            $thumbnail = 'thumbnail';
        } else {
            $thumbnail = '';
        }
        if ($v['excerpt']) {
            $excerpt = 'excerpt';
        } else {
            $excerpt = '';
        }
        register_post_type(
            $k,
            array(
                'labels' => array(
                    'name'          => __($v['name']),
                    'singular_name' => __($v['name']),
                    'add_new'       => __('Add New'),
                    'add_new_item'  => __('Add New ' . $v['name']),
                    'edit_item'     => __('Edit ' . $v['name']),
                    'new_item'      => __('New ' . $v['name']),
                    'view_item'     => __('View ' . $v['name']),
                    'not_found'     => __('Sorry, we couldn\'t find the ' . $v['name'] . ' Menu you are looking for.')
                ),
                'public' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'menu_position'      => $i,
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_icon'          => $v['icon'],
                'taxonomies'         => array($v['taxonomy']),
                'capability_type'    => 'page',
                'rewrite'            => array('slug' => $v['name']),
                'supports'           => ['title', $editor, $thumbnail, $excerpt]
            )
        );

        if ($v['is_category']) {
            $labels = array(
                'name'              => _x($v['name'], 'taxonomy general name'),
                'singular_name'     => _x(' Category', 'taxonomy singular name'),
                'search_items'      => __('Search '),
                'all_items'         => __('All '),
                'parent_item'       => __('Parent Category'),
                'parent_item_colon' => __('Parent Category:'),
                'edit_item'         => __('Edit Category'),
                'update_item'       => __('Update Category'),
                'add_new_item'      => __('Add New Category'),
                'new_item_name'     => __('New Category'),
                'menu_name'         => __(' Category'),
                'rewrite' => array(
                    'slug' => $v['taxonomy'],
                    'with_front' => false
                )
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => true,
            );
            register_taxonomy($v['taxonomy'], array($k), $args);
            $i++;
        }
    }
}
