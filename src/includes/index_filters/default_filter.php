<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

if (isset($_GET['sort']) && strlen($_GET['sort']) > 3) {
  $_GET['sort'] = substr($_GET['sort'], 0, 3);
}

if (!isset($select_column_list)) $select_column_list = "";

// show the products of a specified manufacturer
if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '' ) {
    if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
		// We are asked to show only a specific category
      $listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.master_categories_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, if(s.status = 1, s.specials_new_products_price, NULL) AS specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status
       from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id , " .
       TABLE_PRODUCTS_DESCRIPTION . " pd, " .
       TABLE_MANUFACTURERS . " m, " .
       TABLE_PRODUCTS_TO_CATEGORIES . " p2c
       where p.products_status = 1
         and p.manufacturers_id = m.manufacturers_id
         and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'
         and p.products_id = p2c.products_id
         and pd.products_id = p2c.products_id
         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
         and p2c.categories_id = '" . (int)$_GET['filter_id'] . "'";
    } else {
		// We show them all
      $listing_sql = "select " . $select_column_list . " p.products_id, p.products_type, p.master_categories_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, p.products_sort_order, p.product_is_call, p.product_is_always_free_shipping, p.products_qty_box_status
      from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " .
      TABLE_PRODUCTS_DESCRIPTION . " pd, " .
      TABLE_MANUFACTURERS . " m
      where p.products_status = 1
        and pd.products_id = p.products_id
        and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
        and p.manufacturers_id = m.manufacturers_id
        and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
    }
} else {
	if (isset($_GET['filter_id']) && zen_not_null($_GET['filter_id'])) {
		$listing_sql = "
			select " . $select_column_list . " 
				p.products_id, 
				p.products_type, 
				p.master_categories_id, 
				p.manufacturers_id, 
				p.products_price, 
				p.products_tax_class_id, 
				pd.products_description, 
				IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, 
				IF(s.status = 1, s.specials_new_products_price, p.products_price) as final_price, 
				p.products_sort_order, 
				p.product_is_call, 
				p.product_is_always_free_shipping, 
				p.products_qty_box_status
			from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " .
				TABLE_PRODUCTS_DESCRIPTION . " pd, " .
				TABLE_MANUFACTURERS . " m, " .
				TABLE_PRODUCTS_TO_CATEGORIES . " p2c
			where p.products_status = 1
				and p.manufacturers_id = m.manufacturers_id
				and m.manufacturers_id = '" . (int)$_GET['filter_id'] . "'
				and p.products_id = p2c.products_id
				and pd.products_id = p2c.products_id
				and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
				and p2c.categories_id = '" . (int)$current_category_id . "'";
	} else {
		$listing_sql = "
			select " . $select_column_list . " 
				p.products_id, 
				p.products_type, 
				p.master_categories_id, 
				p.manufacturers_id, 
				p.products_price, 
				p.products_tax_class_id, 
				pd.products_description, 
				IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, 
				IF(s.status =1, s.specials_new_products_price, p.products_price) as final_price, 
				p.products_sort_order, 
				p.product_is_call, 
				p.product_is_always_free_shipping, 
				p.products_qty_box_status
			from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " .
				TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " .
				TABLE_PRODUCTS_TO_CATEGORIES . " p2c left join " . TABLE_SPECIALS . " s on p2c.products_id = s.products_id
			where p.products_status = 1
				and p.products_id = p2c.products_id
				and pd.products_id = p2c.products_id
				and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
				and p2c.categories_id = '" . (int)$current_category_id . "'";

		//echo $listing_sql;
	}
}

if (isset($column_list)) {
	if (
		(!isset($_GET['sort'])) 
		|| (isset($_GET['sort']) && !preg_match('/[1-8][ad]/', $_GET['sort'])) 
		|| (substr($_GET['sort'], 0, 1) > sizeof($column_list)) 
	) {
		for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
			if (isset($column_list[$i]) && $column_list[$i] == 'PRODUCT_LIST_NAME') {
				$_GET['sort'] = $i+1 . 'a';
				$listing_sql .= " order by p.products_sort_order, pd.products_name";
				break;
			} else {
				$listing_sql .= " order by p.products_sort_order, pd.products_name";
				break;
			}
		}
	} else {
		$sort_col = substr($_GET['sort'], 0 , 1);
		$sort_order = substr($_GET['sort'], -1);
		switch ($column_list[$sort_col-1]) {
			case 'PRODUCT_LIST_NAME':
				$listing_sql .= " order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
				break;

			case 'PRODUCT_LIST_QUANTITY':
				$listing_sql .= " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;

			case 'PRODUCT_LIST_IMAGE':
				$listing_sql .= " order by pd.products_name";
				break;

			case 'PRODUCT_LIST_PRICE':
				$listing_sql .= " order by p.products_price_sorter " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
				break;
		}
	}
}

// optional Product List Filter
if (PRODUCT_LIST_FILTER > 0) {
	if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '') {
      $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name
      from " . TABLE_PRODUCTS . " p, " .
      TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
      TABLE_CATEGORIES . " c, " .
      TABLE_CATEGORIES_DESCRIPTION . " cd
      where p.products_status = 1
        and p.products_id = p2c.products_id
        and p2c.categories_id = c.categories_id
        and p2c.categories_id = cd.categories_id
        and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
        and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'
      order by cd.categories_name";
    } else {
      $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name
      from " . TABLE_PRODUCTS . " p, " .
      TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
      TABLE_MANUFACTURERS . " m
      where p.products_status = 1
        and p.manufacturers_id = m.manufacturers_id
        and p.products_id = p2c.products_id
        and p2c.categories_id = '" . (int)$current_category_id . "'
      order by m.manufacturers_name";
    }

	$do_filter_list = false;

	$filterlist = $db->Execute($filterlist_sql);

	if ($filterlist->RecordCount() > 1) {
		$do_filter_list = true;
		if (isset($_GET['manufacturers_id'])) {
			$getoption_set =  true;
			$get_option_variable = 'manufacturers_id';
			$options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
		} else {
			$options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
		}
		while (!$filterlist->EOF) {
			$options[] = array('id' => $filterlist->fields['id'], 'text' => $filterlist->fields['name']);
			$filterlist->MoveNext();
		}
	}
}
