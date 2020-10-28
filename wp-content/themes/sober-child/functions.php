<?php
/**
 * Sober functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sober Child
 */

add_action( 'wp_enqueue_scripts', 'sober_child_enqueue_scripts', 20 );

function sober_child_enqueue_scripts() {
	wp_enqueue_style('sober-child', get_stylesheet_uri());
}

add_action( 'init', 'register_cpt_discountrules' );

function register_cpt_discountrules() {
	$labels = array( 
	    'name' => __( 'Discount Rules', 'discount' ),
	    'singular_name' => __( 'Discount Rules', 'discount' ),
	    'add_new' => __( 'Add New', 'discount' ),
	    'add_new_item' => __( 'Add New Discount Rules', 'discount' ),
	    'edit_item' => __( 'Edit Discount Rules', 'discount' ),
	    'new_item' => __( 'New Discount Rules', 'discount' ),
	    'view_item' => __( 'View Discount Rules', 'discount' ),
	    'search_items' => __( 'Search Discount Rules', 'discount' ),
	    'not_found' => __( 'No galleries found', 'discount' ),
	    'not_found_in_trash' => __( 'No galleries found in Trash', 'discount' ),
	    'parent_item_colon' => __( 'Parent Discount Rules:', 'discount' ),
	    'menu_name' => __( 'Discount Rules', 'discount' ),
	);

	$args = array( 
	    'labels' => $labels,
	    'hierarchical' => true,
	    'description' => '',
	    'supports' => array( 'title', 'editor', 'author'),
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'publicly_queryable' => true,
	    'exclude_from_search' => false,
	    'has_archive' => true,
	    'query_var' => true,
	    'can_export' => true,
	    'rewrite' => true
	);

	register_post_type( 'discountpost', $args );
}

add_action( 'init', 'register_cpt_printing' );

function register_cpt_printing() {
	$labels = array( 
	    'name' => __( 'Printing', 'printing' ),
	    'singular_name' => __( 'Printing', 'printing' ),
	    'add_new' => __( 'Add New', 'printing' ),
	    'add_new_item' => __( 'Add New Printing', 'printing' ),
	    'edit_item' => __( 'Edit Printing', 'printing' ),
	    'new_item' => __( 'New Printing', 'printing' ),
	    'view_item' => __( 'View Printing', 'printing' ),
	    'search_items' => __( 'Search Printing', 'printing' ),
	    'not_found' => __( 'No galleries found', 'printing' ),
	    'not_found_in_trash' => __( 'No galleries found in Trash', 'printing' ),
	    'parent_item_colon' => __( 'Parent Printing:', 'printing' ),
	    'menu_name' => __( 'Printing', 'printing' ),
	);

	$args = array( 
	    'labels' => $labels,
	    'hierarchical' => true,
	    'description' => '',
	    'supports' => array( 'title', 'editor', 'author'),
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'publicly_queryable' => true,
	    'exclude_from_search' => false,
	    'has_archive' => true,
	    'query_var' => true,
	    'can_export' => true,
	    'rewrite' => true
	);

	register_post_type( 'printingpost', $args );
}

add_action( 'init', 'register_cpt_inkprice' );

function register_cpt_inkprice() {
	$labels = array( 
	    'name' => __( 'Ink Price', 'inkprice' ),
	    'singular_name' => __( 'Ink Price', 'inkprice' ),
	    'add_new' => __( 'Add New', 'inkprice' ),
	    'add_new_item' => __( 'Add New Ink Price', 'inkprice' ),
	    'edit_item' => __( 'Edit Ink Price', 'inkprice' ),
	    'new_item' => __( 'New Ink Price', 'inkprice' ),
	    'view_item' => __( 'View Ink Price', 'inkprice' ),
	    'search_items' => __( 'Search Ink Price', 'inkprice' ),
	    'not_found' => __( 'No galleries found', 'inkprice' ),
	    'not_found_in_trash' => __( 'No galleries found in Trash', 'inkprice' ),
	    'parent_item_colon' => __( 'Parent Ink Price:', 'inkprice' ),
	    'menu_name' => __( 'Ink Price', 'inkprice' ),
	);

	$args = array( 
	    'labels' => $labels,
	    'hierarchical' => true,
	    'description' => '',
	    'supports' => array( 'title', 'editor', 'author'),
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'publicly_queryable' => true,
	    'exclude_from_search' => false,
	    'has_archive' => true,
	    'query_var' => true,
	    'can_export' => true,
	    'rewrite' => true
	);

	register_post_type( 'inkpricepost', $args );
}

