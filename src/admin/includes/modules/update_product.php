<?php
include_once('z/model/products.php');
include_once('z/model/products_attributes.php');
include_once('z/model/products_to_categories.php');

  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }
  if (isset($_GET['pID'])) $products_id = zen_db_prepare_input($_GET['pID']);
  if (isset($_POST['edit_x']) || isset($_POST['edit_y'])) {
    $action = 'new_product';
  } elseif ($_POST['products_model'] . $_POST['products_url'] . $_POST['products_name'] . $_POST['products_description'] != '') {
    $products_date_available = zen_db_prepare_input($_POST['products_date_available']);
    $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';
    // Data-cleaning to prevent MySQL5 data-type mismatch errors:
    $tmp_value = zen_db_prepare_input($_POST['products_quantity']);
    $products_quantity = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['products_price']);
    $products_price = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['products_weight']);
    $products_weight = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? 0 : $tmp_value;
    $tmp_value = zen_db_prepare_input($_POST['manufacturers_id']);
    $manufacturers_id = (!zen_not_null($tmp_value) || $tmp_value=='' || $tmp_value == 0) ? 0 : $tmp_value;

    $sql_data_array = array('products_quantity' => $products_quantity,
                            'products_type' => zen_db_prepare_input($_GET['product_type']),
                            'products_model' => zen_db_prepare_input($_POST['products_model']),
                            'products_price' => $products_price,
                            'products_date_available' => $products_date_available,
                            'products_weight' => $products_weight,
                            'products_status' => zen_db_prepare_input((int)$_POST['products_status']),
                            'products_virtual' => zen_db_prepare_input((int)$_POST['products_virtual']),
                            'products_tax_class_id' => zen_db_prepare_input((int)$_POST['products_tax_class_id']),
                            'manufacturers_id' => $manufacturers_id,
                            'products_quantity_order_min' => zen_db_prepare_input(($_POST['products_quantity_order_min'] == 0 ? 1 : $_POST['products_quantity_order_min'])),
                            'products_quantity_order_units' => zen_db_prepare_input(($_POST['products_quantity_order_units'] == 0 ? 1 : $_POST['products_quantity_order_units']) ),
                            'products_priced_by_attribute' => zen_db_prepare_input((int)$_POST['products_priced_by_attribute']),
                            'product_is_free' => zen_db_prepare_input((int)$_POST['product_is_free']),
                            'product_is_call' => zen_db_prepare_input((int)$_POST['product_is_call']),
                            'products_quantity_mixed' => zen_db_prepare_input($_POST['products_quantity_mixed']),
                            'product_is_always_free_shipping' => zen_db_prepare_input((int)$_POST['product_is_always_free_shipping']),
                            'products_qty_box_status' => zen_db_prepare_input($_POST['products_qty_box_status']),
                            'products_quantity_order_max' => zen_db_prepare_input($_POST['products_quantity_order_max']),
                            'products_sort_order' => (int)zen_db_prepare_input($_POST['products_sort_order']),
                            'products_discount_type' => zen_db_prepare_input($_POST['products_discount_type']),
                            'products_discount_type_from' => zen_db_prepare_input($_POST['products_discount_type_from']),
                            'products_price_sorter' => zen_db_prepare_input($_POST['products_price_sorter'])
                            );

    // when set to none remove from database
    // is out dated for browsers use radio only
	/*
      $sql_data_array['products_image'] = zen_db_prepare_input($_POST['products_image']);
      $new_image= 'true';

    if ($_POST['image_delete'] == 1) {
      $sql_data_array['products_image'] = '';
      $new_image= 'false';
    }
	 */

