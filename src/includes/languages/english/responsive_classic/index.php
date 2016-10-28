<?php
define('TEXT_MAIN','This is the main define statement for the page for english when no template defined file exists. It is located in: <strong>/includes/languages/english/index.php</strong>');

define('TEXT_INFORMATION', 'Define your main Index page copy here.');

if ( ($category_depth == 'products') || (zen_check_url_get_terms()) ) {
	// This section deals with product-listing page contents
	define('HEADING_TITLE', 'Available Products');
	define('TABLE_HEADING_IMAGE', '');
	define('TABLE_HEADING_PRODUCTS', 'Product Name');
	define('TABLE_HEADING_QUANTITY', 'Quantity');
	define('TABLE_HEADING_PRICE', 'Price');
	define('TABLE_HEADING_WEIGHT', 'Weight');
	define('TABLE_HEADING_BUY_NOW', 'Buy Now');
	define('TEXT_NO_PRODUCTS', 'There are no products to list in this category.');
	define('TEXT_NO_PRODUCTS2', 'There is no product available from this manufacturer.');
	define('TEXT_NUMBER_OF_PRODUCTS', 'Number of Products: ');
	define('TEXT_SHOW', 'Filter Results by:');
	define('TEXT_BUY', 'Buy 1 \'');
	define('TEXT_NOW', '\' now');
	define('TEXT_ALL_CATEGORIES', 'All Categories');
	define('TEXT_ALL_MANUFACTURERS', 'All Manufacturers');
} 
