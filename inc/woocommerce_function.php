<?php
if (!function_exists('daneshyar_cart_count')) {
    function daneshyar_cart_count(){
        $count = WC()->cart->cart_contents_count;
		?>
		<span class="cart-number"><?php echo esc_html($count); ?></span>
		<?php
    }
}

/**
 * Render custom price html
 */
function daneshyar_custom_get_price_html( $price, $product ) {
	if ( $product->get_price() == 0 ) {
		if ( $product->is_on_sale() && $product->get_regular_price() ) {
			$regular_price = '<del class="amount-free">' . wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) ) . '</del>';

			$price = wc_format_price_range( $regular_price, esc_html__( 'رایگان!', 'daneshyar' ) );
		} else {
			$price = '<span class="amount">' . esc_html__( 'رایگان!', 'daneshyar' ) . '</span>';
		}
	}

	return $price;
}

add_filter( 'woocommerce_get_price_html', 'daneshyar_custom_get_price_html', 10, 2 );

//get teachers list
if(!function_exists('daneshyar_get_teachers_list')){
	function daneshyar_get_teachers_list(){
		$teachers = array(
			'no-teacher'   => __( 'یک استاد را انتخاب کنید', 'daneshyar' ),
		);

		$teachers_arg = array(
			'post_type' => 'teacher',
			'post_status' =>'publish',
			'post_per_page' =>-1,
		);

		$teachers_query = new WP_Query($teachers_arg);

		foreach($teachers_query->posts as $teacher){
			$teachers[$teacher->ID] = $teacher->post_title;
		}

		return $teachers;
	}
}

//remove woocommerce breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

// Remove Woo Styles
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
// Remove result count and catalog ordering
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove Cross-Sells from the shopping cart page
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
// Remove tabs & upsell display
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// Remove functions before single product summary
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_custom_meta', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Remove thumbnails from product single
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

/**
 * Remove sidebar from single product
 */
function remove_sidebar_shop() {
	if ( is_singular('product') ) {
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	}
}
add_action('template_redirect', 'remove_sidebar_shop');

function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );


/*  Sale Product Countdown
/* --------------------------------------------------------------------- */
if( ! function_exists( 'daneshyar_sale_product_countdown' ) ) {
	function daneshyar_sale_product_countdown() {
		global $product;

		if ( $product->is_on_sale() ) :
			$time_sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		endif;

		?>

		<?php if( $product->is_on_sale() && $time_sale_end ) :?>
			<div class="discount_countdown">
				<div class="counter_text">
					<i class="fal fa-clock"></i>
					پیشنهاد
					<span>شگفت انگیز</span>
				</div>
				<div class="counter_number" data-date="<?php echo date('Y-m-d 00:00:00',$time_sale_end); ?>"></div>
			</div>
		<?php endif;?>

	<?php }
}

add_action( 'woocommerce_single_product_countdown', 'daneshyar_sale_product_countdown', 14 );

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
	$prefix = 'daneshyar_';
	$add_to_cart_text= get_post_meta(get_the_ID(  ),$prefix . 'course_add_to_cart_text',true );
	if(class_exists('Redux')){
		$add_to_cart_text_from_setting =  daneshyar_settings('add_to_cart_text');
	}
	if($add_to_cart_text){
		return __( $add_to_cart_text, 'daneshyar' ); 
	}elseif($add_to_cart_text_from_setting){
		return __( $add_to_cart_text_from_setting, 'daneshyar' ); 
	}else{
		return __( 'ثبت نام در دوره', 'daneshyar' ); 
	}
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'ts_replace_add_to_cart_button', 10, 2 );
function ts_replace_add_to_cart_button( $button, $product ) {
if (is_product_category() || is_shop()) {
$button_text = __("شرکت در دوره", "woocommerce");
$button_link = $product->get_permalink();
$button = '<a class="button product_type_simple add_to_cart_button ajax_add_to_cart" href="' . $button_link . '">' . $button_text . '</a>';
return $button;
}
}

add_filter( 'woocommerce_get_availability', 'daneshyar_change_out_of_stock_text_woocommerce', 1, 2);

function daneshyar_change_out_of_stock_text_woocommerce( $availability, $product_to_check ) {

// Change Out of Stock Text
if ( ! $product_to_check->is_in_stock() ) {
$availability['availability'] = 'این دوره فعلاً غیرفعال می باشد.';
}
return $availability;
}

/**
* Change number of products that are displayed per page (shop page)
*/
add_filter( 'loop_shop_per_page', 'daneshyar_loop_shop_per_page', 20 );
function daneshyar_loop_shop_per_page( $cols ) {
  $product_post_per_page =  daneshyar_settings('shop_per_page');
return $product_post_per_page;
}

