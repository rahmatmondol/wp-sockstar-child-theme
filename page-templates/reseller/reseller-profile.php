<?php
/*
Template Name: Reseller Profile
*/

get_header();

$reseller_username = get_query_var('reseller_username');
$member_username = get_query_var('member_username');

$member_user = get_user_by('login', $member_username);
$reseller_user = get_user_by('login', $reseller_username);



if ($reseller_user) {
    $reseller_id = $reseller_user->ID;
    
    $user_meta_data = get_user_meta($reseller_id);
    $team_name = isset($user_meta_data['team_name'][0]) ? $user_meta_data['team_name'][0] : '';
    $shop_name = isset($user_meta_data['shop_name'][0]) ? $user_meta_data['shop_name'][0] : '';
    $shop_description = isset($user_meta_data['shop_description'][0]) ? $user_meta_data['shop_description'][0] : '';
    //shop profile image
    $shop_profile_image_id = isset($user_meta_data['shop_profile_image_id'][0]) ? $user_meta_data['shop_profile_image_id'][0] : '';
    $shop_profile_image = wp_get_attachment_image_url($shop_profile_image_id, 'full');
    $shop_profile_image_scrsrc = wp_get_attachment_image_srcset($shop_profile_image_id, 'full');
    //shop cover img
    $shop_cover_photo_id = isset($user_meta_data['shop_cover_photo_id'][0]) ? $user_meta_data['shop_cover_photo_id'][0] : '';
    // text color
    $bgColorProfile = isset($user_meta_data['bgColorProfile'][0]) ? $user_meta_data['bgColorProfile'][0] : '';
    $shop_cover_photo_scrsrc = wp_get_attachment_image_srcset($shop_cover_photo_id, 'full');
    $shop_cover_photo_img = wp_get_attachment_image_url($shop_cover_photo_id, 'full');

?>

    <style>
        #u-name {
            color: <?php echo $bgColorProfile; ?>;
        }

        #profile-upper #profile-banner-image {
            height: 350px;
        }

        #profile-upper .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        #profile-upper .reseller-menu {
            bottom: 18px;
            z-index: 9;
            right: 0;
        }

        .elementor-location-footer {
            background-color: #3AAFA9;
        }
    </style>
    <div class="container-fluid px-0 profile-main">
        <div id="profile-upper">
            <div id="profile-banner-image" class="position-relative overflow-hidden">
                <img src="<?php echo !empty($shop_cover_photo_img) ? $shop_cover_photo_img : 'https://imagizer.imageshack.com/img921/9628/VIaL8H.jpg'; ?>" srcset="<?php echo !empty($shop_cover_photo_scrsrc) ? $shop_cover_photo_scrsrc : ''; ?>" alt="Banner image" class="img-fluid">
            </div>
            <ul class="list-group list-group-horizontal reseller-menu position-absolute">
                <li class="list-group-item theme-bg-primary text-white"><a href="<?php echo site_url('/user/shop-settings/'); ?>" class="text-decoration-none text-white"><i class="fa-solid fa-camera"></i></a></li>
            </ul>
            <div id="profile-d" class="text-light">
                <div id="profile-pic">
                    <img src="<?php echo !empty($shop_profile_image) ? $shop_profile_image : 'https://imagizer.imageshack.com/img921/3072/rqkhIb.jpg" class="img-fluid rounded-circle'; ?>" srcset="<?php echo !empty($shop_profile_image_scrsrc) ? $shop_profile_image_scrsrc : ''; ?>" alt="Banner image" class="img-fluid">

                </div>
                <div id="u-name"><?php echo esc_html($team_name); ?></div><br>

            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-10 col-12 pt-4 text-center px-4">
                <p><?php echo __($shop_description, 'hello-elementor'); ?></p>
            </div>
            <div class="col-12">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $args = array(
                    'post_type' => 'product',
                    'paged'     => $paged,
                );

                $wp_query = new WP_Query($args);
                ?>

                <?php do_action('woocommerce_archive_description'); ?>

                <?php if (have_posts()) : ?>

                    <?php
                    // I don't want the sorting anymore
                    //do_action('woocommerce_before_shop_loop');
                    ?>

                    <ul class="products-list">

                        <div class="container bg-white">
                            <!-- <nav class="navbar navbar-expand-md navbar-light bg-white">
                                    <div class="container-fluid p-0"> <a class="navbar-brand text-uppercase fw-800" href="#"><span class="border-red pe-2">New</span>Product</a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNav" aria-controls="myNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="fas fa-bars"></span> </button>
                                        <div class="collapse navbar-collapse" id="myNav">
                                            <div class="navbar-nav ms-auto"> <a class="nav-link active" aria-current="page" href="#">All</a> <a class="nav-link" href="#">Women's</a> <a class="nav-link" href="#">Men's</a> <a class="nav-link" href="#">Kid's</a> <a class="nav-link" href="#">Accessories</a> <a class="nav-link" href="#">Cosmetics</a> </div>
                                        </div>
                                    </div>
                                </nav> -->
                            <div class="row">

                                <?php
                                while (have_posts()) : the_post();
                                    global $product;

                                    // Get product information
                                    $price_html = $product->get_price_html();
                                    $sale_status = '';

                                    // Check if the product is on sale
                                    $is_on_sale = $product->is_on_sale();

                                    // Check if the product is in stock
                                    $is_in_stock = $product->is_in_stock();

                                    // Get Polylang translations
                                    $on_sale_translation = __('On Sale', 'hello-elementor');
                                    $out_of_stock_translation = __('Out of Stock', 'hello-elementor');

                                    // Display tags based on conditions
                                    if ($is_on_sale && $is_in_stock) {
                                        $sale_status = '<div class="tag bg-red">' . esc_html($on_sale_translation) . '</div>';
                                    } elseif (!$is_in_stock) {
                                        $sale_status = '<div class="tag bg-black">' . esc_html($out_of_stock_translation) . '</div>';
                                    }

                                    if($member_user){
                                        $id = $member_user->ID;
                                    }else{
                                        $id = $reseller_id;
                                    }
                                ?>

                                    <div class="col-lg-3 col-sm-6 d-flex flex-column align-items-center justify-content-center product-item my-3">
                                        <div class="product">
                                            <a class="sock-product-link-reseller" data-reseller-id="<?php echo $id; ?>" href="<?php the_permalink(); ?><?php echo '?resellerid=' . $id; ?>"><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt=""></a>
                                            <!-- <ul class="d-flex align-items-center justify-content-center list-unstyled icons">
                                                <li class="icon"><span class="fas fa-shopping-bag"></span></li>
                                            </ul> -->
                                        </div>
                                        <?php echo $sale_status; ?>
                                        <div class="title pt-4 pb-1"><a class="sock-product-link-reseller" data-reseller-id="<?php echo $id; ?>" href="<?php the_permalink(); ?><?php echo '?resellerid=' . $id; ?>"><?php the_title(); ?></a></div>

                                        <?php
                                        // Display reviews count and link
                                        $review_count = $product->get_review_count();
                                        $rating_count = $product->get_average_rating();

                                        // Display default WooCommerce star rating
                                        echo wc_get_rating_html($product->get_average_rating());
                                        ?>
                                        <div class="price"><?php echo $price_html; ?></div>
                                    </div>

                                <?php endwhile; // end of the loop.
                                ?>

                            </div>
                        </div>
                    </ul>

                    <?php
                    /*  woocommerce pagination  */
                    do_action('woocommerce_after_shop_loop');
                    ?>

                <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

                    <?php woocommerce_get_template('loop/no-products-found.php'); ?>

                <?php endif; ?>
                <?php
                ?>
            </div>
        </div>
    </div>
<?php
} else {
    // Handle case where reseller user is not found
    echo 'Reseller not found.';
}

get_footer();
?>