<?php
include_once('z/model/products.php');

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

if (isset($_POST['products_id']) && isset($_POST['categories_id'])) {
	$products_id = zen_db_prepare_input($_POST['products_id']);
	$categories_id = zen_db_prepare_input($_POST['categories_id']);

	// Copy attributes to duplicate product
	$products_id_from=$products_id;

	if ($_POST['copy_as'] == 'link') {
		if ($categories_id != $current_category_id) {
			$check = $db->Execute("select count(*) as total
				from " . TABLE_PRODUCTS_TO_CATEGORIES . "
				where products_id = '" . (int)$products_id . "'
				and categories_id = '" . (int)$categories_id . "'");
			if ($check->fields['total'] < '1') {
				$db->Execute("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
					(products_id, categories_id)
					values ('" . (int)$products_id . "', '" . (int)$categories_id . "')");

				zen_record_admin_activity('Product ' . (int)$products_id . ' copied as link to category ' . (int)$categories_id . ' via admin console.', 'info');
			}
		} else {
			$messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
		}
	} elseif ($_POST['copy_as'] == 'duplicate') {
		$old_products_id = (int)$products_id;

		$product = \z\products::GetInstance();
		$product = $product->get((int)$products_id);

		$product_new = clone $product;
		$product_new->products_id 				= NULL;
		$product_new->products_quantity 		= 0;
		$product_new->products_date_added 		= date('Y-m-d H:i:s');
		$product_new->products_last_modified 	= date('Y-m-d H:i:s');
		$product_new->master_categories_id 		= $categories_id;
		$product_new->products_id 				= $product_new->insert();

		$dup_products_id = $product_new->products_id; 

		$description = $db->Execute("select language_id, products_name, products_description,
			products_url
			from " . TABLE_PRODUCTS_DESCRIPTION . "
			where products_id = '" . (int)$products_id . "'");
		while (!$description->EOF) {
			$db->Execute("insert into " . TABLE_PRODUCTS_DESCRIPTION . "
				(products_id, language_id, products_name, products_description,
				products_url, products_viewed)
				values ('" . (int)$dup_products_id . "',
					'" . (int)$description->fields['language_id'] . "',
					'" . zen_db_input($description->fields['products_name']) . "',
					'" . zen_db_input($description->fields['products_description']) . "',
					'" . zen_db_input($description->fields['products_url']) . "', '0')");
			$description->MoveNext();
		}

		$db->Execute("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . "
			(products_id, categories_id)
			values ('" . (int)$dup_products_id . "', '" . (int)$categories_id . "')");
		$products_id = $dup_products_id;

		// FIX HERE
		/////////////////////////////////////////////////////////////////////////////////////////////
		// Copy attributes to duplicate product
		// moved above            $products_id_from=zen_db_input($products_id);
		$products_id_to= $dup_products_id;
		$products_id = $dup_products_id;

		if ( $_POST['copy_attributes']=='copy_attributes_yes' and $_POST['copy_as'] == 'duplicate' ) {
			// $products_id_to= $copy_to_products_id;
			// $products_id_from = $pID;
			//            $copy_attributes_delete_first='1';
			//            $copy_attributes_duplicates_skipped='1';
			//            $copy_attributes_duplicates_overwrite='0';

			if (DOWNLOAD_ENABLED == 'true') {
				$copy_attributes_include_downloads='1';
				$copy_attributes_include_filename='1';
			} else {
				$copy_attributes_include_downloads='0';
				$copy_attributes_include_filename='0';
			}

			zen_copy_products_attributes($products_id_from, $products_id_to);
		}
		// EOF: Attributes Copy on non-linked
		/////////////////////////////////////////////////////////////////////

		// copy product discounts to duplicate
		if ($_POST['copy_discounts'] == 'copy_discounts_yes') {
			zen_copy_discounts_to_product($old_products_id, (int)$dup_products_id);
		}

		zen_record_admin_activity('Product ' . (int)$old_products_id . ' duplicated as product ' . (int)$dup_products_id . ' via admin console.', 'info');
	}

	// reset products_price_sorter for searches etc.
	zen_update_products_price_sorter($products_id);

}
zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $categories_id . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
