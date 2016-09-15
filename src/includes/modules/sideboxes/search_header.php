<?php
$search_header_status = $db->Execute("
select layout_box_name 
from " . TABLE_LAYOUT_BOXES . " 
where (layout_box_status=1 or layout_box_status_single=1) and layout_template ='" . $template_dir . "' and layout_box_name='search_header.php'");

if ($search_header_status->RecordCount() != 0) {
	$show_search_header= true;
}

if ($show_search_header == true) {
	require($template->get_template_dir('tpl_search_header.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_search_header.php');

	$title = '<label>' . BOX_HEADING_SEARCH . '</label>';
	$title_link = false;
	require($template->get_template_dir('tpl_box_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_box_header.php');
}
