<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Ignis
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
function ignis_wc_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );    
}
add_action( 'after_setup_theme', 'ignis_wc_support' );

/**
 * Add and remove actions
 */
function ignis_woo_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    add_action('woocommerce_before_main_content', 'ignis_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'ignis_wrapper_end', 10);
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
    add_filter( 'woocommerce_show_page_title', '__return_false' );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
    add_action( 'woocommerce_before_shop_loop', 'ignis_product_columns_wrapper_start', 40 );
    add_action( 'woocommerce_after_shop_loop', 'ignis_product_columns_wrapper_end', 40 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display',               15 );
    add_action( 'woocommerce_after_single_product_summary',    'ignis_upsell_display',                15 );
}
add_action('wp','ignis_woo_actions');

/**
 * Theme wrappers
 */
function ignis_wrapper_start() {

    echo '<div id="primary" class="content-area col-md-10 nosidebar">';
        echo '<main id="main" class="site-main" role="main">';
}

function ignis_wrapper_end() {
        echo '</main>';
    echo '</div>';
}

/**
 * Update cart
 */
function ignis_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>"><i class="icon-shopping-bag"></i><span class="cart-amount"><?php echo WC()->cart->cart_contents_count; ?></span></a>
    <?php
    
    $fragments['a.cart-contents'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ignis_header_add_to_cart_fragment' );

/**
 * Add cart to menu
 */
function ignis_nav_cart ( $items, $args ) {
    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu', 1);
    if ( $swc_show_cart_menu ) {
        if ( $args -> theme_location == 'menu-1' ) {
            $items .= '<li class="nav-cart menu-icon"><a class="cart-contents" href="' . wc_get_cart_url() . '"><i class="icon-shopping-bag"></i><span class="cart-amount">' . WC()->cart->cart_contents_count . '</span></a></li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'ignis_nav_cart', 10, 2 );

/**
 * Woocommerce account link in header
 */
function ignis_woocommerce_account_link( $items, $args ) {
    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu', 1);
    if ( $swc_show_cart_menu && ( $args -> theme_location == 'menu-1' ) ) {
        if ( is_user_logged_in() ) {
            $account = __( 'My Account', 'ignis' );
        } else {
            $account = __( 'Login/Register', 'ignis' );
        }
        $items .= '<li class="header-account menu-icon"><a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . $account . '"><i class="icon-user"></i></a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'ignis_woocommerce_account_link', 10, 2 );

/**
 * Search icon
 */
function ignis_menu_search( $items, $args ) {
    if ( $args -> theme_location == 'menu-1' ) {
        $items .= '<li class="header-search menu-icon"><a href="#"><i class="icon-search"></i></a></li>';
        $items .= '<div class="header-search-form">' . get_search_form(false) . '</div>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'ignis_menu_search', 10, 2 );

/**
 * Returns true if current page is shop, product archive or product tag
 */
function ignis_wc_archive_check() {
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Number of products on shop/archive page
 */
function ignis_archive_products() {
    $productsNum = get_theme_mod( 'iwc_products_number', 10 );

    return $productsNum;
}
add_filter( 'loop_shop_per_page', 'ignis_archive_products', 20 );

/**
 * Number of columns on shop/archive page
 */
function ignis_archive_columns() {
    $columnsNum = get_theme_mod( 'iwc_columns_number', 3 );

    return $columnsNum;
}
add_filter( 'loop_shop_columns', 'ignis_archive_columns' );

/**
 * Number of related products and columns
 */
function ignis_related_products_args( $args ) {
    $productsNum = get_theme_mod( 'iwc_related_products_number', 3 );
    $columnsNum = get_theme_mod( 'iwc_related_columns_number', 3 );

    $args['posts_per_page'] = $productsNum;
    $args['columns'] = $columnsNum;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'ignis_related_products_args' );

/**
 * Number of upsell product columns (number of upsells is selected through the single product edit screen)
 * Using the same column number for upsell and related products
 */
function ignis_upsell_display() {
    $columnsNum = get_theme_mod( 'iwc_related_columns_number', 3 );
    woocommerce_upsell_display( -1, $columnsNum );
}

/**
 * Product shop/archive wrappers
 * Based on this wrapper and the class added, we are able to style the width of the Shop/Archive products accordingly.
 */
function ignis_product_columns_wrapper_start() {
    $columnsNum = ignis_archive_columns();
    echo '<div class="columns-' . $columnsNum . '">';
}

function ignis_product_columns_wrapper_end() {
    echo '</div>';
}

/**
 * Add number of related/uspsell product columns class to the body
 * Based on this class we are able to style the width of the Related and Upsell products accordingly. 
 * Woocommerce doesn't wrap these elements with the columns-# class out-of-the-box
 */
function ignis_woocommerce_body_class( $classes ){
    if( is_product() ) {
        $columnsNum = get_theme_mod( 'iwc_related_columns_number', 3 );
        if ($columnsNum) {
            $classes[] = 'ignis-related-columns-' . $columnsNum;
            $classes[] = 'ignis-upsell-columns-' . $columnsNum;
        }
    }
    return $classes;
}
add_filter( 'body_class', 'ignis_woocommerce_body_class' );

/**
 * Remove Price on the shop/archive page if the user selected that option
 */
function ignis_price_customizer_check() {
    $iwc_archive_price = get_theme_mod('iwc_archive_price');
    if ( $iwc_archive_price == 1 ) :
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	endif;
}
add_action('wp','ignis_price_customizer_check');

/**
 * Remove Rating on the shop/archive page if the user selected that option
 */
function ignis_archive_ratings_customizer_check() {
    $iwc_archive_ratings = get_theme_mod('iwc_archive_ratings');
    if ( $iwc_archive_ratings == 1 ) :
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	endif;
}
add_action('wp','ignis_archive_ratings_customizer_check');

/**
 * Remove Rating on the single product page if the user selected that option
 */
function ignis_single_ratings_customizer_check() {
    $iwc_product_ratings = get_theme_mod('iwc_product_ratings');
    if ( $iwc_product_ratings == 1 ) :
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	endif;
}
add_action('wp','ignis_single_ratings_customizer_check');

/**
 * Remove number of Results on the shop/archive page if the user selected that option
 */
function ignis_archive_results_customizer_check() {
    $iwc_archive_results = get_theme_mod('iwc_archive_results');
    if ( $iwc_archive_results == 1 ) :
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	endif;
}
add_action('wp','ignis_archive_results_customizer_check');

/**
 * Remove Categories on the single product page if the user selected that option
 * The downside is that this hook removes the entire single product meta that contains the SKU, Categories and Tags
 */
function ignis_single_cats_customizer_check() {
    $iwc_product_cats = get_theme_mod('iwc_product_cats');
    if ( $iwc_product_cats == 1 ) :
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	endif;
}
add_action('wp','ignis_single_cats_customizer_check');

/**
 * Remove Ordering/Sorting on the shop/archive page if the user selected that option
 */
function ignis_sorting_customizer_check() {
    $iwc_archive_sorting = get_theme_mod('iwc_archive_sorting');
    if ( $iwc_archive_sorting == 1 ) :
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	endif;
}
add_action('wp','ignis_sorting_customizer_check');

/**
 * Remove Add to cart button on the shop/archive page if the user selected that option
 */
function ignis_atc_customizer_check() {
    $iwc_archive_atc = get_theme_mod('iwc_archive_atc');
    if ( $iwc_archive_atc == 1 ) :
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	endif;
}
add_action('wp','ignis_atc_customizer_check');

/**
 * Remove Breadcrumbs on the shop/archive and single product pages if the user selected that option
 */
function ignis_bc_customizer_check() {
    $iwc_archive_bc = get_theme_mod('iwc_archive_bc');
    if ( $iwc_archive_bc == 1 ) :
		remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0 );
	endif;
}
add_action('wp','ignis_bc_customizer_check');
