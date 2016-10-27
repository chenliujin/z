<?php
include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING));
?>

<div id="productListing" class="group">

<?php
if ($listing_split->number_of_rows && (PREV_NEXT_BAR_LOCATION == '1' || PREV_NEXT_BAR_LOCATION == '3') ) {
	?>
	<div class="prod-list-wrap group">
	  <div id="productsListingListingTopLinks" class="navSplitPagesLinks back"><?php echo TEXT_RESULT_PAGE . $listing_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
	  <div id="productsListingTopNumber" class="navSplitPagesResult back<?php echo $listing_split->number_of_pages == 1 ? ' navSplitEmpty3rdColumn' : ''; ?>"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
	</div>
	<?php
}

require($template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php');

if ($listing_split->number_of_rows && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3') ) { 
	?>
	<div class="prod-list-wrap group">
	  <div id="productsListingListingBottomLinks"  class="navSplitPagesLinks back"><?php echo TEXT_RESULT_PAGE . $listing_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
	  <div id="productsListingBottomNumber" class="navSplitPagesResult back<?php echo $listing_split->number_of_pages == 1 ? ' navSplitEmpty3rdColumn' : ''; ?>"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
	</div>
	<?php
}
?>

</div>