if ($action == 'insert_product') {
	$products = \z\products::GetInstance();

	$products->products_type 					= $_GET['product_type'];
	$products->products_model 					= $_POST['products_model'];
	$products->product_gross_rate 				= $_POST['product_gross_rate'];
	$products->product_gross_rate_special 		= $_POST['product_gross_rate_special'];
	$products->products_status 					= (int)$_POST['products_status'];
	$products->parent_id 						= (int)$_POST['parent_id'];
	$products->products_date_added 				= 'now()';
	$products->master_categories_id				= (int)$current_category_id;
	$products->product_is_free 					= (int)$_POST['product_is_free'];
	$products->product_is_call 					= (int)$_POST['product_is_call'];
	$products->products_quantity_mixed 			= $_POST['products_quantity_mixed'];
	$products->product_is_always_free_shipping 	= (int)$_POST['product_is_always_free_shipping'];
	$products->products_qty_box_status 			= $_POST['products_qty_box_status'];
	$products->products_quantity_order_max 		= $_POST['products_quantity_order_max'];
	$products->products_sort_order 				= (int)$_POST['products_sort_order'];
	$products->products_discount_type 			= $_POST['products_discount_type'];
	$products->products_discount_type_from 		= $_POST['products_discount_type_from'];
	$products->products_price_sorter 			= $_POST['products_price_sorter'];
	$products->products_virtual 				= (int)$_POST['products_virtual'];
	$products->products_tax_class_id 			= (int)$_POST['products_tax_class_id'];
	$products->products_quantity_order_min		= ($_POST['products_quantity_order_min'] == 0 ? 1 : $_POST['products_quantity_order_min']);
	$products->products_quantity_order_units	= ($_POST['products_quantity_order_units'] == 0 ? 1 : $_POST['products_quantity_order_units']);
	$products->products_priced_by_attribute		= (int)$_POST['products_priced_by_attribute'];
	$products->products_date_available			= (date('Y-m-d') < $_POST['products_date_available']) ? $_POST['products_date_available'] : 'null';
	$products->products_quantity				= (int)$_POST['products_quantity'];
	$products->products_price					= $_POST['products_price'];
	$products->products_weight					= $_POST['products_weight'];
	$products->manufacturers_id 				= $_POST['manufacturers_id']; 
	$products->products_id 						= $products->insert();

	$products_id = $products->products_id;

	$products->products_image 	= $products->UploadProductImage();
	$products->update();

	$products_to_categories = \z\products_to_categories::GetInstance();
	$products_to_categories->products_id 	= $products->products_id;
	$products_to_categories->categories_id 	= (int)$current_category_id;
	$products_to_categories->insert();

	zen_update_products_price_sorter($products->products_id);
	zen_record_admin_activity('New product ' . $products->products_id . ' added via admin console.', 'info');

} elseif ($action == 'update_product') {
	$products = \z\products::GetInstance(); 
	$products = $products->get($products_id);

	$products->products_type 					= $_GET['product_type'];
	$products->products_model 					= $_POST['products_model'];
	$products->products_image 					= $products->UploadProductImage();
	$products->products_status 					= (int)$_POST['products_status'];
	$products->product_gross_rate 				= $_POST['product_gross_rate'];
	$products->product_gross_rate_special 		= $_POST['product_gross_rate_special'];
	$products->parent_id 						= (int)$_POST['parent_id'];
	$products->product_is_free 					= (int)$_POST['product_is_free'];
	$products->product_is_call 					= (int)$_POST['product_is_call'];
	$products->products_quantity_mixed 			= $_POST['products_quantity_mixed'];
	$products->product_is_always_free_shipping 	= (int)$_POST['product_is_always_free_shipping'];
	$products->products_qty_box_status 			= $_POST['products_qty_box_status'];
	$products->products_quantity_order_max 		= $_POST['products_quantity_order_max'];
	$products->products_sort_order 				= (int)$_POST['products_sort_order'];
	$products->products_discount_type 			= $_POST['products_discount_type'];
	$products->products_discount_type_from 		= $_POST['products_discount_type_from'];
	$products->products_price_sorter 			= $_POST['products_price_sorter'];
	$products->products_virtual 				= (int)$_POST['products_virtual'];
	$products->products_tax_class_id 			= (int)$_POST['products_tax_class_id'];
	$products->products_quantity_order_min		= ($_POST['products_quantity_order_min'] == 0 ? 1 : $_POST['products_quantity_order_min']);
	$products->products_quantity_order_units	= ($_POST['products_quantity_order_units'] == 0 ? 1 : $_POST['products_quantity_order_units']);
	$products->products_priced_by_attribute		= (int)$_POST['products_priced_by_attribute'];
	$products->products_date_available			= (date('Y-m-d') < $_POST['products_date_available']) ? $_POST['products_date_available'] : 'null';
	$products->products_quantity				= (int)$_POST['products_quantity'];
	$products->products_price					= $_POST['products_price'];
	$products->products_weight					= $_POST['products_weight'];
	$products->manufacturers_id 				= $_POST['manufacturers_id'];

	$products->update();

	if ($products->parent_id) {
		$products_attributes 		= \z\products_attributes::GetInstance();
		$products_attributes_list 	= $products_attributes->findAll(['products_id' => $products->products_id]);

		foreach ($products_attributes_list as $products_attributes) {
			$products_attributes->parent_id = $products->parent_id;
			$products_attributes->update();
		}
	}




      $update_sql_data = array( 'products_last_modified' => 'now()',
                                'master_categories_id' => ($_POST['master_category'] > 0 ? zen_db_prepare_input($_POST['master_category']) : zen_db_prepare_input($_POST['master_categories_id'])));

      $sql_data_array = array_merge($sql_data_array, $update_sql_data);

      zen_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");

      zen_record_admin_activity('Updated product ' . (int)$products_id . ' via admin console.', 'info');

      // reset products_price_sorter for searches etc.
      zen_update_products_price_sorter((int)$products_id);

      ///////////////////////////////////////////////////////
      //// INSERT PRODUCT-TYPE-SPECIFIC *UPDATES* HERE //////


      ////    *END OF PRODUCT-TYPE-SPECIFIC UPDATES* ////////
      ///////////////////////////////////////////////////////
}

