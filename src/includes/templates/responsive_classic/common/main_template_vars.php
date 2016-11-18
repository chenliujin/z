<?php

if (!isset($layoutType)) $layoutType = 'legacy';
if (!isset($max_display_page_links)) $max_display_page_links = ($layoutType == 'mobile' ? MAX_DISPLAY_PAGE_LINKS_MOBILE : MAX_DISPLAY_PAGE_LINKS);

if (file_exists(DIR_WS_MODULES . 'pages/' . $current_page_base . '/main_template_vars.php')) {
	$body_code = DIR_WS_MODULES . 'pages/' . $current_page_base . '/main_template_vars.php';
} else {
	$body_code = $template->get_template_dir('tpl_' . preg_replace('/.php/', '',$_GET['main_page']) . '_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_' . $_GET['main_page'] . '_default.php';
}

