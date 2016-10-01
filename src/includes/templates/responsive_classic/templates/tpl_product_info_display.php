<?php
include_once('z/model/products.php'); ?>
<div class="centerColumn" id="productGeneral"> 
	<?php 
	echo zen_draw_form(
		'cart_quantity', 
		zen_href_link(
			zen_get_info_page($_GET['products_id']), 
			zen_get_all_get_params(array('action')) . 'action=add_product', 
			$request_type
		), 
		'post', 
		'enctype="multipart/form-data"'
		) . "\n"; 
	?>
	<input type="hidden" name="products_id" value="<?php echo (int)$_GET['products_id']; ?>" />
	<?php

	if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>

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
				\z\products::ShowPriceList( (int) $_GET['products_id'] );
				?>
				<tr>
					<td class="size-base text-right">Qty:</td>
					<td style="width: 105%;">
						<select name="cart_quantity" style="padding: 5px; border: 1px solid #ddd; border-radius: 4px; width: auto">
							<?php 
							if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
								echo '<option value="1">1</option>';
							} else {
								$qty_start = zen_get_buy_now_qty($_GET['products_id']);

								// ToDo 对比产品的剩余数量
								// ToDo 参考 function zen_get_buy_now_button，显示 Sold Out 状态
								$qty_end	= 20;

								for ($qty = $qty_start; $qty <= $qty_end; $qty++) {
									echo '<option value="' . $qty . '">' . $qty . '</option>';
								}
							}
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td><input type="submit" value="Add to Cart" class="add-to-cart" /></td>
				</tr>
			</table>

<div style="width: 100%">
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

<div style="width: 100%; padding: 1em 0">
<?php
if ($pr_attr->fields['total'] > 0) { 
	require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); 
}

if ($products_discount_type != 0) { 
	require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); 
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
	<hr />
	<h2>Product Description</h2>
	<div id="productDescription" class="productGeneral biggerText">
		<?php echo stripslashes($products_description); ?>
	</div><?php 
} 

if (PRODUCT_INFO_PREVIOUS_NEXT == 2 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { 
	require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); 
} 

if ($flag_show_product_info_reviews == 1) { 
	// if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
	if ($reviews->fields['count'] > 0 ) { ?>
		<div id="productReviewLink" class="buttonRow back">
			<?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_REVIEWS, BUTTON_REVIEWS_ALT) . '</a>'; ?>
		</div>
		<br class="clearBoth" />
		<p class="reviewCount">
			<?php echo ($flag_show_product_info_reviews_count == 1 ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : ''); ?>
		</p> <?php 
	} else { ?> 
		<div id="productReviewLink" class="buttonRow back">
			<?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array())) . '">' . zen_image_button(BUTTON_IMAGE_WRITE_REVIEW, BUTTON_WRITE_REVIEW_ALT) . '</a>'; ?>
		</div>
		<br class="clearBoth" /> <?php 
	}
}

if ($products_date_available > date('Y-m-d H:i:s')) {
	if ($flag_show_product_info_date_available == 1) { ?>
		<p id="productDateAvailable" class="productGeneral centeredContent">
			<?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?>
		</p> <?php
	}
} else {
	if ($flag_show_product_info_date_added == 1) { ?>
		<p id="productDateAdded" class="productGeneral centeredContent">
			<?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?>
		</p> <?php
	} 
}

if (zen_not_null($products_url)) {
	if ($flag_show_product_info_url == 1) { ?>
		<p id="productInfoLink" class="productGeneral centeredContent">
		<?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=product&products_id=' . zen_output_string_protected($_GET['products_id']), 'NONSSL', true, false)); ?>
		</p> <?php
	} 
}

require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');
?>

</form>
</div>