$languages = zen_get_languages();
for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	$language_id = $languages[$i]['id'];

	$sql_data_array = array(
		'products_name' => zen_db_prepare_input($_POST['products_name'][$language_id]),
		'products_description' => zen_db_prepare_input($_POST['products_description'][$language_id]),
		'products_url' => zen_db_prepare_input($_POST['products_url'][$language_id]));

	if ($action == 'insert_product') {
		$insert_sql_data = array('products_id' => (int)$products_id,
			'language_id' => (int)$language_id);

		$sql_data_array = array_merge($sql_data_array, $insert_sql_data);

		zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
	} elseif ($action == 'update_product') {
		zen_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
	}
}

    // add meta tags
    $languages = zen_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      $language_id = $languages[$i]['id'];

      $sql_data_array = array('metatags_title' => zen_db_prepare_input($_POST['metatags_title'][$language_id]),
                              'metatags_keywords' => zen_db_prepare_input($_POST['metatags_keywords'][$language_id]),
                              'metatags_description' => zen_db_prepare_input($_POST['metatags_description'][$language_id]));

      if ($action == 'insert_product_meta_tags') {

        $insert_sql_data = array('products_id' => (int)$products_id,
                                 'language_id' => (int)$language_id);

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array);
      } elseif ($action == 'update_product_meta_tags') {
        zen_db_perform(TABLE_META_TAGS_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
      }
    }


    // future image handler code
    define('IMAGE_MANAGER_HANDLER', 0);
    define('DIR_IMAGEMAGICK', '');
    if ($new_image == 'true' and IMAGE_MANAGER_HANDLER >= 1) {
      $src= DIR_FS_CATALOG . DIR_WS_IMAGES . zen_get_products_image((int)$products_id);
      $filename_small= $src;
      preg_match("/.*\/(.*)\.(\w*)$/", $src, $fname);
      list($oiwidth, $oiheight, $oitype) = getimagesize($src);

      $small_width= SMALL_IMAGE_WIDTH;
      $small_height= SMALL_IMAGE_HEIGHT;
      $medium_width= MEDIUM_IMAGE_WIDTH;
      $medium_height= MEDIUM_IMAGE_HEIGHT;
      $large_width= LARGE_IMAGE_WIDTH;
      $large_height= LARGE_IMAGE_HEIGHT;

      $k = max($oiheight / $small_height, $oiwidth / $small_width); //use smallest size
      $small_width = round($oiwidth / $k);
      $small_height = round($oiheight / $k);

      $k = max($oiheight / $medium_height, $oiwidth / $medium_width); //use smallest size
      $medium_width = round($oiwidth / $k);
      $medium_height = round($oiheight / $k);

      $large_width= $oiwidth;
      $large_height= $oiheight;

      $products_image = zen_get_products_image((int)$products_id);
      $products_image_extension = substr($products_image, strrpos($products_image, '.'));
      $products_image_base = preg_replace('/'.$products_image_extension.'/', '', $products_image);

      $filename_medium = DIR_FS_CATALOG . DIR_WS_IMAGES . 'medium/' . $products_image_base . IMAGE_SUFFIX_MEDIUM . '.' . $fname[2];
      $filename_large = DIR_FS_CATALOG . DIR_WS_IMAGES . 'large/' . $products_image_base . IMAGE_SUFFIX_LARGE . '.' . $fname[2];

      // ImageMagick
      if (IMAGE_MANAGER_HANDLER == '1') {
        copy($src, $filename_large);
        copy($src, $filename_medium);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $large_width . " " . $filename_large);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $medium_width . " " . $filename_medium);
        exec(DIR_IMAGEMAGICK . "mogrify -geometry " . $small_width . " " . $filename_small);
      }
    }

    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . (isset($_POST['search']) ? '&search=' . $_POST['search'] : '') ));
  } else {
    $messageStack->add_session(ERROR_NO_DATA_TO_SAVE, 'error');
    zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . (isset($_POST['search']) ? '&search=' . $_POST['search'] : '') ));
  }
