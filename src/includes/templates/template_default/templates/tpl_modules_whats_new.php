<?php
$zc_show_new_products = false;
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_NEW_PRODUCTS));
?>

<?php if ($zc_show_new_products == true) { ?>
<div class="centerBoxWrapper" id="whatsNew">
<?php
require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
</div>
<?php } ?>
