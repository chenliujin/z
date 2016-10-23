<?php
$zc_show_specials = false;
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_SPECIALS_INDEX));

if ($zc_show_specials == true) { 
	?>
<div class="centerBoxWrapper" id="specialsDefault">
	<?php
	require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
	?>
</div>
	<?php 
}
