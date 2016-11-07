<div class="centerColumn" id="indexCategories">
<?php if ($show_welcome == true) { ?>
<h1 id="indexCategoriesHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if (DEFINE_MAIN_PAGE_STATUS >= 1 and DEFINE_MAIN_PAGE_STATUS <= 2) { ?>
<div id="indexCategoriesMainContent" class="content">
<?php
include($define_page);
?>
</div>
<?php } ?>

<?php } else { ?>

<div id="cat-top" class="group">
<div id="cat-left" class="back">

<?php } 

if ($show_welcome != true) { 
?>
</div>
</div>
<?php 
} 

if (PRODUCT_LIST_CATEGORY_ROW_STATUS == 0) {
	// do nothing
} else {
	require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
}

?>
</div>
