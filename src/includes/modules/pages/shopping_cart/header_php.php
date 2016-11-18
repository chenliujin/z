<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE);

if (isset($_GET['jscript']) && $_GET['jscript'] == 'no') {
	$messageStack->add('shopping_cart', PAYMENT_JAVASCRIPT_DISABLED, 'error');
}

$_SESSION['valid_to_checkout'] = true;
$_SESSION['cart_errors'] = '';
$_SESSION['cart']->get_products(true);

if (isset($_SESSION['valid_to_checkout']) && $_SESSION['valid_to_checkout'] == false) {
	$messageStack->add('shopping_cart', ERROR_CART_UPDATE . $_SESSION['cart_errors'] , 'caution');
}

$shipping_weight = $_SESSION['cart']->show_weight();

/*
require(DIR_WS_CLASSES . 'order.php');
$order = new order;
$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping;
$quotes = $shipping_modules->quote();
 */

$flagHasCartContents = ($_SESSION['cart']->count_contents() > 0);
$cartShowTotal = $currencies->format($_SESSION['cart']->show_total());

$flagAnyOutOfStock = false;
$flagStockCheck = '';
$products = $_SESSION['cart']->get_products();
for ($i=0, $n=sizeof($products); $i<$n; $i++) {
	if (($i/2) == floor($i/2)) {
		$rowClass="rowEven";
	} else {
		$rowClass="rowOdd";
	}

	$attributeHiddenField = "";
	$attrArray = false;
	$productsName = $products[$i]['name'];

	if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
		if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
			$options_order_by= ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
		} else {
			$options_order_by= ' ORDER BY popt.products_options_name';
		}
		foreach ($products[$i]['attributes'] as $option => $value) {
			$attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
				FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
				WHERE pa.products_id = :productsID
				AND pa.options_id = :optionsID
				AND pa.options_id = popt.products_options_id
				AND pa.options_values_id = :optionsValuesID
				AND pa.options_values_id = poval.products_options_values_id
				AND popt.language_id = :languageID
				AND poval.language_id = :languageID " . $options_order_by;

			$attributes = $db->bindVars($attributes, ':productsID', $products[$i]['id'], 'integer');
			$attributes = $db->bindVars($attributes, ':optionsID', $option, 'integer');
			$attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
			$attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
			$attributes_values = $db->Execute($attributes);
			//clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
			if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
				$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . TEXT_PREFIX . $option . ']',  $products[$i]['attributes_values'][$option]);
				$attr_value = htmlspecialchars($products[$i]['attributes_values'][$option], ENT_COMPAT, CHARSET, TRUE);
			} else {
				$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
				$attr_value = $attributes_values->fields['products_options_values_name'];
			}

			$attrArray[$option]['products_options_name'] = $attributes_values->fields['products_options_name'];
			$attrArray[$option]['options_values_id'] = $value;
			$attrArray[$option]['products_options_values_name'] = $attr_value;
			$attrArray[$option]['options_values_price'] = $attributes_values->fields['options_values_price'];
			$attrArray[$option]['price_prefix'] = $attributes_values->fields['price_prefix'];
		}
	}

	// Stock Check
	if (STOCK_CHECK == 'true') {
		$qtyAvailable = zen_get_products_stock($products[$i]['id']);
		// compare against product inventory, and against mixed=YES
		if ($qtyAvailable - $products[$i]['quantity'] < 0 || $qtyAvailable - $_SESSION['cart']->in_cart_mixed($products[$i]['id']) < 0) {
			$flagStockCheck = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
			$flagAnyOutOfStock = true;
		}
	}

	$linkProductsImage 	= zen_href_link(zen_get_info_page($products[$i]['id']), 'products_id=' . $products[$i]['id']);
	$linkProductsName 	= zen_href_link(zen_get_info_page($products[$i]['id']), 'products_id=' . $products[$i]['id']);

	$productsImage = IMAGE_SHOPPING_CART_STATUS == 1 ? 
		zen_image(
			DIR_WS_IMAGES . $products[$i]['image'], 
			$products[$i]['name'], 
			100, //IMAGE_SHOPPING_CART_WIDTH, 
			100  //IMAGE_SHOPPING_CART_HEIGHT
		) : '';

	$show_products_quantity_max = zen_get_products_quantity_order_max($products[$i]['id']);
	$showFixedQuantity = (($show_products_quantity_max == 1 or zen_get_products_qty_box_status($products[$i]['id']) == 0) ? true : false);
	$showFixedQuantityAmount = $products[$i]['quantity'] . zen_draw_hidden_field('cart_quantity[]', $products[$i]['quantity']);
	$showMinUnits = zen_get_products_quantity_min_units_display($products[$i]['id']);
	$quantityField = zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4" class="cart_input_'.$products[$i]['id'].'"');
	$ppe = $products[$i]['final_price'];
	$ppe = zen_round(
		zen_add_tax(
			$ppe, 
			zen_get_tax_rate($products[$i]['tax_class_id'])
		), 
		$currencies->get_decimal_places($_SESSION['currency'])
	);

	$productsPriceEach = $currencies->format($ppe) 
		. ($products[$i]['onetime_charges'] != 0 
		? '<br />' . $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) 
		: '');

	$buttonUpdate = zen_draw_hidden_field('products_id[]', $products[$i]['id']);

	$productArray[$i] = [
		'attributeHiddenField'		=> $attributeHiddenField,
		'flagStockCheck'			=> $flagStockCheck,
		'flagShowFixedQuantity'		=> $showFixedQuantity,
		'linkProductsImage'			=> $linkProductsImage,
		'linkProductsName'			=> $linkProductsName,
		'productsImage'				=> $productsImage,
		'image'						=> json_decode($products[$i]['image'], TRUE),
		'productsName'				=> $productsName,
		'showFixedQuantity'			=> $showFixedQuantity,
		'showFixedQuantityAmount'	=> $showFixedQuantityAmount,
		'showMinUnits'				=> $showMinUnits,
		'quantityField'				=> $quantityField,
		'buttonUpdate'				=> $buttonUpdate,
		'productsPriceEach'			=> $productsPriceEach,
		'rowClass'					=> $rowClass,
		'id'						=> $products[$i]['id'],
		'attributes'				=> $attrArray
		];
} 