add_filter( 'rwmb_meta_boxes', 'inkPost_register_meta_boxes' );

function inkPost_register_meta_boxes( $meta_boxes ) {
    $prefix = 'metaBox-';

    $meta_boxes[] = [
        'title'      => esc_html__( 'Color', 'online-generator' ),
        'id'         => 'inkpricePost',
        'post_types' => ['inkpricepost'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
			[
                'type' => 'text',
                'name' => esc_html__( 'Min Product Quantity', 'online-generator' ),
                'id'   => 'inkpricepostminproductquantity',
            ],
            [
                'type' => 'text',
                'name' => esc_html__( 'Max Product Quantity', 'online-generator' ),
                'id'   => 'inkpricepostmaxproductquantity',
            ],
            [
                'type' => 'text',
                'name' => esc_html__( 'Ink Quantity', 'online-generator' ),
                'id'   => 'inkpricepostinkquantity',
                'clone' => true
            ],            
            [
                'type' => 'text',
                'name' => esc_html__( 'Price', 'online-generator' ),
                'id'   => 'singleinkpricepost',
                'clone' => true
            ],            

        ],
    ];

    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'singleProduct_prefix_post_demo' );

function singleProduct_prefix_post_demo( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'  => __( 'Post Field Demo', 'textdomain' ),
        'post_types' => 'product',

        'fields' => array(
            array(
                'type' => 'checkbox',
                'name' => esc_html__( 'Enable branding', 'online-generator' ),
                'id'   => 'enableBranding',
                'std'  => 1, // 0 or 1
            ),
            array(
                'type' => 'color',
                'name' => esc_html__( 'Color', 'online-generator' ),
                'id'   => 'colorSelected',
                'clone'      => true,
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Color name', 'online-generator' ),
                'id'   => 'colorNameSelected',
                'clone'      => true,
            ),
            array(
                'type' => 'text',
                'name' => esc_html__( 'Size', 'online-generator' ),
                'id'   => 'sizeSelected',
                'clone'      => true,
            ),
            array(
                'name'        => __( 'Printing', 'textdomain' ),
                'id'          => 'printSelected',
                'type'        => 'post',
                'post_type'   => array( 'printingpost' ),
                'field_type'  => 'select_advanced',
                'placeholder' => __( 'Select an Item', 'textdomain' ),
                'query_args'  => array(
                    'post_status'    => 'publish',
                    'posts_per_page' => - 1,
                    'order' => 'ASC',
                    'orderby' => 'name',
                ),
                'std'        => ['Please select'],
                'multiple'   => true
            ),

        ),
    );
    return $meta_boxes;
}

function getPrinting_ajax_enqueue() {
	$printingArray = array();

	$args = array( 'post_type' => 'printingpost', 'order' => 'ASC');
	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) : $loop->the_post();
		array_push($printingArray, get_the_ID());
	endwhile;

	return $printingArray;

}

function register_ajax_enqueue($printingArray) {

	wp_enqueue_script('register-ajax-script', get_stylesheet_directory_uri() . '/custom.js', array('jquery'));

    wp_enqueue_script('bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.8/popper.min.js', array('jquery'), '', true );

    wp_enqueue_script('bootstrap-script', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js', array('jquery'), '', true);

	wp_localize_script(
		'register-ajax-script',
		'register_ajax_obj',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('ajax-nonce'),
            'productId' => get_the_ID(),
            'get_Product_discount_data' => get_Product_discount_data(),
            'printingArray' => getPrinting_ajax_enqueue()
		)
	);

}
add_action( 'wp_enqueue_scripts', 'register_ajax_enqueue' );

