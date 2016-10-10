<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

if (isset($_GET['products_id']) && SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS > 0 && MIN_DISPLAY_ALSO_PURCHASED > 0) {

	$also_purchased_products = $db->ExecuteRandomMulti(sprintf(SQL_ALSO_PURCHASED, (int)$_GET['products_id'], (int)$_GET['products_id']), MAX_DISPLAY_ALSO_PURCHASED);

	$num_products_ordered = $also_purchased_products->RecordCount();

	$row = 0;
	$col = 0;
	$list_box_contents = array();
	$title = '';

	// show only when 1 or more and equal to or greater than minimum set in admin
	if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED && $num_products_ordered > 0) {
		if ($num_products_ordered < SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS) {
			$col_width = floor(100/$num_products_ordered);
		} else {
			$col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS);
		}

		while (!$also_purchased_products->EOF) {
			$images = json_decode($also_purchased_products->fields['products_image'], TRUE);

			$also_purchased_products->fields['products_name'] = zen_get_products_name($also_purchased_products->fields['products_id']);
			$list_box_contents[$row][$col] = array(
				'params' => 'class="centerBoxContentsAlsoPurch"' . ' ' . 'style="width:' . $col_width . '%;"',
				'text' => (($also_purchased_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . \z\products::Image($images[0], $also_purchased_products->fields['products_name'], 150, 150) . '</a><br />') . '<a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . $also_purchased_products->fields['products_name'] . '</a>');

			$col ++;
			if ($col > (SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS - 1)) {
				$col = 0;
				$row ++;
			}
			$also_purchased_products->MoveNextRandom();
		}
	}
	if ($also_purchased_products->RecordCount() > 0 && $also_purchased_products->RecordCount() >= MIN_DISPLAY_ALSO_PURCHASED) {
		$title = '<h2 class="title-border">' . TEXT_ALSO_PURCHASED_PRODUCTS . '</h2>';
		$zc_show_also_purchased = true;
	}
}
