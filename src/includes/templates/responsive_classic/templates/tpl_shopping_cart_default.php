<?php
include_once('z/model/products.php');
?>
<div class="centerColumn" id="shoppingCartDefault">
<?php
if ($flagHasCartContents) { ?>
	<h2 style="margin-bottom:0"><?php echo HEADING_TITLE; ?></h2> 
	<?php 

	if ($messageStack->size('shopping_cart') > 0) {
		echo $messageStack->output('shopping_cart');
	}

	echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type), 'post', 'id="shoppingCartForm"'); 

	if ($flagAnyOutOfStock) { 
		if (STOCK_ALLOW_CHECKOUT == 'true') {  ?> 
			<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div> <?php    
		} else { ?>
			<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div> <?php    
		} 
	} 
?>

<table id="cartContentsDisplay">
	 <tr class="tableHeading list-item-border">
		<td scope="col" id="scProductsHeading" style="width: 60%"></td>
		<td scope="col" id="scUnitHeading" ><?php echo TABLE_HEADING_PRICE; ?></td>
		<td scope="col" id="scQuantityHeading" style="width:150px"><?php echo TABLE_HEADING_QUANTITY; ?></td>
	 </tr>
<?php
	foreach ($productArray as $product) { 
?>
     <tr class="<?php echo $product['rowClass']; ?> list-item-border">

	   <td class="cartProductDisplay">
	<div style="margin: 14px 0">
		<div style="padding-left: 115px">
			<div style="width:115px; margin-left:-115px;float:left">
				<a href="#">
					<img alt="" src="<?php echo \z\products::GetImage($product['image'][0], 100); ?>" width="100" />
				</a>
			</div>
			<div style="float:left">
				<a href="<?php echo $product['linkProductsName']; ?>">
					<span class="text-bold size-medium">
						<?php echo $product['productsName'] . '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?>
					</span>
				</a>
				<!--<br class="clearBoth" />-->
				<?php
				echo $product['attributeHiddenField'];
				if (isset($product['attributes']) && is_array($product['attributes'])) {
					echo '<div class="cartAttribsList">';
					echo '<ul>';
					reset($product['attributes']);
					foreach ($product['attributes'] as $option => $value) { ?> 
						<li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?></li> <?php
					}
					echo '</ul>';
					echo '</div>';
				}
				?>
				<div style="margin-top: 1em">
					<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>">
						Delete
					</a>
				</div>
			</div>
		</div>
	</div>
	   </td>

		<td class="price size-medium text-bold  cartUnitDisplay">
			<div style="margin: 14px 0">
			<?php 
			echo $product['productsPriceEach']; 
			?>
			</div>
		</td>

		<td class="cartQuantity"> 
			<div style="margin: 14px 0">
			<?php
			if ($product['flagShowFixedQuantity']) {
				echo $product['showFixedQuantityAmount'];
			} else {
				echo $product['quantityField'];
				?>
				<br />
				<input type="submit" value="update" style="height: 20px" />
				<?php
			} 
			?>
			<br />
			<span class="alert bold"><?php echo $product['flagStockCheck'];?></span>
			<br />
			<br />
			<?php echo $product['showMinUnits']; ?>
			<?php echo $product['buttonUpdate']; ?>
			</div>
		</td>
	 </tr>
<?php
	}
?>
</table>

<div id="order-total">
	<?php
	require(DIR_WS_CLASSES . 'order_total.php');
	$order_total = new order_total;
	$order_total->process();
	$order_total->output();
	?>
</div>

<br class="clearBoth" />

<div class="buttonRow forward">
	<?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a>'; ?>
</div>

</form>

<br class="clearBoth" />

<?php
	if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
		include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
	}
} else { ?> 
	<h2 class="text-center"><?php echo TEXT_CART_EMPTY; ?></h2> <?php 
}
?>
</div>
