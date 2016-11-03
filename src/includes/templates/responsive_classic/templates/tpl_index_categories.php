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
?>


<?php
			if (PRODUCT_LIST_CATEGORY_ROW_STATUS == 0) {
				// do nothing
			} else {
				// display subcategories
				/**
				 * require the code to display the sub-categories-grid, if any exist
				 */
				require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
			}
?>
<?php
		$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_CATEGORY);

		while (!$show_display_category->EOF) {
			// //  echo 'I found ' . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS);

?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_FEATURED_PRODUCTS') { ?>
<?php
			/**
			 * display the Featured Products Center Box
			 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_SPECIALS_PRODUCTS') { ?>
<?php
			/**
			 * display the Special Products Center Box
			 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_NEW_PRODUCTS') { ?>
<?php
			/**
			 * display the New Products Center Box
			 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_CATEGORY_UPCOMING') { ?>
<?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS)); ?>
<?php } ?>
<?php
			$show_display_category->MoveNext();
		} // !EOF
?>
</div>
