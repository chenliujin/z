<?php
$zc_show_also_purchased = false;
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ALSO_PURCHASED_PRODUCTS));

if ($zc_show_also_purchased == true) { 
	?>
	<div class="centerBoxWrapper" id="alsoPurchased">
	<?php
	require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
	?>
	</div>
	<?php 
} 
?>