function get_Product_discount_data() {
 
	$pId = get_the_ID();
	$product = wc_get_product( $pId );

	if ($product) {
        $discountArray = array();
        $discountProductQuantity = array();
        $discountProductQuantityMin = array();

		// echo $product->get_price();     

	    $args = array( 'post_type' => 'discountpost', 'order' => 'DESC');
	    $loop = new WP_Query( $args );

	    while ( $loop->have_posts() ) : $loop->the_post();
	        $discountRulesQuantityMin = get_post_meta(get_the_ID(), 'discountRulesQuantityMin', true);
            $discountRulesQuantity = get_post_meta(get_the_ID(), 'discountRulesQuantity', true);
            $getDiscountvalue = get_post_meta(get_the_ID(), 'discountRulesValue', true);

            array_push($discountArray, $getDiscountvalue);
            array_push($discountProductQuantityMin, $discountRulesQuantityMin);
            array_push($discountProductQuantity, $discountRulesQuantity);

	    endwhile;

		return json_encode(array('success' => true, 'discountArray' => $discountArray, 'discountProductQuantityMin' => $discountProductQuantityMin, 'discountProductQuantity' => $discountProductQuantity, 'price'=> $product->get_price() ));
	    // Always die in functions echoing ajax content
	   die();
	}
}