/* Remove Woocommerce User Fields */
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields' );
// Removes Order Notes Title
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
function custom_override_checkout_fields( $fields ) {
  unset($fields['order']['order_comments']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_city']);
  unset($fields['shipping']['shipping_state']);
  unset($fields['shipping']['shipping_country']);
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_address_1']);
  unset($fields['shipping']['shipping_address_2']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_city']);
  return $fields;
}
function custom_override_billing_fields( $fields ) {
  unset($fields['billing_state']);
  unset($fields['billing_country']);
  unset($fields['billing_company']);
  unset($fields['billing_address_1']);
  unset($fields['billing_address_2']);
  unset($fields['billing_postcode']);
  unset($fields['billing_city']);
  return $fields;
}
function custom_override_shipping_fields( $fields ) {
  unset($fields['shipping_state']);
  unset($fields['shipping_country']);
  unset($fields['shipping_company']);
  unset($fields['shipping_address_1']);
  unset($fields['shipping_address_2']);
  unset($fields['shipping_postcode']);
  unset($fields['shipping_city']);
  return $fields;
}
/* End - Remove Woocommerce User Fields */

/**
 * Remove the generated product schema markup from the Product Category and Shop pages.
 */
function wc_remove_product_schema_product_archive() {
    remove_action( 'woocommerce_shop_loop', array( WC()->structured_data, 'generate_product_data' ), 10, 0 );
}
add_action( 'woocommerce_init', 'wc_remove_product_schema_product_archive' );

// force to update woocommerce link files for old users
class WooCommerce_Legacy_Grant_Download_Permissions {
	protected static $instance = null;
	private function __construct() {
		if ( ! class_exists( 'WC_Admin_Post_Types', false ) ) {
			return;
		}
		remove_action( 'woocommerce_process_product_file_download_paths', array( 'WC_Admin_Post_Types', 'process_product_file_download_paths' ), 10, 3 );
		add_action( 'woocommerce_process_product_file_download_paths', array( $this, 'grant_download_permissions' ), 10, 3 );
	}
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function grant_download_permissions( $product_id, $variation_id, $downloadable_files ) {
		global $wpdb;

		if ( $variation_id ) {
			$product_id = $variation_id;
		}

		if ( ! $product = wc_get_product( $product_id ) ) {
			return;
		}

		$existing_download_ids = array_keys( (array) $product->get_downloads() );
		$updated_download_ids  = array_keys( (array) $downloadable_files );
		$new_download_ids      = array_filter( array_diff( $updated_download_ids, $existing_download_ids ) );
		$removed_download_ids  = array_filter( array_diff( $existing_download_ids, $updated_download_ids ) );

		if ( ! empty( $new_download_ids ) || ! empty( $removed_download_ids ) ) {
			$existing_orders = $wpdb->get_col( $wpdb->prepare( "SELECT order_id from {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE product_id = %d GROUP BY order_id", $product_id ) );

			foreach ( $existing_orders as $existing_order_id ) {
				$order = wc_get_order( $existing_order_id );

				if ( $order ) {
					if ( ! empty( $removed_download_ids ) ) {
						foreach ( $removed_download_ids as $download_id ) {
							if ( apply_filters( 'woocommerce_process_product_file_download_paths_remove_access_to_old_file', true, $download_id, $product_id, $order ) ) {
								$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->get_id(), $product_id, $download_id ) );
							}
						}
					}
					if ( ! empty( $new_download_ids ) ) {
						foreach ( $new_download_ids as $download_id ) {
							if ( apply_filters( 'woocommerce_process_product_file_download_paths_grant_access_to_new_file', true, $download_id, $product_id, $order ) ) {
								if ( ! $wpdb->get_var( $wpdb->prepare( "SELECT 1=1 FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->get_id(), $product_id, $download_id ) ) ) {
									wc_downloadable_file_permission( $download_id, $product_id, $order );
								}
							}
						}
					}
				}
			}
		}
	}
}

add_action( 'admin_init', array( 'WooCommerce_Legacy_Grant_Download_Permissions', 'get_instance' ) );
// برای بالا بردن سرعت سایت
function dequeuePublicMy(){
	// اگر آیکن های سایت شما پرید این قسمت رو حذف کنید
	wp_dequeue_style('font-awesome-4-shim');
 	wp_deregister_style('font-awesome-4-shim');
	
	wp_dequeue_style('elementor-global');
	wp_deregister_style('elementor-global');

	wp_dequeue_style('font-awesome-5-all');
        wp_deregister_style('font-awesome-5-all');	
    // تا این قسمت
    

	wp_dequeue_script('contact-form-7');
        wp_deregister_script('contact-form-7');

	wp_dequeue_script('comment-reply');
        wp_deregister_script('comment-reply');

        wp_dequeue_script('wp-embed');
        wp_deregister_script('wp-embed');

        wp_dequeue_style('wp-block-library');
	wp_deregister_style('wp-block-library');

	wp_dequeue_style('wp-block-library-theme');
        wp_deregister_style('wp-block-library-theme');
    
        wp_dequeue_style('contact-form-7-rtl');
	wp_deregister_style('contact-form-7-rtl');

}
