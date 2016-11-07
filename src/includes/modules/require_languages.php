<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

if (file_exists($language_page_directory . $template_dir . '/' . $current_page_base . '.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}

$directory_array = $template->get_template_part($language_page_directory . $template_dir_select, '/^'.$current_page_base . '/');
while(list ($key, $value) = each($directory_array)) {
	require_once($language_page_directory . $template_dir_select . $value);
}

if ($template_dir_select != '') {
	$directory_array = $template->get_template_part($language_page_directory, '/^'.$current_page_base . '/');
	while(list ($key, $value) = each($directory_array)) {
		require_once($language_page_directory . $value);
	}
}
