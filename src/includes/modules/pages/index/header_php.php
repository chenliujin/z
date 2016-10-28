<?php
// the following cPath references come from application_top/initSystem
$category_depth = 'top';
if (isset($cPath) && zen_not_null($cPath)) {
	$categories_products_query = "
		SELECT count(*) AS total
		FROM   " . TABLE_PRODUCTS_TO_CATEGORIES . "
		WHERE   categories_id = :categoriesID
		";
	$categories_products_query = $db->bindVars($categories_products_query, ':categoriesID', $current_category_id, 'integer');
	$categories_products = $db->Execute($categories_products_query);

	if ($categories_products->fields['total'] > 0) {
		$category_depth = 'products';
	} else {
		$category_parent_query = "
			SELECT count(*) AS total
			FROM   " . TABLE_CATEGORIES . "
			WHERE  parent_id = :categoriesID
			";
		$category_parent_query = $db->bindVars($category_parent_query, ':categoriesID', $current_category_id, 'integer');
		$category_parent = $db->Execute($category_parent_query);

		if ($category_parent->fields['total'] > 0) {
			$category_depth = 'nested'; // navigate through the categories
		} else {
			$category_depth = 'products'; // category has no products, but display the 'no products' message
		}
	}
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
