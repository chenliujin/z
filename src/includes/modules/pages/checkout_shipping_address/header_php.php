<?php
// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() <= 0) {
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

// if the customer is not logged on, redirect them to the login page
if (!isset($_SESSION['customer_id'])) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
} else {
	// validate customer
	if (zen_get_customer_validate_session($_SESSION['customer_id']) == false) {
		$_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING));
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

require(DIR_WS_CLASSES . 'order.php');
$order = new order;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($order->content_type == 'virtual') {
	unset($_SESSION['shipping']);
	$_SESSION['sendto'] = false;
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$addressType = "shipto";
require(DIR_WS_MODULES . zen_get_module_directory('checkout_new_address'));

if (!$_SESSION['sendto']) {
	$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
}

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);
$addresses_count = zen_count_customer_address_book_entries();