function register_ajax_request() {
 
    $discountArray = array();
    $discountProductQuantity = array();
    $discountProductQuantityMin = array();

    $pId = $_POST['pId'];
    $product = wc_get_product( $pId );
    // echo $product->get_price();     

    $args = array( 'post_type' => 'discountpost', 'order' => 'DESC');
    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        $discountRulesQuantityMin = get_post_meta(get_the_ID(), 'discountRulesQuantityMin', true);
        $discountRulesQuantity = get_post_meta(get_the_ID(), 'discountRulesQuantity', true);
        $getDiscountvalue = get_post_meta(get_the_ID(), 'discountRulesValue', true);

        array_push($discountArray, $getDiscountvalue);
        array_push($discountProductQuantityMin, $discountRulesQuantityMin);
        array_push($discountProductQuantity, $discountRulesQuantity);

    endwhile;

    echo json_encode(array('success' => true, 'discountArray' => $discountArray, 'discountProductQuantityMin' => $discountProductQuantityMin, 'discountProductQuantity' => $discountProductQuantity, 'price'=> $product->get_price() ));
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_register_ajax_request', 'register_ajax_request' );
 
// If you wanted to also use the function for non-logged in users (in a theme for register)
add_action( 'wp_ajax_nopriv_register_ajax_request', 'register_ajax_request' );


add_action( 'woocommerce_add_to_cart_redirect', 'prevent_duplicate_products_redirect' );
function prevent_duplicate_products_redirect( $url = false ) {
  if( !empty( $url ) ) {
    return $url;
  }
  return get_bloginfo( 'wpurl' ).add_query_arg( array(), remove_query_arg( 'add-to-cart' ) );
}

add_filter( 'rwmb_meta_boxes', 'discount_register_meta_boxes' );

function discount_register_meta_boxes( $meta_boxes ) {

    $meta_boxes[] = [
        'title'      => esc_html__( 'Color', 'online-generator' ),
        'id'         => 'discountrules',
        'post_types' => ['discountpost'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            [
                'type' => 'text',
                'name' => esc_html__( 'Min Discount Quantity', 'online-generator' ),
                'id'   => 'discountRulesQuantityMin',
            ],
            [
                'type' => 'text',
                'name' => esc_html__( 'Max Discount Quantity', 'online-generator' ),
                'id'   => 'discountRulesQuantity',
            ],
            [
                'type' => 'text',
                'name' => esc_html__( 'Discount value', 'online-generator' ),
                'id'   => 'discountRulesValue',
            ],            
        ],
    ];

    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'printing_register_meta_boxes' );

function printing_register_meta_boxes( $meta_boxes ) {

    $meta_boxes[] = [
        'title'      => esc_html__( 'Price', 'online-generator' ),
        'id'         => 'printingCustomField',
        'post_types' => ['printingpost'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            [
                'type' => 'text',
                'name' => esc_html__( 'Setup Price', 'online-generator' ),
                'id'   => 'printingprice',
            ],            
            [
                'type' => 'text',
                'name' => esc_html__( 'Logo Positions', 'online-generator' ),
                'id'   => 'printinglogopositions',
                'clone'      => true
            ]            

        ],
    ];
    return $meta_boxes;
}

function inkprice_ajax_request() {

    if(!wp_verify_nonce( base64_decode($_POST['nonce']), 'ajax-nonce')){
        die();
    };

    $pId = $_POST['pId'];
    $inkpricepostmaxproductquantityArray = [];
    $inkpricepostminproductquantityArray = [];
    $inkpricepostinkquantityArray = [];
    $singleinkpricepostArray = [];

    $printingsetupprice = get_post_meta($pId, 'printingprice', true);

    $args = array( 'post_type' => 'inkpricepost', 'order' => 'ASC');
    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();

        $inkpricepostminproductquantity = get_post_meta(get_the_ID(), 'inkpricepostminproductquantity', true);
        $inkpricepostmaxproductquantity = get_post_meta(get_the_ID(), 'inkpricepostmaxproductquantity', true);
        $inkpricepostinkquantity = get_post_meta(get_the_ID(), 'inkpricepostinkquantity', true);
        $singleinkpricepost = get_post_meta(get_the_ID(), 'singleinkpricepost', true);
 
        array_push($inkpricepostminproductquantityArray, $inkpricepostminproductquantity);
        array_push($inkpricepostmaxproductquantityArray, $inkpricepostmaxproductquantity);
        array_push($inkpricepostinkquantityArray, $inkpricepostinkquantity);
        array_push($singleinkpricepostArray, $singleinkpricepost);

    endwhile;

    $printingData = array('success' => true, 'inkpricepostminproductquantityArray'=> $inkpricepostminproductquantityArray, 'inkpricepostmaxproductquantityArray'=> $inkpricepostmaxproductquantityArray, 'inkpricepostinkquantityArray' => $inkpricepostinkquantityArray, 'singleinkpricepostArray' => $singleinkpricepostArray,
    'printingsetupprice' => $printingsetupprice,
    );
    echo json_encode($printingData);
   die();
}
 
add_action( 'wp_ajax_inkprice_ajax_request', 'inkprice_ajax_request' );
add_action( 'wp_ajax_nopriv_inkprice_ajax_request', 'inkprice_ajax_request' );

function addtocartprice_ajax_request() {

    if(!wp_verify_nonce( base64_decode($_POST['nonce']), 'ajax-nonce')){
        die();
    };

 	foreach(WC()->cart->get_cart() as $cart_item_key => $values) {
        if ((int)$values['data']->id == (int)$_POST['id']) {
		    die();
        }
    }

	$productId =  $_POST['id'] . 'updated';
    // $_SESSION[$productId] = base64_decode($_POST['price']);
    WC()->session->set( $productId, base64_decode($_POST['price']));

    $result = array('success' => true);
    echo json_encode($result);
    die();
}

add_action( 'wp_ajax_addtocartprice_ajax_request', 'addtocartprice_ajax_request' );
add_action( 'wp_ajax_nopriv_addtocartprice_ajax_request', 'addtocartprice_ajax_request' );

function custom_cart_items_price ( $cart_object ) {

if (is_admin() && ! defined( 'DOING_AJAX' ) )
    return;

    foreach ( $cart_object->get_cart() as $cart_item ) {

        if ($cart_item['enabled_branding'] == 1) {

            $id = $cart_item['data']->get_id();
            $productId =  $id . 'updated';

//          $price = $_SESSION[$productId];
            $price = WC()->session->get($productId);


            // Updated cart item price
            $cart_item['data']->set_price($price);
        }
    }
}

add_filter( 'woocommerce_before_calculate_totals', 'custom_cart_items_price');


add_action( 'wp_ajax_file_upload', 'file_upload_callback' );
add_action( 'wp_ajax_nopriv_file_upload', 'file_upload_callback' );

function file_upload_callback() {
	$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

	if (in_array($_FILES['file']['type'], $arr_img_ext)) {
		$upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
	}

    echo $upload['url'];
    die();
}

function plugin_republic_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
    if (isset( $_POST['enabled_branding'])) {
        $cart_item_data['enabled_branding'] = sanitize_text_field( $_POST['enabled_branding']);
    }

	if (isset( $_POST['size_color'])) {
		$cart_item_data['size_color'] = sanitize_text_field( $_POST['size_color']);
	}

	if (isset( $_POST['logo_quantity'])) {
		$cart_item_data['logo_quantity'] = sanitize_text_field( $_POST['logo_quantity']);
	}

	return $cart_item_data;
}

