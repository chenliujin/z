<?php
include_once('z/model/products.php');
?>
<div class="centerColumn" id="productGeneral">

<!--bof Form start-->
<?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
<!--eof Form start-->

<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>

<style>

ul.nostyle li {
	list-style: none;
}

li.item img {
	max-width: none!important;
}

.spacing-small {
	margin-bottom: 10px!important;
}

.thumbnail {
	line-height: 100%;
	height: 40px;
	display: inline-block;
	border-width: 1px;
	border-style: solid;
	border-color: #a2a6ac;
	border-radius: 2px;;
	cursor: pointer;
}

.thumbnail:hover {
	box-shadow: 0 0 3px 2px rgba(228,121,17,.5);
}

.button-selected {
	border-color: #e77600;
}


</style>
<div id="prod-info-top">
	<div style="width: 100%">
		<div style="width: 500px; float:left;">
		<div style="padding-left:32px;">
			<div style="float:left; width:40px; margin-left: -45px">
				 <ul class="nostyle" style="margin: 0; margin-top: 4px; padding:0">
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/1_40.jpg" data-img="/images/II/2016/08/1/1_450.jpg" />
					</li>
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/2_40.jpg" data-img="/images/II/2016/08/1/2_450.jpg" />
					</li>
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/3_40.jpg" data-img="/images/II/2016/08/1/3_450.jpg" />
					</li>
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/4_40.jpg" data-img="/images/II/2016/08/1/4_450.jpg" />
					</li>
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/5_40.jpg" data-img="/images/II/2016/08/1/5_450.jpg" />
					</li>
					<li class="thumbnail item spacing-small">
						<img src="/images/II/2016/08/1/6_40.jpg" data-img="/images/II/2016/08/1/6_450.jpg" />
					</li>
				</ul>
			</div>
			<div style="float:left;">
				<img id="zoomimg" src="/images/II/2016/08/1/1_450.jpg" style="max-width: 442px; max-height:442px;" />
			</div>
		</div>

		</div>
		<div style="margin-left: 500px;">
			<h1 id="productName" class="productGeneral"><?php echo $products_name; ?></h1>
			<hr>
			<table class="line-item">
				<?php
				$price_list = \z\products::ShowPriceList( (int) $_GET['products_id'] );
				?>
				<tr>
					<td class="size-base text-right">Qty:</td>
					<td style="width: 105%;">
						<select style="padding: 5px; border: 1px solid #ddd; border-radius: 4px; width: auto">
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Add to Cart" /></td>
				</tr>
			</table>
<div id="pinfo-right" class="group grids" style="width: 100%">
<?php 
if ( 
	(
		($flag_show_product_info_model == 1 and $products_model != '') 
		or ($flag_show_product_info_weight == 1 and $products_weight !=0) 
		or ($flag_show_product_info_quantity == 1) 
		or ($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name))
	) 
) { ?>
<ul id="productDetailsList">
  <?php echo (($flag_show_product_info_model == 1 and $products_model !='') ? '<li>' . TEXT_PRODUCT_MODEL . $products_model . '</li>' : '') . "\n"; ?>
  <?php echo (($flag_show_product_info_weight == 1 and $products_weight !=0) ? '<li>' . TEXT_PRODUCT_WEIGHT .  $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</li>'  : '') . "\n"; ?>
  <?php echo (($flag_show_product_info_quantity == 1) ? '<li>' . $products_quantity . TEXT_PRODUCT_QUANTITY . '</li>'  : '') . "\n"; ?>
  <?php echo (($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)) ? '<li>' . TEXT_PRODUCT_MANUFACTURER . $manufacturers_name . '</li>' : '') . "\n"; ?>
</ul> <?php
}

if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
	<div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div> <?php 
} 
?>
</div>

<div id="cart-box" class="grids" style="width: 100%; padding: 1em 0">
<h2 id="productPrices" class="productGeneral">
<?php
// base price
if ($show_onetime_charges_description == 'true') {
	$one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
} else {
	$one_time = '';
}
echo $one_time 
	. ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') 
	. zen_get_products_display_price((int)$_GET['products_id']);
?>
</h2>

<?php
if ($pr_attr->fields['total'] > 0) { 
	require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); 
}

if ($products_discount_type != 0) { 
	require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); 
}

if (CUSTOMERS_APPROVAL == 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
	// do nothing
} else {
	$display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');

	if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
		// hide the quantity box and default to 1
		$the_button = '<input type="hidden" name="cart_quantity" value="1" />' 
			. zen_draw_hidden_field('products_id', (int)$_GET['products_id']) 
			. zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
	} else {
		$the_button = '<div class="max-qty">' 
			. zen_get_products_quantity_min_units_display((int)$_GET['products_id']) 
			. '</div><span class="qty-text">' . PRODUCTS_ORDER_QTY_TEXT 
			. '</span><input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" />' 
			. zen_draw_hidden_field('products_id', (int)$_GET['products_id']) 
			. zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
	}

	$display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);

	if ($display_qty != '' or $display_button != '') { ?>
		<div id="cartAdd">
			<?php
			echo $display_qty;
			echo $display_button;
			?>
		</div> <?php   
	} 
} 
?>
</div>
</div>


		</div>
		<div style="clear: both"></div>
	</div>
	<script>
	$('.thumbnail').each(function(i,o){
		var lilength = $('.thumbnail').length;
		$(o).hover(function(){
			$(o).siblings().removeClass('button-selected');
			$(o).addClass('button-selected');
			$('#zoomimg').attr('src', $(o).find('img').attr('data-img'));
			$('#zoomimg').attr('jqimg', $(o).find('img').attr('data-big'));
		});
	})
		</script>

<?php 
if ($products_description != '') { ?>
	<div id="productDescription" class="productGeneral biggerText"><?php echo stripslashes($products_description); ?></div> <?php 
} 

if (PRODUCT_INFO_PREVIOUS_NEXT == 2 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { 
	require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); 
} 

if ($flag_show_product_info_reviews == 1) { 
	// if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
	if ($reviews->fields['count'] > 0 ) { ?>
		<div id="productReviewLink" class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>'; ?></div>
		<br class="clearBoth" />
		<p class="reviewCount"><?php echo ($flag_show_product_info_reviews_count == 1 ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : ''); ?></p> <?php 
	} else { ?> 
		<div id="productReviewLink" class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array())) . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?></div>
		<br class="clearBoth" /> <?php 
	}
}

if ($products_date_available > date('Y-m-d H:i:s')) {
	if ($flag_show_product_info_date_available == 1) { ?>
		<p id="productDateAvailable" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?></p> <?php
	}
} else {
	if ($flag_show_product_info_date_added == 1) { ?>
		<p id="productDateAdded" class="productGeneral centeredContent"><?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?></p> <?php
	} 
}

if (zen_not_null($products_url)) {
	if ($flag_show_product_info_url == 1) { ?>
		<p id="productInfoLink" class="productGeneral centeredContent"><?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=product&products_id=' . zen_output_string_protected($_GET['products_id']), 'NONSSL', true, false)); ?></p> <?php
	} 
}

require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');
?>

</form>
</div>
