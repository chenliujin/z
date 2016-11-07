<?php
// release manufacturers_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] <= 0) {
	unset($_GET['manufacturers_id']);
	unset($manufacturers_id);
}

// release music_genre_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] <= 0) {
	unset($_GET['music_genre_id']);
	unset($music_genre_id);
}

// release record_company_id when nothing is there so a blank filter is not setup.
// this will result in the home page, if used
if (isset($_GET['record_company_id']) && $_GET['record_company_id'] <= 0) {
	unset($_GET['record_company_id']);
	unset($record_company_id);
}

// only release typefilter if both record_company_id and music_genre_id are blank
// this will result in the home page, if used
if ((isset($_GET['record_company_id']) && $_GET['record_company_id'] <= 0) and (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] <= 0) ) {
	unset($_GET['typefilter']);
	unset($typefilter);
}

// release filter for category or manufacturer when nothing is there
if (isset($_GET['filter_id']) && $_GET['filter_id'] <= 0) {
	unset($_GET['filter_id']);
	unset($filter_id);
}

if ($category_depth == 'nested') {
	$sql = "SELECT cd.categories_name, c.categories_image
		FROM   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
		WHERE      c.categories_id = :categoriesID
		AND        cd.categories_id = :categoriesID
		AND        cd.language_id = :languagesID
		AND        c.categories_status= '1'";

	$sql = $db->bindVars($sql, ':categoriesID', $current_category_id, 'integer');
	$sql = $db->bindVars($sql, ':languagesID', $_SESSION['languages_id'], 'integer');
	$category = $db->Execute($sql);

	if (isset($cPath) && strpos($cPath, '_')) {
		// check to see if there are deeper categories within the current category
		$category_links = array_reverse($cPath_array);
		for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
			$sql = "SELECT count(*) AS total
				FROM   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
				WHERE      c.parent_id = :parentID
				AND        c.categories_id = cd.categories_id
				AND        cd.language_id = :languagesID
				AND        c.categories_status= '1'";

			$sql = $db->bindVars($sql, ':parentID', $category_links[$i], 'integer');
			$sql = $db->bindVars($sql, ':languagesID', $_SESSION['languages_id'], 'integer');
			$categories = $db->Execute($sql);

			if ($categories->fields['total'] < 1) {
				// do nothing, go through the loop
			} else {
				$categories_query = "SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id
					FROM   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
					WHERE      c.parent_id = :parentID
					AND        c.categories_id = cd.categories_id
					AND        cd.language_id = :languagesID
					AND        c.categories_status= '1'
					ORDER BY   sort_order, cd.categories_name";

				$categories_query = $db->bindVars($categories_query, ':parentID', $category_links[$i], 'integer');
				$categories_query = $db->bindVars($categories_query, ':languagesID', $_SESSION['languages_id'], 'integer');
				break; // we've found the deepest category the customer is in
			}
		}
	} else {
		$categories_query = "SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id
			FROM   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
			WHERE      c.parent_id = :parentID
			AND        c.categories_id = cd.categories_id
			AND        cd.language_id = :languagesID
			AND        c.categories_status= '1'
			ORDER BY   sort_order, cd.categories_name";

		$categories_query = $db->bindVars($categories_query, ':parentID', $current_category_id, 'integer');
		$categories_query = $db->bindVars($categories_query, ':languagesID', $_SESSION['languages_id'], 'integer');
	}
	$categories = $db->Execute($categories_query);
	$number_of_categories = $categories->RecordCount();
	$new_products_category_id = $current_category_id;

	$tpl_page_body = 'tpl_index_categories.php';
} elseif ($category_depth == 'products' || zen_check_url_get_terms()) {
	if (SHOW_PRODUCT_INFO_ALL_PRODUCTS == '1') {
		$new_products_category_id = $cPath;
	} 

	$define_list = array(
		'PRODUCT_LIST_NAME' 		=> PRODUCT_LIST_NAME,
		'PRODUCT_LIST_PRICE' 		=> PRODUCT_LIST_PRICE,
		'PRODUCT_LIST_QUANTITY' 	=> PRODUCT_LIST_QUANTITY,
		'PRODUCT_LIST_IMAGE' 		=> PRODUCT_LIST_IMAGE
	);

	asort($define_list);
	reset($define_list);
	$column_list = array();

	foreach ($define_list as $key => $value) {
		if ($value > 0) {
			$column_list[] = $key;
		}
	}

	$select_column_list = '';

	for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
		switch ($column_list[$i]) {
			case 'PRODUCT_LIST_NAME':
				$select_column_list .= 'pd.products_name, ';
				break;
			case 'PRODUCT_LIST_QUANTITY':
				$select_column_list .= 'p.products_quantity, ';
				break;
			case 'PRODUCT_LIST_IMAGE':
				$select_column_list .= 'p.products_image, ';
				break;
		}
	}

	// always add quantity regardless of whether or not it is in the listing for add to cart buttons
	if (PRODUCT_LIST_QUANTITY < 1) {
		$select_column_list .= 'p.products_quantity, ';
	}

	$typefilter = isset($_GET['typefilter']) ? $_GET['typefilter'] : 'default';

	require(zen_get_index_filters_directory($typefilter . '_filter.php'));


	$tpl_page_body = 'tpl_index_product_list.php';
} else {
	$tpl_page_body = 'tpl_index_default.php';
}

require($template->get_template_dir($tpl_page_body, DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . $tpl_page_body);
