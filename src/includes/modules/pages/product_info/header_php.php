<?php
include_once('z/model/products.php');

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$products_id = (int)$_GET['products_id'];

$product = \z\products::GetInstance();
$product = $product->get($products_id);

// if specified product_id is disabled or doesn't exist, ensure that metatags and breadcrumbs don't share inappropriate information
$sql = "select count(*) as total
	from " . TABLE_PRODUCTS . " p, " .
	TABLE_PRODUCTS_DESCRIPTION . " pd
	where    p.products_status = '1'
	and      p.products_id = '" . (int)$_GET['products_id'] . "'
	and      pd.products_id = p.products_id
	and      pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
$res = $db->Execute($sql);
if ( $res->fields['total'] < 1 ) {
	unset($_GET['products_id']);
	unset($breadcrumb->_trail[sizeof($breadcrumb->_trail)-1]['title']);
	$robotsNoIndex = true;
	header('HTTP/1.1 404 Not Found');
}

// ensure navigation snapshot in case must-be-logged-in-for-price is enabled
if (!$_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
}