add_filter( 'woocommerce_add_cart_item_data', 'plugin_republic_add_cart_item_data', 10, 3 );

function plugin_republic_get_item_data( $item_data, $cart_item_data ) {
	if( isset( $cart_item_data['size_color'] ) ) {

        $item_data[] = array(
            'key' => __('enabled_branding', 'plugin-republic'),
            'value' => wc_clean($cart_item_data['enabled_branding'])
        );

		$item_data[] = array(
			'key' => __('size_color', 'plugin-republic'),
			'value' => wc_clean($cart_item_data['size_color'])
		);

		$item_data[] = array(
			'key' => __('logo_quantity', 'plugin-republic'),
			'value' => wc_clean($cart_item_data['logo_quantity'])
		);
	}
}

add_filter('woocommerce_get_item_data', 'plugin_republic_get_item_data', 10, 2);

function cart_product_validation_handler($is_valid, $product_id) {

    foreach(WC()->cart->get_cart() as $cart_item_key => $values) {

        if ($values['data']->id == $product_id) {
            return false;
        }
    }

    return $is_valid;
}

// disable double add to cart of a product
add_filter('woocommerce_add_to_cart_validation', 'cart_product_validation_handler', 10, 2);

// Save / Display custom field value as custom order item meta data
add_action('woocommerce_checkout_create_order_line_item', 'custom_field_update_order_item_meta', 20, 4);

function custom_field_update_order_item_meta($item, $cart_item_key, $values, $order) {

    if( isset($values['size_color']) ){
    	$metaKeyArray = ["Color", "Size", "Color", "Quantity"];
		$metaAttay = explode('~', $values['size_color']);

		for ($i=0; $i < count($metaAttay); $i++) { 

			$dataIndi = explode('_', $metaAttay[$i]);

			for ($j=0; $j < count($dataIndi); $j++) { 
		        $item->update_meta_data(__($metaKeyArray[$j].' '.($i+1)), $dataIndi[$j]);
			}
		}
    }

    if( isset($values['logo_quantity']) ){
    	$metaKeyArray = ["Image", "Position", "Ink", " Each Print", "Prints Total", "Printing Type" ];
		$metaAttay = explode('~', $values['logo_quantity']);

		for ($i=0; $i < count($metaAttay)-1; $i++) { 

			$dataIndi = explode('^', $metaAttay[$i]);

			for ($j=0; $j < count($dataIndi); $j++) { 
		        $item->update_meta_data(__($metaKeyArray[$j].' '.($i+1)), $dataIndi[$j]);
			}
		}
    }
}