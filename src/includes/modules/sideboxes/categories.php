<?php
$main_category_tree = new category_tree;
$row = 0;
$box_categories_array = array();

// don't build a tree when no categories
$check_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1 limit 1");
if ($check_categories->RecordCount() > 0) {
	$box_categories_array = $main_category_tree->zen_category_tree();
}

require($template->get_template_dir('tpl_categories.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_categories.php');

$title = BOX_HEADING_CATEGORIES;
$title_link = false;

require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
