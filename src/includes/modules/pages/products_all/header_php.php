<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE);

// display order dropdown
$disp_order_default = PRODUCT_ALL_LIST_SORT_DEFAULT;
require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER));

$products_all_array = array();

$products_all_query_raw = "SELECT p.products_type, p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id,
                                    p.products_date_added, m.manufacturers_name, p.products_model, p.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id
                             FROM " . TABLE_PRODUCTS . " p
                             LEFT JOIN " . TABLE_MANUFACTURERS . " m ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
                             AND p.products_id = pd.products_id
                             AND pd.language_id = :languageID " . $order_by;

$products_all_query_raw = $db->bindVars($products_all_query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
$products_all_split = new splitPageResults($products_all_query_raw, MAX_DISPLAY_PRODUCTS_ALL);
