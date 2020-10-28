<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$checkForBranding = get_post_meta($product->get_id(), 'enableBranding', true);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php if($checkForBranding) { ?>

		<div class="size_color_inner_wrapper">
			<?php

				$getcolorSelected = get_post_meta(get_the_ID(), 'colorSelected', true);
				$countcolor = count($getcolorSelected);

			    $getcolorNameSelected = get_post_meta(get_the_ID(), 'colorNameSelected', true);
				$countcolorName = count($getcolorSelected);

			    $getSizeSelected = get_post_meta(get_the_ID(), 'sizeSelected', true);
				$countSize = count($getSizeSelected);


				echo "<table border =\"1\" class='table table-bordered size_color_inner singleProductTable' data-product='".get_the_ID()."'>";
				for ($row=1; $row <= $countcolor+1; $row++) { 
				echo "<tr> \n";
				for ($col=1; $col <= $countSize+1; $col++) { 
				   $p = $col * $row;
				   if ($row == 1 && $col == 1) {
					   echo "<th width='60'>Order Grid</th> \n";	   	
				   } elseif ($row == 1) {
					   echo "<th width='60'>".$getSizeSelected[$col-2]."</th> \n";	   	
				   } elseif($col == 1) {
					   echo "<td style='text-align: left; min-width: 125px; vertical-align: middle;' width='120'><span class='color-box' style='background-color: ".$getcolorSelected[$row-2]."'></span>" .$getcolorNameSelected[$row-2]."</td> \n";
				   } else {

					   echo "<td width='60'><input type='number' data-colorn='".$getcolorNameSelected[$row-2]."' data-size='".$getSizeSelected[$col-2]."' data-color='".$getcolorSelected[$row-2]."' min='0' name='quantity_".$row."_".$col."' /></td> \n";   	
				   }
				}
			  	    echo "</tr>";
				}

				echo "</table>";
			?>
		</div>

		<div class="custom-branding">
			<ul class="nav nav-tabs" role="tablist">
				<?php

					$getprintSelected = get_post_meta(get_the_ID(), 'printSelected', false);

					for ($i=0; $i < count($getprintSelected); $i++) { 
						$printingData = get_post($getprintSelected[$i]);

						$active = $i == 0 ? 'active' : '';

						echo '<li class="nav-item"><a class="nav-link '.$active.'" data-toggle="tab" href="#tabs-'.$i.'" role="tab">'.$printingData->post_title.'</a></li>';
					}
				?>
			</ul>

			<div class="tab-content">

				<?php

					$getprintSelected = get_post_meta(get_the_ID(), 'printSelected', false);

					for ($i=0; $i < count($getprintSelected); $i++) {
					$printingData = get_post($getprintSelected[$i]);
				?>

				<div class="tab-pane <?php echo $i == 0 ? 'active': ''; ?>" id="tabs-<?php echo $i; ?>" role="tabpanel">

					<div class="size_logo_inner_wrapper">
						<?php
							$columnPrintingheading = ['Logo', 'Placements', 'Ink Color', 'Each print', 'Prints total'];

					        $printinglogopositions = get_post_meta($printingData->ID, 'printinglogopositions', true);

							$countprintinglogopositions = count($printinglogopositions);
							$countcolumnPrintingheading = count($columnPrintingheading);

							echo "<table border='1' class='table table-bordered size_logo_inner singleColorTable printing_".$printingData->ID."' data-product='".$printingData->ID."'>";

							for ($row=1; $row <= $countprintinglogopositions+1; $row++) { 
								echo "<tr> \n";

								for ($col=1; $col <= $countcolumnPrintingheading; $col++) { 
								   $p = $col * $row;

								   if ($row == 1 && $col == 1) {
									   echo "<th width='100'>".$columnPrintingheading[$col-1]."</th> \n";	   	
								   } elseif ($row == 1) {
									   echo "<th width='60'>".$columnPrintingheading[$col-1]."</th> \n";	   	
								   } elseif ($col == 1) {
									   echo "<td width='150'><input class='printing_file' type='file' accept='image/*' name='quantity_".$row."_".$col."' /></td> \n";	   			   
								   } elseif ($col == 2) {
									   echo "<td width='65'><span data-printing='".$printingData->post_title."' class='printing_position'>".$printinglogopositions[$row-2]."</span></td> \n";
								   } elseif ($col == 3) {
									   echo "<td width='60'><input class='printing_quantity' type='number' min='0' name='quantity_".$row."_".$col."' /></td> \n";	   			   
								   } else {
									   echo "<td width='65'><span class='printing_single_price ".$row."_".$col."'></span></td> \n";
								   }
								}

						  	    echo "</tr>";
							}

							echo "</table>";
						?>
					</div>

				</div>

				<?php } ?>
			</div>
		</div>

		<div class="branding-wrapper">
			<label>
				<input class="enable-branding" type="checkbox" name="branding" /> <span>Customization</span>
			</label>
		</div>

		<form class="cart branding-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<div class="cart-error-message"></div>

			<?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			woocommerce_quantity_input( array(
				'min_value'   => 0,
				'input_value' => 0, // WPCS: CSRF ok, input var ok.
			));

			do_action('woocommerce_after_add_to_cart_quantity');
			?>


			<input type="hidden" class="enabled_branding" name="enabled_branding" value="<?php echo $checkForBranding; ?>" />
			<input type="hidden" class="size_color" name="size_color" />
			<input type="hidden" class="logo_quantity" name="logo_quantity" />
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
			<button type="submit" class="single_add_to_cart_button button alt">
				<?php sober_shopping_cart_icon(); ?>
				<?php echo esc_html($product->single_add_to_cart_text()); ?>
			</button>

			<div class="finalPrice">
				Per item: <?php echo $currency; ?><span class="singleFinalPrice">0.00</span> | Total: <?php echo $currency; ?><span class="totalFinalPrice">0.00</span>
			</div>

		</form>
	<?php } ?>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
