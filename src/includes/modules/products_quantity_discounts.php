<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$zc_hidden_discounts_text = '';

// find out the minimum quantity for this product
$products_min_query = $db->Execute("
	select products_quantity_order_min 
	from " . TABLE_PRODUCTS . " 
	where products_id='" . (int)$products_id_current . "'");
$products_quantity_order_min = $products_min_query->fields['products_quantity_order_min'];

// retrieve the list of discount levels for this product
$products_discounts_query = $db->Execute("
	select * 
	from " . TABLE_PRODUCTS_DISCOUNT_QUANTITY . " 
	where products_id='" . (int)$products_id_current . "' and discount_qty !=0 " . " 
	order by discount_qty");


$discount_col_cnt = DISCOUNT_QUANTITY_PRICES_COLUMN;

$display_price = zen_get_products_base_price($products_id_current);
$display_specials_price = zen_get_products_special_price($products_id_current, false);

if ($display_specials_price == false) {
	$show_price = $display_price;
} else {
	$show_price = $display_specials_price;
}

switch (true) {
	case ($products_discounts_query->fields['discount_qty'] <= 2):
		$show_qty = '1';
		break;

	case ($products_quantity_order_min == ($products_discounts_query->fields['discount_qty']-1) || $products_quantity_order_min == ($products_discounts_query->fields['discount_qty'])):
		$show_qty = $products_quantity_order_min;
		break;

	default:
		$show_qty = $products_quantity_order_min . '-' . number_format($products_discounts_query->fields['discount_qty']-1);
		break;
}

$display_price = zen_get_products_base_price($products_id_current);
$display_specials_price = zen_get_products_special_price($products_id_current, false);
$disc_cnt = 1;
$quantityDiscounts = array();
$columnCount = 0;

while (!$products_discounts_query->EOF) {
	$disc_cnt++;
	switch ($products_discount_type) {
		// none
		case '0':
			$quantityDiscounts[$columnCount]['discounted_price'] = 0;
			break;

		// percentage discount
		case '1':
			if ($products_discount_type_from == '0') {
				$quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($products_discounts_query->fields['discount_price']/100));
			} else {
				if (!$display_specials_price) {
					$quantityDiscounts[$columnCount]['discounted_price'] = $display_price - ($display_price * ($products_discounts_query->fields['discount_price']/100));
				} else {
					$quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - ($display_specials_price * ($products_discounts_query->fields['discount_price']/100));
				}
			}
			break;

		// actual price
		case '2':
			if ($products_discount_type_from == '0') {
				$quantityDiscounts[$columnCount]['discounted_price'] = $products_discounts_query->fields['discount_price'];
			} else {
				$quantityDiscounts[$columnCount]['discounted_price'] = $products_discounts_query->fields['discount_price'];
			}
			break;

		// amount offprice
		case '3':
			if ($products_discount_type_from == '0') {
				$quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $products_discounts_query->fields['discount_price'];
			} else {
				if (!$display_specials_price) {
					$quantityDiscounts[$columnCount]['discounted_price'] = $display_price - $products_discounts_query->fields['discount_price'];
				} else {
					$quantityDiscounts[$columnCount]['discounted_price'] = $display_specials_price - $products_discounts_query->fields['discount_price'];
				}
			}
			break;

		case '4':
			$quantityDiscounts[$columnCount]['discounted_price'] = $products->products_price * (1 + $products_discounts_query->fields['gross_rate_qty']/100); 
			break;
	}

	$quantityDiscounts[$columnCount]['show_qty'] = number_format($products_discounts_query->fields['discount_qty']);
	$products_discounts_query->MoveNext();

	if ($products_discounts_query->EOF) {
		$quantityDiscounts[$columnCount]['show_qty'] .= '+';
	} else {
		if (($products_discounts_query->fields['discount_qty']-1) != $show_qty) {
			if ($quantityDiscounts[$columnCount]['show_qty'] < $products_discounts_query->fields['discount_qty']-1) {
				$quantityDiscounts[$columnCount]['show_qty'] .= '-' . number_format($products_discounts_query->fields['discount_qty']-1);
			}
		}
	}

	$disc_cnt=0;
	$columnCount++;
}
