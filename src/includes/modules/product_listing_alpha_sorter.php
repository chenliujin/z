<?php
if (PRODUCT_LIST_ALPHA_SORTER == 'true') {
	if ((int)$_GET['alpha_filter_id'] == 0) {
		$letters_list[] = array('id' => '0', 'text' => TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES);
	} else {
		$letters_list[] = array('id' => '0', 'text' => TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET);
	}
	for ($i=65; $i<91; $i++) {
		$letters_list[] = array('id' => sprintf('%02d', $i), 'text' => chr($i) );
	}
	for ($i=48; $i<58; $i++) {
		$letters_list[] = array('id' => sprintf('%02d', $i), 'text' => chr($i) );
	}

	$zco_notifier->notify('NOTIFY_PRODUCT_LISTING_ALPHA_SORTER_SELECTLIST', $prefix, $letters_list);

	if (TEXT_PRODUCTS_LISTING_ALPHA_SORTER != '') {
		echo '<label class="inputLabel">' . TEXT_PRODUCTS_LISTING_ALPHA_SORTER . '</label>' . zen_draw_pull_down_menu('alpha_filter_id', $letters_list, (isset($_GET['alpha_filter_id']) ? $_GET['alpha_filter_id'] : ''), 'onchange="this.form.submit()"');
	} else {
		echo zen_draw_pull_down_menu('alpha_filter_id', $letters_list, (isset($_GET['alpha_filter_id']) ? $_GET['alpha_filter_id'] : ''), 'onchange="this.form.submit()"');
	}
}
