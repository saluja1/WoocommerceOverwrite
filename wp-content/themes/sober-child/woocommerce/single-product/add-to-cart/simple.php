<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

$currency = get_woocommerce_currency_symbol();

$checkForBranding = get_post_meta($product->get_id(), 'enableBranding', true);

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

		<?php if ($checkForBranding) {
			$args = array('post_type' => 'discountpost', 'order' => 'ASC');
			$discountposts = get_posts($args);
		?>

		<div class="discount-wrapper">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="5">BLANK GARMENT DISCOUNTS</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
							for ($i=0; $i < count($discountposts); $i++) { 
								$minvalue = get_post_meta($discountposts[$i]->ID, 'discountRulesQuantityMin', true);
								$maxvalue = get_post_meta($discountposts[$i]->ID, 'discountRulesQuantity', true);

								if ($i == (count($discountposts) - 1)) {
									echo '<td>'.$minvalue.'+'.'</td>';
								} else {
									echo '<td>'.$minvalue.'-'.$maxvalue.'</td>';
								}
							}
						?>
					</tr>
					<tr>
						<?php

							for ($i=0; $i < count($discountposts); $i++) {
								$discount = get_post_meta($discountposts[$i]->ID, 'discountRulesValue', true);
								echo '<td>'.$discount.'%</td>';
							}
						?>
					</tr>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<form class="cart cart-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			) );

			do_action( 'woocommerce_after_add_to_cart_quantity' );
			?>

			<input type="hidden" class="enabled_branding" name="enabled_branding" value="0" />
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
			<button type="submit" class="single_add_to_cart_button button alt">
				<?php sober_shopping_cart_icon(); ?>
				<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
			</button>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>
	<?php } ?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
