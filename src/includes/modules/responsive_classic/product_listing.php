<?php
include_once('z/model/products.php');

if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

//echo $listing_sql;


$show_submit = zen_run_normal();

$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
$how_many = 0;

$list_box_contents[0] = array('params' => 'class="productListing-rowheading"');

$zc_col_count_description = 0;
$lc_align = '';
for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
	switch ($column_list[$col]) {
		case 'PRODUCT_LIST_NAME':
			$lc_text = TABLE_HEADING_PRODUCTS;
			$lc_align = '';
			$zc_col_count_description++;
			break;

		case 'PRODUCT_LIST_PRICE':
			$lc_text = TABLE_HEADING_PRICE;
			$lc_align = 'right' . (PRODUCTS_LIST_PRICE_WIDTH > 0 ? '" width="' . PRODUCTS_LIST_PRICE_WIDTH : '');
			$zc_col_count_description++;
			break;

		case 'PRODUCT_LIST_QUANTITY':
			$lc_text = TABLE_HEADING_QUANTITY;
			$lc_align = 'right';
			$zc_col_count_description++;
			break;

		case 'PRODUCT_LIST_IMAGE':
			$lc_text = TABLE_HEADING_IMAGE;
			$lc_align = 'center';
			$zc_col_count_description++;
			break;
	}

	if ( ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
		$lc_text = zen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
	}

	$list_box_contents[0][$col] = array(
		'align' 	=> $lc_align,
		'params' 	=> 'class="productListing-heading"',
		'text' 		=> $lc_text
		);
}

if ($listing_split->number_of_rows > 0) {
	$rows = 0;
	$listing = $db->Execute($listing_split->sql_query);
	$extra_row = 0;
	while (!$listing->EOF) {
		$rows++;

		if ((($rows-$extra_row)/2) == floor(($rows-$extra_row)/2)) {
			$list_box_contents[$rows] = array('params' => 'class="productListing-even"');
		} else {
			$list_box_contents[$rows] = array('params' => 'class="productListing-odd"');
		}

		$cur_row = sizeof($list_box_contents) - 1;

		for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
			$lc_align = '';
			switch ($column_list[$col]) {
			case 'PRODUCT_LIST_NAME':
				$lc_align = '';
				$lc_text = '<h3 class="itemTitle"><a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' 
					. $listing->fields['products_name'] 
					. '</a></h3><div class="listingDescription">' 
					. zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION) 
					. '</div>';
				break;

			case 'PRODUCT_LIST_PRICE':
				$lc_price = '<div class="list-price">' 
					. zen_get_products_display_price($listing->fields['products_id']) 
					. '</div>';
				$lc_align = 'right';
				$lc_text =  $lc_price;

				$lc_text .= '' . (zen_get_show_product_switch($listing->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') 
					? (zen_get_product_is_always_free_shipping($listing->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '' : '') 
					: '');

				break;

			case 'PRODUCT_LIST_QUANTITY':
				$lc_align = 'right';
				$lc_text = '<div class="list-quantity">' 
					. $listing->fields['products_quantity'] 
					. '</div>';
				break;

			case 'PRODUCT_LIST_IMAGE':
				$lc_align = 'center';
				$lc_text = '';

				$images = json_decode($listing->fields['products_image'], TRUE);

				if ( is_array($images) ) {
					$lc_text = '
						<div class="list-image">
							<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id']) > 0 ?  zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']) . '">' 
								. \z\products::Image($images[0], $listing->fields['products_name'], 220, 220) . '
							</a>
						</div>';
				} 

				break;
			}

			$list_box_contents[$rows][$col] = array(
				'align' 	=> $lc_align,
				'params' 	=> 'class="productListing-data"',
				'text'  	=> $lc_text
			);
		}

		// add description and match alternating colors
		//if (PRODUCT_LIST_DESCRIPTION > 0) {
		//  $rows++;
		//  if ($extra_row == 1) {
		//    $list_box_description = "productListing-data-description-even";
		//    $extra_row=0;
		//  } else {
		//    $list_box_description = "productListing-data-description-odd";
		//    $extra_row=1;
		//  }
		//  $list_box_contents[$rows][] = array('params' => 'class="' . $list_box_description . '" colspan="' . $zc_col_count_description . '"',
		//  'text' => zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION));
		//}
		$listing->MoveNext();
	}
	$error_categories = false;
} else {
	$list_box_contents = array();

	$list_box_contents[0] = array('params' => 'class="productListing-odd"');
	$list_box_contents[0][] = array('params' => 'class="productListing-data"',
		'text' => TEXT_NO_PRODUCTS);

	$error_categories = true;
}
